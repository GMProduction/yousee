<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'head_office_address',
        'head_office_phone',
        'head_office_location',
        'address',
        'phone',
        'email',
        'location',
        'sort_history',
        'facebook',
        'instagram',
        'tiktok',
        'whatsapp',
    ];
}
