<?php

namespace App\Livewire\Backend\Admin\Emails\Signatures;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EmailSignature;
use Illuminate\Support\Str;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public string $title = '';
    public string $html_content = '';

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'html_content' => 'required|string',
        ]);

        // Generate base key
        $base = Str::snake($this->title);
        $key_name = $base;

        // Ensure unique key_name
        $counter = 1;
        while (EmailSignature::where('key_name', $key_name)->exists()) {
            $key_name = $base . '_' . $counter;
            $counter++;
        }

        EmailSignature::create([
            'title' => $this->title,
            'key_name' => $key_name,
            'html_content' => $this->html_content,
            'active' => true,
        ]);

        session()->flash('success', 'Signature created successfully.');
        return redirect()->route('admin.emails.signatures.index');
    }

    public function render()
    {
        return view('livewire.backend.admin.emails.signatures.create');
    }
}
