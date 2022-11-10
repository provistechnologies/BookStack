<?php

namespace BookStack;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'screenshots';
    protected $fillable = [
        'session_id',
        'screenshot_time',
        'screenshot',
        'key_count',
    ];
}
