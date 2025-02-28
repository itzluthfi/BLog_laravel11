<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Blog;

class UserController extends Controller
{
      // Menampilkan halaman profil
      public function index()
      {
          $user = Auth::user(); // Ambil data pengguna yang login
          return view('profile.index', compact('user'));
      }
  
      // Mengupdate data profil
      public function updateSetting(Request $request)

      
      {
        // dd($request->all());
          $validated = $request->validate([
              'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
              'username' => 'required|string|max:255',
              'bio' => 'nullable|string',
              'email' => 'required|email|unique:users,email,' . Auth::id(),
          ]);
      
          $user = User::find(Auth::id());
      
          // Jika ada gambar baru, hapus gambar lama dan simpan yang baru
          if ($request->hasFile('profile_image')) {
              if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                  Storage::disk('public')->delete($user->profile_image);
              }
      
              $profileImage = $request->file('profile_image');
              $profileFileName = 'profile_' . time() . '-' . $profileImage->getClientOriginalName();
              $path = $profileImage->move(public_path('storage/user_images'), $profileFileName);
            //   dd($path);
              
      
            $validated['profile_image'] = 'storage/user_images/' . $profileFileName;
          }
      
          // Update data langsung menggunakan $validated
          $user->update($validated);
      
          return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
      }
  
      // Mengupdate password
      public function updatePassword(Request $request)
      {
          $request->validate([
              'current_password' => 'required',
              'new_password' => 'required|min:6|confirmed',
          ]);
  
          $user = User::find(Auth::id());
  
          // Validasi password lama
          if (!Hash::check($request->current_password, $user->password)) {
              return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
          }
  
          // Update password baru
          $user->password = Hash::make($request->new_password);
          $user->save();
  
          return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui.');
      }
  
      public function myArticles()
  {
      $blogs = Blog::where('author_id', Auth::id())->latest()->get();
      return view('profile.artikelSaya', compact('blogs'));
  }

  public function setting()
    {
        $user = Auth::user(); // Pastikan auth middleware aktif
        return view('profile.setting', compact('user'));
    }

    // public function updateSetting(Request $request)
    // {
    //     $user = Auth::user(); // Ambil user yang sedang login
    
    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    //     }
    
    //     $validated = $request->validate([
    //         'username' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         'password' => 'nullable|min:6',
    //     ]);
    
    //     if ($request->filled('password')) {
    //         $validated['password'] = Hash::make($request->password);
    //     } else {
    //         unset($validated['password']);
    //     }
    
    //     // Perbaiki update dengan menggunakan find()
    //     $user = User::find($user->id);
        
    //     if ($user) {
    //         $user->update($validated);
    //         return redirect()->route('profile.setting')->with('success', 'Pengaturan berhasil diperbarui!');
    //     }
    
    //     return redirect()->route('profile.setting')->with('error', 'Gagal memperbarui pengaturan.');
    // }
}