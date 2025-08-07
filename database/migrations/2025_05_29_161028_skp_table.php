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
        Schema::create('skp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('agama')->nullable();
            $table->enum('status', ['Diajukan', 'Diproses', 'Selesai', 'Ditolak','draf'])->default('Diajukan');
            $table->string('alasan')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->text('alamat')->nullable();
             $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status_kawin')->nullable();

            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();
            $table->string('pengantar_rt_rw')->nullable();
            $table->string('foto')->nullable();

            $table->timestamps();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('status_perkawinan_id')->nullable();
            $table->foreign('status_perkawinan_id')->references('id')->on('status_perkawinan')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skp');
    }
};
