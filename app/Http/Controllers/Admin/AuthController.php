<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email tidak boleh kosong.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);

        $userExists = User::where('email', $request->email)->exists();

        if (!$userExists) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak terdaftar di sistem.']);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['password' => 'Password yang kamu masukkan salah.']);
        }

        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}