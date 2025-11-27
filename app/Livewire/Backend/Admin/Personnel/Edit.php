<?php

namespace App\Livewire\Backend\Admin\Personnel;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Personnel;
use App\Models\PersonnelGroup;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
	public Event $event;
	public Personnel $personnel;

	public string $line_1 = '';
    public string $line_2 = '';
    public string $line_3 = '';
	public ?int $personnel_group_id = null;

	public function mount(Event $event, Personnel $personnel)
	{
		$this->event = $event;
		$this->personnel = $personnel;

		$this->line_1 = $personnel->line_1 ?? '';
		$this->line_2 = $personnel->line_2 ?? '';
		$this->line_3 = $personnel->line_3 ?? '';
		$this->personnel_group_id = $personnel->personnel_group_id;
	}

	public function update()
	{
		$this->validate([
			'line_1' => 'required|string|max:255',
			'line_2' => 'nullable|string|max:255',
			'line_3' => 'nullable|string|max:255',
			'personnel_group_id' => 'required|exists:personnel_groups,id',
		], [
			'personnel_group_id.required' => 'Please select a personnel group.',
		]);

		$this->personnel->update([
			'line_1' => $this->line_1,
			'line_2' => $this->line_2,
			'line_3' => $this->line_3,
			'personnel_group_id' => $this->personnel_group_id,
		]);

		session()->flash('success', 'Personnel updated successfully.');
		return redirect()->route('admin.events.personnel.index', ['event' => $this->event->id]);
	}

	public function render()
	{
		$groups = $this->event->personnelGroups()->get();
		return view('livewire.backend.admin.personnel.edit', compact('groups'));
	}
}
