<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan dashboard admin
    public function index()
    {
        // Mengambil semua pengguna
        $users = User::all();
        
        // Menghitung jumlah pengguna
        $totalUsers = User::count();
        $activeUsers = User::where('active', 1)->count(); // Misalkan ada kolom 'active'
        $inactiveUsers = User::where('active', 0)->count(); // Misalkan ada kolom 'active'

        // Mengembalikan tampilan admin dengan data pengguna
        return view('auth.admin', compact('users', 'totalUsers', 'activeUsers', 'inactiveUsers')); // Pastikan path 'auth.admin' benar
    }

    // Menambahkan pengguna
    public function create()
    {
        return view('auth.admin.create'); // Form untuk menambah pengguna
    }

    // Mengedit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('auth.admin.edit', compact('user')); // Form untuk mengedit pengguna
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin')->with('success', 'Pengguna berhasil dihapus!');
}


    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        // Validasi data pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Menyimpan pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash password
            'active' => 1, // Misalkan pengguna baru aktif secara default
            // Tambahkan kolom lain sesuai kebutuhan
        ]);

        return redirect()->route('admin')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi data pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'active' => 'required|boolean', // Misalkan ada kolom 'active'
        ]);

        // Memperbarui data pengguna
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'active' => $request->active,
            // Tambahkan kolom lain sesuai kebutuhan
        ]);

        return redirect()->route('admin')->with('success', 'Pengguna berhasil diperbarui!');
    }
}
