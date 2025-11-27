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
            
            return view('livewire.frontend.privacy-policy', [
                'page_title' => config('customer.contact_details.booking_website_company_name') . ' privacy policy',
                'og_title' => 'Our privacy policy',
                'og_description' => 'Globally held courses and events by' . config('customer.contact_details.booking_website_company_name'),
                'company_name' => config('customer.contact_details.booking_website_company_name'),
                'events' => $events
            ]);
        }
}
