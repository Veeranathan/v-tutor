<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\AcademicProgramPurchase;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $guarded = [];

    public function getState()
    {
        return $this->hasOne(State::class, 'id', 'state');
    }

    public function fcmTokens()
    {
        return $this->hasMany(UserFcmToken::class);
    }


    // CRITICAL ADDITION: Relationship for Tutor's WWCC records
    // This allows a User (acting as a Tutor) to have many TutorWWCCModel records.
    // 'tutor_id' in 'tutor_wwcc' table is the foreign key referencing 'id' in 'users' table.
    public function getTutorWWCC()
    {
        // This relationship should define how to get ALL *valid* WWCC entries
        // and eager load the associated state details.
        return $this->hasMany(TutorWWCCModel::class, 'tutor_id', 'id')
            ->where('is_valid', 1) // Only valid WWCCs
            ->with('state');       // Eager load the related State model
    }

    // You can add a computed attribute to get unique WWCC states directly
    public function getUniqueWwccStatesAttribute()
    {
        return $this->getTutorWWCC->map(function ($wwcc) {
            return $wwcc->state; // Get the State model from each WWCC entry
        })->filter()->unique('id'); // Filter out nulls and get unique states by ID
    }

    public function getTutorShipPlan()
    {
        return $this->hasMany('App\Models\TutorshipPlan', 'teacher_id', 'id')->where('status', 'A');
    }
    public function getTutorShipPlanGrade()
    {
        return $this->hasMany(TutorshipPlan::class, 'tutor_id');
    }
    public function getMinTutorShipPlan()
    {
        return $this->hasOne('App\Models\TutorshipPlan', 'teacher_id', 'id')->where(['status' => 'A'])->orderBy('hourly_rate', 'asc');
    }
    public function getMaxTutorShipPlan()
    {
        return $this->hasOne('App\Models\TutorshipPlan', 'teacher_id', 'id')->where(['status' => 'A'])->orderBy('hourly_rate', 'desc');
    }

    public function getTutorAcademic()
    {
        return $this->hasMany('App\Models\TutorAcademic', 'teacher_id', 'id')->where('status', 'A');
    }
    public function getTutorExperience()
    {
        return $this->hasMany('App\Models\TutorExperience', 'teacher_id', 'id')->where('status', 'A');
    }
    public function getTutorRecognision()
    {
        return $this->hasMany('App\Models\TutorRecognision', 'teacher_id', 'id')->where('status', 'A');
    }
    public function languguageToTuor()
    {
        return $this->hasMany('App\Models\LangToTutor', 'tutor_id', 'id');
    }
    public function userToFavourite()
    {
        return $this->hasMany('App\Models\UserToFavourite', 'favourite_user_id', 'id');
    }
    public function getuserToFavourite()
    {
        return $this->hasOne('App\Models\UserToFavourite', 'favourite_user_id', 'id');
    }
    public function getStudentGrade()
    {
        return $this->hasOne('App\Models\StudentClassBooking', 'student_grade_id', 'grade');
    }
    public function getMyAvailability()
    {
        return $this->hasMany('App\Models\MyAvailability', 'teacher_id', 'id');
    }
    public function getSchool()
    {
        return $this->hasOne('App\Models\School', 'id', 'school');
    }
    public function getTimezone()
    {
        return $this->hasOne('App\Models\TimezoneLists', 'id', 'timezone_id');
    }
    //for tutor to get total online hours for a tutor
    public function getOnlineHours()
    {
        return $this->hasOne('App\Models\StudentClassBooking', 'tutor_id', 'id')->whereIn('booking_status', ['CM'])->groupBy('tutor_id')->select('booking_status', 'tutor_id', 'from_time', 'to_time', \DB::raw('((SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))/60)/60) as shift_length'));
    }
    public function getLastPaid()
    {
        return $this->hasOne('App\Models\Tutor_transaction', 'tutor_id', 'id')->where('purpose', 'W')->orderBy('id', 'desc');
    }
    public function getStudentTotOnlineHours()
    {
        return $this->hasOne('App\Models\StudentClassBooking', 'student_id', 'id')->whereIn('booking_status', ['CM'])->groupBy('student_id')->select('booking_status', 'student_id', 'from_time', 'to_time', \DB::raw('((SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))/60)/60) as shift_length'));
    }
    public function getStudentTotCount()
    {
        return $this->hasMany('App\Models\StudentClassBooking', 'student_id', 'id')->whereIn('booking_status', ['CM'])->select('student_id', 'booking_status', 'id');
    }
    public function getStudentTotPaid()
    {
        return $this->hasOne('App\Models\StudentClassBooking', 'student_id', 'id')->whereIn('booking_status', ['CM'])->groupBy('student_id')->select('booking_status', 'student_id', 'booking_amount', \DB::raw('((SUM(booking_amount))) as tot_booking_amount'));
    }
    public function getNationality()
    {
        return $this->hasOne('App\Models\Nationality', 'id', 'nationality_id');
    }

    public function getTutorAppForms()
    {
        return $this->hasMany('App\Models\TutorApplicationFormsModel', 'tutor_id', 'id');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getCalendarAvailability()
    {
        return $this->hasMany(Tutor_calander_availability::class, 'tutor_id', 'id');
    }
    public function zoomUser()
    {
        return $this->hasOne(ZoomUser::class, 'tutor_id', 'id');
    }

    public function status_change_user()
    {
        return $this->hasOne('App\Models\Admin', 'id', 'status_change_user_id');
    }
     public function tutorPayments()
    {
    return $this->hasMany(\App\Models\TutorPayment::class, 'tutor_id', 'id');
    }
    public function learningProgramAssessments()
    {
        return $this->hasMany(\App\Models\LearningProgramAssessment::class,'student_id','id');
    }
    public function academicProgramPurchases()
    {
        return $this->hasMany(AcademicProgramPurchase::class);
    }
    public function getFullNameAttribute()
    {
        return trim($this->f_name . ' ' . $this->l_name);
    }
    public function academicProgramSessions()
    {
        return $this->hasMany(
            \App\Models\AcademicProgramSession::class,
            'tutor_id',
            'id'
        );
    }
   public function gradeRelation()
    {
        return $this->belongsTo(\App\Models\Grade::class, 'grade', 'id');
    }
}
