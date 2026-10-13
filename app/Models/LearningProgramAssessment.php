<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MyAssessment;
use App\Models\AssessmentSuggestion;

class LearningProgramAssessment extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'learning_program_assessments';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'student_id',
        'assessment_for',        // me | child
        'visit_reason',          // why user visited
        'school_year',           // grade / year
        'state',                 // location
        'subject',               // selected subject
        'learning_need',         // learning requirement
        'free_time',             // available free time
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'country_code',
        'source',                // fb, google, direct
        'ip_address',
        'user_agent',
        'grade',
        'form_slug',
        'terms_agreed',
        'otp',
        'otp_expires',
        'token',
        'otp_verified_at'

    ];

    public const STATUS_PENDING   = 'pending';
    public const STATUS_PROGRESS  = 'progress';
    public const STATUS_COMPLETED = 'completed';


    /**
     * Attribute casting
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'otp_verified_at' => 'datetime',
        'otp_expires'     => 'datetime',
    ];

      /* ===========================
       Program Mode Labels
    ============================ */
    public const PROGRAM_MODE_LABELS = [
        'free_assessment' => 'Student Assessment',
        'book_session'    => 'Tutoring Session',
        'explore'         => 'Academic Programs',
        'research'        => 'Just Exploring',
    ];

    /**
     * Get readable Program Mode label
     */
    public function getProgramModeLabelAttribute()
    {
        return self::PROGRAM_MODE_LABELS[$this->visit_reason]
            ?? ucfirst(str_replace('_', ' ', $this->visit_reason));
    }

    /**
     * Get Terms Agreed label
     */
    public function getTermsAgreedLabelAttribute()
    {
        return $this->terms_agreed == 1 ? 'Yes' : 'No';
    }

    /* ===========================
       Learning Need Labels
    ============================ */
    public const LEARNING_NEED_CONTENT = [
        'English' => [
            'falling_behind' => 'Building Strong Foundations',
            'motivation' => 'Confidence & Expression',
            'extend_learning' => 'Extending Writing & Thinking',
            'individual_needs' => 'Personalised English Support',
        ],
        'Mathematics' => [
            'falling_behind' => 'Keeping Up with the Basics',
            'motivation' => 'Staying Motivated',
            'extend_learning' => 'Ready for More Challenge',
            'individual_needs' => 'Individual Learning Needs',
        ],
        'Science' => [
            'falling_behind' => 'Understanding Core Concepts',
            'motivation' => 'Building Interest & Confidence',
            'extend_learning' => 'Exploring Science Further',
            'individual_needs' => 'Personalised Science Support',
        ],
        'common' => [
            'falling_behind' => 'Strengthening the Foundations',
            'motivation' => 'Building Confidence & Engagement',
            'extend_learning' => 'Extending Skills & Understanding',
            'individual_needs' => 'Personalised Learning Support',
        ],
    ];

    /**
     * Get Learning Need Title (based on subject)
     */
    public function getLearningNeedTitleAttribute()
    {
        $subject = $this->subject;
        $need = $this->learning_need;

        return self::LEARNING_NEED_CONTENT[$subject][$need]
            ?? self::LEARNING_NEED_CONTENT['common'][$need]
            ?? ucfirst(str_replace('_', ' ', $need));
    }

    /* ===========================
       Free Time Labels
    ============================ */
    public const FREE_TIME_LABELS = [
        'creative' => 'Creative & Curious',
        'performing' => 'Expressive & Social',
        'playing' => 'Active & Energetic',
    ];

    /**
     * Get Free Time display label
     */
    public function getFreeTimeLabelAttribute()
    {
        return self::FREE_TIME_LABELS[$this->free_time]
            ?? ucfirst(str_replace('_', ' ', $this->free_time));
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function myAssessment()
    {
        return $this->hasOne(MyAssessment::class,'learning_program_assessment_id','id');
    }

    public function assessmentSuggestion()
    {
        return $this->hasOne(AssessmentSuggestion::class, 'learning_program_assessment_id', 'id');
    }

}
