<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TutorWWCCModel extends Model
{
     use HasFactory;

    protected $table = 'tutor_wwcc';
    protected $guarded = [];
     protected $fillable = ['tutor_id', 'states', 'is_valid']; 
    public function getTutor(){
        return $this->hasOne('App\\Models\\User', 'id', 'tutor_id');
    }
    
    public function getTutorForm(){
        return $this->hasOne('App\\Models\\TutorApplicationFormsModel', 'id', 'tutor_app_id');
    }
     public function state()
    {
        return $this->belongsTo(State::class, 'states');
    }
}