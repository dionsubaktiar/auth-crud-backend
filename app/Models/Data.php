<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = ['title','article','tanggal','user_id'];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
