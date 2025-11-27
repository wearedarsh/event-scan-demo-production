<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminContentUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('event_content_documents', 'public');

            return response()->json([
                'url' => Storage::disk('public')->url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
