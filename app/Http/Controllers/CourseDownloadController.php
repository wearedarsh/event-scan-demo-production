<?php

namespace App\Http\Controllers;

use App\Models\EventDownload;
use Illuminate\Support\Facades\Storage;

class EventDownloadController extends Controller
{

    public function download($id)
    {
        
        $document = EventDownload::findOrFail($id);

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }
}