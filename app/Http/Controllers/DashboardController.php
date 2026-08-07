<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();

        // ================= FILTER =================

        if ($request->filled('tahun')) {
            $query->whereYear('periode', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('periode', $request->bulan);
        }

        if ($request->filled('layanan')) {
            $query->where('layanan', $request->layanan);
        }

        if ($request->filled('tipe_layanan')) {
            $query->where('tipe_layanan', $request->tipe_layanan);
        }

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        // ================= KPI =================

        $totalTransaksi = (clone $query)->sum('transaksi');
        $totalPelanggan = (clone $query)->sum('jumlah_pelanggan');
        $totalNilai = (clone $query)->sum('nilai_transaksi');
        $totalFee = (clone $query)->sum('fee_kai');

        // ================= DATA TERBARU =================

        $recentTransaksi = (clone $query)
            ->orderByDesc('periode')
            ->take(10)
            ->get();

        // ================= FILTER DROPDOWN =================

        $tahuns = Transaksi::selectRaw('YEAR(periode) as tahun')
            ->distinct()
            ->orderBy('tahun')
            ->pluck('tahun');

        $layanans = Transaksi::select('layanan')
            ->distinct()
            ->orderBy('layanan')
            ->pluck('layanan');

        $tipes = Transaksi::select('tipe_layanan')
            ->distinct()
            ->orderBy('tipe_layanan')
            ->pluck('tipe_layanan');
// ================= CHANNEL SESUAI LAYANAN =================

$channelQuery = Transaksi::query();

if ($request->filled('layanan')) {

    $channelQuery->where('layanan', $request->layanan);

}


$channels = $channelQuery
    ->select('channel')
    ->distinct()
    ->orderBy('channel')
    ->pluck('channel');
        // ================= TREND =================

        $trendChart = (clone $query)
            ->selectRaw("
                DATE_FORMAT(periode,'%Y-%m') as urut,
                DATE_FORMAT(periode,'%b %Y') as bulan,
                SUM(transaksi) as total
            ")
            ->groupBy('urut', 'bulan')
            ->orderBy('urut')
            ->get();

        // ================= CHANNEL =================

        $channelData = (clone $query)
            ->selectRaw("
                channel,
                SUM(transaksi) as total
            ")
            ->groupBy('channel')
            ->orderByDesc('total')
            ->get();

        $topChannel = $channelData->take(8);

        $others = $channelData->skip(8)->sum('total');

        if ($others > 0) {
            $topChannel->push((object)[
                'channel' => 'Lainnya',
                'total' => $others
            ]);
        }

        $channelChart = $topChannel;

        // ================= LAYANAN =================

        $layananChart = (clone $query)
            ->selectRaw("
                layanan,
                SUM(transaksi) as total
            ")
            ->groupBy('layanan')
            ->orderByDesc('total')
            ->get();

        // ================= TIPE =================

        $tipeChart = (clone $query)
            ->selectRaw("
                tipe_layanan,
                SUM(transaksi) as total
            ")
            ->groupBy('tipe_layanan')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'totalTransaksi',
            'totalPelanggan',
            'totalNilai',
            'totalFee',
            'recentTransaksi',
            'trendChart',
            'channelChart',
            'layananChart',
            'tipeChart',
            'tahuns',
            'layanans',
            'tipes',
            'channels'
        ));
    }
}