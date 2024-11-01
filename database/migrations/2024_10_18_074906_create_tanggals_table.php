<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanggals', function (Blueprint $table) {
            $table->id('id_tanggal');
            $table->foreignId('id_mata_kuliah') // foreign key ke tabel mata_kuliahs
                ->constrained('mata_kuliahs', 'id_mata_kuliah')
                ->onDelete('cascade'); // Cascade delete saat mata kuliah dihapus
            $table->date('tanggal'); // kolom tanggal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanggals');
    }
};
