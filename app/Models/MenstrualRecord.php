<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenstrualRecord extends Model
{
    protected $fillable = [
        'user_id',
        'start_datetime',
        'end_datetime',
        'duration_days'
    ];
}