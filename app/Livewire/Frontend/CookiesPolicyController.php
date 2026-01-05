<?php

namespace App\Livewire\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Event;



class CookiesPolicyController extends Controller
{
    public function show()
        {
            $company_name = client_setting('general.friendly_name');
            $events = Event::where('active', true)
            ->orderBy('date_start', 'asc')->get();
            return view('livewire.frontend.cookies-policy', [
                'page_title' => $company_name . ' cookies policy',
                'og_title' => 'Our cookies policy',
                'og_description' => 'Globally held courses and events by ' . $company_name,
                'company_name' => $company_name,
                'events' => $events
            ]);
        }
}
