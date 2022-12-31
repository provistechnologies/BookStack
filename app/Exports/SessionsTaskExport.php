<?php

namespace BookStack\Exports;

use Illuminate\Contracts\View\View;
use BookStack\Actions\UserSessionRepo;
use Maatwebsite\Excel\Concerns\FromView;

class SessionsTaskExport implements FromView
{
    public $tasks;

    public function __construct($tasks = [], $userSessionRepo)
    {
        $this->tasks = $tasks;
        $this->userSessionRepo = $userSessionRepo;
    }
    public function view(): View
    {
        return view('exports.tasks', [
            'sessionsTasks' => $this->tasks,
            'usersRepo' => $this->userSessionRepo
        ]);
    }
}
