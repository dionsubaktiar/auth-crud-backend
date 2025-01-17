<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'sparepart',
        'harga_part',
        'harga_jasa',
        'kode_packages'
    ];
    public function packages()
    {

        return $this->belongsTo(servicepackage::class, 'kode_packages', 'kode_packages');
    }
}
