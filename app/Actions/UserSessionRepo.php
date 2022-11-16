<?php

namespace BookStack\Actions;

use BookStack\Uploads\ScreenshotRepo;

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

    public function getSession($authUser_id, $current_date)
    {
        return $this->userSession->where('user_id', $authUser_id)->where('session_date', $current_date)->first();
    }

    public function createNewSession($sessionData)
    {
        return $this->userSession->create($sessionData);
    }

    public function getSessionById($session_id)
    {
        return $this->userSession->where('id', $session_id)->first();
    }

    public function addScreenshot($screnshotData)
    {
        return $this->screenshot->create($screnshotData);
    }

    public function saveEndTime($session, $end_session)
    {
        $session->fill($end_session)->save();
    }

}
