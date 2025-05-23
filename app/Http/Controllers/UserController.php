<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Tampilkan daftar semua pengguna (untuk Superadmin)
    public function index()
    {
        // Ambil semua pengguna dari database
        $users = User::all();

        // Kirim data pengguna ke tampilan 'users.index'
        return view('users.index', compact('users'));
    }

    // Tampilkan form untuk menambah pengguna
    public function create() {

        return view('users.create');
    }
    // Proses tambah pengguna
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:superadmin,admin,user',
        ]);

        // Create new user tanpa isi kolom 'role' langsung
        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Assign role menggunakan Spatie
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Tampilkan form untuk edit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Proses edit pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role'     => 'required|in:superadmin,admin,user',
        ]);

        $user->name     = $request->name;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sinkronisasi role
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Tampilkan detail pengguna
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    // Proses hapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('error', 'Pengguna berhasil dihapus.');
    }
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }
    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            return redirect()->route('dashboard')->with('success', 'Login berhasil.');
        }

        return redirect()->back()->withErrors(['username' => 'Username atau password salah.']);
    }
    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Logout berhasil.');
    }
}
