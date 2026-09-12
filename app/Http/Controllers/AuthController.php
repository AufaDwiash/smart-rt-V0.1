<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'NIK atau Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        $user = User::where($loginField, $credentials['login'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withInput($request->only('login'))->withErrors([
                'login' => 'NIK / Email atau password yang Anda masukkan salah.',
            ]);
        }

        if ($user->status_akun !== 'aktif') {
            return back()->withErrors([
                'login' => 'Akun Anda berstatus nonaktif. Silakan hubungi pengurus RT.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, ' . $user->nama_lengkap . '!');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:users,nik'],
            'no_kk' => ['nullable', 'string', 'size:16'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['required', 'string'],
            'rt' => ['nullable', 'string', 'max:10'],
            'rw' => ['nullable', 'string', 'max:10'],
            'status_keluarga' => ['nullable', 'in:Kepala Keluarga,Istri,Anak,Anggota Lain'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus berjumlah 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'alamat.required' => 'Alamat tinggal wajib diisi.',
        ]);

        // Auto-create or ensure KK if provided
        if (!empty($validated['no_kk'])) {
            KartuKeluarga::firstOrCreate(
                ['no_kk' => $validated['no_kk']],
                [
                    'kepala_keluarga_nama' => $validated['nama_lengkap'],
                    'alamat' => $validated['alamat'],
                    'rt' => $validated['rt'] ?? '03',
                    'rw' => $validated['rw'] ?? '02',
                ]
            );
        }

        $user = User::create([
            'nik' => $validated['nik'],
            'no_kk' => $validated['no_kk'] ?? null,
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'warga',
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'alamat' => $validated['alamat'],
            'rt' => $validated['rt'] ?? '03',
            'rw' => $validated['rw'] ?? '02',
            'status_keluarga' => $validated['status_keluarga'] ?? 'Anggota Lain',
            'status_warga' => 'tetap',
            'status_akun' => 'aktif',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di Smart-RT, ' . $user->nama_lengkap . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah berhasil logout.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'agama' => ['nullable', 'string', 'max:30'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->nama_lengkap = $validated['nama_lengkap'];
        $user->email = $validated['email'] ?? null;
        $user->no_hp = $validated['no_hp'] ?? null;
        $user->alamat = $validated['alamat'];
        $user->pekerjaan = $validated['pekerjaan'] ?? null;
        $user->agama = $validated['agama'] ?? null;
        $user->save();

        return back()->with('success', 'Data profil berhasil diperbarui.');
    }
}
