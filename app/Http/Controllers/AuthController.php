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


    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     // Log the credentials (remove in production)
    //     Log::info('Login attempt:', ['email' => $credentials['email']]);

    //     // Check if the user exists
    //     $user = \App\Models\Auth::where('email', $credentials['email'])->first();
    //     if (!$user) {
    //         Log::warning('User not found:', ['email' => $credentials['email']]);
    //         return back()->withErrors(['email' => 'Email tidak ditemukan.']);
    //     }

    //     Log::info('User found:', ['user' => $user]);

    //     // Check if the password is correct
    //     if (!Hash::check($credentials['password'], $user->password)) {
    //         Log::warning('Incorrect password for user:', ['email' => $credentials['email']]);
    //         return back()->withErrors(['password' => 'Password salah.']);
    //     }

    //     // Attempt to log in
    //     if (Auth::attempt($credentials)) {
    //         Log::info('Login successful:', ['email' => $credentials['email']]);

    //         // Set user_name session
    //         session(['user_name' => $user->nama]);

    //         return redirect()->intended('/dashboard')->with('login_success', true); // Mengatur session untuk menandai login berhasil
    //     }

    //     Log::error('Authentication failed for valid credentials:', ['email' => $credentials['email']]);

    //     return back()->withErrors(['email' => 'Gagal login. Silakan coba lagi.']);
    // }



    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:auths',
            'password' => 'required|string|min:8|confirmed',
        ]);

        AuthModel::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
    public function updateName(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        if ($user instanceof User) {
            $user->nama = $request->input('nama');
            $user->save();

            return response()->json([
                'success' => true,
                'nama' => $user->nama,
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'User not authenticated']);
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
