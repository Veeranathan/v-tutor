<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor_transaction extends Model
{
    protected $table = 'user_transaction';
    protected $guarded = []; 
    
     public function tutor(){
        return $this->hasOne('App\Models\User', 'id', 'tutor_id');
    }
}
