<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'tags',
        'content'
    ];
}
