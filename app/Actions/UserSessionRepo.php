<?php

namespace BookStack\Actions;

use BookStack\Uploads\ScreenshotRepo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Class CommentRepo.
 */
class UserSessionRepo
{
    /**
     * @var UserSession
     * @var Screenshot
     */
    protected $userSession;
    protected $screenshot;
    protected $screenshotRepo;

    public function __construct(UserSession $userSession, Screenshot $screenshot, ScreenshotRepo $screenshotRepo)
    {
        $this->userSession = $userSession;
        $this->screenshot = $screenshot;
        $this->screenshotRepo = $screenshotRepo;
    }

    /**
     * Get all session users.
     */
    public function getSessionUsers()
    {
        return $this->userSession->with('userSession')->groupBy('user_id')->orderBy('id', 'desc')->get();
    }

    public function getSessionByUserId($user_id)
    {
        return $this->userSession->where('user_id', $user_id)->with('userSession')->orderBy('id', 'desc')->get();
    }

    public function getScreenshotsBySessionId($session_id)
    {
        $screenshotData = [];
        $screenshotData['sessionScreenshots'] = $this->screenshot->where('session_id', $session_id)->orderBy('id', 'desc')->get();
        $screenshotData['sessionUser'] = $this->userSession->where('id', $session_id)->with('userSession')->first();
        return $screenshotData;
    }

    public function checkSession($authUser_id, $current_date)
    {
        return $this->userSession->where('user_id', $authUser_id)->where('session_date', $current_date)->first();
    }
    
    // Apis functions for tracker
    
    public function startUserSession()
    {
        if (Auth::user()) {
            $current_date = Carbon::now()->toDateString();
            $authUser_id = Auth::user()->id;
            $session = $this->userSession->where('user_id', $authUser_id)->where('session_date', $current_date)->first();
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
                $sessionDetail = $this->userSession->create($sessionData);
                return response()->json([
                    'success' => true,
                    'data' => $sessionDetail,
                ], 200);
            }
        }
    }

    public function updateUserSession($request_data)
    {
        if (Auth::user()) {
            $session = $this->userSession->where('id', $request_data->session_id)->first();
            if ($request_data->session_end_time) {
                $end_session = [
                    'session_end_time' => $request_data->session_end_time,
                ];
                $session->fill($end_session)->save();
            }
            $screnshotData = [];
            if (!empty($session)) {
                $screnshotData['session_id'] = $session->id;
                $screnshotData['screenshot_time'] = $request_data->screenshot_time;
                $screnshotData['key_count'] = $request_data->key_count;
                if (!empty($request_data->file('screenshot'))) {
                    $imageUpload = $request_data->file('screenshot');
                    $screenshotData = $this->screenshotRepo->saveScreemshot($imageUpload, $session->id);
                    $screnshotData['screenshot'] = $screenshotData->url;
                    $screnshotData = $this->screenshot->create($screnshotData);
                }
            }
            return response()->json([
                'success' => true,
                'data' => $session,
            ], 200);
        }
    }

}
