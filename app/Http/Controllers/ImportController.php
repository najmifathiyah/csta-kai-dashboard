<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransaksiImport;
use App\Models\Transaksi;
use App\Models\Dataset;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }


    public function store(Request $request)
    {
        // ==================================================
        // VALIDASI
        // ==================================================

        $request->validate([

            'file' =>
                'required|mimes:xlsx,xls',

            'mode' =>
                'required',

        ]);


        // ==================================================
        // NAMA FILE
        // ==================================================

        $filename =
            $request
                ->file('file')
                ->getClientOriginalName();


        // ==================================================
        // PROSES IMPORT
        // ==================================================

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | MODE REPLACE
            |--------------------------------------------------------------------------
            |
            | Kalau file dengan nama yang sama sudah pernah dimasukkan,
            | data lama dari file tersebut kita hapus terlebih dahulu.
            |
            | BERBEDA dengan sebelumnya:
            |
            | Transaksi::truncate()
            |
            | tidak digunakan lagi karena kita ingin menyimpan histori
            | dataset lainnya.
            |
            */

            if ($request->mode == 'replace') {

                Transaksi::where(
                    'nama_file',
                    $filename
                )->delete();


                Dataset::where(
                    'nama_file',
                    $filename
                )->delete();

            }


            // ==================================================
            // SEMUA DATASET LAMA MENJADI ARSIP
            // ==================================================

            Dataset::query()->update([
                'is_active' => false
            ]);


            // ==================================================
            // IMPORT EXCEL
            // ==================================================

            Excel::import(

                new TransaksiImport(
                    $filename
                ),

                $request->file('file')

            );


            // ==================================================
            // HITUNG DATA YANG BARU DIIMPORT
            // ==================================================

            $jumlahData = Transaksi::where(
                'nama_file',
                $filename
            )->count();


            // ==================================================
            // AMBIL LAYANAN DATASET
            // ==================================================

            $layanan = Transaksi::where(
                'nama_file',
                $filename
            )

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

            ->pluck(
                'layanan'
            );


            /*
            |--------------------------------------------------------------------------
            | LAYANAN DATASET
            |--------------------------------------------------------------------------
            |
            | Kalau dataset hanya memiliki satu layanan,
            | kita simpan layanan tersebut.
            |
            | Kalau memiliki beberapa layanan,
            | kita simpan sebagai gabungan.
            |
            */

            if ($layanan->count() === 1) {

                $namaLayanan =
                    $layanan->first();

            } else {

                $namaLayanan =
                    $layanan->implode(', ');

            }


            // ==================================================
            // SIMPAN DATASET
            // ==================================================

            Dataset::create([

                'nama_file' =>
                    $filename,

                'layanan' =>
                    $namaLayanan,

                'jumlah_data' =>
                    $jumlahData,

                'is_active' =>
                    true,

            ]);


            // ==================================================
            // SELESAI
            // ==================================================

            DB::commit();


            return redirect()

                ->route(
                    'transaksi.index'
                )

                ->with(
                    'success',
                    'Dataset berhasil diimport dan sekarang menjadi dataset aktif.'
                );


        } catch (\Exception $e) {

            // ==================================================
            // JIKA ERROR
            // ==================================================

            DB::rollBack();


            return back()

                ->withInput()

                ->withErrors([

                    'file' =>
                        'Import gagal: ' .
                        $e->getMessage(),

                ]);
        }
    }
}