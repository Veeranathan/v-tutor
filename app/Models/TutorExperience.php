<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorExperience extends Model
{
    protected $table = 'teacher_experience';
    protected $guarded = []; 

      public function getExpToSub(){
        return $this->hasMany('App\Models\ExpToSubject', 'exp_id', 'id');
    }
}
