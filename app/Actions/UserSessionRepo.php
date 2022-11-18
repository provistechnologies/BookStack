<?php

namespace BookStack\Actions;
use Carbon\Carbon;
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

    public function getUsers()
    {
        return $this->userSession->with('userSession')->groupBy('user_id')->get();
    }

    /**
     * Get all session users.
     */

    public function getAllSession()
    {
        return $this->userSession->with('userSession')->where('created_at', '>=', Carbon::now()->subDays(30)->endOfDay())->orderBy('id', 'desc')->paginate(15);
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

    public function getSessionByFilters($request_data) {
        $filterSessions = $this->userSession->query();
        if ($request_data->has('user_id') && !empty($request_data->user_id)) {
            $filterSessions->where('user_id', intval($request_data->user_id));
        }
        if ($request_data->has('from_date') && !empty($request_data->from_date)) {
            $filterSessions->where('created_at','>=', $request_data->from_date);
        }
        if ($request_data->has('to_date') && !empty($request_data->to_date)) {
            $filterSessions->where('created_at','<=', $request_data->to_date);
        }
        if ($request_data->has('search_keyword') && !empty($request_data->search_keyword)) {
            $filterSessions->whereRelation('userSession', function ($query) use ($request_data) {
                $query->where('name', 'LIKE', '%'. $request_data->search_keyword .'%')
                ->orWhere('email', 'LIKE', '%'. $request_data->search_keyword .'%');
            });
        }
        if (!empty($request_data->col_name) && !empty($request_data->order) ) {
            if ($request_data->col_name == 'name' || $request_data->col_name == 'email') {
                return $filterSessions->with(['userSession' => function ($q) use ($request_data){
                        $q->orderBy($request_data->col_name, $request_data->order);
                    }])->paginate(15);
            } else {
                return $filterSessions->orderBy($request_data->col_name, $request_data->order)->with('userSession')->paginate(15)->withQueryString();
            }
        } else {
            return $filterSessions->orderBy('id', 'desc')->with('userSession')->paginate(15)->withQueryString();
        }
    }

}
