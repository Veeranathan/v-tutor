<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    //
    protected $table = 'schools';
    protected $guarded = []; 
    public function getState(){
        return $this->hasOne('App\Models\State', 'id', 'state_id');
    }
    
    public function getSuburb(){
        return $this->hasOne('App\Models\Suburb', 'id', 'suburb_id');
    } 
}
