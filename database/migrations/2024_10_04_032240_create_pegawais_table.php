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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pegawai');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->text('alamat');
            $table->string('email');
            $table->date('tanggal_masuk');
            $table->integer('umur');
            $table->integer('gaji')->nullable()->default(0);
            $table->enum('status_pegawai', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->unsignedBigInteger('id_jabatan');

            $table->foreign('id_jabatan')->references('id')->on('jabatans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
