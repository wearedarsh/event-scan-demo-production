<?php

namespace App\Livewire\Backend\Admin\Registrations;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\BankTransferInformationCustomer;
use App\Services\EmailMarketing\EmailMarketingService;
use Carbon\Carbon;

use App\Models\EmailSend;
use App\Models\EmailQueuedSend;
use App\Jobs\SendQueuedEmailJob;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    public Event $event;
    public Registration $attendee;
    public $currency_symbol;
    public string $payment_date = '';
    public string $payment_hour = '';
    public string $payment_minute = '';
    public bool $showMarkPaidModal = false;

    #[Computed]
    public function roleKey(): string
    {
        return auth()->user()->role->key_name ?? '';
    }

    public function mount(Event $event, Registration $attendee)
    {
        $this->event = $event;
        $this->attendee = $attendee;
        $this->currency_symbol = config('app.currency_symbol', '€');
        $now = now();
        $this->payment_date = $now->format('d-m-Y');
        $this->payment_hour = $now->format('H');
        $this->payment_minute = $now->format('i');

        if ($this->attendee->payment_status === 'paid') {
            session()->flash('success', 'This registration has already made their payment');
            return redirect()->route('admin.events.manage', [
                'event' => $this->event->id
            ]);
        }
    }

    public function render()
    {
        $email_sends = EmailSend::where('recipient_id', $this->attendee->user_id)
            ->latest()->paginate(20);

        return view('livewire.backend.admin.registrations.manage', [
            'attendee'     => $this->attendee,
            'event'       => $this->event,
            'email_sends'  => $email_sends,
        ]);
    }

    public function openMarkPaidModal()
    {
        $this->showMarkPaidModal = true;
    }

    public function confirmMarkAsPaid()
    {
        $this->validate([
            'payment_date' => 'required|regex:/^\d{2}-\d{2}-\d{4}$/',
            'payment_hour' => 'required|numeric|min:0|max:23',
            'payment_minute' => 'required|numeric|min:0|max:59',
        ]);

        $timestamp = Carbon::createFromFormat('d-m-Y H:i', "{$this->payment_date} {$this->payment_hour}:{$this->payment_minute}");
        $randomNumber = random_int(1000, 9999);
        $booking_reference = config('customer.invoice_prefix') . '-' . $randomNumber . '-' . $this->attendee->user_id . '-' . $this->attendee->event_id;

        $this->attendee->update([
            'payment_status' => 'paid',
            'paid_at' => $timestamp,
            'booking_reference' => $booking_reference,
        ]);

        $this->attendee->user->update(['active' => true]);

        $attendee_array = [
            'email' => $this->attendee->user->email,
            'first_name' => $this->attendee->user->first_name,
            'last_name' => $this->attendee->user->last_name,
            'title' => $this->attendee->user->title
        ];

        $emailService = app(EmailMarketingService::class);

        if ($this->attendee->user->email_marketing_opt_in) {
            $email_subscriber_id = $emailService->addToList($attendee_array, config('services.emailblaster.marketing_list_id'));

            $this->attendee->user->update([
                'email_marketing_opt_in' => true,
                'email_marketing_subscriber_id' => $email_subscriber_id
            ]);
        }

        if ($this->attendee->event->auto_email_opt_in) {
            $email_subscriber_id = $emailService->addToList($attendee_array, $this->attendee->event->email_list_id);

            $this->attendee->update([
                'email_subscriber_id' => $email_subscriber_id
            ]);
        }

        session()->flash('success', 'Registration marked as paid and added to attendees.');
        return redirect()->route('admin.events.manage', [
            'event' => $this->event->id
        ]);
    }

    public function sendBankTransferInfo()
    {
        Mail::to($this->attendee->user->email)->send(
            (new BankTransferInformationCustomer($this->attendee, $this->attendee->registration_total))
                ->from(config('mail.customer.address'), config('mail.customer.name'))
        );

        session()->flash('receipt', 'Bank transfer information sent to the registrant\'s email address');
    }

    public function resendEmail(int $email_send_id)
    {
        $send = EmailSend::with('broadcast')
            ->where('recipient_id', $this->attendee->user_id)
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
}
