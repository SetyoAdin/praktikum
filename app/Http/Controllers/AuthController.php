<?php

namespace App\Http\Controllers;

use App\Models\Auth as AuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;
use App\Models\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:auths',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        AuthModel::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Save the role to the AuthModel
        ]);

        return redirect()->route('registeradmin');
    }
    public function role()
    {
        $auths = AuthModel::all();
        return view('admin.role', compact('auths'));
    }
    public function registeradmin()
    {
        $auths = AuthModel::all();
        return view('admin.registeradmin', compact('auths'));
    }
    public function getEmails()
    {
        $emails = AuthModel::select('email')->get();
        return response()->json($emails);
    }
    public function updatePassword(Request $request, $email)
    {
        $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        $user = AuthModel::where('email', $email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password berhasil direset.']);
    }
    public function destroy($id)
    {
        // Cari user berdasarkan ID
        $auth = Auth::find($id);

        if ($auth) {
            // Jika ditemukan, hapus data
            $auth->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }

        // Jika tidak ditemukan, kirimkan response error
        return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    }
    public function profile()
    {
        return view('admin.profile');
    }
    public function updateName(Request $request, $id)
    {
        // Validate the input name
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            // Find the user data based on the ID
            $auth = Auth::findOrFail($id);

            // Update the user's name
            $auth->nama = $request->input('nama');
            $auth->save();

            // Redirect back to the user list page with a success message
            return redirect()->back()->with('success', 'Nama pengguna berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case when the user data is not found
            return response()->json(['error' => 'Data pengguna tidak ditemukan.'], 404);
        } catch (\Throwable $e) {
            // Handle other exceptions that may occur during the update process
            Log::error('Error updating user name: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui nama pengguna.'], 500);
        }
    }
    public function updateNama(Request $request, $id)
    {
        // Validasi input nama
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Cari data pengguna berdasarkan ID
        $auth = Auth::findOrFail($id);

        // Update nama pengguna
        $auth->nama = $request->input('nama');
        $auth->save();

        // Redirect kembali ke halaman daftar pengguna dengan pesan sukses
        return redirect()->back()->with('success', 'Nama pengguna berhasil diperbarui.');
    }
    public function deleteUser($id)
    {
        try {
            DB::beginTransaction();

            $user = Auth::findOrFail($id);
            $user->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus pengguna.'], 500);
        }
    }
}
