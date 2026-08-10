<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATASET INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY DATASET
        |--------------------------------------------------------------------------
        */

        $query = Transaksi::query();


        /*
        |--------------------------------------------------------------------------
        | FILTER LAYANAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('layanan')) {

            $query->where(
                'layanan',
                $request->layanan
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATASET
        |--------------------------------------------------------------------------
        */

        $datasets = $query

            ->select('nama_file')

            ->selectRaw(
                'COUNT(*) as jumlah'
            )

            ->whereNotNull(
                'nama_file'
            )

            ->groupBy(
                'nama_file'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | LIST LAYANAN
        |--------------------------------------------------------------------------
        |
        | Daftar layanan diambil dari data transaksi.
        |
        */

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


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'dataset.index',
            compact(
                'datasets',
                'layanans'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL DATASET / DATA TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function show(
        $nama_file,
        Request $request
    ) {

        /*
        |--------------------------------------------------------------------------
        | QUERY TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $query = Transaksi::where(
            'nama_file',
            $nama_file
        );


        /*
        |--------------------------------------------------------------------------
        | FILTER LAYANAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('layanan')) {

            $query->where(
                'layanan',
                $request->layanan
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER CHANNEL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('channel')) {

            $query->where(
                'channel',
                $request->channel
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATA TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $transaksis = $query

            ->latest()

            ->get();


        /*
        |--------------------------------------------------------------------------
        | LIST LAYANAN
        |--------------------------------------------------------------------------
        |
        | Hanya layanan yang tersedia pada file Excel
        | yang sedang dibuka.
        |
        */

        $layananQuery = Transaksi::where(
            'nama_file',
            $nama_file
        );


        $layanans = $layananQuery

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


        /*
        |--------------------------------------------------------------------------
        | LIST CHANNEL SESUAI LAYANAN
        |--------------------------------------------------------------------------
        |
        | Kalau layanan dipilih:
        |
        | Tiket KAI
        |      ↓
        | Channel Tiket KAI saja
        |
        | Mitra KAI Group
        |      ↓
        | Channel Mitra KAI Group saja
        |
        | Mitra Non KAI Group
        |      ↓
        | Channel Mitra Non KAI Group saja
        |
        */

        $channelQuery = Transaksi::where(
            'nama_file',
            $nama_file
        );


        /*
        |--------------------------------------------------------------------------
        | CHANNEL MENGIKUTI LAYANAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('layanan')) {

            $channelQuery->where(
                'layanan',
                $request->layanan
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LIST CHANNEL
        |--------------------------------------------------------------------------
        */

        $channels = $channelQuery

            ->whereNotNull(
                'channel'
            )

            ->where(
                'channel',
                '!=',
                ''
            )

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


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        |
        | Halaman yang digunakan:
        |
        | resources/views/transaksi/index.blade.php
        |
        */

        return view(
            'transaksi.index',
            compact(
                'transaksis',
                'layanans',
                'channels'
            )
        );
    }
}