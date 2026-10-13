<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';
    protected $guarded = [];
    public function getAllSubjects(){
        return $this->hasMany('App\Models\Subject', 'grade_id', 'id')->orderBy('display_order','asc');
    }
}
