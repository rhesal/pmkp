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
        Schema::table('master_indikator_mutu', function (Blueprint $table) {
            $table->renameColumn('jenis_indikator', 'kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_indikator_mutu', function (Blueprint $table) {
            $table->renameColumn('kategori', 'jenis_indikator');
        });
    }
};
