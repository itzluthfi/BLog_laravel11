<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Exception;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        try {
            $categories = Category::latest()->get();
            return view('admin.categories.list', compact('categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat kategori: ' . $e->getMessage());
        }
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        try {
            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal menyimpan kategori: ' . $e->getMessage())->withInput();
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    // Menampilkan form edit kategori berdasarkan slug
    public function edit($slug)
    {
        try {
            $category = Category::where('slug', $slug)->firstOrFail();
            return view('admin.categories.edit', compact('category'));
        } catch (Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Kategori tidak ditemukan.');
        }
    }

    // Menyimpan perubahan kategori berdasarkan slug
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $slug . ',slug',
        ]);

        try {
            $category = Category::where('slug', $slug)->firstOrFail();
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage())->withInput();
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    // Menghapus kategori berdasarkan slug
    public function destroy($slug)
    {
        try {
            $category = Category::where('slug', $slug)->firstOrFail();
            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
        } catch (QueryException $e) {
            return back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}