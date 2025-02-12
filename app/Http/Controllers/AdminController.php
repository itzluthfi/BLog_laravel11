<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalBlogs = Blog::count();
        return view('admin.dashboard', compact('totalUsers', 'totalBlogs'));
    }

    /**
     * Menampilkan daftar user
     */
    public function users(Request $request)
    {
        $query = User::with('role');
    
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('username', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        }
    
        $users = $query->paginate(10);
    
        return view('admin.users.list', compact('users'));
    }
    

    public function createUser()
{
    return view('admin.users.add');
}

public function storeUser(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role_id' => 'required|exists:roles,id',
    ]);

    $validated['password'] = Hash::make($validated['password']);

    User::create($validated);

    return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
}


    /**
     * Menampilkan form edit user
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }


    public function setting()
    {
        $admin = Auth::user(); // Pastikan auth middleware aktif
        return view('admin.setting', compact('admin'));
    }
    
    public function updateSetting(Request $request)
    {
        $admin = Auth::user(); // Ambil user yang sedang login
    
        if (!$admin) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6',
        ]);
    
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }
    
        // Perbaiki update dengan menggunakan find()
        $admin = User::find($admin->id);
        
        if ($admin) {
            $admin->update($validated);
            return redirect()->route('admin.setting')->with('success', 'Pengaturan berhasil diperbarui!');
        }
    
        return redirect()->route('admin.setting')->with('error', 'Gagal memperbarui pengaturan.');
    }
    
}