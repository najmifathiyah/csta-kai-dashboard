<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class DatasetController extends Controller
{

    public function index()
    {

        $datasets = Transaksi::select('nama_file')
            ->selectRaw('COUNT(*) as jumlah')
            ->whereNotNull('nama_file')
            ->groupBy('nama_file')
            ->get();


        return view('dataset.index', compact('datasets'));

    }


    public function show($nama_file)
    {

        $transaksis = Transaksi::where('nama_file', $nama_file)
            ->latest()
            ->get();


        return view('transaksi.index', compact('transaksis'));

    }

}