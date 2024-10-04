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
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_gaji');
            $table->integer('jumlah_gaji');
            $table->integer('bonus')->nullable()->default(0);
            $table->integer('potongan')->nullable()->default(0);
            $table->unsignedBigInteger('id_pegawai');

            $table->foreign('id_pegawai')->references('id')->on('pegawais')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
