<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function viewLogin()
    {
        return view('login');
    }

    public function storeLogin(Request $request)
    {
        $request->validate([
            "username" => "required|min:3",
            'password' => "required|min:3"
        ]);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('home.index');
        }

        return redirect()->back()->with("gagal", "Username Atau Password Salah, Silahkan Coba Kembali");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login')->with('sukses', "Sukses Logout");
    }
}
