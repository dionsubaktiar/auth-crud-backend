<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicepackage extends Model
{
    use HasFactory;

    protected $table = "servicepackages";
    protected $fillable = ['kode_packages'];

    public function invoices()
    {
        return $this->hasMany(invoice::class, 'id_package', 'id');
    }

    public function items()
    {
        return $this->hasMany(item::class, 'kode_packages', 'kode_packages');
    }
}
