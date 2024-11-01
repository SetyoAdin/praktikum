<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggal extends Model
{
    use HasFactory;

    protected $table = 'tanggals';
    protected $fillable = ['id_mata_kuliah', 'tanggal'];
    protected $primaryKey = 'id_tanggal';

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_mata_kuliah');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_tanggal');
    }
}
