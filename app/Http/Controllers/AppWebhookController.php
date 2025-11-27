<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AppApi\LoginService;
use App\Services\AppApi\EventsService;
use App\Services\AppApi\SessionGroupService;
use App\Services\AppApi\SessionService;
use App\Services\AppApi\AttendeeService;

class AppWebhookController extends Controller
{
    public function login(Request $request)
    {
        return (new LoginService())->handle($request);
    }

    public function events(Request $request)
    {
        return (new EventsService())->handle($request);
    }

    public function sessionGroups(Request $request)
    {
        return (new SessionGroupService())->handle($request);
    }

    public function sessions(Request $request)
    {
        return (new SessionService())->handle($request);
    }

    public function attendees(Request $request)
    {
        return (new AttendeeService())->handle($request);
    }

}
