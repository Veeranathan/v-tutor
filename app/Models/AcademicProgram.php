<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use App\Models\Grade;
use App\Models\AcademicProgramPurchase;

class AcademicProgram extends Model
{
    use HasFactory;
     protected $table = 'academic_programs';

    protected $fillable = [
        'name',
        'slug',
        'code',
        'grade_id',
        'branch_id',
        'curriculum',
        'city',
        'state',
        'price',
        'regular_price',
        'discount',
        'document',
        'description',
        'validity',
        'status',
        'display_for',
        'popular',
        'display_order',
        'program_type',
        'program_duration',
        'session_duration',
        'session_interval',
        'mode_of_delivery',
        'program_tutor',
        'booking_method',
        'assessments',
        'number_of_sessions',
        'program_detail',
        'outcome',
        'parent_session_plan',
        'tutor_session_plan',
    ];

    protected $casts = [
        'display_for' => 'array',
        'assessments' => 'array',
        'status'      => 'boolean',
        'popular'     => 'boolean',
        'price'       => 'decimal:2',
        'regular_price' => 'decimal:2',
        'discount'    => 'decimal:2',
        'number_of_sessions' => 'integer',
    ];

     public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function purchases()
    {
        return $this->hasMany(AcademicProgramPurchase::class);
    }
    public function academicProgram()
    {
        return $this->belongsTo(
            AcademicProgram::class,
            'academic_program_id'
        );
    }

}
