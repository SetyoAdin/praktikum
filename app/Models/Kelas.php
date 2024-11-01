<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Kolom 'id' tetap dapat diisi
    // Nama tabel yang akan digunakan model ini
    protected $table = 'kelas';

    // Kolom yang boleh diisi
    protected $fillable = ['kelas'];
}
