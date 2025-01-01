<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kontrak extends Model
{
    protected $table = "kontrak";
    protected $fillable = ['kontrak_no','client_name','otr','dp','durasi','tgl_mulai'];
    public function angsuran(){
        return $this->hasMany(angsuran::class,'kontrak_id','kontrak_no');
    }
}
