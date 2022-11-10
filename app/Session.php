<?php

namespace BookStack;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use BookStack\Model;
use BookStack\Auth\User;

class Session extends Model
{
    use HasFactory;
    protected $table = 'tbl_sessions';
    protected $fillable = [
        'user_id',
        'session_start_time',
        'session_end_time',
        'session_date',
    ];

    public function userSession()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
