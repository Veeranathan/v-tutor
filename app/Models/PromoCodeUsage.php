<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeUsage extends Model
{
    use HasFactory;
      protected $fillable = [
        'promo_code_id',
        'booking_id',
        'student_id',
        'tutor_id',
        'used_at',
        'status'
    ];
}
