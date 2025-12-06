<?php

namespace App\Livewire\Backend\Admin\Personnel;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

use App\Models\Event;
use App\Models\Personnel;
use App\Models\PersonnelGroup;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
	use WithPagination;

	public Event $event;
	public string $search = '';
	public string $group_filter = '';
	public bool $showLabelModal      = false;
	// Label modal
    public string $slot = '';
    public string $mode = '80mm_80mm';
	public $selected_personnel_id = null;

	#[Computed]
	public function personnelGroups()
	{
		return $this->event->personnelGroups()->get();
	}

	public function mount(Event $event)
	{
		$this->event = $event;
	}

	public function updatingSearch()
	{
		$this->resetPage();
	}

	public function openLabelModal($personnel_id): void
    {
        $this->resetErrorBag();
        $this->slot = '';
        $this->mode = '80mm_80mm';
		$this->selected_personnel_id = $personnel_id;
        $this->showLabelModal = true;
    }

	public function updateSlot($slot)
    {
        $this->slot = $slot;
    }


	public function downloadLabel()
    {
        if (!$this->slot) {
            $this->addError('slot', 'Please select a label position.');
            return;
        }

        return redirect()->route(
            'admin.events.personnel.label.export',
            [
                $this->event->id,
                'personnel' => $this->selected_personnel_id,
                'slot' => $this->slot,
                'mode' => $this->mode,
            ]
        );
    }

	public function updatingGroupFilter()
	{
		$this->resetPage();
	}

	public function render()
    {
        $personnel = Personnel::with('group')
            ->where('event_id', $this->event->id)
            ->when($this->group_filter, fn($query) =>
                $query->where('personnel_group_id', $this->group_filter)
            )
            ->where(function ($query) {
                $query->where('line_1', 'like', "%{$this->search}%")
                    ->orWhere('line_2', 'like', "%{$this->search}%")
                    ->orWhere('line_3', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.backend.admin.personnel.index', compact('personnel'));
    }


	public function deletePersonnelGroup(int $id)
	{
		$group = PersonnelGroup::findOrFail($id);

		if ($group->personnel()->count() > 0) {
			session()->flash('error', 'This group contains personnel and cannot be deleted.');
			return;
		}

		$group->delete();
		session()->flash('success', 'Personnel group deleted successfully.');
	}

	public function delete(int $id)
	{
		Personnel::findOrFail($id)->delete();
		session()->flash('success', 'Personnel entry deleted successfully.');
	}
}
