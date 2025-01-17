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
        Schema::create('invoices', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('kode_invoice')->unique();
            $table->string('kode_spk')->unique();
            $table->integer('kilometer');
            $table->date('tanggal');
            $table->foreignId('id_unit')->constrained('units');
            $table->integer('id_package')->nullable();
            $table->foreign('id_package')->references('id')->on('servicepackages');
            $table->json('id_part')->nullable();
            $table->integer('harga');
            $table->string('status_invoice');
            $table->string('status_spk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
