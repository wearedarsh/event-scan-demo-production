<?php

namespace App\Livewire\Backend\Admin\Emails\Broadcasts;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\EmailSend;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public Event $event;
    public string $search = '';

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = EmailSend::query()
            ->with([
                'recipient:id,title,first_name,last_name',
                'broadcast.event:id,title',
            ])
            ->whereHas('broadcast', fn ($q) =>
                $q->where('event_id', $this->event->id)
            );

        if ($this->search !== '') {
            $s = '%' . $this->search . '%';
            $query->where(function ($q) use ($s) {
                $q->where('email_address', 'like', $s)
                  ->orWhere('subject', 'like', $s)
                  ->orWhereHas('recipient', fn ($sub) =>
                      $sub->where('last_name', 'like', $s)
                  );
            });
        }

        $email_sends = $query->orderByDesc('id')->paginate(30);

        return view('livewire.backend.admin.emails.broadcasts.index', [
            'email_sends' => $email_sends,
            'event'      => $this->event,
        ]);
    }
}
