<?php

namespace App\Livewire\Backend\Admin\Registrations;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Registration;
use Livewire\WithPagination;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public Event $event;
    public $currency_symbol;
    public $search = '';
    public $paymentMethod = '';

    #[Computed]
    public function roleKey(): string
    {
        return auth()->user()->role->key_name ?? '';
    }

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->currency_symbol = client_setting('general.currency_symbol');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaymentMethod()
    {
        $this->resetPage();
    }

    public function render()
    {
        $registrations = $this->event->registrations()
            ->where(function($query) {
                $query->whereHas('user', fn($q) => $q->where('email', 'like', "%{$this->search}%"))
                      ->orWhere('last_name', 'like', "%{$this->search}%");
            })
            ->when($this->paymentMethod, function ($query) {
                $query->whereHas('eventPaymentMethod', fn($q) => $q->where('payment_method', $this->paymentMethod));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.backend.admin.registrations.index', compact('registrations'));
    }

    public function delete(int $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->user->update(['active' => false]);
        $registration->delete();
        $registration->user->delete();

        session()->flash('success', 'Registration soft deleted successfully.');
    }
}