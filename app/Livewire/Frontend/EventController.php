<?php

namespace App\Livewire\Frontend;
use App\Http\Controllers\Controller;

use App\Models\Event;
use App\Models\EventDownload;
use App\Models\EventContent;
use App\Models\Testimonial;

class EventController extends Controller
{

    public function show(Event $event)
    {
        $events = Event::where('active', true)
            ->orderBy('date_start', 'asc')->get();


        $event_content = EventContent::where('event_id', $event->id)->orderBy('order', 'asc')->get();
        $event_display_tickets = $event->frontendTickets;
        $currency_symbol = $currency_symbol = config('app.currency_symbol', '€');

        $testimonials = Testimonial::where('active', true)->orderBy('display_order', 'asc')->get();

        $event_downloads = EventDownload::where('event_id', $event->id)->orderBy('display_order', 'asc')->get();

        return view('livewire.frontend.event', [
            'event' => $event,
            'events' => $events,
            'testimonials' => $testimonials,
            'page_title' => $event->title,
            'og_title' => $event->title,
            'og_description' => 'Event organised by the European venous Forum',
            'event_content' => $event_content,
            'event_display_tickets' => $event_display_tickets,
            'currency_symbol' => $currency_symbol,
            'event_downloads' => $event_downloads
        ]);
    }
}
