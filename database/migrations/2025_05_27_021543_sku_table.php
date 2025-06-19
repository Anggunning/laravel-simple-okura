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
            $table->string('nama');
            $table->string('tujuan');
            $table->string('jenis_kelamin');
            $table->string('tempatLahir');
            $table->date('tanggalLahir');
            $table->string('agama');
            $table->string('nik');
            $table->string('pekerjaan');
            $table->string('jenis_usaha');
            $table->string('tempat_usaha');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('alamat');
            $table->text('keterangan');
            $table->string('status');
            $table->string('foto_usaha')->nullable();
            $table->string('pengantar_rt_rw')->nullable();
            $table->string('kk')->nullable();
            $table->string('ktp')->nullable();
            $table->string('surat_pernyataan')->nullable();

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
