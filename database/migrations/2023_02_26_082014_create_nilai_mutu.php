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
        Schema::create('nilai_mutu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indikator_id')->required();
            $table->date('tanggal')->required();
            $table->bigInteger('numerator')->required();
            $table->bigInteger('denumerator')->required();
            $table->timestamps();
            $table->ipAddress('visitor');
            $table->string('pc_name');
            $table->foreign('indikator_id')->references('id')->on('master_indikator_mutu')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_mutu');
    }
};
