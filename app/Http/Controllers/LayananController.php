<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Dataset;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(
        Request $request,
        $layanan
    ) {

        /*
        |--------------------------------------------------------------------------
        | DATASET YANG DIGUNAKAN
        |--------------------------------------------------------------------------
        |
        | KONDISI 1:
        |
        | User sedang membuka dataset tertentu
        | melalui tombol "Lihat Data".
        |
        | Maka gunakan:
        |
        | session('dataset_file')
        |
        |
        | KONDISI 2:
        |
        | User tidak sedang membuka dataset tertentu.
        |
        | Maka gunakan:
        |
        | dataset yang is_active = 1
        |
        |
        | PENTING:
        |
        | Membuka File A TIDAK mengubah is_active.
        |
        */


        $datasetFile =
            session('dataset_file');


        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK SEDANG MEMBUKA DATASET
        |--------------------------------------------------------------------------
        |
        | Gunakan dataset aktif.
        |
        */


        if (!$datasetFile) {

            $datasetAktif =
                Dataset::query()

                    ->where(
                        'is_active',
                        true
                    )

                    ->latest('id')

                    ->first();


            if ($datasetAktif) {

                $datasetFile =
                    $datasetAktif->nama_file;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | DATASET SEKARANG
        |--------------------------------------------------------------------------
        |
        | Digunakan untuk menampilkan informasi:
        |
        | 📂 Sedang membuka:
        | nama_file
        |
        */


        $datasetSekarang = null;


        if ($datasetFile) {

            $datasetSekarang =
                Dataset::query()

                    ->where(
                        'nama_file',
                        $datasetFile
                    )

                    ->first();

        }


        /*
        |--------------------------------------------------------------------------
        | JUDUL HALAMAN
        |--------------------------------------------------------------------------
        */


        $judul =
            'Dashboard ' .
            $layanan;


        /*
        |--------------------------------------------------------------------------
        | QUERY UTAMA
        |--------------------------------------------------------------------------
        |
        | FILTER PERTAMA:
        |
        | layanan
        |
        | FILTER KEDUA:
        |
        | nama_file
        |
        |
        | Jadi data tidak akan tercampur.
        |
        */


        $query =
            Transaksi::query()

                ->where(
                    'layanan',
                    $layanan
                );


        /*
        |--------------------------------------------------------------------------
        | FILTER DATASET
        |--------------------------------------------------------------------------
        */


        if ($datasetFile) {

            $query->where(
                'nama_file',
                $datasetFile
            );

        }


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


        $totalTransaksi =
            (clone $query)

                ->sum(
                    'transaksi'
                );


        $totalPelanggan =
            (clone $query)

                ->sum(
                    'jumlah_pelanggan'
                );


        $totalNilai =
            (clone $query)

                ->sum(
                    'nilai_transaksi'
                );


        $totalFee =
            (clone $query)

                ->sum(
                    'fee_kai'
                );


        /*
        |--------------------------------------------------------------------------
        | DATA TRANSAKSI
        |--------------------------------------------------------------------------
        */


        $transaksiData =
            (clone $query)

                ->orderByDesc(
                    'periode'
                )

                ->paginate(
                    10
                )

                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN TAHUN
        |--------------------------------------------------------------------------
        |
        | Hanya tahun dari:
        |
        | dataset yang sedang digunakan
        | +
        | layanan yang sedang dipilih
        |
        */


        $tahunQuery =
            Transaksi::query()

                ->where(
                    'layanan',
                    $layanan
                );


        if ($datasetFile) {

            $tahunQuery->where(
                'nama_file',
                $datasetFile
            );

        }


        $tahuns =
            $tahunQuery

                ->whereNotNull(
                    'periode'
                )

                ->selectRaw(
                    'YEAR(periode) as tahun'
                )

                ->distinct()

                ->orderBy(
                    'tahun'
                )

                ->pluck(
                    'tahun'
                );


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN TIPE LAYANAN
        |--------------------------------------------------------------------------
        */


        $tipeQuery =
            Transaksi::query()

                ->where(
                    'layanan',
                    $layanan
                );


        if ($datasetFile) {

            $tipeQuery->where(
                'nama_file',
                $datasetFile
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN UNTUK TIPE
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
        | FILTER BULAN UNTUK TIPE
        |--------------------------------------------------------------------------
        */


        if ($request->filled('bulan')) {

            $tipeQuery->whereMonth(
                'periode',
                $request->bulan
            );

        }


        $tipes =
            $tipeQuery

                ->whereNotNull(
                    'tipe_layanan'
                )

                ->where(
                    'tipe_layanan',
                    '!=',
                    ''
                )

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
        */


        $channelQuery =
            Transaksi::query()

                ->where(
                    'layanan',
                    $layanan
                );


        /*
        |--------------------------------------------------------------------------
        | FILTER DATASET UNTUK CHANNEL
        |--------------------------------------------------------------------------
        */


        if ($datasetFile) {

            $channelQuery->where(
                'nama_file',
                $datasetFile
            );

        }


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
        | FILTER TIPE LAYANAN UNTUK CHANNEL
        |--------------------------------------------------------------------------
        */


        if ($request->filled('tipe_layanan')) {

            $channelQuery->where(
                'tipe_layanan',
                $request->tipe_layanan
            );

        }


        $channels =
            $channelQuery

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
        | TREND TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | Grafik hanya dari:
        |
        | dataset yang sedang digunakan
        | +
        | layanan yang dipilih
        |
        */


        $trendChart =
            (clone $query)

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


        $channelChart =
            (clone $query)

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


        $tipeChart =
            (clone $query)

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

                ->limit(
                    10
                )

                ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
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
                | LAYANAN
                |--------------------------------------------------------------------------
                */

                'layananTetap' =>
                    $layanan,


                /*
                |--------------------------------------------------------------------------
                | DATASET
                |--------------------------------------------------------------------------
                |
                | Dataset yang sedang digunakan.
                |
                */

                'datasetSekarang' =>
                    $datasetSekarang,


                'datasetAktif' =>
                    $datasetSekarang,


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
                | DATA TRANSAKSI
                |--------------------------------------------------------------------------
                */

                'transaksiData' =>
                    $transaksiData,


                /*
                |--------------------------------------------------------------------------
                | DROPDOWN
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
                | CHART
                |--------------------------------------------------------------------------
                */

                'trendChart' =>
                    $trendChart,


                'channelChart' =>
                    $channelChart,


                'tipeChart' =>
                    $tipeChart,

            ]

        );
    }
}