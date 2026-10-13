<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'tutor_unique_id',
        'pay_from',
        'pay_to',
        'gross_pay',
        'commission',
        'deductions',
        'net_pay',
        'payment_status',
        'status',
        'paid_on'
    ];

    protected $dates = ['pay_from','pay_to','paid_on'];
}
