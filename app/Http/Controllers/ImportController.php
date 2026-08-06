<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransaksiImport;
use App\Models\Transaksi;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'mode' => 'required'
        ]);


        // Ambil nama file Excel
        $filename = $request->file('file')->getClientOriginalName();


        // Jika pilih "Ganti Semua Data"
        if ($request->mode == 'replace') {

            Transaksi::truncate();

        }


        // Import Excel + kirim nama file
        Excel::import(
            new TransaksiImport($filename),
            $request->file('file')
        );


        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil diimport.');
    }
}