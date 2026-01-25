<?php 

namespace App\Services;

use App\Models\User;
use App\Models\Registration;
use App\Models\EventPaymentMethod;
use App\Models\RegistrationPayment;
use App\Mail\BankTransferConfirmationAdmin;
use App\Mail\BankTransferInformationCustomer;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class RegistrationPaymentService
{

    protected string $booking_reference_prefix;
    protected int $bank_transfer_method_id;
    protected int $stripe_method_id;
    protected int $free_payment_id;

    public function __construct(){
        $this->booking_reference_prefix = client_setting('general.booking_reference_prefix');
        $this->bank_transfer_method_id = EventPaymentMethod::where('key_name', 'bank_transfer')->first()->id;
        $this->stripe_method_id = EventPaymentMethod::where('key_name', 'stripe')->first()->id;
        $this->free_payment_id = EventPaymentMethod::where('key_name', 'no_payment_due')->first()->id;
    }

    public function completeFreeRegistration(Registration $registration): void
    {
        $registration->update([
            'registration_status' => 'complete',
            'payment_status' => 'paid',
            'booking_reference' => $registration->ensureBookingReference()
        ]);

        $free_payment = RegistrationPayment::updateOrCreate([
            'registration_id' => $registration->id,
            'event_payment_method_id' => $this->free_payment_id
        ],[
            'amount_paid_cents' => 0,
            'total_amount_due_cents' => $registration->calculated_total_cents,
            'provider_reference' => null,
            'provider' =>'no_payment_due',
            'paid_at' => now(),
            'status' => 'paid',
        ]);

        $registration->user->update(['active' => true]);

        //send emails
    }

    public function initiateBankTransfer(Registration $registration): void
    {

        $bank_transfer_payment = RegistrationPayment::updateOrCreate([
            'registration_id' => $registration->id,
            'event_payment_method_id' => $this->bank_transfer_method_id
        ],[
            'amount_paid_cents' => 0,
            'total_amount_due_cents' => $registration->calculated_total_cents,
            'provider_reference' => null,
            'provider' =>'bank_transfer',
            'paid_at' => null,
            'status' => 'pending',
        ]);

        $registration->ensureBookingReference();


        if($bank_transfer_payment->wasRecentlyCreated){

            $registration->update([
                'registration_status' => 'complete',
                'payment_status' => 'pending',
            ]);


            foreach (User::adminNotificationRecipients()->get() as $user) {
                
                $mailable = new BankTransferConfirmationAdmin($registration);

                EmailService::queueMailable(
                    mailable: $mailable,
                    from_address: client_setting('email.admin.from_address'),
                    from_name: client_setting('email.admin.from_name'),
                    recipient_user: $user,
                    recipient_email: $user->email,
                    friendly_name: 'Registration complete pending bank transfer payment admin',
                    type: 'transactional_admin',
                    event_id: $registration->event_id,
                );
            }

            $mailable = new BankTransferInformationCustomer($registration);

            EmailService::queueMailable(
                mailable: $mailable,
                from_address: client_setting('email.customer.from_address'),
                from_name: client_setting('email.customer.from_name'),
                recipient_user: $registration->user,
                recipient_email: $registration->user->email,
                friendly_name: 'Registration complete pending bank transfer payment admin',
                type: 'transactional_customer',
                event_id: $registration->event_id,
            );
        }
    }

    public function createStripeCheckoutSession(Registration $registration): string
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $line_items = $registration->registrationTickets->map(function ($reg_ticket) {
            return [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $reg_ticket->ticket->name,
                    ],
                    'unit_amount' => $reg_ticket->price_cents_at_purchase,
                ],
                'quantity' => $reg_ticket->quantity,
            ];
        })->toArray();

        $registration->ensureBookingReference();

        $registration->update([
            'registration_status' => 'complete',
            'payment_status' => 'pending',
        ]);

        $registration_payment = RegistrationPayment::create([
                'registration_id' => $registration->id,
                'event_payment_method_id' => $this->stripe_method_id,
                'amount_paid_cents' => 0,
                'total_amount_due_cents' => $registration->calculated_total_cents,
                'provider_reference' => null,
                'provider' =>'stripe',
                'paid_at' => null,
                'status' => 'pending',
        ]);


        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('registration', [
                'registration_id' => $registration->id,
                'event' => $registration->event,
                'system_state' => 'stripe-payment-pending'
            ]),
            'cancel_url' => route('registration', [
                'event' => $registration->event,
            ]),
            'customer_email' => $registration->email,
            'metadata' => [
                'registration_id' => $registration->id,
                'registration_payment_id' => $registration_payment->id
            ],
        ]);

        return $session->url;
    }

}
