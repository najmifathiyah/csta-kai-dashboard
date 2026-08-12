<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DatasetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX DATASET
    |--------------------------------------------------------------------------
    |
    | Halaman ini menampilkan DAFTAR DATASET.
    |
    | Bukan langsung menampilkan seluruh transaksi.
    |
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY DATASET
        |--------------------------------------------------------------------------
        */

        $query = Dataset::query();


        /*
        |--------------------------------------------------------------------------
        | FILTER LAYANAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('layanan')) {

            $query->where(
                'layanan',
                'like',
                '%' . $request->layanan . '%'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATASET
        |--------------------------------------------------------------------------
        |
        | Dataset aktif selalu ditaruh paling atas.
        |
        */

        $datasets = $query

            ->orderByDesc('is_active')

            ->orderByDesc('created_at')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN LAYANAN
        |--------------------------------------------------------------------------
        */

        $layanans = Transaksi::query()

            ->whereNotNull('layanan')

            ->where(
                'layanan',
                '!=',
                ''
            )

            ->select('layanan')

            ->distinct()

            ->orderBy('layanan')

            ->pluck('layanan');


        /*
        |--------------------------------------------------------------------------
        | DATASET YANG SEDANG DIBUKA
        |--------------------------------------------------------------------------
        */

        $datasetSekarang = null;


        if (Session::has('dataset_file')) {

            $datasetSekarang = Dataset::query()

                ->where(
                    'nama_file',
                    Session::get('dataset_file')
                )

                ->first();

        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dataset.index',
            compact(
                'datasets',
                'layanans',
                'datasetSekarang'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW DATASET
    |--------------------------------------------------------------------------
    |
    | Ketika user klik "Lihat Data",
    | hanya transaksi dari file tersebut yang ditampilkan.
    |
    | PENTING:
    |
    | Klik Lihat Data TIDAK mengubah is_active.
    |
    | Kita hanya menyimpan nama file ke SESSION.
    |
    */

    public function show(
        $nama_file,
        Request $request
    ) {

        /*
        |--------------------------------------------------------------------------
        | CARI DATASET
        |--------------------------------------------------------------------------
        */

        $dataset = Dataset::where(
            'nama_file',
            $nama_file
        )->first();


        /*
        |--------------------------------------------------------------------------
        | JIKA DATASET TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!$dataset) {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATASET YANG SEDANG DIBUKA
        |--------------------------------------------------------------------------
        |
        | Ini hanya konteks halaman.
        |
        | Tidak mengubah:
        |
        | is_active
        |
        */

        Session::put(
            'dataset_file',
            $nama_file
        );


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
        | AMBIL TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $transaksis = $query

            ->orderByDesc('periode')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN LAYANAN
        |--------------------------------------------------------------------------
        */

        $layanans = Transaksi::where(
            'nama_file',
            $nama_file
        )

            ->whereNotNull('layanan')

            ->where(
                'layanan',
                '!=',
                ''
            )

            ->select('layanan')

            ->distinct()

            ->orderBy('layanan')

            ->pluck('layanan');


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN TIPE LAYANAN
        |--------------------------------------------------------------------------
        */

        $tipeQuery = Transaksi::where(
            'nama_file',
            $nama_file
        )

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

            ->orderBy('tipe_layanan')

            ->pluck('tipe_layanan');


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN CHANNEL
        |--------------------------------------------------------------------------
        */

        $channelQuery = Transaksi::where(
            'nama_file',
            $nama_file
        )

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

            ->orderBy('channel')

            ->pluck('channel');


        /*
        |--------------------------------------------------------------------------
        | VIEW DETAIL TRANSAKSI
        |--------------------------------------------------------------------------
        */

        return view(
            'transaksi.index',
            compact(
                'dataset',
                'transaksis',
                'layanans',
                'tipes',
                'channels'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KELUAR DARI DATASET
    |--------------------------------------------------------------------------
    |
    | Menghapus konteks dataset dari SESSION.
    |
    | Setelah keluar:
    |
    | Dashboard kembali menggunakan dataset
    | yang is_active = 1.
    |
    */

    public function keluar()
    {
        Session::forget(
            'dataset_file'
        );


        return redirect()

            ->route(
                'dashboard'
            )

            ->with(
                'success',
                'Berhasil keluar dari dataset.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE DATASET
    |--------------------------------------------------------------------------
    |
    | Menghapus dataset sekaligus seluruh transaksi
    | yang berasal dari file tersebut.
    |
    */

    public function destroy(
        $nama_file
    ) {

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | JIKA DATASET YANG DIHAPUS SEDANG DIBUKA
            |--------------------------------------------------------------------------
            */

            if (
                Session::get('dataset_file')
                ===
                $nama_file
            ) {

                Session::forget(
                    'dataset_file'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS TRANSAKSI DATASET
            |--------------------------------------------------------------------------
            */

            Transaksi::where(
                'nama_file',
                $nama_file
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | HAPUS DATASET
            |--------------------------------------------------------------------------
            */

            Dataset::where(
                'nama_file',
                $nama_file
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return redirect()

                ->route(
                    'dataset.index'
                )

                ->with(
                    'success',
                    'Dataset berhasil dihapus.'
                );


        } catch (\Exception $e) {

            DB::rollBack();


            return back()

                ->with(
                    'error',
                    'Dataset gagal dihapus: ' .
                    $e->getMessage()
                );

        }
    }
}