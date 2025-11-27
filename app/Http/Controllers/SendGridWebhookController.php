<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailOpen;
use App\Models\EmailClick;
use App\Models\EmailBounce;
use App\Models\EmailBroadcast;
use App\Models\EmailSend;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SendGridWebhookController extends Controller
{
    public function __invoke(Request $request)
    {

        if ($request->ip() !== config('services.eventscan.request_ip_address')) {
            Log::warning('Unauthorized IP attempted to access the webhook: ' . $request->ip());
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Log::info('SendGrid webhook hit');
        Log::info('Webhook payload:', $request->all());
        
        foreach ($request->all() as $event) {
            $type = $event['event'] ?? null;
            $email_send_id = $event['email_send_id'] ?? null;

            Log::info("Email send id: {$email_send_id}");
            Log::info("Sendgrid type: {$type}");

            if (!$type || !$email_send_id) {
                continue;
            }

            (match ($type) {
                'delivered' => function() use ($email_send_id) {
                    Log::info("Email delivered: " . $email_send_id);
                    $emailSend = EmailSend::find($email_send_id);
                    $emailSend?->update(['status' => 'delivered']);
                },
                'deferred' => function() use ($email_send_id) {
                    Log::info("Email deferred: " . $email_send_id);

                    $emailSend = EmailSend::find($email_send_id);
                    if ($emailSend->status !== 'delivered') {
                        $emailSend->update(['status' => 'deferred']);
                    }
                },
                'processed' => function() use ($email_send_id) {
                    Log::info("Email processed: " . $email_send_id);
                    $emailSend = EmailSend::find($email_send_id);
                    if ($emailSend->status !== 'delivered') {
                        $emailSend->update(['status' => 'processed']);
                    }
                },
                'open' => function() use ($email_send_id, $event) {
                    Log::info("Email opened: " . $email_send_id);

                    $recipient_email = $event['email'] ?? null;
                    $ip_address = $event['ip'] ?? null;
                    $user_agent = $event['useragent'] ?? null;
                    $timestamp = $event['timestamp'] ?? time();

                    EmailOpen::create([
                        'email_send_id' => $email_send_id,
                        'recipient_email' => $recipient_email,
                        'ip_address' => $ip_address,
                        'user_agent' => $user_agent,
                        'event_time' => date('Y-m-d H:i:s', $timestamp)
                    ]);
                },
                'click' => function() use ($email_send_id, $event) {
                    Log::info("Email clicked: " . $email_send_id);

                    $recipient_email = $event['email'] ?? null;
                    $url = $event['url'] ?? null;
                    $ip_address = $event['ip'] ?? null;
                    $user_agent = $event['useragent'] ?? null;
                    $timestamp = $event['timestamp'] ?? time();

                    EmailClick::create([
                        'email_send_id' => $email_send_id,
                        'recipient_email' => $recipient_email,
                        'url' => $url,
                        'ip_address' => $ip_address,
                        'user_agent' => $user_agent,
                        'event_time' => date('Y-m-d H:i:s', $timestamp)
                    ]);
                },
                'bounce' => function() use ($email_send_id, $event) {
                    Log::info("Email bounced: " . $email_send_id);

                    $recipient_email = $event['email'] ?? null;
                    $type = $event['type'] ?? null;
                    $reason = $event['reason'] ?? $event['status'] ?? 'Unknown';
                    $timestamp = $event['timestamp'] ?? time();

                    EmailBounce::create([
                        'email_send_id' => $email_send_id,
                        'recipient_email' => $recipient_email,
                        'type' => $type,
                        'reason' => $reason,
                        'event_time' => date('Y-m-d H:i:s', $timestamp)
                    ]);

                    Log::info("EmailBounce created for EmailSend ID: " . $email_send_id);
                },
                default => function() {}
            })();
        }

        return response()->json(['status' => 'ok']);
    }
}