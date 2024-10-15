<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutisTable extends Migration
{
    public function up()
    {
        Schema::create('cutis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('alasan');
            $table->timestamps();

            $table->foreign('id_pegawai')->references('id')->on('pegawais')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cutis');
    }
}
