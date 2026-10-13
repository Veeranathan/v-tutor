<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingToReviews extends Model
{
    protected $table = 'booking_to_review';
    protected $guarded = [];

    public function getUser(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function bookingInfo(){
        return $this->hasOne('App\Models\StudentClassBooking', 'id', 'booking_id');
    }
}
