<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use App\Models\Auth as AuthModel; // Ubah alias jika perlu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth as AuthFacade;


class LoginController extends Controller
{
    public function loginadmin()
    {
        return view('admin.loginadmin');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama' => ['required'], // Menggunakan 'nama' untuk login
            'password' => ['required'],
        ]);

        // Check if 'nama' exists in super_admins table
        // $superAdmin = SuperAdmin::where('username', $credentials['nama'])->first();
        // if ($superAdmin && Hash::check($credentials['password'], $superAdmin->password)) {
        //     AuthFacade::login($superAdmin);
        //     return redirect()->intended('/dashboard');
        // }

        // Check if 'nama' exists in either table 
        $user = User::where('nama', $credentials['nama'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            AuthFacade::login($user);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'nama' => 'The provided credentials do not match our records.'
        ]);
    }

    public function logout()
    {
        AuthFacade::logout();
        return redirect('/login');
    }
}
