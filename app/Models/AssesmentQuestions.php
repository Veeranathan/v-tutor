<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssesmentQuestions extends Model
{
    protected $table = 'assessment_questions';
    protected $guarded = [];

    public function getAnswerOptions(){
        return $this->hasMany('App\Models\AssesmentAnswers', 'question_id', 'id');
    }
}
