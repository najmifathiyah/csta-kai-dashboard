<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:categories,kode_kategori',
            'nama_kategori' => 'required',
        ]);

        Category::create([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Data kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kategori
     */
    public function show(string $id)
    {
        return redirect()->route('categories.index');
    }

    /**
     * Menampilkan form edit kategori
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Mengupdate data kategori
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:categories,kode_kategori,' . $id,
            'nama_kategori' => 'required',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Data kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Data kategori berhasil dihapus.');
    }
}