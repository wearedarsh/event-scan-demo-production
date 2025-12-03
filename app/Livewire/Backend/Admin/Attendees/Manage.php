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
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\EmailMarketing\EmailMarketingService;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    use WithPagination;

    public EmailSend $email_send;
    public Event $event;
    public Registration $attendee;

    public $currency_symbol;

    // Modals
    public bool $showEditPaymentModal = false;
    public bool $showMarkPaidModal   = false;
    public bool $showLabelModal      = false;

    // Payments
    public string $payment_date = '';
    public string $payment_hour = '';
    public string $payment_minute = '';

    // Label modal
    public string $slot = '';
    public string $selectedFormat = '75mm_110mm'; // default

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

        // Defaults
        $this->slot = '';
        $this->selectedFormat = '75mm_110mm';
    }

    public function updateSlot($slot)
    {
        Log::info("Selected slot: " . $slot);
        $this->slot = $slot;
    }

    public function downloadLabel()
    {
        if (!$this->slot) {
            $this->addError('slot', 'Please select a label position.');
            return;
        }

        return redirect()->route(
            'admin.events.attendees.label.export',
            [
                $this->event->id,
                $this->attendee->id,
                'slot' => $this->slot,
                'mode' => $this->selectedFormat,
            ]
        );
    }

    public function openLabelModal(): void
    {
        $this->resetErrorBag();
        $this->slot = '';
        $this->selectedFormat = '75mm_110mm';
        $this->showLabelModal = true;
    }

    public function openMarkPaidModal(): void
    {
        $this->resetErrorBag();
        $this->payment_date = now()->format('d-m-Y');
        $this->showMarkPaidModal = true;
    }

    public function confirmMarkAsPaid(): void
    {
        $this->validate([
            'payment_date' => ['required', 'regex:/^\d{2}-\d{2}-\d{4}$/'],
        ]);

        $parsedDate = Carbon::createFromFormat('d-m-Y', $this->payment_date)->startOfDay();

        $this->attendee->update(['paid_at' => $parsedDate]);

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

        $this->attendee->update(['paid_at' => $timestamp]);

        $this->showEditPaymentModal = false;
        session()->flash('success', 'Payment date updated successfully.');
    }

    public function render()
    {
        return view('livewire.backend.admin.attendees.manage', [
            'activity_logs' => Activity::where('causer_id', $this->attendee->user->id)
                ->latest()->limit(20)->paginate(20),

            'email_sends' => EmailSend::where('recipient_id', $this->attendee->user->id)
                ->latest()->paginate(20),

            'check_ins' => $this->attendee->checkIns()
                ->with(['session', 'checkedInBy'])
                ->orderByDesc('checked_in_at')
                ->paginate(20),

            'attendee' => $this->attendee,
            'event'    => $this->event,
        ]);
    }

    public function updateEmailOptIn()
    {
        $emailService = app(EmailMarketingService::class);

        $user = $this->attendee->user;

        $attendee_array = [
            'email'      => $user->email,
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'title'      => $user->title,
        ];

        if (!$user->email_marketing_opt_in) {
            $subscriber_id = $emailService->addToList(
                $attendee_array,
                config('services.emailblaster.marketing_list_id')
            );

            $user->update([
                'email_marketing_opt_in'     => true,
                'email_marketing_subscriber_id' => $subscriber_id,
            ]);

            session()->flash('opt_in', 'Attendee added to the marketing list.');
        } else {
            $emailService->removeFromList(
                $user->email_marketing_subscriber_id,
                config('services.emailblaster.marketing_list_id')
            );

            $user->update([
                'email_marketing_opt_in'     => false,
                'email_marketing_subscriber_id' => null,
            ]);

            session()->flash('opt_in', 'Attendee removed from the marketing list.');
        }
    }

    public function sendWelcome()
    {
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

        session()->flash('welcome', 'Welcome email sent.');
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

    public function sendReceipt()
    {
        $method = $this->attendee->eventPaymentMethod->payment_method;

        if ($method === 'stripe') {
            $mailable = new StripeConfirmationCustomer($this->attendee, $this->attendee->registration_total);
            $type = 'Stripe confirmation customer';
        } else {
            $mailable = new BankTransferConfirmationCustomer($this->attendee, $this->attendee->registration_total);
            $type = 'Bank transfer confirmation customer';
        }

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_email: $this->attendee->user->email,
            recipient_user: $this->attendee->user,
            sender_id: auth()->id(),
            friendly_name: $type,
            type: 'Admin triggered',
            event_id: $this->attendee->event->id,
        );

        session()->flash('receipt', 'Receipt sent to attendee.');
    }
}
