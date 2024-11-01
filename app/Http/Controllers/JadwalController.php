<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Tanggal;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function datajadwal(Request $request)
    {
        $jadwals = Jadwal::all();
        $tanggals = Tanggal::all();

        // Cek apakah ada data yang di-submit melalui form tanggal
        if ($request->has('tanggal')) {
            $tanggal = new Tanggal;
            $tanggal->tanggal = $request->tanggal;
            $tanggal->save();
        }

        return view('admin.jadwal', compact('jadwals', 'tanggals'));
    }
    public function insertjw(Request $request)
    {
        $request->validate([
            'id_tanggal' => 'required|exists:tanggals,id_tanggal',
            'sesi' => 'required|string|max:255',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'kuota' => 'required|integer|min:1',
        ], [
            'id_tanggal.required' => 'Tanggal harus dipilih.',
            'id_tanggal.exists' => 'Tanggal yang dipilih tidak valid.',
            'sesi.required' => 'Sesi harus dipilih.',
            'sesi.string' => 'Format sesi tidak valid.',
            'waktu_mulai.required' => 'Waktu mulai harus diisi.',
            'waktu_mulai.date_format' => 'Format waktu mulai tidak valid.',
            'waktu_selesai.required' => 'Waktu selesai harus diisi.',
            'waktu_selesai.date_format' => 'Format waktu selesai tidak valid.',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
            'kuota.required' => 'Kuota harus diisi.',
            'kuota.integer' => 'Kuota harus berupa angka.',
            'kuota.min' => 'Kuota minimal 1.',
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah jadwal untuk tanggal dan sesi tersebut sudah ada
            $existingJadwal = Jadwal::where('id_tanggal', $request->id_tanggal)
                ->where('sesi', $request->sesi)
                ->first();

            if ($existingJadwal) {
                throw new \Exception('Jadwal untuk tanggal dan sesi ini sudah ada.');
            }

            // Buat jadwal baru
            $jadwal = new Jadwal();
            $jadwal->id_tanggal = $request->id_tanggal;
            $jadwal->sesi = $request->sesi;
            $jadwal->waktu_mulai = $request->waktu_mulai;
            $jadwal->waktu_selesai = $request->waktu_selesai;
            $jadwal->kuota = $request->kuota;
            $jadwal->save();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 422);
        }
    }

    public function viewjw()
    {
        $jadwals = Jadwal::all();
        $tanggals = Tanggal::all();

        return view('user.viewjw', compact('jadwals', 'tanggals'));
    }
    public function nav()
    {
        return view('admin.nav');
    }
    // AJAXX
    public function getTanggal($matkulId)
    {
        $tanggals = Tanggal::where('id_mata_kuliah', $matkulId)
            ->orderBy('tanggal', 'asc')
            ->get(['id_tanggal', 'tanggal']);

        return response()->json($tanggals);
    }

    // Method untuk mendapatkan sesi berdasarkan tanggal
    public function getSesi($tanggalId)
    {
        $jadwals = Jadwal::where('id_tanggal', $tanggalId)
            ->orderBy('sesi', 'asc')
            ->get(['id_jadwal', 'sesi']);

        return response()->json($jadwals);
    }

    // Method untuk mendapatkan detail jadwal
    public function getJadwalDetail($jadwalId)
    {
        $jadwal = Jadwal::findOrFail($jadwalId);

        return response()->json([
            'waktu_mulai' => $jadwal->waktu_mulai,
            'waktu_selesai' => $jadwal->waktu_selesai,
            'kuota' => $jadwal->kuota
        ]);
    }
    public function deleteSession($id_tanggal)
    {
        try {
            // Hapus data di tabel jadwals berdasarkan id_tanggal
            Jadwal::where('id_tanggal', $id_tanggal)->delete();

            return response()->json(['status' => 'success', 'message' => 'Data jadwal berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus data jadwal.']);
        }
    }
}
