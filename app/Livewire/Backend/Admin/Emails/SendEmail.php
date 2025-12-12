<?php

namespace App\Livewire\Backend\Admin\Emails;

use App\Mail\CustomEmail;
use App\Models\EmailBroadcast;
use App\Models\EmailBroadcastType;
use App\Models\EmailSignature;
use App\Models\Event;
use App\Models\Ticket;
use App\Services\EmailService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('livewire.backend.admin.layouts.app')]
class SendEmail extends Component
{
	public Event $event;

	public string $custom_subject = '';
	public string $custom_html_content = '';
	public string $signature = '';

	#[Url(as: 'audience', history: true)]
	public string $audience = 'attendees_paid';

	#[Url(as: 'lock', history: false)]
	public bool $lock_audience = false;

	protected function is_ticket_audience(): bool
	{
		return Str::startsWith($this->audience, 'ticket:');
	}

	protected function ticket_id(): ?int
	{
		return $this->is_ticket_audience() ? (int) Str::after($this->audience, 'ticket:') : null;
	}

	protected function ticket_name(): ?string
	{
		$id = $this->ticket_id();
		if (!$id) return null;
		return Ticket::where('event_id', $this->event->id)->where('id', $id)->value('name');
	}

	public function mount(Event $event) { $this->event = $event; }

	public function send()
	{
		$this->validate([
			'custom_subject' => 'required|string',
			'custom_html_content' => ['required', 'string', function ($attr, $val, $fail) {
				if (strlen(trim(strip_tags($val))) < 10) $fail('Content must be at least 10 characters.');
			}],
			'audience' => ['required', function ($attr, $val, $fail) {
				$fixed = ['attendees_paid','registrations_unpaid_complete','attendees_incomplete_feedback'];
				if (!in_array($val, $fixed) && !preg_match('/^ticket:\d+$/', $val)) $fail('Invalid audience.');
				if (preg_match('/^ticket:(\d+)$/', $val, $m)) {
					$exists = Ticket::where('event_id', $this->event->id)->where('id', (int)$m[1])->exists();
					if (!$exists) $fail('Ticket not found for this event.');
				}
			}],
		]);

		$signature_html = $this->signature ? optional(EmailSignature::find($this->signature))->html_content : '';

		$targets = $this->queryAudience()->with('user')->get();

		$friendly = match (true) {
			$this->audience === 'attendees_paid' => 'Email all paid attendees',
			$this->audience === 'registrations_unpaid_complete' => 'Email all unpaid complete registrations',
			$this->audience === 'attendees_incomplete_feedback' => 'Email all attendees that have not completed feedback',
			$this->is_ticket_audience() => 'Email paid attendees who bought '.$this->ticket_label(),
		};

		$broadcast = EmailBroadcast::create([
				'friendly_name' => $friendly,
				'email_broadcast_type_id' => EmailBroadcastType::where('key_name', 'admin_bulk_send')->firstOrFail()->id,
				'sent_at' =>
				'sent_by' => auth()->id(),
				'event_id' => $this->event->id,
			]);

		foreach ($targets as $reg) {
			$mailable = new CustomEmail($this->custom_subject, $this->custom_html_content, $signature_html);

			EmailService::queueMailable(
				mailable: $mailable,
				recipient_user: $reg->user,
				recipient_email: $reg->user?->email ?? '',
				sender_id: auth()->id(),
				friendly_name: $friendly,
				broadcast: $broadcast,
				type: 'admin_bulk_send',
				event_id: $this->event->id,
			);
		}

		session()->flash('success', 'Emails queued for sending.');
		return redirect()->route('admin.events.attendees.index', ['event' => $this->event->id]);
	}

	private function queryAudience()
	{
		if ($this->is_ticket_audience()) {
			$ticket_id = $this->ticket_id();
			return $this->event->attendees()
				->whereHas('registrationTickets', fn($q) => $q->where('ticket_id', $ticket_id));
		}

		return match ($this->audience) {
			'attendees_paid' => $this->event->attendees(),
			'registrations_unpaid_complete' => $this->event->registrations(),
			'attendees_incomplete_feedback' => $this->event->attendees()->feedbackIncompleteForEvent($this->event->id),
		};
	}

	protected function ticket_label(): ?string
	{
		$id = $this->ticket_id();
		if (!$id) return null;

		$ticket = $this->event->tickets()->where('id', $id)->first();
		if (!$ticket) return null;

		$currency = config('app.currency_symbol', '€');
		return "{$currency}{$ticket->price} {$ticket->name} ticket";
	}

	public function getAudienceLabelProperty(): string
	{
		return match (true) {
			$this->audience === 'attendees_paid' => 'attendees',
			$this->audience === 'registrations_unpaid_complete' => 'unpaid registrations',
			$this->audience === 'attendees_incomplete_feedback' => 'attendees that have not completed the feedback form',
			$this->is_ticket_audience() => 'attendees who bought '.$this->ticket_label(),
			default => 'recipients',
		};
	}

	public function getPreviewCountProperty(): int
	{
		return $this->queryAudience()->count();
	}

	public function render()
	{
		$signatures = EmailSignature::where('active', true)->get();
		$tickets = $this->event->tickets()->orderBy('display_order')->get();
		$currency_symbol = config('app.currency_symbol', '€');

		return view('livewire.backend.admin.emails.send-email', [
			'ck_apikey' => config('services.ckeditor.api_key'),
			'signatures' => $signatures,
			'preview_count' => $this->previewCount,
			'tickets' => $tickets,
			'currency_symbol' => $currency_symbol
		]);
	}
}
