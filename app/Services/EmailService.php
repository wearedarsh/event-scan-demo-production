<?php

namespace App\Services;

use App\Models\EmailBroadcast;
use App\Models\EmailBroadcastType;
use App\Models\EmailQueuedSend;
use App\Jobs\SendQueuedEmailJob;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use DateTimeInterface;

class EmailService
{
    public static function queueMailable(
        Mailable $mailable,
        string $recipient_email,
        string $friendly_name,
        string $type,
        ?int $event_id = null,
        ?int $sender_id = null,
        ?DateTimeInterface $schedule_at = null,
        ?string $signature_html = null,
        ?EmailBroadcast $broadcast = null,
        ?User $recipient_user = null
    ): EmailQueuedSend {
        return DB::transaction(function () use (
            $mailable,
            $recipient_email,
            $recipient_user,
            $friendly_name,
            $event_id,
            $sender_id,
            $schedule_at,
            $signature_html,
            $type,
            $broadcast
        ) {

            Log::info('Email service received request');

            $subject = $mailable->subject;

            $html = $mailable->render();

            if ($signature_html) {
                $html .= '<br><br>' . $signature_html;
            }

            $broadcast_type = EmailBroadcastType::where('key_name', $type)->firstOrFail();

            if(!$broadcast){
                $broadcast = EmailBroadcast::create([
                    'friendly_name' => $friendly_name,
                    'subject' => $subject,
                    'email_broadcast_type_id' => $broadcast_type->id,
                    'sent_by' => $sender_id,
                    'queued_at' => now(),
                    'event_id' => $event_id,
                ]);
            }
            

            Log::info('Creating email queued now');

            $queued = EmailQueuedSend::create([
                'email_broadcast_id' => $broadcast->id,
                'recipient_id' => $recipient_user?->id,
                'email_address' => $recipient_email,
                'subject' => $subject,
                'html_content' => $html,
                'scheduled_at' => $schedule_at,
                'status' => 'queued',
            ]);

            Log::info('Sending queud email job now');
            SendQueuedEmailJob::dispatch($queued)->delay($schedule_at);

            return $queued;
        });
    }
}
