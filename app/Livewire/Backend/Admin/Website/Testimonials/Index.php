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
        $this->testimonials = Testimonial::orderBy('display_order', 'asc')->get();

        $this->orders = $this->testimonials
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function updateOrder($id, $value)
    {
        $value = max(1, (int) $value);

        Testimonial::where('id', $id)->update([
            'display_order' => $value
        ]);

        // Refresh the collection
        $this->orders[$id] = $value;
        $this->dispatch('notify', 'Display order updated.');
    }




    public function delete(int $id)
    {
        $content = Testimonial::findOrFail($id);
        $content->delete();
        session()->flash('success', 'Testimonial deleted successfully.');
    }

    public function render()
    {
        $this->testimonials = Testimonial::orderBy('display_order')->get();
        return view('livewire.backend.admin.website.testimonials.index');
    }
}
