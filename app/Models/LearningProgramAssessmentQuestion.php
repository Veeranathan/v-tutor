<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningProgramAssessmentQuestion extends Model
{
    use HasFactory;

    protected $table =
        'learning_program_assessment_questions';

    protected $fillable = [

        'form_id',
        /*qualitative | quantitative*/
        'type',
        'assessment_type',
        'subject',
        'question',
        'question_image',
        /*choose_best | text*/
        'question_type',
        /*MCQ OPTIONS*/
         'options',
        /*ANSWER*/
        'answer',
        'question_mark',
        'order',
        'status',
        'diagnostic_assessment',
        'grade',
        /*
        |--------------------------------------------------------------------------
        | reading
        | writing
        | thinking
        | reasoning
        |--------------------------------------------------------------------------
        */
        'section',
        'passage_no',
    ];

    protected $casts = [

        'options' => 'array',

        'status' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    public function form()
    {
        return $this->belongsTo(
            LearningProgramAssessmentForm::class,
            'form_id'
        );
    }
}