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
            $table->string('nik', 16);
            $table->string('pekerjaan');
            $table->string('jenis_usaha');
            $table->string('tempat_usaha');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('alamat');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Diajukan', 'Diproses', 'Selesai', 'Ditolak'])->default('Diajukan');
            $table->text('alasan')->nullable();
            $table->string('foto_usaha');
            $table->string('pengantar_rt_rw');
            $table->string('kk');
            $table->string('ktp');
            $table->string('surat_pernyataan');
            $table->uuid('user_id');
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
