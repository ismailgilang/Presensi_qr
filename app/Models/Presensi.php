<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nip',
        'role',
        'qr',
        'keterangan',
        'created_at'
    ];
}
