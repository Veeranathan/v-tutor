<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpCategory extends Model
{
    protected $table = 'help_category';
    protected $guarded = [];

     public function helpDetails(){
        return $this->hasOne('App\Models\HelpModel', 'help_category', 'id');
    }
    public function helpAllDetails(){
        return $this->hasMany('App\Models\HelpModel', 'help_category', 'id')->orderBy('display_order','asc');
    }
}
