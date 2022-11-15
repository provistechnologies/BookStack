<?php

namespace BookStack\Http\Controllers;

use BookStack\Actions\UserSessionRepo;

class SessionUserController extends Controller
{
    protected $UserSessionRepo;

    public function __construct(UserSessionRepo $UserSessionRepo)
    {
        $this->UserSessionRepo = $UserSessionRepo;
    }

    public function index()
    {
        $sessionUsers = $this->UserSessionRepo->getSessionUsers();
        return view('session-user.index', ['sessionUsers' => $sessionUsers]);
    }

    public function userSessions($user_id = 0)
    {   
        $userAllSessions = $this->UserSessionRepo->getSessionByUserId($user_id);
        return view('session-user.users-sessions', ['userAllSessions' => $userAllSessions]);
    }

    public function sessionScreenshot($session_id = 0)
    {   
        $screenshotData = $this->UserSessionRepo->getScreenshotsBySessionId($session_id);
        return view('session-user.session-screenshots', [
            'sessionScreenshots' => $screenshotData['sessionScreenshots'],
            'sessionUser' => $screenshotData['sessionUser'],
            ]);
    }
}
