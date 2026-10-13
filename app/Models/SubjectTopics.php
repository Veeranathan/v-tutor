<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubjectTopics extends Model
{
    protected $table = 'subject_topics';
    protected $guarded = [];

    // Relationships
    public function getBranch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function getSubject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    public function getGrade()
    {
        return $this->hasOne(Grade::class, 'id', 'grade_id');
    }

    public function details()
    {
        return $this->hasMany(TopicDetail::class, 'topic_id', 'id');
    }

   
   
}
