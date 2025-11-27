<?php

namespace App\Livewire\Backend\Admin\Emails\Templates;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EmailHtmlContent;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public function render()
    {
        $emails = EmailHtmlContent::orderBy('title', 'asc')->get();
        return view('livewire.backend.admin.emails.templates.index', [
            'emails' => $emails
        ]);
    }
}
