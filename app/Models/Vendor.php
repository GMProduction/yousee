<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'brand',
        'email',
        'picName',
        'picPhone',
        'password'
    ];

//    protected $with = 'items';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(){
        return $this->hasMany(Item::class, 'vendor_id');
    }

}
