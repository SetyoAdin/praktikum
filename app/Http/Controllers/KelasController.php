<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

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
}
