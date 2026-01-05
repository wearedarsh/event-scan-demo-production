<?php

namespace App\Livewire\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Event;



class PrivacyPolicyController extends Controller
{
    public function show()
        {
            $events = Event::where('active', true)
            ->orderBy('date_start', 'asc')->get();

            $company_name = client_setting('general.customer_friendly_name');

            return view('livewire.frontend.privacy-policy', [
                'page_title' => $company_name . ' privacy policy',
                'og_title' => 'Our privacy policy',
                'og_description' => 'Globally held courses and events by' . $company_name,
                'company_name' => $company_name,
                'events' => $events
            ]);
        }
}
