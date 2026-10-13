<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MyAvailability extends Model
{
    protected $table = 'teacher_my_availability';
    protected $guarded = [];
    protected $appends = ['from_time_local', 'to_time_local'];
    public function teacher_details()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function getBook()
    {
        return $this->hasMany('App\Models\StudentClassBooking', 'availability_id', 'id');
    }

    public function getFromTimeLocalAttribute()
    {
        return Carbon::parse($this->from_time)->format('H:i'); // or include date if needed
    }

    public function getToTimeLocalAttribute()
    {
        return Carbon::parse($this->to_time)->format('H:i'); // or include date if needed
    }
}
