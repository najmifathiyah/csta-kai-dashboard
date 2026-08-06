<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'periode',
        'layanan',
        'tipe_layanan',
        'channel',
        'transaksi',
        'jumlah_pelanggan',
        'nilai_transaksi',
        'fee_kai',
        'nama_file',
    ];
}