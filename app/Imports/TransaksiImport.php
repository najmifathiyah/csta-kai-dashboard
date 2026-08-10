<?php

namespace App\Imports;

use App\Models\Transaksi;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransaksiImport implements ToModel, WithHeadingRow
{
    protected $filename;


    public function __construct($filename)
    {
        $this->filename = $filename;
    }


    public function model(array $row)
    {
        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        |
        | Excel bisa membaca tanggal dalam beberapa bentuk:
        |
        | 1. Angka serial Excel
        | 2. DateTime
        | 3. String tanggal
        |
        | Karena itu kita tangani semuanya.
        |
        */

        $periode = null;


        if (!empty($row['periode'])) {

            $nilaiPeriode = $row['periode'];


            // ==================================================
            // JIKA SUDAH BERUPA OBJECT TANGGAL
            // ==================================================

            if ($nilaiPeriode instanceof \DateTimeInterface) {

                $periode = Carbon::instance(
                    $nilaiPeriode
                )->format('Y-m-d');

            }


            // ==================================================
            // JIKA BERUPA ANGKA SERIAL EXCEL
            // ==================================================

            elseif (
                is_numeric($nilaiPeriode)
                &&
                $nilaiPeriode > 0
            ) {

                $periode = Date::excelToDateTimeObject(
                    $nilaiPeriode
                )->format('Y-m-d');

            }


            // ==================================================
            // JIKA BERUPA STRING TANGGAL
            // ==================================================

            else {

                try {

                    $periode = Carbon::parse(
                        $nilaiPeriode
                    )->format('Y-m-d');

                } catch (\Exception $e) {

                    $periode = null;

                }

            }

        }


        // ==================================================
        // BUAT DATA TRANSAKSI
        // ==================================================

        return new Transaksi([

            'periode' => $periode,

            'layanan' => $row['layanan'] ?? null,

            'tipe_layanan' => $row['tipe_layanan'] ?? null,

            'channel' => $row['channel'] ?? null,

            'transaksi' => $row['transaksi'] ?? 0,

            'jumlah_pelanggan' =>
                $row['jumlah_pelanggan'] ?? 0,

            'nilai_transaksi' =>
                $row['nilai_transaksi'] ?? 0,

            'fee_kai' =>
                $row['fee_kai'] ?? 0,

            'nama_file' =>
                $this->filename,

        ]);
    }
}