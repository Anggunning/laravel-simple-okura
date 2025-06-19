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
        $table->string('nama');
        $table->string('tujuan');
        $table->string('jenis_kelamin');
        $table->string('tempatLahir');
        $table->date('tanggalLahir');
        $table->string('agama');
        $table->string('nik');
        $table->string('alamat');
        $table->date('tanggal');
        $table->text('keterangan');
        $table->string('status');
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
