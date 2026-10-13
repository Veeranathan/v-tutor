<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews';
    protected $guarded = []; 

     public function tutor(){
        return $this->hasOne('App\Models\User', 'id', 'tutor_id');
    }

     public function student(){
        return $this->hasOne('App\Models\User', 'id', 'student_id');
    }
}
