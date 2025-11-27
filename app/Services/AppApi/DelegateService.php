<?php

namespace App\Services\AppApi;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class AttendeeService
{
    public function handle(Request $request)
    {

        $request->validate([
            'event_id' => 'required|integer|exists:events,id',
        ]);

        $event = Event::with(['attendees.user:id,first_name,last_name,email'])
            ->findOrFail($request->event_id);

        $attendees = $event->attendees->map(function ($registration) {
            return [
                'id' => $registration->id,
                'user_id' => $registration->user_id,
                'first_name' => optional($registration->user)->first_name,
                'last_name' => optional($registration->user)->last_name,
                'email' => optional($registration->user)->email,
            ];
        });

        return response()->json([
            'status' => 'ok',
            'attendees' => $attendees,
        ]);
    }
}
