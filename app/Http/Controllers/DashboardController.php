<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Dataset;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATASET AKTIF
        |--------------------------------------------------------------------------
        |
        | Dashboard utama hanya membaca dataset yang berstatus aktif.
        |
        | Dataset yang lebih lama tetap tersimpan di database,
        | tetapi tidak dicampurkan ke dashboard utama.
        |
        |
        | TAMBAHAN:
        |
        | Kalau user sedang membuka dataset tertentu,
        | maka dataset tersebut digunakan sementara.
        |
        | is_active TIDAK DIUBAH.
        |
        */


        $datasetAktif = Dataset::query()
            ->where('is_active', true)
            ->latest('id')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | DATASET YANG SEDANG DIBUKA
        |--------------------------------------------------------------------------
        |
        | Kalau user sebelumnya klik "Lihat Data"
        | pada dataset tertentu, nama file disimpan di session.
        |
        | Maka dashboard akan mengikuti dataset tersebut.
        |
        | Kalau tidak ada session:
        | → Dashboard tetap menggunakan dataset aktif.
        |
        */


        $datasetFile =
            session('dataset_file');


        if ($datasetFile) {

            $datasetSession =
                Dataset::query()

                ->where(
                    'nama_file',
                    $datasetFile
                )

                ->first();


            /*
            |--------------------------------------------------------------------------
            | JIKA DATASET SESSION MASIH ADA
            |--------------------------------------------------------------------------
            |
            | Gunakan dataset tersebut.
            |
            | PENTING:
            | Tidak mengubah is_active.
            |
            */


            if ($datasetSession) {

                $datasetAktif =
                    $datasetSession;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | FALLBACK DATA LAMA
        |--------------------------------------------------------------------------
        |
        | Bagian ini penting karena database kamu sudah memiliki data transaksi
        | sebelum sistem "dataset aktif" dibuat.
        |
        | Kalau belum ada dataset aktif, kita cari nama_file transaksi terbaru
        | lalu menjadikannya dataset aktif.
        |
        | Dengan begitu dashboard tidak kosong setelah sistem baru dipasang.
        |
        */


        if (!$datasetAktif) {

            $namaFileTerbaru = Transaksi::query()

                ->whereNotNull('nama_file')

                ->where(
                    'nama_file',
                    '!=',
                    ''
                )

                ->latest('created_at')

                ->value('nama_file');


            /*
            |--------------------------------------------------------------------------
            | JIKA DATA LAMA MEMILIKI NAMA_FILE
            |--------------------------------------------------------------------------
            */

            if ($namaFileTerbaru) {

                $jumlahData = Transaksi::query()

                    ->where(
                        'nama_file',
                        $namaFileTerbaru
                    )

                    ->count();


                $layanan = Transaksi::query()

                    ->where(
                        'nama_file',
                        $namaFileTerbaru
                    )

                    ->whereNotNull('layanan')

                    ->where(
                        'layanan',
                        '!=',
                        ''
                    )

                    ->select('layanan')

                    ->distinct()

                    ->pluck('layanan');


                if ($layanan->count() === 1) {

                    $namaLayanan =
                        $layanan->first();

                } else {

                    $namaLayanan =
                        $layanan->implode(', ');

                }


                $datasetAktif = Dataset::create([

                    'nama_file' =>
                        $namaFileTerbaru,

                    'layanan' =>
                        $namaLayanan,

                    'jumlah_data' =>
                        $jumlahData,

                    'is_active' =>
                        true,

                ]);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | QUERY UTAMA
        |--------------------------------------------------------------------------
        |
        | Semua angka, grafik, tabel dan filter dashboard utama
        | menggunakan query yang sama.
        |
        | Perbedaannya sekarang:
        |
        | Dashboard hanya mengambil DATASET AKTIF
        | atau DATASET YANG SEDANG DIBUKA.
        |
        */


        $query = Transaksi::query();


        /*
        |--------------------------------------------------------------------------
        | FILTER DATASET AKTIF / DATASET YANG SEDANG DIBUKA
        |--------------------------------------------------------------------------
        */

        if ($datasetAktif) {

            $query->where(
                'nama_file',
                $datasetAktif->nama_file
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
        | GROWTH
        |--------------------------------------------------------------------------
        |
        | Growth dihitung berdasarkan bulan terakhir dan bulan sebelumnya
        | dari dataset aktif yang sedang digunakan.
        |
        */


        $bulanTerakhir = (clone $query)

            ->selectRaw("
                YEAR(periode) as tahun,
                MONTH(periode) as bulan
            ")

            ->whereNotNull('periode')

            ->groupBy(
                'tahun',
                'bulan'
            )

            ->orderByDesc('tahun')

            ->orderByDesc('bulan')

            ->first();


        $growth = 0;


        if ($bulanTerakhir) {

            $tahunSekarang =
                $bulanTerakhir->tahun;


            $bulanSekarang =
                $bulanTerakhir->bulan;


            $tanggalSekarang = sprintf(

                '%04d-%02d-01',

                $tahunSekarang,

                $bulanSekarang

            );


            $tanggalLalu = date(

                'Y-m-01',

                strtotime(
                    $tanggalSekarang .
                    ' -1 month'
                )

            );


            $transaksiSekarang =
                (clone $query)

                ->whereYear(
                    'periode',
                    date(
                        'Y',
                        strtotime(
                            $tanggalSekarang
                        )
                    )
                )

                ->whereMonth(
                    'periode',
                    date(
                        'm',
                        strtotime(
                            $tanggalSekarang
                        )
                    )
                )

                ->sum('transaksi');


            $transaksiLalu =
                (clone $query)

                ->whereYear(
                    'periode',
                    date(
                        'Y',
                        strtotime(
                            $tanggalLalu
                        )
                    )
                )

                ->whereMonth(
                    'periode',
                    date(
                        'm',
                        strtotime(
                            $tanggalLalu
                        )
                    )
                )

                ->sum('transaksi');


            if ($transaksiLalu > 0) {

                $growth =
                    (
                        (
                            $transaksiSekarang
                            -
                            $transaksiLalu
                        )
                        /
                        $transaksiLalu
                    )
                    *
                    100;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | DATA TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | Tabel transaksi dashboard juga hanya mengambil
        | data dari dataset yang sedang digunakan.
        |
        */


        $transaksiData =
            (clone $query)

            ->orderByDesc(
                'periode'
            )

            ->paginate(10)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN TAHUN
        |--------------------------------------------------------------------------
        |
        | Tahun hanya berasal dari dataset yang sedang digunakan.
        |
        */


        $tahuns = (clone $query)

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
        | DROPDOWN LAYANAN
        |--------------------------------------------------------------------------
        |
        | Hanya layanan yang terdapat pada dataset yang sedang digunakan.
        |
        */


        $layanans = (clone $query)

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
        | DROPDOWN TIPE LAYANAN
        |--------------------------------------------------------------------------
        |
        | Jika layanan dipilih:
        | → hanya tipe layanan dari layanan tersebut.
        |
        | Jika layanan tidak dipilih:
        | → semua tipe layanan dari dataset yang sedang digunakan.
        |
        */


        $tipeQuery = (clone $query)

            ->whereNotNull(
                'tipe_layanan'
            )

            ->where(
                'tipe_layanan',
                '!=',
                ''
            );


        if ($request->filled('layanan')) {

            $tipeQuery->where(
                'layanan',
                $request->layanan
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
        | Channel mengikuti:
        |
        | Dataset yang sedang digunakan
        |       ↓
        | Layanan
        |       ↓
        | Tipe Layanan
        |
        */


        $channelQuery = (clone $query)

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
                ) as urut,

                DATE_FORMAT(
                    periode,
                    '%b %Y'
                ) as bulan,

                SUM(transaksi) as total
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


        $channelData = (clone $query)

            ->whereNotNull(
                'channel'
            )

            ->selectRaw("
                channel,
                SUM(transaksi) as total
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
        | TOP CHANNEL
        |--------------------------------------------------------------------------
        */


        $topChannel =
            $channelData->take(8);


        $others =
            $channelData

            ->skip(8)

            ->sum(
                'total'
            );


        if ($others > 0) {

            $topChannel->push(

                (object) [

                    'channel' =>
                        'Lainnya',

                    'total' =>
                        $others,

                ]

            );

        }


        $channelChart =
            $topChannel;


        /*
        |--------------------------------------------------------------------------
        | LAYANAN CHART
        |--------------------------------------------------------------------------
        */


        $layananChart = (clone $query)

            ->whereNotNull(
                'layanan'
            )

            ->selectRaw("
                layanan,
                SUM(transaksi) as total
            ")

            ->groupBy(
                'layanan'
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
                SUM(transaksi) as total
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
        | INSIGHT OTOMATIS
        |--------------------------------------------------------------------------
        |
        | TAMBAHAN SAJA
        |
        | Bagian ini membaca hasil query dashboard yang sama.
        | Jadi insight otomatis tetap mengikuti:
        |
        | Dataset
        | Tahun
        | Bulan
        | Layanan
        | Tipe Layanan
        | Channel
        |
        | Tidak ada data dari dataset lain yang ikut terbaca.
        |
        */


        $insights = [];


        /*
        |--------------------------------------------------------------------------
        | INSIGHT TOTAL TRANSAKSI
        |--------------------------------------------------------------------------
        */

        if ($totalTransaksi > 0) {

            $insights[] =
                'Total transaksi pada data yang sedang ditampilkan mencapai '
                . number_format($totalTransaksi, 0, ',', '.')
                . ' transaksi.';

        } else {

            $insights[] =
                'Belum terdapat transaksi pada filter yang dipilih.';

        }


        /*
        |--------------------------------------------------------------------------
        | INSIGHT CHANNEL TERTINGGI
        |--------------------------------------------------------------------------
        */

        $insightTopChannel =
            $channelData->first();


        if (
            $insightTopChannel
            &&
            $totalTransaksi > 0
        ) {

            $persentaseChannel =
                (
                    $insightTopChannel->total
                    /
                    $totalTransaksi
                )
                *
                100;


            $insights[] =
                'Channel dengan transaksi tertinggi adalah "'
                . $insightTopChannel->channel
                . '" dengan '
                . number_format(
                    $insightTopChannel->total,
                    0,
                    ',',
                    '.'
                )
                . ' transaksi atau sekitar '
                . number_format(
                    $persentaseChannel,
                    1,
                    ',',
                    '.'
                )
                . '% dari total transaksi.';

        }


        /*
        |--------------------------------------------------------------------------
        | INSIGHT LAYANAN TERTINGGI
        |--------------------------------------------------------------------------
        */

        $insightTopLayanan =
            $layananChart->first();


        if ($insightTopLayanan) {

            $insights[] =
                'Layanan dengan jumlah transaksi tertinggi adalah "'
                . $insightTopLayanan->layanan
                . '" dengan '
                . number_format(
                    $insightTopLayanan->total,
                    0,
                    ',',
                    '.'
                )
                . ' transaksi.';

        }


        /*
        |--------------------------------------------------------------------------
        | INSIGHT PERTUMBUHAN
        |--------------------------------------------------------------------------
        */

        if ($growth > 0) {

            $insights[] =
                'Transaksi menunjukkan pertumbuhan sebesar '
                . number_format(
                    $growth,
                    1,
                    ',',
                    '.'
                )
                . '% dibandingkan bulan sebelumnya.';

        } elseif ($growth < 0) {

            $insights[] =
                'Transaksi mengalami penurunan sebesar '
                . number_format(
                    abs($growth),
                    1,
                    ',',
                    '.'
                )
                . '% dibandingkan bulan sebelumnya.';

        } else {

            if ($bulanTerakhir) {

                $insights[] =
                    'Belum terdapat perubahan transaksi dibandingkan bulan sebelumnya, atau data bulan sebelumnya tidak tersedia.';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | INSIGHT NILAI TRANSAKSI
        |--------------------------------------------------------------------------
        */

        if ($totalNilai > 0) {

            $insights[] =
                'Total nilai transaksi pada data yang sedang ditampilkan mencapai Rp '
                . number_format(
                    $totalNilai,
                    0,
                    ',',
                    '.'
                )
                . '.';

        }


        /*
        |--------------------------------------------------------------------------
        | INSIGHT DATASET
        |--------------------------------------------------------------------------
        */

        if ($datasetAktif) {

            $insights[] =
                'Insight ini dihitung khusus dari dataset "'
                . $datasetAktif->nama_file
                . '" sehingga tidak tercampur dengan dataset lainnya.';

        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */


        return view(

            'dashboard.index',

            [

                /*
                |--------------------------------------------------------------------------
                | JUDUL
                |--------------------------------------------------------------------------
                */

                'judul' =>
                    'Dashboard Monitoring Transaksi Unit CSTA KAI',


                /*
                |--------------------------------------------------------------------------
                | DATASET YANG SEDANG DIGUNAKAN
                |--------------------------------------------------------------------------
                |
                | Kalau tidak sedang membuka file:
                | → dataset aktif.
                |
                | Kalau sedang membuka file:
                | → dataset dari session.
                |
                */

                'datasetAktif' =>
                    $datasetAktif,


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

                'growth' =>
                    $growth,


                /*
                |--------------------------------------------------------------------------
                | DATA TABEL
                |--------------------------------------------------------------------------
                */

                'transaksiData' =>
                    $transaksiData,


                /*
                |--------------------------------------------------------------------------
                | CHART
                |--------------------------------------------------------------------------
                */

                'trendChart' =>
                    $trendChart,

                'channelChart' =>
                    $channelChart,

                'layananChart' =>
                    $layananChart,

                'tipeChart' =>
                    $tipeChart,


                /*
                |--------------------------------------------------------------------------
                | DROPDOWN
                |--------------------------------------------------------------------------
                */

                'tahuns' =>
                    $tahuns,

                'layanans' =>
                    $layanans,

                'tipes' =>
                    $tipes,

                'channels' =>
                    $channels,


                /*
                |--------------------------------------------------------------------------
                | INSIGHT OTOMATIS
                |--------------------------------------------------------------------------
                |
                | TAMBAHAN SAJA
                |
                */

                'insights' =>
                    $insights,

            ]

        );
    }
}