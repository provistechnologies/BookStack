<?php

namespace BookStack\Http\Controllers;

use BookStack\Auth\User as AuthUser;
use Illuminate\Http\Request;
use BookStack\Session as UsersSession;
use BookStack\Screenshot;
use BookStack\Auth\User;


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
        $sessionScreenshots = Screenshot::where('session_id', $session_id)->get();
        return view('session-user.session-screenshots', ['sessionScreenshots' => $sessionScreenshots]);
    }
}
