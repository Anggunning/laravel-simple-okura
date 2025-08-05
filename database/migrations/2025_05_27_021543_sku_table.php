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
       Schema::create('sku', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempatLahir')->nullable();
            $table->date('tanggalLahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->string('tempat_usaha')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('alamat')->nullable();
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Diajukan', 'Diproses', 'Selesai', 'Ditolak', 'draf'])->default('Diajukan');
            $table->string('nomor_surat')->nullable();
            $table->text('alasan')->nullable();
            $table->string('foto_usaha')->nullable();
            $table->string('pengantar_rt_rw')->nullable();
            $table->string('kk')->nullable();
            $table->string('ktp')->nullable();
            $table->string('surat_pernyataan')->nullable();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->timestamps();
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
