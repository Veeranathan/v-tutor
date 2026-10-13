<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = [
        'name',
        'email',
        'number',
        'role',
        'category',
        'contact_method',
        'best_time',
        'subject',
        'message',
        'zoho_ticket_id'
    ];
}
