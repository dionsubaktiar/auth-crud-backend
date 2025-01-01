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
        Schema::create('angsuran', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('angsuran_ke');
            $table->integer('nominal');
            $table->date('tanggal_jatuh_tempo');
            $table->string('status')->default('pending');
            $table->string('kontrak_id');
            $table->foreign('kontrak_id')->references('kontrak_no')->on('kontrak')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsuran');
    }
};
