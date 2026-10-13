<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZoomMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'tutor_id',
        'zoom_meeting_id',
        'start_url',
        'join_url',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
}
