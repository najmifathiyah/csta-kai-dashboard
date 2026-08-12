<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();


        // ==================================================
        // FILTER LAYANAN
        // ==================================================

        if ($request->filled('layanan')) {

            $query->where(
                'layanan',
                $request->layanan
            );
        }


        // ==================================================
        // FILTER CHANNEL
        // ==================================================

        if ($request->filled('channel')) {

            $query->where(
                'channel',
                $request->channel
            );
        }


        // ==================================================
        // AMBIL DATA TRANSAKSI
        // ==================================================

        $transaksis = $query

            ->latest()

            ->get();


        // ==================================================
        // DROPDOWN LAYANAN
        // ==================================================
        //
        // Mengambil semua layanan yang memang ada
        // di tabel transaksi.
        //

        $layanans = Transaksi::query()

            ->whereNotNull(
                'layanan'
            )

            ->where(
                'layanan',
                '!=',
                ''
            )

            ->select(
                'layanan'
            )

            ->distinct()

            ->orderBy(
                'layanan'
            )

            ->pluck(
                'layanan'
            );


        // ==================================================
        // DROPDOWN CHANNEL
        // ==================================================
        //
        // Channel mengikuti layanan yang dipilih.
        //
        // Kalau belum memilih layanan:
        // → tampil semua channel
        //
        // Kalau memilih Tiket KAI:
        // → hanya channel Tiket KAI
        //
        // Kalau memilih Mitra KAI Group:
        // → hanya channel Mitra KAI Group
        //
        // dst.
        //

        $channelQuery = Transaksi::query()

            ->whereNotNull(
                'channel'
            )

            ->where(
                'channel',
                '!=',
                ''
            );


        if ($request->filled('layanan')) {

            $channelQuery->where(
                'layanan',
                $request->layanan
            );
        }


        $channels = $channelQuery

            ->select(
                'channel'
            )

            ->distinct()

            ->orderBy(
                'channel'
            )

            ->pluck(
                'channel'
            );


        // ==================================================
        // TAMPILKAN HALAMAN
        // ==================================================

        return view(
            'transaksi.index',
            compact(
                'transaksis',
                'layanans',
                'channels'
            )
        );
    }


    // ==================================================
    // CREATE
    // ==================================================

    public function create()
    {
        return view(
            'transaksi.create'
        );
    }


    // ==================================================
    // STORE
    // ==================================================

    public function store(Request $request)
    {
        $validated = $request->validate([

            'periode' =>
                'required|date',

            'layanan' =>
                'required|string|max:255',

            'tipe_layanan' =>
                'required|string|max:255',

            'channel' =>
                'required|string|max:255',

            'transaksi' =>
                'required|integer',

            'jumlah_pelanggan' =>
                'required|integer',

            'nilai_transaksi' =>
                'required|numeric',

            'fee_kai' =>
                'required|numeric',

        ]);


        Transaksi::create(
            $validated
        );


        return redirect()

            ->route(
                'transaksi.index'
            )

            ->with(
                'success',
                'Data transaksi berhasil ditambahkan.'
            );
    }


    // ==================================================
    // SHOW
    // ==================================================

    public function show(
        Transaksi $transaksi
    ) {

        return view(
            'transaksi.show',
            compact(
                'transaksi'
            )
        );
    }


    // ==================================================
    // EDIT
    // ==================================================

    public function edit(
        Transaksi $transaksi
    ) {

        return view(
            'transaksi.edit',
            compact(
                'transaksi'
            )
        );
    }


    // ==================================================
    // UPDATE
    // ==================================================

    public function update(
        Request $request,
        Transaksi $transaksi
    ) {

        $validated = $request->validate([

            'periode' =>
                'required|date',

            'layanan' =>
                'required|string|max:255',

            'tipe_layanan' =>
                'required|string|max:255',

            'channel' =>
                'required|string|max:255',

            'transaksi' =>
                'required|integer',

            'jumlah_pelanggan' =>
                'required|integer',

            'nilai_transaksi' =>
                'required|numeric',

            'fee_kai' =>
                'required|numeric',

        ]);


        $transaksi->update(
            $validated
        );


        return redirect()

            ->route(
                'transaksi.index'
            )

            ->with(
                'success',
                'Data transaksi berhasil diperbarui.'
            );
    }


    // ==================================================
    // DELETE
    // ==================================================

    public function destroy(
        Transaksi $transaksi
    ) {

        $transaksi->delete();


        return redirect()

            ->route(
                'transaksi.index'
            )

            ->with(
                'success',
                'Data transaksi berhasil dihapus.'
            );
    }
}