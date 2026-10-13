<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentClassBooking;

class Recording extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'booking_id',
        'session_id',
        'daily_recording_id',
        'file_name',
        'sharepoint_file_id',
        'recording_folder',
        'recording_url',
        'duration',
        'max_participants',
        'daily_status',
        'daily_instance_id',
        's3_key',
        'status',
        'recording_started_at',
        'recording_ended_at',
        'uploaded_at',
    ];

    public function booking()
    {
        return $this->belongsTo(
            StudentClassBooking::class, 'booking_id', 'id');
    }
}