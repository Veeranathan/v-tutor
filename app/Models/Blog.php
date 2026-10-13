<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes; // <-- include SoftDeletes

    protected $table = 'blogs';

    protected $fillable = [
        'seo_keyword',
        'seo_description',
        'seo_page_title',
        'post_title',
        'post_content',
        'post_image',
        'user_type',
        'user_name',
        'status',
        'display_order',
        'slug'
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];
}
