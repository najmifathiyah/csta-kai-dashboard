<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::all();

        return view('divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('divisions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_divisi' => 'required|unique:divisions',
            'nama_divisi' => 'required',
            'deskripsi' => 'nullable'
        ]);

        Division::create([
            'kode_divisi' => $request->kode_divisi,
            'nama_divisi' => $request->nama_divisi,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()
            ->route('divisions.index')
            ->with('success', 'Data divisi berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('divisions.index');
    }

    public function edit(string $id)
    {
        $division = Division::findOrFail($id);

        return view('divisions.edit', compact('division'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_divisi' => 'required|unique:divisions,kode_divisi,' . $id,
            'nama_divisi' => 'required',
            'deskripsi' => 'nullable'
        ]);

        $division = Division::findOrFail($id);

        $division->update([
            'kode_divisi' => $request->kode_divisi,
            'nama_divisi' => $request->nama_divisi,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()
            ->route('divisions.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $division = Division::findOrFail($id);

        $division->delete();

        return redirect()
            ->route('divisions.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}