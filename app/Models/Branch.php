<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $table = 'branches';
    protected $guarded = [];
    public function getAllSubjects(){
        return $this->hasMany('App\Models\Subject', 'branch_id', 'id')->orderBy('display_order','asc');
    }
}
