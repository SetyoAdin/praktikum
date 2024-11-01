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
        Schema::create('ujadwals', function (Blueprint $table) {
            $table->bigIncrements('id'); // Menambahkan primary key yang otomatis increment
            $table->bigInteger('id_tanggal');
            $table->string('sesi');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->integer('kuota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujadwals');
    }
};
