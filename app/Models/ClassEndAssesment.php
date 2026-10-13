<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassEndAssesment extends Model
{
    protected $table = 'class_end_assessment';
    protected $guarded = [];

    public function getUser(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function bookingInfo(){
        return $this->hasOne('App\Models\StudentClassBooking', 'id', 'booking_id');
    }
    public function getQuestion(){
        return $this->hasOne('App\Models\AssesmentQuestions', 'id', 'question_id');
    }
    public function getAnswer(){
        return $this->hasOne('App\Models\AssesmentAnswers', 'id', 'answer_id');
    }
    
}
