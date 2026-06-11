<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $admins = User::where('id', '!=', $user->id)->get();
        return view('admin.profil.index', compact('user', 'admins'));
    }

    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'name.required'  => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan akun lain.',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success_info', 'Nama dan email berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password lama tidak boleh kosong.',
            'password.required'         => 'Password baru tidak boleh kosong.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
            'password.min'              => 'Password minimal 8 karakter.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password lama tidak sesuai.'])
                ->with('tab', 'password');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()
            ->with('success_password', 'Password berhasil diperbarui.')
            ->with('tab', 'password');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(8), 'confirmed'],
        ], [
            'name.required'      => 'Nama tidak boleh kosong.',
            'email.required'     => 'Email tidak boleh kosong.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password tidak boleh kosong.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back()
            ->with('success_admin', 'Admin baru berhasil ditambahkan.')
            ->with('tab', 'admin');
    }

    public function destroyAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['delete' => 'Tidak bisa menghapus akun sendiri.'])->with('tab', 'admin');
        }

        $user->delete();

        return back()
            ->with('success_admin', 'Admin berhasil dihapus.')
            ->with('tab', 'admin');
    }
}