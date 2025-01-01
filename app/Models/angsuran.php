<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class angsuran extends Model
{
    protected $table = "angsuran";
    protected $fillable = ['angsuran_ke','nominal','tanggal_jatuh_tempo','kontrak_id','status'];
    public function kontrak(){
        return $this->belongsTo(kontrak::class,'kontrak_id','kontrak_no');
    }
}
