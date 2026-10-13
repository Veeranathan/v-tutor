<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpToSubject extends Model
{
   protected $table = 'teacher_exp_to_sub';
    protected $guarded = [];

     public function subjectName(){
        return $this->hasOne('App\Models\Subject', 'id', 'subject_id');
    }
}
