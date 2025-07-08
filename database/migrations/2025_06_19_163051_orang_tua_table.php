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
        Schema::create('orang_tua', function (Blueprint $table) {
        $table->uuid('id')->primary();

        // Ayah
        $table->string('nama_ayah')->nullable();
        $table->string('nik_ayah', 16);
        $table->string('tempat_lahir_ayah')->nullable();
        $table->date('tanggal_lahir_ayah')->nullable();
        $table->string('kewarganegaraan_ayah')->nullable();
        $table->string('pekerjaan_ayah')->nullable();
        $table->string('agama_ayah')->nullable();
        $table->text('alamat_ayah')->nullable();
        $table->string('rt_ayah', 3)->nullable();
        $table->string('rw_ayah', 3)->nullable();

        // Ibu
        $table->string('nama_ibu')->nullable();
        $table->string('nik_ibu', 16);
        $table->string('tempat_lahir_ibu')->nullable();
        $table->date('tanggal_lahir_ibu')->nullable();
        $table->string('kewarganegaraan_ibu')->nullable();
        $table->string('pekerjaan_ibu')->nullable();
        $table->string('agama_ibu')->nullable();
        $table->text('alamat_ibu')->nullable();
        $table->string('rt_ibu', 3)->nullable();
        $table->string('rw_ibu', 3)->nullable();

        $table->timestamps();
        $table->uuid('skp_id');
        $table->foreign('skp_id')->references('id')->on('skp')->onDelete('cascade');
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
