<?php

namespace App\Livewire\Backend\Admin\App;
use Livewire\Attributes\Layout;
use App\Mail\CheckInAppInstructionAdmin;
use App\Services\EmailService;

use Livewire\Component;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public $client_id;
    public $auth_token;
    public $app_scheme;
    public $apple_url;
    public $android_url;
    public $qr_prefix;
    public $phone_type = null;
    public $initialise_url;

    public function emailInstructions(){
        
        $user = auth()->user();

        $mailable = new CheckInAppInstructionAdmin($user);

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_email: $user->email,
            recipient_user: $user,
            friendly_name: 'App setup instruction admin',
            type: 'admin_triggered',
            event_id: null,
        );
        session()->flash('success', 'App setup instructions sent to your email address');

    }

    public function render()
    {
        $this->client_id = config('services.eventscan.client_id');
        $this->auth_token = config('check-in-app.auth_token');
        $this->app_scheme = config('check-in-app.scheme');
        $this->apple_url = config('check-in-app.apple_download_url');
        $this->android_url = config('check-in-app.android_download_url');
        $this->qr_prefix = config('check-in-app.qr_prefix');

        $this->initialise_url = $this->app_scheme . '://initialise?client_id=' . $this->client_id . '&auth_token=' . $this->auth_token . '&qr_prefix=' . $this->qr_prefix;
        return view('livewire.backend.admin.app.index');
    }

    public function selectPhone($type)
    {
        $this->phone_type = $type;
    }

}
