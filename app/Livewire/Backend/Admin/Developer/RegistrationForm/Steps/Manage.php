<?php

namespace App\Livewire\Backend\Admin\Developer\RegistrationForm\Steps;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\RegistrationFormStep;
use App\Models\RegistrationFormInput;
use App\Traits\HandlesDisplayOrder;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    use HandlesDisplayOrder;

    public RegistrationFormStep $step;

    public array $orders = [];

    public function mount(RegistrationFormStep $step): void
    {
        abort_if($step->type === 'rigid', 404);

        $this->step = $step;
        $this->loadOrders();
    }

    protected function loadOrders(): void
    {
        $this->orders = $this->step->inputs()
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function moveInputUp(int $id): void
    {
        $this->moveUp(RegistrationFormInput::findOrFail($id));
        $this->loadOrders();
    }

    public function moveInputDown(int $id): void
    {
        $this->moveDown(RegistrationFormInput::findOrFail($id));
        $this->loadOrders();
    }

    public function updateInputOrder(int $id): void
    {
        if (!isset($this->orders[$id])) {
            return;
        }

        $this->updateOrder(
            RegistrationFormInput::findOrFail($id),
            (int) $this->orders[$id]
        );

        $this->loadOrders();
    }

    public function deleteInput(int $id): void
    {
        RegistrationFormInput::findOrFail($id)->delete();

        session()->flash('success', 'Field deleted successfully.');
        $this->loadOrders();
    }

    public function render()
    {
        $inputs = $this->step->inputs
            ->sortBy(fn ($i) => $this->orders[$i->id] ?? $i->display_order);

        return view('livewire.backend.admin.developer.registration-form.steps.manage', [
            'step'   => $this->step,
            'inputs' => $inputs,
        ]);
    }
}
