<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;

class Tickets extends Component
{
    use WithFileUploads;

    public Event $event;
    public Registration $registration;

    public Collection $ticketLookup;
    public Collection $ticketsRequiringUploads;

    public array $single_ticket_selections = [];
    public array $multiple_ticket_selections = [];
    public array $ticket_documents = [];
    public array $replace_document = [];

    public int $registration_total_cents = 0;
    public string $currency_symbol = '';

    public $step_help_info;
    public $total_steps;

    protected $listeners = [
        'validate-step' => 'validateStep',
    ];

    public function mount(): void
    {
        $this->currency_symbol = client_setting('general.currency_symbol');
        $tickets = Ticket::where('event_id', $this->event->id)->get();

        $this->ticketLookup = $tickets->keyBy('id');
        $this->ticketsRequiringUploads = $tickets
            ->where('requires_document_upload', true)
            ->keyBy('id');

        $this->registration->load([
            'registrationDocuments',
            'registrationTickets.ticket',
        ]);

        $this->hydrateFromStoredTickets();
    }

    protected function hydrateFromStoredTickets(): void
    {
        if ($this->registration->registrationTickets->isEmpty()) {
            return;
        }

        foreach ($this->registration->registrationTickets as $regTicket) {
            $ticket = $regTicket->ticket;
            $group  = $ticket->ticketGroup;

            if ($group->multiple_select) {
                $this->multiple_ticket_selections[$ticket->id] = $regTicket->quantity;
            } else {
                $this->single_ticket_selections[$group->id] = $ticket->id;
            }
        }

        $this->recalculateTotals();
    }

    public function selectedTicketIds(): Collection
    {
        return collect($this->single_ticket_selections)
            ->filter(fn($id) => is_numeric($id))
            ->map(fn($id) => (int) $id)
            ->merge(
                collect($this->multiple_ticket_selections)
                    ->filter(fn($qty) => (int) $qty > 0)
                    ->keys()
                    ->map(fn($id) => (int) $id)
            )
            ->unique()
            ->values();
    }

    public function selectedTicketsRequiringUploads(): Collection
    {
        return $this->ticketsRequiringUploads->filter(
            fn($ticket) => $this->selectedTicketIds()->contains($ticket->id)
        );
    }

    public function updatedSingleTicketSelections(): void
    {
        $this->recalculateTotals();
    }

    public function updatedMultipleTicketSelections(): void
    {
        $this->recalculateTotals();
    }

    public function getRegistrationTotalProperty(): string
    {
        return $this->registration->calculated_total;
    }

    protected function recalculateTotals(): void
    {
        $this->registration_total_cents = $this->registration->calculated_total_cents;
    }

    protected function validateRequiredTicketGroups(): void
    {
        foreach ($this->event->ticketGroups->where('required', true) as $group) {
            if (!$group->multiple_select) {
                if (empty($this->single_ticket_selections[$group->id] ?? null)) {
                    $this->addError(
                        "ticket_group_{$group->id}",
                        "Please select a ticket from {$group->name}."
                    );
                }
            } else {
                $hasSelection = $group->activeTickets->contains(
                    fn($ticket) => ($this->multiple_ticket_selections[$ticket->id] ?? 0) > 0
                );

                if (!$hasSelection) {
                    $this->addError(
                        "ticket_group_{$group->id}",
                        "Please select at least one ticket from {$group->name}."
                    );
                }
            }
        }
    }

    protected function validateRequiredUploads(): void
    {
        foreach ($this->selectedTicketsRequiringUploads() as $ticket) {

            $isReplacing = !empty($this->replace_document[$ticket->id]);

            $existingDocument = $this->registration
                ->registrationDocuments
                ->firstWhere('ticket_id', $ticket->id);

            $file = $this->ticket_documents[$ticket->id] ?? null;

            if (($isReplacing || !$existingDocument) && !$file) {
                $this->addError(
                    "ticket_documents.{$ticket->id}",
                    "Please upload a document for {$ticket->name}."
                );
                continue;
            }

            if ($file) {
                $rules = ['file', 'max:5120'];

                if ($types = $ticket->allowedFileTypes()) {
                    $rules[] = 'mimes:' . implode(',', $types);
                }

                $this->validate([
                    "ticket_documents.{$ticket->id}" => $rules,
                ]);
            }
        }
    }

    protected function cleanupOrphanedDocuments(): void
    {
        $validTicketIds = $this->selectedTicketIds();

        $this->registration->registrationDocuments
            ->whereNotIn('ticket_id', $validTicketIds)
            ->each(function ($doc) {
                Storage::disk('private')->delete($doc->file_path);
                $doc->delete();
            });
    }

    protected function persistUploads(): void
    {
        foreach ($this->ticket_documents as $ticketId => $file) {
            if (!$file) continue;

            $path = $file->store(
                "registrations/{$this->registration->id}/document_uploads",
                'private'
            );

            $this->registration->registrationDocuments()->updateOrCreate(
                ['ticket_id' => $ticketId],
                [
                    'file_path'     => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]
            );

            unset($this->replace_document[$ticketId]);
        }
    }

    protected function persistTicketSelections(): void
    {
        $this->registration->registrationTickets()->delete();

        foreach ($this->single_ticket_selections as $ticketId) {
            if (!$ticketId) continue;

            $ticket = $this->ticketLookup[$ticketId];

            $this->registration->registrationTickets()->create([
                'ticket_id'        => $ticket->id,
                'quantity'         => 1,
                'price_cents_at_purchase' => $ticket->price_cents,
            ]);
        }

        foreach ($this->multiple_ticket_selections as $ticketId => $qty) {
            if ((int) $qty <= 0) continue;

            $ticket = $this->ticketLookup[$ticketId];

            $this->registration->registrationTickets()->create([
                'ticket_id'        => $ticket->id,
                'quantity'         => (int) $qty,
                'price_cents_at_purchase' => $ticket->price_cents,
            ]);
        }
    }


    public function validateStep(string $direction): void
    {
        $this->dispatch('scroll-to-top');
        $this->resetErrorBag();

        if ($direction === 'forward') {
            $this->validateRequiredTicketGroups();
            $this->validateRequiredUploads();

            if ($this->getErrorBag()->isNotEmpty()) return;

            $this->cleanupOrphanedDocuments();
            $this->persistUploads();
            $this->persistTicketSelections();
        }


        $this->dispatch('update-step', $direction);
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.tickets');
    }
}
