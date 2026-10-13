<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\AcademicProgramPurchase;

class AcademicProgramInvoice extends Model
{
      use HasFactory;

    protected $table = 'academic_program_invoices';

    protected $fillable = [
        'user_id',
        'order_id',
        'invoice_number',
        'stripe_session_id',
        'sub_total',
        'gst_percent',
        'gst_amount',
        'total_amount',
        'payment_status',
    ];

    /**
     * Invoice belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Invoice has many purchased programs
     */
    public function purchases()
    {
        return $this->hasMany(AcademicProgramPurchase::class, 'invoice_id');
    }

}
