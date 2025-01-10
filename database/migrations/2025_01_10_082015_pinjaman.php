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
    Schema::create('pinjaman', function (Blueprint $table) {
        $table->id();
        $table->decimal('asuransi', 15, 2);
        $table->decimal('down_payment', 15, 2);
        $table->integer('tenor');
        $table->decimal('angsuran', 15, 2);
        $table->foreignId('id_kendaraan')->constrained('kendaraan');
        $table->foreignId('id_user')->constrained('konsumen');
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
