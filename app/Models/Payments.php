<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payments';
    protected $guarded = [];

    public function getBookingsInfo(){
        return $this->hasOne('App\Models\StudentClassBooking', 'id', 'booking_id');
    }
}
