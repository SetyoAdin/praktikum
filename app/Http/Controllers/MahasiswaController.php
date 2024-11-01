<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Tanggal;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;





class MahasiswaController extends Controller
{
    public function halaman()
    {
        $jadwals = Jadwal::all();
        return view('user.halaman', compact('jadwals'));
    }
    public function dash()
    {
        return view('layout.dash');
    }
    public function panel()
    {
        return view('user.usepanel');
    }

    public function form()
    {
        $tanggals = Tanggal::all();
        $jadwals = Jadwal::all();
        $mata_kuliahs = MataKuliah::all();
        $kelas = Kelas::all();
        $mahasiswa = Mahasiswa::all();

        return view('user.form', compact('tanggals', 'jadwals', 'mata_kuliahs', 'kelas'));
    }


    public function insertmhs(Request $request)
    {
        // Validasi input
        $request->validate([
            'mata_kuliah' => 'required',
            'tanggal' => 'required',
            'sesi' => 'required',
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'kelas' => 'required|string',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Ambil jadwal berdasarkan ID
            $jadwal = Jadwal::findOrFail($request->sesi);

            // Cek kuota
            if ($jadwal->kuota <= 0) {
                throw new \Exception('Kuota untuk sesi ini sudah penuh.');
            }

            // Cek apakah mahasiswa sudah terdaftar di mata kuliah ini
            $existingRegistration = Mahasiswa::where('nim', $request->nim)
                ->where('mata_kuliah', $request->mata_kuliah)
                ->first();

            if ($existingRegistration) {
                throw new \Exception('Anda sudah terdaftar untuk mata kuliah ini.');
            }

            // Ambil data tanggal dari relasi jadwal
            $tanggal = Tanggal::findOrFail($jadwal->id_tanggal);

            // Ambil data mata kuliah
            $mataKuliah = MataKuliah::findOrFail($request->mata_kuliah);

            // Kurangi kuota
            $jadwal->decrement('kuota');

            // Simpan data mahasiswa
            $mahasiswa = new Mahasiswa();
            $mahasiswa->tanggal = $tanggal->tanggal;
            $mahasiswa->nama = $request->nama;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->mata_kuliah = $mataKuliah->matkul; // Simpan nama mata kuliah
            $mahasiswa->id_mata_kuliah = $request->mata_kuliah; // Simpan ID mata kuliah jika diperlukan
            $mahasiswa->waktu_mulai = $jadwal->waktu_mulai;
            $mahasiswa->waktu_selesai = $jadwal->waktu_selesai;
            $mahasiswa->kuota = $jadwal->kuota; // Kuota setelah dikurangi
            $mahasiswa->sesi = $jadwal->sesi;
            $mahasiswa->kelas = $request->kelas;
            $mahasiswa->id_jadwal = $jadwal->id_jadwal; // Simpan ID jadwal jika diperlukan

            $mahasiswa->save();

            // Commit transaksi
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran praktikum berhasil!'
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function mahasiswa(Request $request)
    {
        $tanggals = Tanggal::all();
        $jadwals = Jadwal::all();
        $matkuls = MataKuliah::all();
        $mahasiswas = Mahasiswa::all();

        return view('admin.mahasiswa', compact('mahasiswas', 'tanggals', 'jadwals', 'matkuls',));
    }
    public function min()
    {
        return view('admin.min');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
