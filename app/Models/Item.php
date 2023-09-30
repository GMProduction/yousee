<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'city_id',
        'location',
        'url',
        'type_id',
        'position',
        'width',
        'height',
        'image1',
        'image2',
        'image3',
        'created_by',
        'last_update_by',
        'vendor_id',
        'qty',
        'side',
        'trafic'
    ];

    protected $with = ['type','city','createdBy','lastUpdate'];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
//    protected $hidden = [
//        'url',
//    ];

    public function type(){
        return $this->belongsTo(type::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lastUpdate(){
        return $this->belongsTo(User::class, 'last_update_by');
    }

    public function history(){
        return $this->belongsToMany(User::class, 'histories','item_id','user_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendorAll(){
        return $this->belongsTo(Vendor::class, 'vendor_id')->withDefault(['name' => ''])->withTrashed();
    }
}
