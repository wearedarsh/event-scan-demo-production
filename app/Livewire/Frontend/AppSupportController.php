<?php

namespace App\Livewire\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Event;


class AppSupportController extends Controller
{

    public function show()
    {
        $events = Event::where('active', true)
            ->orderBy('date_start', 'asc')->get();
        return view('livewire.frontend.app-support', [
            'privacy_email' => client_setting('check_in{app.privacy_email'),
            'page_title' => 'Check in app privacy policy',
            'events' => $events
        ]);
    }
}
