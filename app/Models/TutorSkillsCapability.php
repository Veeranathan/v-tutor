<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorSkillsCapability extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id','skills','capabilities'
    ];

    public function tutor()
        {
            return $this->belongsTo(User::class,'tutor_id','id');
        }
}
