<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicDetail extends Model
{
    

    protected $table = 'topic_details';

     protected $guarded = [];
   

     public function getBranch(){
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }  
    public function getSubject(){
        return $this->hasOne('App\Models\Subject', 'id', 'subject_id');
    }
     public function getGrade(){
        return $this->hasOne('App\Models\Grade', 'id', 'grade_id');

    }
 public function getTopic(){
        return $this->hasOne('App\Models\SubjectTopics', 'id', 'topic_id');
}
      
}