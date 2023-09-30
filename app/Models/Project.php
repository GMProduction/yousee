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
        'description'
    ];

    protected $casts = [
        'is_lighted' => 'boolean'
    ];

    /**
     * @return HasMany
     */
    public function project_item(){
        return $this->hasMany(ProjectItem::class,'project_id');
    }

    protected static function booted()
    {
        static::deleting(function (Project $project) {
            $project->project_item()->delete();
        });
    }

}
