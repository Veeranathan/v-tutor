<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorAcademic extends Model
{
      protected $table = 'teacher_academic';
    protected $guarded = [];  

    public function getUser(){
        return $this->hasOne('App\Models\User', 'id', 'teacher_id');
    }
    public function getFieldStudy(){
        return $this->hasOne('App\Models\FieldOfStudy', 'id', 'field_of_study');
    }
    public function getUniversity(){
        return $this->hasOne('App\Models\University', 'id', 'university');
    }
}
