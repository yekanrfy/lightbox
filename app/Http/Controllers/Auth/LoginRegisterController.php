<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'photo' => 'image|nullable|max:1999', // Validasi untuk foto
        ]);
        
        // Menyimpan foto jika ada
        $path = null;
        if ($request->hasFile('photo')) {
            // Mengambil nama file dan ekstensi
            $filenameWithExt = $request->file('photo')->getClientOriginalName(); // Nama file lengkap
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); // Nama file tanpa ekstensi
            $extension = $request->file('photo')->getClientOriginalExtension(); // Ekstensi file
            
            // Membuat nama file baru yang unik
            $filenameSimpan = $filename . '_' . time() . '.' . $extension; // Nama file baru
            
            // Simpan file dengan nama yang baru
            $path = $request->file('photo')->storeAs('photos', $filenameSimpan, 'public'); // Menyimpan file dan mendapatkan path-nya
        }

        // Membuat user baru dan menyimpan path foto ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $path, // Menyimpan path foto ke database
        ]);
        
        // Autentikasi user
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        
        return redirect()->route('dashboard')->withSuccess('You have successfully registered & logged in!');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->withSuccess('You have logged out successfully!');
    }
}