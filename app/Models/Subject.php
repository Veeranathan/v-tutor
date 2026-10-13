<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $guarded = [];

    public function getBranch(){
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    } 
    public function getGrade(){
        return $this->hasOne('App\Models\Grade', 'id', 'grade_id');
    }   
}
