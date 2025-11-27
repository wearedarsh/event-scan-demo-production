<?php

namespace App\Livewire\Backend\Admin\Emails\Broadcasts;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\EmailSend;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class View extends Component
{
    public EmailSend $email_send;
    public Event $event;

    public function mount(EmailSend $email_send, Event $event)
    {
        $this->email_send = $email_send->loadCount(['opens', 'clicks']);
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.backend.admin.emails.broadcasts.view');
    }
}
