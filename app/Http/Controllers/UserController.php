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
}
