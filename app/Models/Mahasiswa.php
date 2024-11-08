<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';
    protected $guarded = ['id'];
    protected $fillable = [
        'tanggal',
        'nama',
        'nim',
        'mata_kuliah',
        'id_mata_kuliah',
        'waktu_mulai',
        'waktu_selesai',
        'kuota',
        'sesi',
        'kelas',
        'id_jadwal'
    ];

    // Relasi ke model lain jika diperlukan
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_mata_kuliah', 'id_mata_kuliah');
    }
    public function ruangan()
    {
        return $this->hasOne(Ruangan::class, 'nim', 'nim');
    }

    public function penanggung_Jawab()
    {
        return $this->hasOne(Penanggung_Jawab::class, 'nim', 'nim');
    }
}
