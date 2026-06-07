<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QadaLog extends Model
{
    use HasFactory;

    protected $table = 'qada_logs';

    protected $fillable = [
        'user_id',
        'menstrual_record_id',
        'qada_date',
        'prayer_type',
        'is_completed',
        'notes',
    ];

    protected $casts = [
        'qada_date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function menstrualRecord(): BelongsTo
    {
        return $this->belongsTo(MenstrualRecord::class);
    }
}