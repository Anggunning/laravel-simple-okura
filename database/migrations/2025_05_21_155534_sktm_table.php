<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sktm', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempatLahir')->nullable();
            $table->date('tanggalLahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('alamat')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->text('alasan')->nullable();
            $table->string('pekerjaan')->nullable();

            $table->enum('status', ['Diajukan', 'Diproses', 'Selesai', 'Ditolak', 'draf'])->default('Diajukan');

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
