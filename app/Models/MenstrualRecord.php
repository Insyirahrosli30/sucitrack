<?php

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MenstrualRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'start_datetime',
        'end_datetime',
        'duration_days'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}