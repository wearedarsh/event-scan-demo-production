<?php 

namespace App\Http\Controllers;

use App\Models\Event;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendeesDataExport;

class AttendeesDataExportController
{
    public function __invoke(Event $event)
    {
        $filename = "attendee-data.xlsx";

        return Excel::download(new AttendeesDataExport($event), $filename);
    }
}
