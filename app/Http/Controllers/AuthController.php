<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Blog;
use App\Models\Category;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Menampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi user
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9_]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Ambil role default untuk user
        $userRole = Role::where('name', 'User')->first();
        if (!$userRole) {
            return back()->withErrors(['role' => 'Role User tidak ditemukan.'])->onlyInput('username', 'email');
        }

        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $userRole->id,
        ]);

        Auth::login($user); // Langsung login setelah registrasi

        return redirect()->route('login')->with('success', 'Registrasi berhasil!');
    }

    // Proses login user
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role->name === 'Admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin!');
            } else {
                return redirect()->route('profile.dashboard')->with('success', 'Login berhasil sebagai User!');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    // Proses logout user
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logout berhasil!');
    }



    public function beranda(Request $request) {
        $categories = Category::all();
    
        // Tangkap query pencarian
        $query = Blog::with(['category', 'author', 'likes', 'favorites']);
        
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%')
                  ->orWhereHas('author', function ($q) use ($request) {
                      $q->where('username', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
        }
    
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }
    
        $blogs = $query->paginate(5);
    
        return view('home', compact('blogs', 'categories'));
    }
    
    
    
}