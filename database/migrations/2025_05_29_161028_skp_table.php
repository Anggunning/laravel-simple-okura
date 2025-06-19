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
            $table->string('nama');
            $table->string('nik', 16)->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('kewarganegaraan');
            $table->string('pekerjaan');
            $table->string('agama');
            $table->string('status');
            $table->text('alamat');
            $table->string('status_kawin');

            $table->string('ktp')->nullable(); // path file
            $table->string('kk')->nullable(); // path file
            $table->string('pengantar_rt_rw')->nullable(); // path file
            $table->string('foto')->nullable(); // path file

            $table->timestamps();
            $table->uuid('status_perkawinan_id');
            $table->foreign('status_perkawinan_id')->references('id')->on('status_perkawinan')->onDelete('cascade');
            
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
