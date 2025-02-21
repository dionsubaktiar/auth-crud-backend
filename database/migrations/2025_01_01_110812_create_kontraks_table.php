<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kontrak', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('kontrak_no')->unique();
            $table->string('client_name');
            $table->integer('otr');
            $table->integer('dp');
            $table->integer('durasi');
            $table->float('bunga');
            $table->date('tgl_mulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak');
    }
};
