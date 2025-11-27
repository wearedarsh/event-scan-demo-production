<?php

namespace App\Services\AppApi;

use Illuminate\Http\Request;
use App\Models\EventSession;

class SessionService
{
    public function handle(Request $request)
    {
        $request->validate([
            'event_session_group_id' => 'required|integer|exists:event_session_groups,id',
        ]);

        $sessions = EventSession::where('event_session_group_id', $request->event_session_group_id)
            ->orderBy('display_order')
            ->get(['id', 'title', 'start_time', 'end_time', 'cme_points']);

        return response()->json([
            'status' => 'ok',
            'sessions' => $sessions,
        ]);
    }
}
