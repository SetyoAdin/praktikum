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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama');
            $table->string('nim');
            $table->string('mata_kuliah');
            $table->unsignedBigInteger('id_mata_kuliah')->nullable();
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->integer('kuota');
            $table->string('sesi');
            $table->string('kelas');
            $table->unsignedBigInteger('id_jadwal')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('mata_kuliahs');
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
