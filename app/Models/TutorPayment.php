<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorPayment extends Model
{
    use HasFactory;

    protected $table = 'tutor_payment'; 

    protected $fillable = [
        'tutor_id',
        'booking_id',
        'tutor_amount',
        'commission_amount',
        'booking_status',
        'payment_status',
    ];

    /**
     * Optional: Define constants for clarity
     */
    /*public const BOOKED = 1;
    public const CANCELLED = 2;

    public const NOT_PAID = 0;
    public const PAID = 1;
    public const REFUND = 2;
    public const SETTLED = 3;

    /**
     * Relationships (optional, if you have related tables)
     */
   // App\Models\TutorPayment.php
public function get_tutor()
{
    return $this->belongsTo(\App\Models\User::class, 'tutor_id', 'id');
}
public function booking()
{
    return $this->belongsTo(\App\Models\StudentClassBooking::class, 'booking_id', 'id');
}



}
