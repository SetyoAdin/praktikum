<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujadwal extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Sesuaikan dengan nama kunci utama yang digunakan dalam tabel

    protected $table = 'mahasiswas';
}
