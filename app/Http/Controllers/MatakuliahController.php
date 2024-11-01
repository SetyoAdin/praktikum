<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Jadwal;
use App\Models\Tanggal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MataKuliahController extends Controller
{
    public function matkul()
    {
        $mata_kuliahs = MataKuliah::all();
        $jadwals = Jadwal::all();
        $tanggals = Tanggal::all();
        return view('admin.matkul', compact('mata_kuliahs', 'jadwals', 'tanggals'));
    }

    public function insertMatkul(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'mataKuliah' => 'required|string|max:255|unique:mata_kuliahs,matkul',
            ], [
                'mataKuliah.required' => 'Nama mata kuliah harus diisi',
                'mataKuliah.string' => 'Nama mata kuliah harus berupa teks',
                'mataKuliah.max' => 'Nama mata kuliah maksimal 255 karakter',
                'mataKuliah.unique' => 'Mata kuliah ini sudah ada'
            ]);

            DB::beginTransaction();

            // Buat mata kuliah baru
            $matkul = new MataKuliah();
            $matkul->matkul = $request->mataKuliah;
            $matkul->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mata kuliah berhasil ditambahkan',
                'data' => $matkul
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['mataKuliah'][0]
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating mata kuliah: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan mata kuliah: ' . $e->getMessage()
            ], 500);
        }
    }
    public function insertTanggal(Request $request)
    {
        $request->validate([
            'id_mata_kuliah' => 'required|exists:mata_kuliahs,id_mata_kuliah',
            'tanggal' => 'required|date',
        ]);

        try {
            $tanggal = Tanggal::firstOrCreate(
                [
                    'id_mata_kuliah' => $request->id_mata_kuliah,
                    'tanggal' => $request->tanggal,
                ]
            );

            if ($tanggal->wasRecentlyCreated) {
                // Kirim respon JSON untuk AJAX
                return response()->json(['success' => true, 'message' => 'Tanggal berhasil ditambahkan']);
            } else {
                // Kirim respon JSON jika tanggal sudah ada
                return response()->json(['success' => false, 'message' => 'Tanggal sudah ada untuk mata kuliah ini']);
            }
        } catch (\Exception $e) {
            Log::error('Error inserting tanggal: ' . $e->getMessage());

            // Kirim respon JSON jika ada kesalahan
            return response()->json(['success' => false, 'message' => 'Gagal menambah tanggal: ' . $e->getMessage()]);
        }
    }
    public function deleteMatkul($id)
    {
        try {
            DB::beginTransaction();

            // Cari mata kuliah
            $matkul = MataKuliah::findOrFail($id);

            // Ambil semua id tanggal terkait
            $tanggalIds = Tanggal::where('id_mata_kuliah', $id)->pluck('id_tanggal');

            // Hapus jadwal terkait
            if (!empty($tanggalIds)) {
                Jadwal::whereIn('id_tanggal', $tanggalIds)->delete();
            }

            // Hapus tanggal terkait
            Tanggal::where('id_mata_kuliah', $id)->delete();

            // Hapus mata kuliah
            $matkul->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mata kuliah dan data terkait berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting mata kuliah: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus mata kuliah: ' . $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'matkul' => 'required|string|max:255',
        ]);

        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->matkul = $validated['matkul'];
        $mataKuliah->save();

        return response()->json(['success' => true]);
    }
}
