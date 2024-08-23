<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Barcode extends Model
{
    use HasFactory;
    public $incrementing = false;
    // Set the key type to string
    protected $keyType = 'string';
    protected $fillable = [
        'judul',
        'deskripsi',
        'keterangan',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate a UUID if not provided
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
