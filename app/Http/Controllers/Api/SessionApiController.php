<?php

namespace BookStack\Http\Controllers\Api;

use BookStack\Http\Controllers\Controller;
use Illuminate\Http\Request;

use BookStack\Actions\UserSessionRepo;

class SessionApiController extends Controller
{
    protected $userSessionRepo;

    public function __construct(UserSessionRepo $userSessionRepo)
    {
        $this->userSessionRepo = $userSessionRepo;
    }

    public function startSession(Request $request)
    {
        return $this->userSessionRepo->startUserSession();
    }

    public function updateSession(Request $request)
    {   
        return $this->userSessionRepo->updateUserSession($request);
    }
}
