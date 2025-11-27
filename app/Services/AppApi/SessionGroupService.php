<?php

namespace App\Services\AppApi;

use Illuminate\Http\Request;
use App\Models\EventSessionGroup;
use Illuminate\Support\Facades\Log;

class SessionGroupService
{
    public function handle(Request $request)
    {
        Log::info('Session group request');
        Log::info('Request: ' . json_encode($request));
        $request->validate([
            'event_id' => 'required|integer|exists:events,id',
        ]);

        $groups = EventSessionGroup::where('event_id', $request->event_id)
            ->where('active', true)
            ->orderBy('display_order')
            ->get(['id', 'friendly_name', 'display_order']);

        Log::info('Fetched session groups:', $groups->toArray());

        return response()->json([
            'status' => 'ok',
            'groups' => $groups,
        ]);

    }
}
