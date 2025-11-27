<?php

namespace App\Livewire\Backend\Admin\Emails\Templates;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EmailHtmlContent;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public EmailHtmlContent $email_html_content;
    public $html_content;

    public function mount(EmailHtmlContent $email_html_content)
    {
        $this->email_html_content = $email_html_content;
        $this->html_content = $email_html_content->html_content;
    }

    public function update()
    {
        $this->validate([
            'html_content' => 'required|string',
        ]);

        $this->email_html_content->update([
            'html_content' => $this->html_content,
        ]);

        session()->flash('success', 'Email updated successfully.');
        return redirect()->route('admin.emails.templates.index');
    }

    

    public function render()
    {
        return view('livewire.backend.admin.emails.templates.edit', [
            'ck_apikey' => config('services.ckeditor.api_key')
        ]);
    }
}
