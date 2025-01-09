<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role; // Tambahkan use untuk Role

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

            // Menetapkan role ID 2 (Customer) ke pengguna baru
            $role = Role::find(2); // Cari role dengan ID 2
            if ($role) {
                $user->assignRole($role); // Tetapkan role ke pengguna
            } else {
                // Jika role tidak ditemukan, bisa menambahkan logika penanganan
                return back()->withErrors(['error' => 'Role tidak ditemukan.']);
            }

            // Jika berhasil, kirimkan pesan sukses
            return redirect()->route('register')->with('success', 'Akun berhasil dibuat! Silakan login.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan pengguna, kirimkan pesan error
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat akun.'])->withInput();
        }
    }
}

