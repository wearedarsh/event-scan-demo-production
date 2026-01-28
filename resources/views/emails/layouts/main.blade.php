<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        {!! branding_css('email') !!}
    </style>
</head>
<body>
    <span class="preheader">{{ $pre_header ?? '' }}</span>

    <table class="email-wrapper" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <table class="email-content" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="email-masthead">
                            <a href="{{ $app_url }}" style="text-decoration: none; display: inline-block;">
                                <img src="{{ $app_url }}/images/frontend/logo-white.png" alt="Logo">
                                <p style="color:#fff; font-size:16px; margin-top:10px;"> {{ $sub_title ?? 'events' }}</p>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="email-body">
                            {!! $body_html_content !!}
                        </td>
                    </tr>

                    <tr>
                        <td class="email-footer">
                            <p>© {{ now()->year }}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
