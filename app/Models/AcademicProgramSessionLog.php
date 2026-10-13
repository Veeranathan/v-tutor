<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicProgramSessionLog extends Model
{
    use HasFactory;

    protected $table = 'academic_program_session_logs';

    protected $fillable = [
        'session_id',
        'tutor_id',
        'action',
        'action_by',
        'action_at',
        'scheduled_date',
        'start_time',
        'end_time',
        'reason',
    ];

    protected $casts = [
        'action_at'      => 'datetime',
        'scheduled_date' => 'datetime',
        'start_time'     => 'datetime',
        'end_time'       => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the session associated with the log.
     */
    public function session()
    {
        return $this->belongsTo(AcademicProgramSession::class, 'session_id');
    }

    /**
     * Get the tutor associated with the logged session snapshot.
     */
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Get the user who performed the action.
     */
    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}