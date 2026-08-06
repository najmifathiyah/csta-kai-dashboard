<?php

namespace App\Imports;

use App\Models\Transaksi;
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
        return new Transaksi([

            'periode' => Date::excelToDateTimeObject($row['periode'])
                ->format('Y-m-d'),

            'layanan' => $row['layanan'],

            'tipe_layanan' => $row['tipe_layanan'],

            'channel' => $row['channel'],

            'transaksi' => $row['transaksi'],

            'jumlah_pelanggan' => $row['jumlah_pelanggan'] ?? 0,

            'nilai_transaksi' => $row['nilai_transaksi'],

            'fee_kai' => $row['fee_kai'] ?? 0,

            'nama_file' => $this->filename,

        ]);
    }
}