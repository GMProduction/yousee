<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'city_id',
        'pic_id',
        'item_id',
        'vendor_price',
        'available',
        'is_lighted',
        'end_price'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id')->withDefault(['name' => '', 'location' => '', 'type' => ['name' => ''], 'address' => '']);
    }
}
