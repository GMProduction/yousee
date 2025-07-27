<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAffiliate extends Model
{
    use HasFactory;

    protected $table = 'useraffiliates';

    protected $fillable = [
        'nama',
        'email',
        'nophone',
        'domisilikota',
        'file_upload',
        'status',
    ];
}
