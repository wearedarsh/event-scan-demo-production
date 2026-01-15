<?php

namespace App\Jobs;

use App\Models\EmailQueuedSend;
use Illuminate\Support\Facades\Log;
use App\Models\EmailSend;
use App\Mail\BroadcastEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Throwable;

class SendQueuedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public EmailQueuedSend $queued_send) {}

    public function handle(): void
    {
        $this->queued_send->update(['status' => 'processing']);

        try {
            Log::info('Creating new mailable');

            $mailable = new BroadcastEmail(
                from_address: $this->queued_send->from_address,
                from_name: $this->queued_send->from_name,
                custom_subject: $this->queued_send->subject,
                html_content: $this->queued_send->html_content,
                broadcast_id: $this->queued_send->email_broadcast_id,
                email_send_id: $this->queued_send->id,
                client_id: config('api.client_id')
            );

            Log::info('Creating new EmailSend');

            $send = EmailSend::create([
                'email_broadcast_id' => $this->queued_send->email_broadcast_id,
                'recipient_id' => $this->queued_send->recipient_id ?? null,
                'email_address' => $this->queued_send->email_address,
                'subject' => $this->queued_send->subject,
                'html_content' => $this->queued_send->html_content,
                'status' => 'pending'
            ]);

            $mailable->email_send_id = $send->id;

            Log::info('My email send id is: ' . $mailable->email_send_id);

            Mail::to($this->queued_send->email_address)->send($mailable);

            $send->update(['status' => 'sent', 'sent_at' => now()]);

            $this->queued_send->update(['status' => 'sent']);

        } catch (Throwable $e) {
            $this->queued_send->update([
                'status' => 'failed',
                'last_error' => $e->getMessage(),
                'attempts' => $this->queued_send->attempts + 1,
            ]);

            throw $e;
        }
    }
}
