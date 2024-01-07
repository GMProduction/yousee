<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'description',
        'total_price',
        'number_doc',
        'to_name',
        'from'
    ];

    protected $casts = [
        'is_lighted' => 'boolean'
    ];

    public function items()
    {
        return $this->hasMany(ProjectItem::class, 'project_id')->orderBy('city_id','asc');
    }

//    public function items_count()
//    {
//        return $this->hasMany(ProjectItem::class, 'project_id')->count('id');
//    }

    /**
     * @return HasMany
     */
    public function project_item()
    {
        return $this->hasMany(ProjectItem::class, 'project_id');
    }

    protected static function booted()
    {
        static::deleting(function (Project $project) {
            $project->project_item()->delete();
        });
    }
}
