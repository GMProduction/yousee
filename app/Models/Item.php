<?php

namespace App\Models;

use Carbon\Carbon;
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
        'trafic',
        'isShow',
        'slug'
    ];

    protected $with = ['type', 'city', 'createdByUser', 'lastUpdate'];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
    //    protected $hidden = [
    //        'url',
    //    ];

    public function type()
    {
        return $this->belongsTo(type::class)->withDefault(['name' => '']);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lastUpdate()
    {
        return $this->belongsTo(User::class, 'last_update_by');
    }

    public function history()
    {
        return $this->belongsToMany(User::class, 'histories', 'item_id', 'user_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendorAll()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id')->withDefault(['name' => ''])->withTrashed();
    }

    public function itemRent()
    {
        return $this->hasMany(ItemRent::class, 'item_id');
    }

    public function getStatusOnRentAttribute()
    {
        $now = Carbon::now()->format('Y-m-d');
        $rents = $this->itemRent()->where('end', '>', $now)->get();
        $result = 'empty';
        if (count($rents) > 0) {
            foreach ($rents as $rent) {
                $dateNow = Carbon::now();
                $dateStart = date('Y-m-d', strtotime($rent->start));
                $dateEnd = date('Y-m-d', strtotime($rent->end));
                if (($dateNow > $dateStart) && ($dateNow < $dateEnd)) {
                    $result = 'used until ' . Carbon::parse($dateEnd)->format('d-m-Y');
                    break;
                } else {
                    $result = 'will used ' . Carbon::parse($dateStart)->format('d-m-Y');
                }
            }
            return $result;
        }
        return $result;
    }

    // Di dalam model Item
    public function getStatusAttribute()
    {
        // Logika untuk menentukan status berdasarkan latitude dan longitude
        if ($this->latitude < -11.000 || $this->latitude > 6.100 || $this->longitude < 95.000 || $this->longitude > 141.000) {
            return "SALAH";
        }
        return "BENAR";
    }
}
