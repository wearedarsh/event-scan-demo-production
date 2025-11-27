<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class CheckInWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
       Log::info('Check in webhook request');

        if ($request->ip() !== config('services.eventscan.request_ip_address')) {
            Log::warning('Unauthorized IP attempted to access CheckIn webhook: ' . $request->ip());
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Log::info('I have had a little webhook call form my parent');

        $validated = $request->validate([
            'attendee_id' => 'required|exists:registrations,id',
            'event_session_id' => 'required|exists:event_sessions,id',
            'event_id' => 'required|exists:events,id',
            'checked_in_by' => 'required|exists:users,id',
            'checked_in_route' => 'required|string',
            'checked_in_at' => 'nullable|date',
        ]);

        $exists = CheckIn::where([
            'attendee_id' => $request->attendee_id,
            'event_id' => $request->event_id,
            'event_session_id' => $request->event_session_id,
        ])->first();

        if ($exists) {
            Log::info('This check in already exists');
            return response()->json([
                'status' => 'duplicate',
                'message' => 'This person has already checked in',
            ], 200);
        }


        try {
            $checkIn = CheckIn::create([
                'attendee_id' => $validated['attendee_id'],
                'event_session_id' => $validated['event_session_id'],
                'event_id' => $validated['event_id'],
                'checked_in_by' => $validated['checked_in_by'],
                'checked_in_route' => $validated['checked_in_route'],
                'checked_in_at' => $validated['checked_in_at'] ?? now(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'This person has already checked in',
                ], 200);
            }
            throw $e;
        }

        return response()->json(['status' => 'ok', 'check_in_id' => $checkIn->id]);
    }
}
