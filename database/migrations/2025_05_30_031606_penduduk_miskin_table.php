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
        Schema::create('pendudukMiskin', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->text('alamat');
            $table->string('nama_kepala_keluarga');
            $table->integer('jml_agt_keluarga');
            $table->string('kelompokPKH')->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->string('foto_rumah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendudukMiskin');
    }
};
