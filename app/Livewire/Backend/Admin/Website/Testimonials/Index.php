<?php

namespace App\Livewire\Backend\Admin\Website\Testimonials;

use Livewire\Component;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public function delete(int $id)
    {
        $content = Testimonial::findOrFail($id);
        $content->delete();
        session()->flash('success', 'Testimonial deleted successfully.');
    }

    public function render()
    {
        $testimonials = Testimonial::orderBy('display_order', 'asc')->get();
        return view('livewire.backend.admin.website.testimonials.index',[
            'testimonials' => $testimonials
        ]);
    }
}
