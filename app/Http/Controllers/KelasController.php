<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'kelas' => 'required|string|max:255|unique:kelas,kelas',
            ], [
                'kelas.required' => 'Nama kelas harus diisi.',
                'kelas.unique' => 'Kelas ini sudah ada.',
                'kelas.max' => 'Nama kelas tidak boleh lebih dari 255 karakter.',
            ]);

            // Simpan data ke database
            $kelas = Kelas::create([
                'kelas' => $request->input('kelas')
            ]);

            // Tidak ada output 'pretty print' di sini, hanya mengembalikan respons
            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil ditambahkan',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['kelas'][0], // Ambil pesan error pertama
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan kelas',
            ], 500);
        }
    }
    public function destroy($id)
    {
        // Cari data kelas berdasarkan ID
        $kelas = Kelas::findOrFail($id);

        // Hapus data kelas
        $kelas->delete();

        // Kirimkan response JSON untuk SweetAlert
        return response()->json(['success' => 'Data kelas berhasil dihapus!']);
    }
    public function editkelas(Request $request, $id)
    {
        try {
            // Validasi manual
            $validator = Validator::make($request->all(), [
                'kelas' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('kelas', 'kelas')->ignore($id)
                ],
            ], [
                'kelas.unique' => 'Kelas sudah ada.', // Pesan error kustom
                'kelas.required' => 'Nama kelas tidak boleh kosong.',
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $kelas = Kelas::findOrFail($id);

            // Update nama kelas
            $kelas->kelas = $request->kelas;
            $kelas->save();

            // Return JSON
            return response()->json([
                'success' => 'Nama kelas berhasil diperbarui!',
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            // Tangani error umum
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
