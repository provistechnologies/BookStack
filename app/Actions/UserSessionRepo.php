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

    public function getScreenshotsBySessionId($session_id)
    {
        $screenshotData = [];
        $screenshotData['sessionScreenshots'] = $this->screenshot->where('session_id', $session_id)->orderBy('id', 'desc')->get();
        $screenshotData['sessionUser'] = $this->userSession->where('id', $session_id)->with('userSession')->first();
        return $screenshotData;
    }
    
    public function getTasksBySessionId($session_id)
    {
        $taskData = [];
        $tasks = [];
        $taskData['sessionUser'] = $this->userSession->where('id', $session_id)->with('userSession')->first();
        $last = $taskData['sessionUser']->session_start_time;
        $screenshots = $this->screenshot->where('session_id', $session_id)->orderBy('screenshot_time', 'asc')->get();
        if (count($screenshots) > 0) {
            foreach($screenshots as $screenshot) {
                $start = Carbon::parse($last);
                $end = Carbon::parse($screenshot->screenshot_time);
                $seconds = $start->diffInSeconds($end);
                $minutes = $seconds / 60;
                if (isset($tasks[$screenshot->key_count])) {
                    $min = $tasks[$screenshot->key_count] + $minutes;
                    $tasks[$screenshot->key_count] = $min;
                } else {
                    $tasks[$screenshot->key_count] = $minutes;
                }
                $last = $screenshot->screenshot_time;
            }
        }
        $taskData['sessionTasks'] = $tasks;
        return $taskData;
    }

    public function setStatus($session_id, $request)
    {
        $session = $this->userSession->where('id', $session_id)->with('userSession')->first();
        $session->status = $request->status;
        $session->comments = $request->comments;
        $session->save();
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

    public function getSessionByFilters($request_data, $paginate = true) {
        $filterSessions = $this->userSession->query();

        $filter_flag = false;
        if (user()->can('session-view-own') && !user()->can('session-view-all')) {
            $filterSessions->where('user_id', user()->id);
        }
        if ($request_data->has('user_id') && !empty($request_data->user_id)) {
            $filterSessions->where('user_id', intval($request_data->user_id));
            $filter_flag = true;
        }
        if ($request_data->has('from_date') && !empty($request_data->from_date)) {
            $filterSessions->whereDate('created_at','>=', $request_data->from_date);
            $filter_flag = true;
        }
        if ($request_data->has('to_date') && !empty($request_data->to_date)) {
            $filterSessions->whereDate('created_at','<=', $request_data->to_date);
            $filter_flag = true;
        }
        if ($request_data->has('search_keyword') && !empty($request_data->search_keyword)) {
            $filterSessions->whereRelation('userSession', function ($query) use ($request_data) {
                $query->where('name', 'LIKE', '%'. $request_data->search_keyword .'%')
                ->orWhere('email', 'LIKE', '%'. $request_data->search_keyword .'%');
            });
            $filter_flag = true;
        }
        if (!empty($request_data->col_name) && !empty($request_data->order) ) {
            if ($request_data->col_name == 'name' || $request_data->col_name == 'email') {
                 $filterSessions->with(['userSession' => function ($q) use ($request_data){
                        $q->orderBy($request_data->col_name, $request_data->order);
                    }]);
            } else {
                 $filterSessions->orderBy($request_data->col_name, $request_data->order)->with('userSession')->paginate(15);
            }
        } else {
            if ($filter_flag == false) {
                 $filterSessions->whereDate('created_at', '>=', Carbon::now()->subDays(30)->endOfDay())->orderBy('id', 'desc');
                } else {                
                 $filterSessions->orderBy('id', 'desc')->with('userSession');
            }
        }
        if ($paginate) {
            return $filterSessions->paginate(15);   
        }
        return $filterSessions->get();
    }

}
