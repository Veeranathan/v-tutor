<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor_calander_availability extends Model
{
     protected $table = 'user_cal_availablity';
    protected $guarded = [];  
     public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
