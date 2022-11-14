<?php

namespace BookStack\Http\Controllers;

use BookStack\Session as UsersSession;
use BookStack\Screenshot;


class SessionUserController extends Controller
{
    public function index()
    {
        $sessionUsers = UsersSession::with('userSession')->groupBy('user_id')->get();
        return view('session-user.index', ['sessionUsers' => $sessionUsers]);
    }

    public function userSessions($user_id = 0)
    {   
        $userAllSessions = UsersSession::where('user_id', $user_id)->with('userSession')->get();
        return view('session-user.users-sessions', ['userAllSessions' => $userAllSessions]);
    }

    public function sessionScreenshot($session_id = 0)
    {   
        $sessionUser = UsersSession::where('id', $session_id)->with('userSession')->first();
        $sessionScreenshots = Screenshot::where('session_id', $session_id)->get();
        return view('session-user.session-screenshots', [
            'sessionScreenshots' => $sessionScreenshots,
            'sessionUser' => $sessionUser,
            ]);
    }
}
