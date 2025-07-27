<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CalonVendor extends Model
{
    use HasFactory;

    protected $table = 'calon_vendors';

    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false;

    // Kolom yang bisa diisi (mass-assignable)
    protected $fillable = [
        'id',
        'nama_perusahaan',
        'brand_vendor',
        'alamat',
        'email',
        'nophone',
        'pic',
        'nomor_pic',
        'status',
        'titik_file',
    ];


    /**
     * Auto-generate UUID saat membuat data baru
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
