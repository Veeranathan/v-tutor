<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LearningProgramAssessment;
use App\Models\User;

class AssessmentSuggestion extends Model
{
    use HasFactory;

    protected $table = 'assessment_suggestions';

    protected $fillable = [
        'learning_program_assessment_id',
        'student_id',
        'advisor_summary_report',
        'key_strengths',
        'additional_strength',
        'learning_opportunities',
        'additional_opportunity',
        'quantitative_status',
        'quantitative_statement',
        'qualitative_status',
        'qualitative_statement',
        'overall_alignment',
        'alignment_summary',
        'additional_notes',
        'reading',
        'reasoning',
        'thinking',
        'logic',
        'writing',
        'recommended_learning_priorities',
        'recommended_learning_pathway',
        'performance_comment',
        'report_prepared_by',
        'report_prepared_by_id',
        'primary_learning_recommendation',
        'secondary_learning_recommendation',
        'quantitative_assessment_summary',
        'qualitative_responses_summary',
    ];

    // Accessor for Primary Programs
    public function getPrimaryProgramsAttribute()
    {
        $ids = $this->primary_learning_recommendation ?? [];
        return AcademicProgram::whereIn('id', $ids)->get();
    }

    // Accessor for Secondary Programs
    public function getSecondaryProgramsAttribute()
    {
        $ids = $this->secondary_learning_recommendation ?? [];
        return AcademicProgram::whereIn('id', $ids)->get();
    }

//     <!-- Display Primary Programs -->
// <h5>Primary Recommendations:</h5>
// <ul>
//     @foreach($suggestion->primary_programs as $program)
//         <li>{{ $program->name }} ({{ $program->program_type }})</li>
//     @endforeach
// </ul>

// <!-- Display Secondary Programs -->
// <h5>Secondary Recommendations:</h5>
// <ul>
//     @foreach($suggestion->secondary_programs as $program)
//         <li>{{ $program->name }} ({{ $program->program_type }})</li>
//     @endforeach
// </ul>

    /**
     * Attribute casting for multiselect and date arrays.
     */
    protected $casts = [
        'key_strengths'                    => 'array',
        'learning_opportunities'           => 'array',
        'recommended_learning_priorities'  => 'array',
        'recommended_learning_pathway'     => 'array',
        'created_at'                       => 'datetime',
        'updated_at'                       => 'datetime',
        'primary_learning_recommendation'   => 'array',
        'secondary_learning_recommendation' => 'array',
    ];

    /* =========================================================================
       CONSTANTS FOR SELECT / MULTI-SELECT DROPDOWNS (For UI Forms & Validation)
    ========================================================================= */

    public const PERFORMANCE_COMMENT_OPTIONS = [
        'High Performer'       => 'High Performer',
        'Strong Performer'     => 'Strong Performer',
        'Balanced Performance' => 'Balanced Performance',
        'Developing Learner'   => 'Developing Learner',
        'Needs Attention'      => 'Needs Attention',
        'Custom'               => 'Custom',
    ];

    public const KEY_STRENGTHS_OPTIONS = [
        'Reading Comprehension', 'Reading Fluency', 'Vocabulary',
        'Writing Skills', 'Grammar', 'Mathematical Reasoning', 'Number Sense',
        'Problem Solving', 'Logical Thinking', 'Critical Thinking', 'Scientific Thinking',
        'Creativity', 'Communication', 'Independent Learning', 'Learning Confidence',
        'Organisation', 'Concentration', 'Positive Learning Attitude', 'Curiosity',
        'Persistence', 'Time Management', 'Collaboration', 'Emotional Resilience', 'Growth Mindset'
    ];

    public const LEARNING_OPPORTUNITIES_OPTIONS = [
        'Reading Accuracy', 'Reading Comprehension', 'Vocabulary Development',
        'Written Expression', 'Grammar', 'Spelling', 'Mathematical Fluency',
        'Number Operations', 'Fractions', 'Algebra', 'Multi-step Problem Solving',
        'Logical Reasoning', 'Scientific Inquiry', 'Exam Confidence', 'Study Skills',
        'Independent Learning', 'Time Management', 'Focus & Attention',
        'Confidence Building', 'Organisation', 'Homework Habits', 'Critical Thinking'
    ];

    public const QUANTITATIVE_STATUS_OPTIONS = [
        'Validated'     => 'Validated',
        'Not Validated' => 'Not Validated',
    ];

    public const QUANTITATIVE_STATEMENT_OPTIONS = [
        'Excellent understanding',
        'Strong understanding with minor gaps',
        'Developing understanding',
        'Learning gaps identified',
        'Reliable indication of academic ability',
    ];

    public const QUALITATIVE_STATUS_OPTIONS = [
        'Validated'     => 'Validated',
        'Not Validated' => 'Not Validated',
    ];

    public const QUALITATIVE_STATEMENT_OPTIONS = [
        'Consistent with assessment',
        'Generally aligns',
        'Broadly consistent',
        'Some inconsistencies',
        'Further observations recommended',
    ];

    public const OVERALL_ALIGNMENT_OPTIONS = [
        'Strong Alignment',
        'Good Alignment',
        'Moderate Alignment',
        'Limited Alignment',
    ];

    public const PERFORMANCE_RATING_OPTIONS = [
        'Strong'        => 'Strong',
        'Developing'    => 'Developing',
        'Emerging'      => 'Emerging',
        'Needs Support' => 'Needs Support',
    ];

    public const RECOMMENDED_PRIORITIES_OPTIONS = [
        'Strengthen Reading Comprehension', 'Improve Reading Fluency', 'Expand Vocabulary',
        'Develop Written Expression', 'Improve Grammar', 'Strengthen Number Sense',
        'Improve Mathematical Fluency', 'Develop Algebra Skills', 'Improve Problem Solving',
        'Strengthen Logical Thinking', 'Develop Critical Thinking', 'Build Academic Confidence',
        'Improve Independent Learning', 'Improve Study Skills', 'Develop Time Management',
        'Prepare for NAPLAN', 'Improve Examination Technique', 'Build Consistency',
        'Increase Learning Engagement'
    ];

    public const PATHWAY_PROGRAM_OPTIONS = [
        'program1' => 'Program 1',
        'program2' => 'Program 2',
        'program3' => 'Program 3',
        'program4' => 'Program 4',
    ];

    /* =========================================================================
       RELATIONSHIPS
    ========================================================================= */

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

    public function reportPreparedBy()
    {
        return $this->belongsTo(User::class, 'report_prepared_by_id');
    }
}