<?php

namespace App\Livewire\Backend\Admin\Emails\Signatures;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EmailSignature;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public function render()
    {
        $signatures = EmailSignature::orderBy('title', 'asc')->get();
        return view('livewire.backend.admin.emails.signatures.index', [
            'signatures' => $signatures
        ]);
    }
}
