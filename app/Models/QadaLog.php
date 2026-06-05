<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QadaLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'prayer_name', 
        'missed_date', 
        'is_completed'
    ];

    protected $casts = [
        'is_completed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}