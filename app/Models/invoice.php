<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $fillable = [
        'kode_invoice',
        'kode_spk',
        'kilometer',
        'tanggal',
        'id_unit',
        'id_package',
        'id_part',
        'harga',
        'status_invoice',
        'status_spk'
    ];

    public function units()
    {
        return $this->belongsTo(unit::class, 'id_unit', 'id');
    }

    public function packages()
    {
        return $this->belongsTo(servicepackage::class, 'id_package', 'id');
    }
}
