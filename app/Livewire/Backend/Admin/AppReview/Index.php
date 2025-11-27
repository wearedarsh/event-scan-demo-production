<?php

namespace App\Livewire\Backend\Admin\AppReview;
use Livewire\Attributes\Layout;

use Livewire\Component;

#[Layout('livewire.backend.admin.layouts.app-review')]
class Index extends Component
{
    public $app_scheme;

    public $initialise_url;

    public function render()
    {
        $this->app_scheme = config('check-in-app.scheme');

        $this->initialise_url = $this->app_scheme . '://initialise?review=true';

        return view('livewire.backend.admin.app-review.index');
    }
}
