<table>
    <thead>
        <tr>
            <th>
                Date
            </th>
            <th>
                UserName
            </th>
            <th>
                Email
            </th>
            <th>
                Task
            </th>
            <th>
                Time
            </th>
        </tr>
    </thead>
    <tbody>
        @if (count($sessionsTasks) > 0)
            @foreach ($sessionsTasks as $sessionsTask)
            @php
              $sessionTasks = $usersRepo->getTasksBySessionId(strval($sessionsTask->id));
            @endphp
            @foreach ($sessionTasks['sessionTasks'] as $task => $minutes)
                <tr>
                    <td>
                        {{date('Y-m-d',strtotime($sessionsTask->session_start_time))}}
                    </td>
                    <td>
                        {{isset($sessionsTask->userSession) ? $sessionsTask->userSession->name : 'N/A'}}
                    </td>
                    <td>
                        {{isset($sessionsTask->userSession) ? $sessionsTask->userSession->email : 'N/A'}}
                    </td>
                    <td>
                        {{$task}}
                    </td>
                    <td>
                        @php
                            $totalMins = 0;
                            $totalMins += $minutes;
                            $hours = floor($minutes / 60);
                            $minutes = $minutes % 60;
                        @endphp
                        {{$hours.'H '.$minutes.'M'}}
                    </td>
                </tr>
            @endforeach
            @endforeach
        @endif
    </tbody>
</table>