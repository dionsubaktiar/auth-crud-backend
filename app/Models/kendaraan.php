<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';
    protected $fillable = [
        'dealer', 'merk_kendaraan', 'model_kendaraan', 'warna_kendaraan', 'harga_kendaraan'
    ];

    // Relationships
    public function pinjaman()
    {
        return $this->hasMany(pinjaman::class, 'id_kendaraan');
    }
}
