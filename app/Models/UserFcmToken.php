<?php

// app/Models/UserFcmToken.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFcmToken extends Model
{
    protected $fillable = ['user_id', 'fcm_token', 'device'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
