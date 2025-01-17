<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    use HasFactory;

    protected $table = "units";
    protected $fillable = [
        'nopol',
        'tipe',
        'no_rangka',
        'no_mesin',
        'driver',
        'tahun',
        'japo_kir',
        'japo_pajak',
        'japo_stnk',
        'japo_kontrak',
        'status',
        'id_customer'
    ];

    public function customers()
    {
        return $this->belongsTo(customer::class, 'id_customer', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(invoice::class, 'id_unit', 'id');
    }
}
