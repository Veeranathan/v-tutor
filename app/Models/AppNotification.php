<?php
// app/Models/AppNotification.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id','type','title','body','read'];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean',
    ];
}
