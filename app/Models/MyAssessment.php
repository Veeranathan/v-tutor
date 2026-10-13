<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LearningProgramAssessment;
use App\Models\User;

class MyAssessment extends Model
{
    use HasFactory;
     protected $table = 'my_assessments';

    protected $fillable = [
        'learning_program_assessment_id',
        'student_id',
        'assessment_form_name',
        'terms_agreed',
        'qualitative_answers',
        'quantitative_answers',
        'qualitative_submitted',
        'quantitative_submitted',
        'oc_answers',
        'oc_submitted',
    ];

    protected $casts = [
        'terms_agreed'          => 'boolean',
        'qualitative_answers'  => 'array',
        'quantitative_answers' => 'array',
        'qualitative_submitted'=> 'boolean',
        'quantitative_submitted'=> 'boolean',
        'oc_answers' => 'array',
        'oc_submitted' => 'boolean',
    ];

    public function learningProgramAssessment()
    {
        return $this->belongsTo(
            LearningProgramAssessment::class,
            'learning_program_assessment_id'
        );
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
