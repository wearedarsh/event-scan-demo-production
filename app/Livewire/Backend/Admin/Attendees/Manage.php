<?php

namespace App\Livewire\Backend\Admin\Attendees;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use App\Models\Registration;
use App\Models\Event;
use App\Models\EmailSend;
use App\Mail\StripeConfirmationCustomer;
use App\Mail\BankTransferConfirmationCustomer;
use App\Mail\WelcomeEmailCustomer;
use Spatie\Activitylog\Models\Activity;
use App\Services\EmailService;
use App\Models\EmailQueuedSend;
use App\Jobs\SendQueuedEmailJob;

use Carbon\Carbon;


use App\Services\EmailMarketing\EmailMarketingService;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{

    public EmailSend $email_send;
    public Event $event;
    public Registration $attendee;
    public $currency_symbol;
    public bool $showEditPaymentModal = false;
    public string $payment_date = '';
    public string $payment_hour = '';
    public string $payment_minute = '';
    public bool $showMarkPaidModal = false;
    public bool $showLabelModal = false;

    #[Computed]
    public function roleKey(): string
    {
        return auth()->user()->role->key_name ?? '';
    }

    public function mount(Event $event, Registration $attendee){
        $this->event = $event;
        $this->attendee = $attendee;
        $this->currency_symbol = config('app.currency_symbol', '€');
    }

    public function openLabelModal(): void
    {
        $this->resetErrorBag();
        $this->showLabelModal = true;
    }

    public function openMarkPaidModal(): void
    {
        $this->resetErrorBag();
        $this->payment_date = now()->format('d-m-Y'); // optional
        $this->showMarkPaidModal = true;
    }

    public function confirmMarkAsPaid(): void
    {
        $this->validate([
            'payment_date' => ['required', 'regex:/^\d{2}-\d{2}-\d{4}$/'],
        ]);

        $parsedDate = Carbon::createFromFormat('d-m-Y', $this->payment_date)->startOfDay();

        $this->attendee->update([
            'paid_at' => $parsedDate,
        ]);

        $this->showMarkPaidModal = false;
        session()->flash('success', 'Registration marked as paid successfully.');
    }

    public function closeMarkPaidModal(): void
    {
        $this->reset(['payment_date']);
        $this->resetErrorBag();
        $this->showMarkPaidModal = false;
    }


    public function openEditPaymentModal()
    {
        if ($this->attendee->eventPaymentMethod->payment_method !== 'bank_transfer') {
            return;
        }

        $paid_at = $this->attendee->paid_at ?? now();
        $this->payment_date   = $paid_at->format('d-m-Y');
        $this->payment_hour   = $paid_at->format('H');
        $this->payment_minute = $paid_at->format('i');

        $this->showEditPaymentModal = true;
    }

    public function updatePaymentDate()
    {
        $this->validate([
            'payment_date'   => 'required|regex:/^\d{2}-\d{2}-\d{4}$/',
            'payment_hour'   => 'required|numeric|min:0|max:23',
            'payment_minute' => 'required|numeric|min:0|max:59',
        ]);

        $timestamp = Carbon::createFromFormat(
            'd-m-Y H:i',
            "{$this->payment_date} {$this->payment_hour}:{$this->payment_minute}"
        );

        $this->attendee->update([
            'paid_at' => $timestamp,
        ]);

        $this->showEditPaymentModal = false;
        session()->flash('success', 'Payment date updated successfully.');
    }

    public function render()
    {
        $activity_logs = Activity::where('causer_id', $this->attendee->user->id)
            ->latest()->limit(20)->get();

        $email_sends = EmailSend::where('recipient_id', $this->attendee->user->id)
            ->latest()->get();

        $check_ins = $this->attendee->checkIns()
            ->with(['session', 'checkedInBy'])
            ->orderByDesc('checked_in_at')
            ->get();

        return view('livewire.backend.admin.attendees.manage', [
            'activity_logs' => $activity_logs,
            'attendee'      => $this->attendee,
            'event'        => $this->event,
            'email_sends'   => $email_sends,
            'check_ins'     => $check_ins,
        ]);
    }
    

    public function updateEmailOptIn()
    {
        $attendee_array = [
            'email' => $this->attendee->user->email,
            'first_name' => $this->attendee->user->first_name,
            'last_name' => $this->attendee->user->last_name,
            'title' => $this->attendee->user->title
        ];

        $emailService = app(EmailMarketingService::class);

        if (!$this->attendee->user->email_marketing_opt_in) {

            $email_subscriber_id = $emailService->addToList($attendee_array, config('services.emailblaster.marketing_list_id'));

            $this->attendee->user->update([
                'email_marketing_opt_in' => true,
                'email_marketing_subscriber_id' => $email_subscriber_id
            ]);
            session()->flash('opt_in', 'Attendee added to the marketing opt in list on Email Blaster');

        } else {

            $emailService->removeFromList($this->attendee->user->email_marketing_subscriber_id, config('services.emailblaster.marketing_list_id'));

            $this->attendee->user->update([
                'email_marketing_opt_in' => false,
                'email_marketing_subscriber_id' => null
            ]);
            session()->flash('opt_in', 'Attendee removed from the marketing opt in list on Email Blaster');

        }
    }

    public function sendWelcome(){
        // Mail::to($this->attendee->user->email)->send(
        //     (new WelcomeEmailCustomer($this->attendee))->from(config('mail.customer.address'), config('mail.customer.name'))
        // );

        $mailable = new WelcomeEmailCustomer($this->attendee);

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_email: $this->attendee->user->email,
            recipient_user: $this->attendee->user,
            friendly_name: 'Welcome email customer',
            sender_id: auth()->id(),
            type: 'Admin triggered',
            event_id: $this->attendee->event->id,
        );
        session()->flash('welcome', 'Welcome email sent to the attendee');
    }

    public function resendEmail(int $email_send_id)
    {
        $send = EmailSend::with('broadcast')
            ->where('recipient_id', $this->attendee->user->id)
            ->findOrFail($email_send_id);

        if ($send->broadcast && $send->broadcast->event_id !== $this->event->id) {
            $this->addError('resend', 'That email belongs to a different event.');
            return;
        }
        
        $queued = EmailQueuedSend::create([
            'email_broadcast_id' => $send->email_broadcast_id,
            'recipient_id'       => $send->recipient_id,
            'email_address'      => $send->email_address,
            'subject'            => $send->subject,
            'html_content'       => $send->html_content,
            'status'             => 'queued',
            'scheduled_at'       => null,
        ]);

        SendQueuedEmailJob::dispatch($queued);

        session()->flash('success', 'Email queued for resend.');
    }

    public function sendReceipt(){
        if($this->attendee->eventPaymentMethod->payment_method === 'stripe'){


            $mailable = new StripeConfirmationCustomer($this->attendee, $this->attendee->registration_total);

            EmailService::queueMailable(
                mailable: $mailable,
                recipient_email: $this->attendee->user->email,
                recipient_user: $this->attendee->user,
                sender_id: auth()->id(),
                friendly_name: 'Stripe confirmation customer',
                type: 'Admin triggered',
                event_id: $this->attendee->event->id,
            );


            session()->flash('receipt', 'Stripe receipt sent to the attendees account email address');
        }elseif($this->attendee->eventPaymentMethod->payment_method === 'bank_transfer'){

            $mailable = new BankTransferConfirmationCustomer($this->attendee, $this->attendee->registration_total);

            EmailService::queueMailable(
                mailable: $mailable,
                recipient_email: $this->attendee->user->email,
                recipient_user: $this->attendee->user,
                sender_id: auth()->id(),
                friendly_name: 'Bank transfer confirmation customer',
                type: 'Admin triggered',
                event_id: $this->attendee->event->id,
            );
            session()->flash('receipt', 'Bank transfer receipt sent to the attendees account email address');
        }
    }
}
