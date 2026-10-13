<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicProgramSession extends Model
{
    use HasFactory;

    protected $table = 'academic_program_sessions';

    protected $fillable = [
        'purchase_id',
        'session_number',
        'tutor_id',
        'status',
        'scheduled_at',
        'completed_at',
        'start_time',
        'end_time',
        'notes',
        'student_class_booking_id'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'start_time'   => 'datetime',
        'end_time'     => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Belongs to Purchase
    public function purchase()
    {
        return $this->belongsTo(AcademicProgramPurchase::class, 'purchase_id');
    }

    // Tutor who handled this session
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    // Session Logs
    public function logs()
    {
        return $this->hasMany(AcademicProgramSessionLog::class, 'session_id');
    }

    public function booking()
    {
        return $this->belongsTo(
            \App\Models\StudentClassBooking::class,
            'student_class_booking_id'
        );
    }
}
