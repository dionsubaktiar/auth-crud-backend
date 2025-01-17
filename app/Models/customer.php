<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = ['nama_perusahaan','alamat','pic','kontak'];
    public function units(){
        return $this->hasMany(unit::class,'id_customer','id');
    }
}
