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
