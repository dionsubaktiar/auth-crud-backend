<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class konsumen extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'konsumen';

    protected $fillable = [
        'username', 'email', 'nama', 'nik', 'tanggal_lahir', 'status_perkawinan', 'data_pasangan', 'password'
    ];

    protected $hidden = [
        'password',
    ];

    // Relationships
    public function pinjaman()
    {
        return $this->hasMany(pinjaman::class, 'id_user');
    }
}

