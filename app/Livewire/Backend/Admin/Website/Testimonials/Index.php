<?php

namespace App\Livewire\Backend\Admin\Website\Testimonials;

use Livewire\Component;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public $orders = [];
    public $testimonials;

    public function mount()
    {
        $this->loadTestimonials();
    }

    private function loadTestimonials()
    {
        $this->testimonials = Testimonial::orderBy('display_order')->get();

        $this->orders = $this->testimonials
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function moveUp($id)
    {
        $item = Testimonial::findOrFail($id);

        if ($item->display_order <= 1) {
            return;
        }

        $item->decrement('display_order', 1);

        $this->loadTestimonials();
    }

    public function moveDown($id)
    {
        $item = Testimonial::findOrFail($id);

        $item->increment('display_order', 1);

        $this->loadTestimonials();
    }

    public function updateOrder($id)
    {
        if (!isset($this->orders[$id])) {
            return;
        }

        $newOrder = max(1, (int)$this->orders[$id]);

        Testimonial::where('id', $id)->update([
            'display_order' => $newOrder,
        ]);

        $this->loadTestimonials();
        session()->flash('success', 'Order updated');
    }

    public function delete(int $id)
    {
        Testimonial::findOrFail($id)->delete();

        session()->flash('success', 'Testimonial deleted successfully.');
        $this->loadTestimonials();
    }

    public function render()
    {
        return view('livewire.backend.admin.website.testimonials.index');
    }
}
