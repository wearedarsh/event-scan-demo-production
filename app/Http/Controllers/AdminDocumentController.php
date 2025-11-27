<?php

namespace App\Http\Controllers;

use App\Models\RegistrationDocument;
use Illuminate\Support\Facades\Storage;

class AdminDocumentController extends Controller
{
    public function download(RegistrationDocument $document)
    {

        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404);
        }

        return Storage::disk('private')->download($document->file_path, $document->original_name);
    }
}
