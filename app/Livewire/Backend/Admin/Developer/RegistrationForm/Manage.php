<?php

namespace App\Livewire\Backend\Admin\Developer\RegistrationForm;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\RegistrationForm;
use App\Models\RegistrationFormStep;
use App\Traits\HandlesDisplayOrder;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    use HandlesDisplayOrder;
    public RegistrationForm $form;

    public array $orders = [];

    public function mount(RegistrationForm $form)
    {
        $this->form = $form;
        $this->loadOrders();
    }

    protected function loadOrders(): void
    {
        $this->orders = $this->form->steps
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function moveStepUp(int $id): void
    {
        $this->moveUp(
            RegistrationFormStep::findOrFail($id)
        );

        $this->loadOrders();
    }

    public function moveStepDown(int $id): void
    {
        $this->moveDown(
            RegistrationFormStep::findOrFail($id)
        );

        $this->loadOrders();
    }

    public function updateStepOrder(int $id): void
    {
        if (!isset($this->orders[$id])) {
            return;
        }

        $this->updateOrder(
            RegistrationFormStep::findOrFail($id),
            (int) $this->orders[$id]
        );

        $this->loadOrders();
    }   


    public function deleteStep(int $id): void
    {
        $step = RegistrationFormStep::findOrFail($id);

        $step->delete();

        session()->flash('success', 'Step deleted successfully.');
        $this->loadOrders();
    }

    public function render()
    {
        $steps = $this->form->steps
            ->sortBy(fn ($s) => $this->orders[$s->id] ?? $s->display_order);

        return view('livewire.backend.admin.developer.registration-form.manage', [
            'form'  => $this->form,
            'steps' => $steps,
        ]);
    }
}
