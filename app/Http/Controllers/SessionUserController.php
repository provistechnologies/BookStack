<?php

namespace BookStack\Http\Controllers;

use BookStack\Actions\UserSessionRepo;
use Illuminate\Http\Request;
class SessionUserController extends Controller
{
    protected $UserSessionRepo;

    public function __construct(UserSessionRepo $UserSessionRepo)
    {
        $this->UserSessionRepo = $UserSessionRepo;
    }

    public function index(Request $request)
    {   
        $session_date_order = 'desc';
        $start_time_order = 'desc';
        $name_order = 'desc';
        $email_order = 'desc';
        $end_time_order = 'desc';
        if ($request->has('col_name') && !empty($request->col_name)) {
            if ($request->col_name == 'session_date') {
                if ($request->order == 'desc') {
                    $session_date_order = 'asc';
                }
                if ($request->order == 'asc') {
                    $session_date_order = 'desc';
                }
            }
            if ($request->col_name == 'session_start_time') {
                if ($request->order == 'desc') {
                    $start_time_order = 'asc';
                }
                if ($request->order == 'asc') {
                    $start_time_order = 'desc';
                }
            }
            if ($request->col_name == 'name') {
                if ($request->order == 'desc') {
                    $name_order = 'asc';
                }
                if ($request->order == 'asc') {
                    $name_order = 'desc';
                }
            }
            if ($request->col_name == 'email') {
                if ($request->order == 'desc') {
                    $email_order = 'asc';
                }
                if ($request->order == 'asc') {
                    $email_order = 'desc';
                }
            }
            if ($request->col_name == 'session_end_time') {
                if ($request->order == 'desc') {
                    $end_time_order = 'asc';
                }
                if ($request->order == 'asc') {
                    $end_time_order = 'desc';
                }
            }
        }

        $users = $this->UserSessionRepo->getUsers();
        if (count($request->all()) > 0) {
            $allSessions = $this->UserSessionRepo->getSessionByFilters($request);
        } else {
            $allSessions = $this->UserSessionRepo->getAllSession();
            $request = [];
        }
        return view('session-user.index', [
            'allSessions' => $allSessions,
            'users' => $users,
            'filterData' => $request,
            'session_date_order' => $session_date_order,
            'start_time_order' => $start_time_order,
            'name_order' => $name_order,
            'email_order' => $email_order,
            'end_time_order' => $end_time_order,
          ]);
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
