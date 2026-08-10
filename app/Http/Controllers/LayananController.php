<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request, $layanan)
    {
        /*
        |--------------------------------------------------------------------------
        | JUDUL HALAMAN
        |--------------------------------------------------------------------------
        */

        $judul = 'Dashboard ' . $layanan;


        /*
        |--------------------------------------------------------------------------
        | QUERY UTAMA
        |--------------------------------------------------------------------------
        |
        | Setiap halaman layanan hanya mengambil data
        | sesuai layanan yang dipilih dari sidebar.
        |
        | Contoh:
        |
        | /layanan/Tiket KAI
        |       ↓
        | layanan = Tiket KAI
        |
        */

        $query = Transaksi::query()
            ->where('layanan', $layanan);


        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tahun')) {

            $query->whereYear(
                'periode',
                $request->tahun
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER BULAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bulan')) {

            $query->whereMonth(
                'periode',
                $request->bulan
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TIPE LAYANAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tipe_layanan')) {

            $query->where(
                'tipe_layanan',
                $request->tipe_layanan
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
        | KPI
        |--------------------------------------------------------------------------
        */

        $totalTransaksi = (clone $query)
            ->sum('transaksi');


        $totalPelanggan = (clone $query)
            ->sum('jumlah_pelanggan');


        $totalNilai = (clone $query)
            ->sum('nilai_transaksi');


        $totalFee = (clone $query)
            ->sum('fee_kai');


        /*
        |--------------------------------------------------------------------------
        | DATA TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | Menggunakan pagination supaya seluruh data tetap bisa
        | dilihat, bukan hanya 10 data terbaru.
        |
        */

        $transaksiData = (clone $query)

            ->orderByDesc('periode')

            ->paginate(10)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN TAHUN
        |--------------------------------------------------------------------------
        |
        | Hanya tahun yang memang tersedia pada layanan tersebut.
        |
        */

        $tahuns = Transaksi::query()

            ->where(
                'layanan',
                $layanan
            )

            ->whereNotNull(
                'periode'
            )

            ->selectRaw(
                'YEAR(periode) as tahun'
            )

            ->distinct()

            ->orderBy('tahun')

            ->pluck('tahun');


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN TIPE LAYANAN
        |--------------------------------------------------------------------------
        |
        | Hanya tipe layanan yang berada di dalam layanan
        | yang sedang dibuka.
        |
        */

        $tipeQuery = Transaksi::query()

            ->where(
                'layanan',
                $layanan
            )

            ->whereNotNull(
                'tipe_layanan'
            )

            ->where(
                'tipe_layanan',
                '!=',
                ''
            );


        /*
        |--------------------------------------------------------------------------
        | JIKA TAHUN DIPILIH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tahun')) {

            $tipeQuery->whereYear(
                'periode',
                $request->tahun
            );
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA BULAN DIPILIH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bulan')) {

            $tipeQuery->whereMonth(
                'periode',
                $request->bulan
            );
        }


        $tipes = $tipeQuery

            ->select(
                'tipe_layanan'
            )

            ->distinct()

            ->orderBy(
                'tipe_layanan'
            )

            ->pluck(
                'tipe_layanan'
            );


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN CHANNEL
        |--------------------------------------------------------------------------
        |
        | Channel mengikuti layanan dan tipe layanan yang dipilih.
        |
        */

        $channelQuery = Transaksi::query()

            ->where(
                'layanan',
                $layanan
            )

            ->whereNotNull(
                'channel'
            )

            ->where(
                'channel',
                '!=',
                ''
            );


        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN UNTUK CHANNEL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tahun')) {

            $channelQuery->whereYear(
                'periode',
                $request->tahun
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER BULAN UNTUK CHANNEL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bulan')) {

            $channelQuery->whereMonth(
                'periode',
                $request->bulan
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TIPE UNTUK CHANNEL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tipe_layanan')) {

            $channelQuery->where(
                'tipe_layanan',
                $request->tipe_layanan
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


        /*
        |--------------------------------------------------------------------------
        | TREND TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $trendChart = (clone $query)

            ->whereNotNull(
                'periode'
            )

            ->selectRaw("
                DATE_FORMAT(
                    periode,
                    '%Y-%m'
                ) AS urut,

                DATE_FORMAT(
                    periode,
                    '%b %Y'
                ) AS bulan,

                SUM(transaksi) AS total
            ")

            ->groupBy(
                'urut',
                'bulan'
            )

            ->orderBy(
                'urut'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | CHANNEL CHART
        |--------------------------------------------------------------------------
        */

        $channelChart = (clone $query)

            ->whereNotNull(
                'channel'
            )

            ->selectRaw("
                channel,
                SUM(transaksi) AS total
            ")

            ->groupBy(
                'channel'
            )

            ->orderByDesc(
                'total'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | TIPE LAYANAN CHART
        |--------------------------------------------------------------------------
        */

        $tipeChart = (clone $query)

            ->whereNotNull(
                'tipe_layanan'
            )

            ->selectRaw("
                tipe_layanan,
                SUM(transaksi) AS total
            ")

            ->groupBy(
                'tipe_layanan'
            )

            ->orderByDesc(
                'total'
            )

            ->limit(10)

            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        |
        | File Blade yang kamu upload:
        |
        | resources/views/dashboard/layanan.blade.php
        |
        */

        return view(
            'dashboard.layanan',
            [

                /*
                |--------------------------------------------------------------------------
                | JUDUL
                |--------------------------------------------------------------------------
                */

                'judul' =>
                    $judul,


                /*
                |--------------------------------------------------------------------------
                | LAYANAN AKTIF
                |--------------------------------------------------------------------------
                */

                'layananTetap' =>
                    $layanan,


                /*
                |--------------------------------------------------------------------------
                | KPI
                |--------------------------------------------------------------------------
                */

                'totalTransaksi' =>
                    $totalTransaksi,

                'totalPelanggan' =>
                    $totalPelanggan,

                'totalNilai' =>
                    $totalNilai,

                'totalFee' =>
                    $totalFee,


                /*
                |--------------------------------------------------------------------------
                | CHART
                |--------------------------------------------------------------------------
                */

                'trendChart' =>
                    $trendChart,

                'channelChart' =>
                    $channelChart,

                'tipeChart' =>
                    $tipeChart,


                /*
                |--------------------------------------------------------------------------
                | FILTER
                |--------------------------------------------------------------------------
                */

                'tahuns' =>
                    $tahuns,

                'tipes' =>
                    $tipes,

                'channels' =>
                    $channels,


                /*
                |--------------------------------------------------------------------------
                | TABLE
                |--------------------------------------------------------------------------
                */

                'transaksiData' =>
                    $transaksiData,

            ]
        );
    }
}