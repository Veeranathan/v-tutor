<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LangToTutor extends Model
{
    protected $table = 'lang_to_tutor';
    protected $guarded = [];
    public function languageName(){
        return $this->hasOne('App\Models\Language', 'id', 'language_id');
    }
}
