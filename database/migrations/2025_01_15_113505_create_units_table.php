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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('nopol')->unique();
            $table->string('tipe');
            $table->string('no_rangka');
            $table->string('no_mesin');
            $table->string('driver');
            $table->string('tahun');
            $table->date('japo_kir');
            $table->date('japo_pajak');
            $table->date('japo_stnk');
            $table->date('japo_kontrak')->nullable();
            $table->boolean('status');
            $table->foreignId('id_customer')->constrained('customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
