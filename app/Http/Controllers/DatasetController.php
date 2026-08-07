<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;


class DatasetController extends Controller
{


    public function index(Request $request)
    {


        $query = Transaksi::query();



        // ================= FILTER LAYANAN =================

        if ($request->filled('layanan')) {

            $query->where('layanan', $request->layanan);

        }




        $datasets = $query
            ->select('nama_file')
            ->selectRaw('COUNT(*) as jumlah')
            ->whereNotNull('nama_file')
            ->groupBy('nama_file')
            ->get();




        return view('dataset.index', compact('datasets'));



    }





    public function show($nama_file, Request $request)
    {


        $query = Transaksi::where('nama_file', $nama_file);




        // ================= FILTER LAYANAN =================

        if ($request->filled('layanan')) {

            $query->where('layanan', $request->layanan);

        }




        // ================= FILTER CHANNEL =================

        if ($request->filled('channel')) {

            $query->where('channel', $request->channel);

        }





        $transaksis = $query
            ->latest()
            ->get();






        // ================= CHANNEL SESUAI LAYANAN =================


        $channelQuery = Transaksi::where('nama_file', $nama_file);




        if ($request->filled('layanan')) {

            $channelQuery->where('layanan', $request->layanan);

        }




        $channels = $channelQuery
            ->select('channel')
            ->distinct()
            ->orderBy('channel')
            ->pluck('channel');






        return view('transaksi.index', compact(

            'transaksis',

            'channels'

        ));



    }




}