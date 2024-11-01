<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwals';
    protected $primaryKey = 'id_jadwal';
    // protected $fillable = ['tanggal', 'nama', 'nim', 'mata_kuliah', 'waktu_mulai', 'waktu_selesai', 'sesi'];
    protected $fillable = ['id_tanggal', 'sesi', 'waktu_mulai', 'waktu_selesai', 'kuota'];

    public function tanggal()
    {
        return $this->belongsTo(Tanggal::class, 'id_tanggal', 'id_tanggal');
    }
}
