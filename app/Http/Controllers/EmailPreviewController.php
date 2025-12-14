<?php

namespace App\Http\Controllers;
use App\Models\EmailSend;

class EmailPreviewController extends Controller
{
    public function show(EmailSend $email_send)
    {
        return view('admin.emails.preview', [
            'html' => $email_send->html_content
        ]);
    }
}