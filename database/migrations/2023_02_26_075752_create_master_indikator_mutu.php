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
        Schema::create('master_indikator_mutu', function (Blueprint $table) {
            $table->id();
            $table->text('indikator')->required();
            $table->unsignedBigInteger('unit_id')->required();
            $table->string('jenis_indikator');
            $table->enum('satuan_pengukuran',['%','menit','']);
            $table->string('nilai_standar');
            $table->enum('penyajian_data',['tabel','line']);
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_indikator_mutu');
    }
};
