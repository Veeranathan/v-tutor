<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AcademicProgram;

class AcademicProgramPurchase extends Model
{
    use HasFactory;

    protected $table = 'academic_program_purchases';

    protected $fillable = [
        'user_id',
        'academic_program_id',
        'amount',
        'payment_status',
        'stripe_session_id',
        'order_id',
        'invoice_id',
        'quantity',
        'assigned_tutor_id',
        'start_date',
        'expires_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Relation: Purchased Academic Program
     */
    public function academicProgram()
    {
        return $this->belongsTo(AcademicProgram::class, 'academic_program_id');
    }

    /**
     * Relation: User who purchased
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
     
    public function invoice()
    {
    return $this->belongsTo(AcademicProgramInvoice::class, 'invoice_id');
    }

    public function sessions()
    {
        return $this->hasMany(AcademicProgramSession::class, 'purchase_id');
    }

    public function assignedTutor()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_tutor_id');
    }

    public function getAssignmentStatusAttribute()
    {
        if ($this->expires_at && $this->expires_at->lt(now())) {
            return 'expired';
        }

        if (!is_null($this->assigned_tutor_id)) {
            return 'assigned';
        }

        return 'unassigned';
    }

    public function bookings()
    {
        return $this->hasMany(
            \App\Models\StudentClassBooking::class,
            'academic_program_purchase_id'
        );
    }

}
