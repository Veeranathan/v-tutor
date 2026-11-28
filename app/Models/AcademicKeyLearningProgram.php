<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicKeyLearningProgram extends Model
{
    use HasFactory;
     protected $table = 'academic_key_learning_programs';

    protected $fillable = [
        'learning_program_id',
        'name'
    ];
}
