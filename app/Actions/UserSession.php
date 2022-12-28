<?php

namespace BookStack\Actions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use BookStack\Model;
use BookStack\Auth\User;

class UserSession extends Model
{
    use HasFactory;
    protected $table = 'tbl_sessions';
    protected $fillable = [
        'user_id',
        'status',
        'comments',
        'session_start_time',
        'session_end_time',
        'session_date',
    ];

    public function userSession() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
