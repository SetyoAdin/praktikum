<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';
    protected $fillable = ['matkul'];
    protected $primaryKey = 'id_mata_kuliah';
    public function tanggals()
    {
        return $this->hasMany(Tanggal::class, 'id_mata_kuliah');
    }
}
