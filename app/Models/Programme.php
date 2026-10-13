<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_name',
        'email',
        'student_name',
        'student_grade',
        'ref_source',
        'subscribe',
        'programs',
        'terms_agreed',
    ];

    protected $casts = [
        'programs' => 'array',
        'subscribe' => 'boolean',
        'terms_agreed' => 'boolean',
    ];
}
