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
            $table->text('numerator')->after('nilai_standar')->nullable();
            $table->text('denumerator')->after('numerator')->nullable();
            $table->string('penanggung_jawab')->after('penyajian_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_indikator_mutu', function (Blueprint $table) {
            $table->dropColumn('numerator');
            $table->dropColumn('denumerator');
            $table->dropColumn('penanggung_jawab');
        });
    }
};
