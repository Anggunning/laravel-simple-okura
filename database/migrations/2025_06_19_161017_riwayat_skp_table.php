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
        Schema::create('riwayat_skp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->string('peninjau');
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamp('waktu');
            $table->text('surat_balasan')->nullable();
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
