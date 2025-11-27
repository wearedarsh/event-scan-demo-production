<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CertificateDownloadController extends Controller
{
    

    public function download($booking_id)
    {

        function ordinal($number) {
            $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
            if (($number % 100) >= 11 && ($number % 100) <= 13) {
                return $number . 'th';
            }
            return $number . $ends[$number % 10];
        }

        $booking = Registration::with(['user','event'])->findOrFail($booking_id);

        if ($booking->user->id !== Auth::id()) {
            abort(403);
        }

        $start = Carbon::parse($booking->event->date_start);
        $end   = Carbon::parse($booking->event->date_end);

        $start_date = ordinal($start->day) . ' ' . $start->format('F Y');
        $end_date   = ordinal($end->day)   . ' ' . $end->format('F Y');

        $bodyText = sprintf(
            '%s in %s, %s - %s
organized by the European Venous Forum has been accredited by the European Accreditation Council for Continuing Medical Education (EACCME®) for a maximum of 12.5 European CME credits (ECMEC®s).',
            $booking->event->title,
            $booking->event->location ?? '—',
            $start_date,
            $end_date,
        );

        $afterText = sprintf(
            'attended as a participant and has been awarded with %s CME credits corresponding to the respective attendance time.',
            $booking->total_cme_points
        );

        $pdf = Pdf::loadView('certificates.event-completed', [
            'booking' => $booking,
            'user_name' => trim($booking->user->title.' '.$booking->user->first_name.' '.$booking->user->last_name),
            'body_text' => $bodyText,
            'after_text' => $afterText,
            'img_url'   => resource_path('certificates/certificate-of-attendance-bgr.jpg'),
        ])->setPaper('A4', 'portrait');

        $file_name = $booking->user->title . '-' . $booking->user->last_name . '-EVF-HOW-certificate-of-attendance.pdf';


        return $pdf->download($file_name);
    }
}
