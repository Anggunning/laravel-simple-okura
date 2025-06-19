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
        $table->string('nama_ayah');
        $table->string('nik_ayah', 16);
        $table->string('tempat_lahir_ayah');
        $table->date('tanggal_lahir_ayah');
        $table->string('kewarganegaraan_ayah');
        $table->string('pekerjaan_ayah');
        $table->string('agama_ayah');
        $table->text('alamat_ayah');

        // Ibu
        $table->string('nama_ibu');
        $table->string('nik_ibu', 16);
        $table->string('tempat_lahir_ibu');
        $table->date('tanggal_lahir_ibu');
        $table->string('kewarganegaraan_ibu');
        $table->string('pekerjaan_ibu');
        $table->string('agama_ibu');
        $table->text('alamat_ibu');

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
