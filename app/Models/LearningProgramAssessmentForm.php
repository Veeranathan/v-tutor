<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningProgramAssessmentForm extends Model
{
    use HasFactory;

    protected $table =
        'learning_program_assessment_forms';

    protected $fillable = [

        /*
        |------------------------------------------------------------------
        | BASIC
        |------------------------------------------------------------------
        */
        'form_name',
        'form_slug',
        'description',
        'assessment_type',
        'diagnostic_assessment',

        /*
        |------------------------------------------------------------------
        | full-length | sectional
        |------------------------------------------------------------------
        */
        'category',

        /*
        |------------------------------------------------------------------
        | reading
        | thinking
        | reasoning
        | writing
        | logic
        |------------------------------------------------------------------
        */
        'sections',

        /*
        |------------------------------------------------------------------
        | PASSAGES
        |------------------------------------------------------------------
        */
        'passage_count',
        'passages',

        /*
        |------------------------------------------------------------------
        | STATUS
        |------------------------------------------------------------------
        */
        'status',
    ];

    protected $casts = [

        'sections' => 'array',

        'passages' => 'array',

        'status' => 'boolean',
    ];

    /*
    |----------------------------------------------------------------------
    | QUESTIONS
    |----------------------------------------------------------------------
    */

    public function questions()
    {
        return $this->hasMany(
            LearningProgramAssessmentQuestion::class,
            'form_id'
        );
    }
}