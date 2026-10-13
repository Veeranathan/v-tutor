<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Recording;

class StudentClassBooking extends Model
{
    protected $table = 'student_class_bookings';
    protected $guarded = [];
    public function getStudent()
    {
        return $this->hasOne('App\Models\User', 'id', 'student_id');
    }
    public function getTutor()
    {
        return $this->hasOne('App\Models\User', 'id', 'tutor_id');
    }
    public function getSubject()
    {
        return $this->hasOne('App\Models\Subject', 'id', 'subject_id');
    }
    public function getTopicDetails()
    {
        // return $this->hasOne('App\Models\SubjectTopics', 'id', 'topic_details_id');
       return $this->hasOne('App\Models\TopicDetail', 'id', 'topic_details_id')->with('getTopic');

    }
    public function getStudentGrade()
    {
        return $this->hasOne('App\Models\Grade', 'id', 'student_grade_id');
    }
    public function getCancelledBy()
{
    return $this->cancelled_by;
}
    public function getPaymentsInfo()
    {
        return $this->hasOne('App\Models\Payments', 'booking_id', 'id');
    }
    public function getClassEndAssesment()
    {
        return $this->hasMany('App\Models\ClassEndAssesment', 'booking_id', 'id');
    }
    public function getReviewClassEndAssesment()
    {
        return $this->hasOne('App\Models\ClassEndAssesment', 'booking_id', 'id')->whereIn('question_id', [9, 17]);
    }
    public function getTimezone()
    {
        return $this->hasOne('App\Models\TimezoneLists', 'id', 'timezone_id');
    }
    public function getSubjectTopics()
    {
        return $this->belongsTo(SubjectTopics::class, 'subject_area', 'id');
    }

    public function getShortUrlAttribute()
    {
        $code = base64_encode($this->id);

        return URL::to('/s/' . $code);
    }



    public function getBookingDateUserAttribute()
    {
       // Log::info("in accessor");
        $timezone = Auth::user()->timezone_id ?? config('app.timezone');

        // ✅ Safely fetch raw attributes
        $bookingDate = $this->getAttribute('booking_date');
        $fromTime = $this->getAttribute('from_time');

        if (!$bookingDate || !$fromTime) {
            return null;
        }

        // Combine UTC booking_date + from_time
        $utcDateTime = Carbon::parse("$bookingDate $fromTime", 'UTC');

        // Convert to user's timezone and return date only
        return $utcDateTime->setTimezone($timezone)->format('Y-m-d');
    }

    public function getFromTimeUserAttribute()
    {
        $timezone = Auth::user()->timezone_id ?? config('app.timezone', 'Australia/Perth');
        $bookingDate = $this->getAttribute('booking_date');
        $fromTime = $this->getAttribute('from_time');

        if (!$bookingDate || !$fromTime) {
            return null;
        }

        $utcDateTime = Carbon::parse("$bookingDate $fromTime", 'UTC');
        return $utcDateTime->setTimezone($timezone)->format('H:i:s');
    }

    public function getToTimeUserAttribute()
    {
        $timezone = Auth::user()->timezone_id ?? config('app.timezone', 'Australia/Perth');
        $bookingDate = $this->getAttribute('booking_date');
        $toTime = $this->getAttribute('to_time');

        if (!$bookingDate || !$toTime) {
            return null;
        }

        $utcDateTime = Carbon::parse("$bookingDate $toTime", 'UTC');
        return $utcDateTime->setTimezone($timezone)->format('H:i:s');
    }

    public function academicProgramPurchase()
    {
        return $this->belongsTo(
            \App\Models\AcademicProgramPurchase::class,
            'academic_program_purchase_id'
        );
    }

    public function academicProgramSession()
    {
        return $this->hasOne(
            \App\Models\AcademicProgramSession::class,
            'student_class_booking_id'
        );
    }

    public function recordings()
    {
        return $this->hasMany(Recording::class, 'booking_id', 'id');
    }
}
