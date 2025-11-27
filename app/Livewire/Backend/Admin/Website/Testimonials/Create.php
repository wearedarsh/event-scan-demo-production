<?php

namespace App\Livewire\Backend\Admin\Website\Testimonials;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Testimonial;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public $title;
    public $sub_title;
    public $content;
    public $star_rating;
    public string $active = '0';
    public $display_order = 0;

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'star_rating' => 'required|integer|min:1|max:5',
            'display_order' => 'required|integer|min:0',
            'active' => 'required|boolean',
        ]);

        Testimonial::create([
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'content' => $this->content,
            'star_rating' => $this->star_rating,
            'active' => (bool) $this->active,
            'display_order' => $this->display_order,
        ]);

        session()->flash('success', 'Testimonial created successfully.');
        return redirect()->route('admin.website.testimonials.index');
    }

    public function render()
    {
        return view('livewire.backend.admin.website.testimonials.create');
    }
}
