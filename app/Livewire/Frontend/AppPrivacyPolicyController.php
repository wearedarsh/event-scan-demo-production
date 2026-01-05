<?php

namespace App\Livewire\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Event;


class AppPrivacyPolicyController extends Controller
{

    public function show()
    {
        $events = Event::where('active', true)
            ->orderBy('date_start', 'asc')->get();
        return view('livewire.frontend.app-privacy-policy', [
            'privacy_email' => client_setting('check_in_app.privacy_email'),
            'page_title' => 'Check in app privacy policy',
            'events' => $events
        ]);
    }
}
