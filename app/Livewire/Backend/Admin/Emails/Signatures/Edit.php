<?php

namespace App\Livewire\Backend\Admin\Emails\Signatures;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EmailSignature;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public EmailSignature $signature_html_content;

    public string $title = '';
    public string $html_content = '';

    public function mount(EmailSignature $signature_html_content)
    {
        $this->signature_html_content = $signature_html_content;

        $this->title = $signature_html_content->title;
        $this->html_content = $signature_html_content->html_content;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'html_content' => 'required|string',
        ]);

        $this->signature_html_content->update([
            'title' => $this->title,
            'html_content' => $this->html_content,
        ]);

        session()->flash('success', 'Signature updated successfully.');
        return redirect()->route('admin.emails.signatures.index');
    }

    public function render()
    {
        return view('livewire.backend.admin.emails.signatures.edit');
    }
}
