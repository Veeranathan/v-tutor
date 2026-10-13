<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorApplicationFormsModel extends Model
{
    protected $table = 'tutor_application_forms';
    protected $guarded = [];

    public function getFormattedIdAttribute()
    {
        return 'TAF' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getTutor(){
        return $this->hasOne('App\Models\User', 'id', 'tutor_id');
    }

    public function getTutorWwcc(){
        return $this->hasMany('App\Models\TutorWWCCModel', 'tutor_app_id', 'id');
    }
}
