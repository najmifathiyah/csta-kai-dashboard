<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();

        // Filter layanan (dari dashboard)
        if ($request->filled('layanan')) {
            $query->where('layanan', $request->layanan);
        }

        // Filter channel
        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        // Ambil data transaksi
        $transaksis = $query->latest()->get();

        // Data dropdown channel
        $channels = Transaksi::select('channel')
            ->whereNotNull('channel')
            ->where('channel', '!=', '')
            ->distinct()
            ->orderBy('channel')
            ->pluck('channel');

        return view('transaksi.index', compact(
            'transaksis',
            'channels'
        ));
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode' => 'required|date',
            'layanan' => 'required|string|max:255',
            'tipe_layanan' => 'required|string|max:255',
            'channel' => 'required|string|max:255',
            'transaksi' => 'required|integer',
            'jumlah_pelanggan' => 'required|integer',
            'nilai_transaksi' => 'required|numeric',
            'fee_kai' => 'required|numeric',
        ]);

        Transaksi::create($validated);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil ditambahkan.');
    }

    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'periode' => 'required|date',
            'layanan' => 'required|string|max:255',
            'tipe_layanan' => 'required|string|max:255',
            'channel' => 'required|string|max:255',
            'transaksi' => 'required|integer',
            'jumlah_pelanggan' => 'required|integer',
            'nilai_transaksi' => 'required|numeric',
            'fee_kai' => 'required|numeric',
        ]);

        $transaksi->update($validated);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil dihapus.');
    }
}