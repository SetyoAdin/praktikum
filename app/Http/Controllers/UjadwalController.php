<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Ujadwal;

class UjadwalController extends Controller
{
    public function transferData()
    {


        $jadwalData = Jadwal::all();

        foreach ($jadwalData as $data) {
            Ujadwal::create([
                'id_tanggal' => $data->id_tanggal,
                'sesi' => $data->sesi,
                'waktu_mulai' => $data->waktu_mulai,
                'waktu_selesai' => $data->waktu_selesai,
                'kuota' => $data->kuota,
            ]);
        }

        return redirect('/datajadwwal')->with('message', 'Data has been transferred successfully.');
    }
}
