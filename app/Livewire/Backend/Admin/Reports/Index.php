<?php

namespace App\Livewire\Backend\Admin\Reports;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{

    public Event $event;
	public $feedback_forms;

	public function mount(Event $event)
	{
		$this->event = $event;
	}


	public function render()
	{
		return view('livewire.backend.admin.reports.index');
	}
}
