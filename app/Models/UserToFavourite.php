<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToFavourite extends Model
{
    protected $table = 'user_to_favourite';
    protected $guarded = [];

    public function getFavouriteUserInfo(){
        return $this->hasOne('App\Models\User', 'id', 'favourite_user_id');    
    }
    public function getStudentInfo(){
        return $this->hasOne('App\Models\User', 'id', 'user_id')->whereIn('status',['A','U']);    
    }
    public function getTutorInfo(){
        return $this->hasOne('App\Models\User', 'id', 'favourite_user_id')->whereIn('status',['A','U']);    
    }
}
