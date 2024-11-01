<?php

namespace App\Http\Controllers;

use App\Models\Tanggal;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TanggalController extends Controller
{
    public function hapusData($id_tanggal)
    {
        Jadwal::where('id_tanggal', $id_tanggal)->delete();
        Tanggal::where('id_tanggal', $id_tanggal)->delete();

        return redirect()->back()->with('status', 'Data berhasil dihapus');
    }
    public function datatanggal()
    {
        $jadwals = Jadwal::all();
        $tanggals = Tanggal::all();
        return view('admin.tanggal', compact('jadwals', 'tanggals'));
    }
    public function tambahtanggal(Request $request)
    {
        $tanggal = new Tanggal;
        $tanggal->tanggal = $request->tanggal;
        $tanggal->save();

        return redirect('/matkul');
    }
    public function destroy($id_tanggal)
    {
        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Hapus jadwal terkait terlebih dahulu
            Jadwal::where('id_tanggal', $id_tanggal)->delete();

            // Hapus data tanggal
            Tanggal::where('id', $id_tanggal)->delete();

            // Commit transaksi jika semua berhasil
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data tanggal dan jadwal berhasil dihapus',
                'redirect' => true  // Tambahkan flag untuk redirect
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateTanggal(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        try {
            $tanggal = Tanggal::findOrFail($id); // Mencari tanggal berdasarkan ID
            $tanggal->tanggal = $request->tanggal; // Mengubah tanggal
            $tanggal->save(); // Menyimpan perubahan

            return response()->json(['success' => true, 'message' => 'Tanggal berhasil diupdate']);
        } catch (\Exception $e) {
            Log::error('Error updating tanggal: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengupdate tanggal']);
        }
    }
}
