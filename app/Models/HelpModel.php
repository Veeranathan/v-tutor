<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpModel extends Model
{
     protected $table = 'help';
    protected $guarded = [];

      public function helpName(){
        return $this->hasOne('App\Models\HelpCategory','id', 'help_category');
    }
   
}
