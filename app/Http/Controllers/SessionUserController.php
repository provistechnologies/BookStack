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
        $session_date_order = $request->get('col_name') == 'session_date' ? $request->get('order', 'desc') : 'desc';
        $start_time_order = $request->get('col_name') == 'session_start_time' ? $request->get('order', 'desc') : 'desc';
        $name_order = $request->get('col_name') == 'name' ? $request->get('order', 'desc') : 'desc';
        $email_order = $request->get('col_name') == 'email' ? $request->get('order', 'desc') : 'desc';
        $end_time_order = $request->get('col_name') == 'session_end_time' ? $request->get('order', 'desc') : 'desc';

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

    public function sessionTask($session_id = 0)
    {   
        $taskData = $this->UserSessionRepo->getTasksBySessionId($session_id);

        return view('session-user.session-tasks', [
            'sessionTasks' => $taskData['sessionTasks'],
            'sessionUser' => $taskData['sessionUser'],
        ]);
    }

    public function sessionStatusUpdate(Request $request, $session_id = 0)
    {   
        $this->UserSessionRepo->setStatus($session_id, $request);
        $this->showSuccessNotification('Session status successfully updated');
        return redirect('/session-tasks/'.$session_id);
    }
}
