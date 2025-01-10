<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('kendaraan', function (Blueprint $table) {
        $table->id();
        $table->string('dealer');
        $table->string('merk_kendaraan');
        $table->string('model_kendaraan');
        $table->string('warna_kendaraan');
        $table->decimal('harga_kendaraan', 15, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
