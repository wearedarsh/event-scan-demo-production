<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use App\Models\Registration;
use App\Models\RegistrationPayment;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\StripeConfirmationCustomer;
use App\Mail\StripeConfirmationAdmin;
use App\Mail\WelcomeEmailCustomer;
use App\Services\EmailService;

use App\Services\EmailMarketing\EmailMarketingService;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, EmailMarketingService $emailService)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');
        
        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (\Exception $e) {
            Log::error("Stripe webhook error: " . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $registration_id = $session->metadata->registration_id ?? null;
            $registration_payment_id = $session->metadata->registration_payment_id;

            if ($registration_id) {
                $registration = Registration::find($registration_id);
                $registration_payment = RegistrationPayment::find($registration_payment_id);

                if ($registration_payment->status === 'paid') {
                    return response()->json(['status' => 'already_processed']);
                }

                if ($registration && $registration_payment) {

                    $registration_total = $registration->calculated_total;

                    $registration_payment->update([
                        'provider_reference' => $session->payment_intent ?? null,
                        'amount_paid_cents' => $session->amount_total,
                        'paid_at' => Carbon::createFromTimestamp($session->created),
                        'status' => 'paid'
                    ]);

                    $registration->update([
                        'payment_status' => 'paid'
                    ]);

                    $registration->user->update([
                        'active' => true
                    ]);
                    
                        try{

                            $mailable = new StripeConfirmationCustomer($registration, $session->amount_total);

                            EmailService::queueMailable(
                                mailable: $mailable,
                                from_address: client_setting('email.customer.from_address'),
                                from_name: client_setting('email.customer.from_name'),
                                recipient_user: $registration->user,
                                recipient_email: $registration->user->email,
                                friendly_name: 'Stripe confirmation customer',
                                type: 'transactional_customer',
                                event_id: $registration->event_id,
                            );

                        }catch(\Throwable $e){
                            Log::error('Error sending customer confirmation email: ' . $e->getMessage());
                        }

                        if(client_setting('email.config.send_second_email_with_receipt')){
                            $mailable = new WelcomeEmailCustomer($registration);

                            EmailService::queueMailable(
                                mailable: $mailable,
                                from_address: client_setting('email.customer.from_address'),
                                from_name: client_setting('email.customer.from_name'),
                                recipient_user: $registration->user,
                                recipient_email: $registration->user->email,
                                friendly_name: 'Welcome email customer',
                                type: 'transactional_customer',
                                event_id: $registration->event_id,
                            );
                        }

                        try {

                            foreach (User::adminNotificationRecipients()->get() as $user) {

                                $mailable = new StripeConfirmationAdmin($registration, $session->amount_total);

                                EmailService::queueMailable(
                                    mailable: $mailable,
                                    from_address: client_setting('email.admin.from_address'),
                                    from_name: client_setting('email.admin.from_name'),
                                    recipient_user: $user,
                                    recipient_email: $user->email,
                                    friendly_name: 'Stripe confirmation admin',
                                    type: 'transactional_admin',
                                    event_id: $registration->event_id,
                                );
                            }

                        } catch (\Throwable $e) {
                            Log::error('Error sending admin email: ' . $e->getMessage());
                        }

                        // if ($registration->event->auto_email_opt_in) {
                        //     $email_subscriber_id = $emailService->addToList([
                        //         'email' => $registration->user->email,
                        //         'first_name' => $registration->user->first_name,
                        //         'last_name' => $registration->user->last_name,
                        //         'title' => $registration->user->title
                        //     ], $registration->event->email_list_id);

                        //     if($email_subscriber_id){
                        //         $registration->update([
                        //             'email_subscriber_id' => $email_subscriber_id
                        //         ]);
                        //     }
                        // }

                        // if ($registration->user->email_marketing_opt_in) {
                        //     $email_subscriber_id = $emailService->addToList([
                        //         'email' => $registration->user->email,
                        //         'first_name' => $registration->user->first_name,
                        //         'last_name' => $registration->user->last_name,
                        //         'title' => $registration->user->title
                        //     ], config('services.emailblaster.marketing_list_id'));

                        //     if($email_subscriber_id){
                        //         $registration->user->update([
                        //             'email_marketing_subscriber_id' => $email_subscriber_id
                        //         ]);
                        //     }

                        // }                    
                    }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
