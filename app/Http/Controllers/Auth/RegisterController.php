<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Jika validasi gagal, kembalikan ke halaman register dengan error
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Membuat pengguna baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Jika berhasil, kirimkan pesan sukses
            return redirect()->route('register')->with('success', 'Akun berhasil dibuat! Silakan login.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan pengguna, kirimkan pesan error
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat akun.'])->withInput();
        }
    }
}
