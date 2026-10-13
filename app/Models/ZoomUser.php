<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZoomUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'zoom_user_id',
        'email',
        'password',
        'pmi',
        'status',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id', 'id');
    }
}
