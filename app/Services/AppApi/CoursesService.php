<?php

namespace App\Services\AppApi;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventsService
{
    public function handle(Request $request)
    {
        
        Log::info('Events request from: ' . $request->ip());
        Log::info('Request from parent webhook: ' . $request);


        $events = Event::where('active', true)
            ->orderBy('date_start')
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'location' => $event->location,
                    'date_start' => $event->date_start,
                    'date_end' => $event->date_end,
                    'attendee_count' => $event->attendees->count(),
                ];
            });

        return response()->json([
            'status' => 'ok',
            'events' => $events,
        ]);
    }
}
