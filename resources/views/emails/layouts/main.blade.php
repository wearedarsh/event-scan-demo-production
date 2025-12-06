<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Eventscan demo' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F3F5F8;
            font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
            line-height: 1.5;
            color: #0D4261;
            -webkit-text-size-adjust: none;
        }

        table {
            border-collapse: collapse;
        }

        h1 {
            font-size:16px;
        }

        p {
            font-size:16px;
        }

        .email-wrapper {
            width: 100%;
            background-color: #F3F5F8;
            padding: 0;
        }

        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
        }

        .email-masthead {
            background-color: #0D4261;
            text-align: center;
            padding: 25px 20px;
        }

        .email-masthead img {
            max-width: 200px;
            height: auto;
        }

        .email-body {
            padding: 30px 40px;
        }

        .email-footer {
            text-align: center;
            
            color: #FFFFFF;
            padding: 35px 20px;
            background-color: #0D4261;
        }

        .email-footer p{
            font-size: 12px;
        }

        .preheader {
            display: none !important;
            visibility: hidden;
            opacity: 0;
            height: 0;
            width: 0;
            font-size: 0;
            line-height: 0;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 20px 15px;
            }

            .email-masthead,
            .email-footer {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
        }
    </style>
</head>
<body>
    <span class="preheader">{{ $preheader ?? '' }}</span>

    <table class="email-wrapper" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <table class="email-content" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="email-masthead">
                            <a href="{{ config('app.url') }}" style="text-decoration: none; display: inline-block;">
                                <img src="{{ config('app.url') }}/images/frontend/logo-white.png" alt="{{config('config('customer.contact_details.booking_website_company_name') }} Logo">
                                <p style="color:#fff; font-size:16px; margin-top:10px;">{{config('customer.contact_details.booking_website_company_name') }} events</p>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="email-body">
                            @yield('content')
                        </td>
                    </tr>

                    <tr>
                        <td class="email-footer">
                            <p>© {{ now()->year }} {{ config('customer.contact_details.booking_website_company_name') }}. All rights reserved.</p>
                            {!! config('customer.contact_details.booking_website_company_details') !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
