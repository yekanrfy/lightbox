<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Please login to access the dashboard.'])
                ->onlyInput('email');
        }

        // Ambil semua pengguna dari database
        $users = User::all();

        // Tampilkan view dengan data pengguna
        return view('auth.users')->with('users', $users);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    public function edit($id)
    {
        // Cari user berdasarkan id
        $user = User::findOrFail($id);

        // Kirim data user ke view edit di folder auth
        return view('auth.edit_user', compact('user'));
    }

    public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
    ]);

    // Cari user berdasarkan id
    $user = User::findOrFail($id);
    
    // Update nama dan email
    $user->name = $request->input('name');
    $user->email = $request->input('email');

    // Jika ada file foto yang diunggah
    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
        if ($user->photo && file_exists(storage_path('app/public/' . $user->photo))) {
            unlink(storage_path('app/public/' . $user->photo));
        }

        // Simpan file foto baru
        $filePath = $request->file('photo')->store('photos', 'public');
        $user->photo = $filePath;
    }

    // Simpan perubahan
    $user->save();

    return redirect()->route('user.index')->with('success', 'User updated successfully');
}

}
