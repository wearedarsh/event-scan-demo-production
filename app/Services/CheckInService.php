<?php
//THIS IS FOR MANUAL CHECK INS LOCALLY NOT FROM THE APP
namespace App\Services;

use App\Models\CheckIn;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class CheckInService
{
    /**
     * @return array{status:'ok'|'duplicate'|'error', check_in?: \App\Models\CheckIn, message?: string}
     */
    public function record(
        int $attendeeId,
        int $eventId,
        int $sessionId,
        int $byUserId,
        string $route,
        ?string $at = null
    ): array {
        try {
            return DB::transaction(function () use ($attendeeId, $eventId, $sessionId, $byUserId, $route, $at) {
                $checkIn = CheckIn::create([
                    'attendee_id'      => $attendeeId,
                    'event_id'        => $eventId,
                    'event_session_id' => $sessionId,
                    'checked_in_by'    => $byUserId,
                    'checked_in_route' => $route,
                    'checked_in_at'    => $at ? Carbon::parse($at) : now(),
                ]);

                return ['status' => 'ok', 'check_in' => $checkIn];
            });
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return ['status' => 'duplicate', 'message' => 'Already checked in'];
            }
            return ['status' => 'error', 'message' => 'DB error'];
        }
    }
}
