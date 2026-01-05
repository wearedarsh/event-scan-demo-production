<?php

namespace App\Livewire\Frontend;
use App\Http\Controllers\Controller;

use App\Models\Event;
use App\Models\Testimonial;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
        {
            $events = Event::where('active', true)
            ->orderBy('date_start', 'asc')
            ->get();

            $events_nav = Event::where('active', true)
            ->orderBy('date_start', 'asc');

                
            $testimonials = Testimonial::where('active', true)->orderBy('display_order', 'asc')->get();

            $currency_symbol = client_setting('general.currency_symbol');

            $company_name = client_setting('general.customer_friendly_name');
            return view('livewire.frontend.home', [
                'page_title' => $company_name . ' events',
                'og_title' => 'Our upcoming global courses',
                'og_description' => 'Globally held courses and events by ' . $company_name,
                'events' => $events,
                'events_nav' => $events_nav,
                'testimonials' => $testimonials,
                'currency_symbol' => $currency_symbol
                ]);
        }
}
