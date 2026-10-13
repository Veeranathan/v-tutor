<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorshipPlan extends Model
{
    protected $table = 'tutorship_plan';
    protected $guarded = [];

    public function getUser(){
        return $this->hasOne('App\Models\User', 'id', 'teacher_id');
    }
    public function getSubject(){
        return $this->hasOne('App\Models\Subject', 'id', 'subject_id');
    }
    public function getGrade(){
        return $this->hasOne('App\Models\Grade', 'id', 'grade_id');
    }

    public function getBranches(){
        return $this->hasMany('App\Models\Branch', 'id', 'branch_id');
    }



    public function getBranch(){
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }
}
