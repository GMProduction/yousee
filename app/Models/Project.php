<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_pic',
        'request_date',
        'duration',
        'duration_unit',
        'is_lighted',
        'description'
    ];

    protected $casts = [
        'is_lighted' => 'boolean'
    ];

}
