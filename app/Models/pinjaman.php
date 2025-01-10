<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';

    protected $fillable = [
        'asuransi', 'down_payment', 'tenor', 'angsuran', 'id_kendaraan', 'id_user'
    ];

    // Relationships
    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_user');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }
}
