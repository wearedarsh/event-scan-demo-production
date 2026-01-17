<?php 

namespace App\Services;

use App\Models\Registration;
use App\Models\EventPaymentMethod;
use App\Models\RegistrationPayment;
use App\Mail\BankTransferConfirmationAdmin;
use App\Mail\BankTransferConfirmationCustomer;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class RegistrationPaymentService
{

    protected string $booking_reference_prefix;
    protected int $bank_transfer_method_id;

    public function __construct(){
        $this->booking_reference_prefix = client_setting('general.booking_reference_prefix');
        $this->bank_transfer_method_id = EventPaymentMethod::where('key_name', 'bank_transfer')->first()->id;
    }

    public function completeFreeRegistration(Registration $registration): void
    {
        $registration->update([
            'payment_status' => 'paid',
            'event_payment_method_id' =>
                EventPaymentMethod::where('key_name', 'no_payment')->first()->id,
            'booking_reference' => $this->generateBookingReference($registration),
            'total_cents' => 0,
            'paid_at' => now(),
        ]);

        $registration->user->update(['active' => true]);
    }

    public function initiateBankTransfer(Registration $registration): void
    {
        $payment = RegistrationPayment::where('registration_id', $registration->id)
            ->where('event_payment_method_id', $this->bank_transfer_method_id);

        if($payment && $registration->registration_status === 'complete'){
            return;
        }else{

            $registration->update([
                'registration_status' => 'complete',
                'payment_status' => 'pending'
            ]);

            RegistrationPayment::updateOrCreate([
                'registration_id' => $registration->id,
                'event_payment_method_id' => $this->bank_transfer_method_id,
                'amount_cents' => 0,
                'total_cents' => $registration->calculated_total_cents,
                'payment_intent_id' => null,
                'paid_at' => now(),
                'status' => 'pending',
            ]);

            $mailable = new BankTransferConfirmationAdmin($registration);

            EmailService::queueMailable(
                mailable: $mailable,
                from_address: client_setting('email.admin.from_address'),
                from_name: client_setting('email.admin.from_name'),
                recipient_user: $registration->user,
                recipient_email: $registration->user->email,
                friendly_name: 'Registration complete pending bank transfer payment admin',
                type: 'transactional_admin',
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

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [
                'registration_id' => $registration->id,
                'event' => $registration->event,
            ]),
            'cancel_url' => route('registration', [
                'event' => $registration->event,
            ]) . '?step=payment&cancelled=true',
            'customer_email' => $registration->email,
            'metadata' => [
                'registration_id' => $registration->id,
            ],
        ]);

        return $session->url;
    }

    protected function generateBookingReference(Registration $registration): string
    {
        return $this->booking_reference_prefix
            . '-' . random_int(1000, 9999)
            . '-' . $registration->user_id
            . '-' . $registration->event_id;
    }
}
