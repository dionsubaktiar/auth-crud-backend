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
    Schema::create('konsumen', function (Blueprint $table) {
        $table->id();
        $table->string('username')->unique();
        $table->string('email')->unique();
        $table->string('nama');
        $table->string('nik')->unique();
        $table->date('tanggal_lahir');
        $table->string('status_perkawinan');
        $table->string('data_pasangan')->nullable();
        $table->string('password');
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
