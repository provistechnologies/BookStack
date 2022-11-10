<?php

namespace BookStack\Http\Controllers\Api;

use BookStack\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BookStack\Session as UsersSession;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use BookStack\Screenshot;

class SessionApiController extends Controller
{
    public function startSession(Request $request)
    {
        if (Auth::user()) {
            $current_date = Carbon::now()->toDateString();
            $authUser_id = Auth::user()->id;
            $session = UsersSession::where('user_id', $authUser_id)->where('session_date', $current_date)->first();
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
                $sessionDetail = UsersSession::create($sessionData);
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
            $session = UsersSession::where('id', $request->session_id)->first();
            if ($request->session_end_time) {
                $end_session = [
                    'session_end_time' => $request->session_end_time,
                ];
                $session->fill($end_session)->save();
            }
            $screnshotData = [];
            if (!empty($session)) {
                $screnshotData['session_id'] = $session->id;
                $screnshotData['screenshot_time'] = $request->screenshot_time;
                $screnshotData['key_count'] = $request->key_count;
                if (!empty($request->file('screenshot'))) {
                    $screnshotData['screenshot'] = $request->file('screenshot')->store('/uploads/screenshots/'.$session->id);
                    $screnshotData = Screenshot::create($screnshotData);
                }
            }
            return response()->json([
                'success' => true,
                'data' => $session,
            ], 200);
        }
    }
}
