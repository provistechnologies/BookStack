<?php

namespace BookStack\Http\Controllers\Api;

use BookStack\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use BookStack\Actions\UserSessionRepo;
use BookStack\Uploads\ScreenshotRepo;
use Exception;

class SessionApiController extends Controller
{
    protected $userSessionRepo;
    protected $screenshotRepo;

    public function __construct(UserSessionRepo $userSessionRepo, ScreenshotRepo $screenshotRepo)
    {
        $this->userSessionRepo = $userSessionRepo;
        $this->screenshotRepo = $screenshotRepo;
    }

    public function startSession(Request $request)
    {
        if (Auth::user()) {
            $current_date = Carbon::now()->toDateString();
            $authUser_id = Auth::user()->id;
            $session = $this->userSessionRepo->getSession($authUser_id, $current_date);
            if (!empty($session)) {
                return response()->json([
                    'success' => true,
                    'data' => $session,
                ], 200);

            } else {
                $sessionData = [];
                $sessionData['user_id'] = $authUser_id;
                $sessionData['session_date'] =  $current_date;
                $sessionData['session_start_time'] = Carbon::now();
                $sessionDetail = $this->userSessionRepo->createNewSession($sessionData);
                return response()->json([
                    'success' => true,
                    'data' => $sessionDetail,
                ], 200);
            }
        }
    }

    public function updateSession(Request $request)
    {   
        if (Auth::user()) {
            $session = $this->userSessionRepo->getSessionById($request->session_id);
            if ($request->session_end_time) {
                $end_session = [
                    'session_end_time' => $request->session_end_time,
                ];
                $this->userSessionRepo->saveEndTime($session, $end_session);
            }
            $screnshotData = [];
            if (!empty($session)) {
                $screnshotData['session_id'] = $session->id;
                $screnshotData['screenshot_time'] = $request->screenshot_time;
                $screnshotData['key_count'] = $request->key_count;
                if (!empty($request->file('screenshot'))) {
                    $imageUpload = $request->file('screenshot');
                    try {
                    $screnshotData['screenshot'] = $this->screenshotRepo->saveScreenshot($imageUpload, $session->id);
                    $screnshotData = $this->userSessionRepo->addScreenshot($screnshotData);    
                    } catch (Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Error when attempting file upload:' . $e->getMessage(),
                        ], 200);
                    }
                }
            }
            return response()->json([
                'success' => true,
                'data' => $session,
            ], 200);
        }
    }
}
