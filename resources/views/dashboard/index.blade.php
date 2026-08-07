@extends('layouts.app')

@section('title','Dashboard')


@section('content')


<div class="container-fluid">


<!-- ================= HEADER ================= -->


<div class="d-flex justify-content-between align-items-center mb-4">


    <div>


        <h2 class="fw-bold mb-0">

            Dashboard Monitoring Transaksi Unit CSTA KAI

        </h2>


        <small class="text-muted">

            Business Intelligence

        </small>


    </div>



    <a href="{{ route('transaksi.index', request()->query()) }}"
       class="btn btn-primary">


        <i class="bi bi-table"></i>

        Lihat Semua Data


    </a>



</div>




<!-- ================= MENU LAYANAN ================= -->


<div class="mb-4">


<div class="btn-group w-100" role="group">


<a href="{{ route('dashboard') }}"
class="btn {{ request('layanan')=='' ? 'btn-primary':'btn-outline-primary' }}">


📊 Semua


</a>



<a href="{{ route('dashboard',['layanan'=>'Tiket KAI']) }}"
class="btn {{ request('layanan')=='Tiket KAI' ? 'btn-primary':'btn-outline-primary' }}">


🚆 Tiket KAI


</a>




<a href="{{ route('dashboard',['layanan'=>'Mitra KAI Group']) }}"
class="btn {{ request('layanan')=='Mitra KAI Group' ? 'btn-primary':'btn-outline-primary' }}">


🤝 Mitra KAI Group


</a>




<a href="{{ route('dashboard',['layanan'=>'Mitra Non KAI Group']) }}"
class="btn {{ request('layanan')=='Mitra Non KAI Group' ? 'btn-primary':'btn-outline-primary' }}">


🏪 Mitra Non KAI Group


</a>



</div>


</div>





<!-- ================= FILTER ================= -->


<div class="card border-0 shadow-sm mb-4">


<div class="card-header bg-primary text-white">


<strong>

<i class="bi bi-funnel"></i>

Filter Dashboard

</strong>


</div>


<div class="card-body">


<form method="GET"
action="{{ route('dashboard') }}">


<div class="row">



<div class="col-lg-2 mb-3">


<label class="form-label">

Tahun

</label>


<select name="tahun"
class="form-select">


<option value="">
Semua
</option>


@foreach($tahuns as $tahun)


<option value="{{ $tahun }}"
{{ request('tahun')==$tahun?'selected':'' }}>


{{ $tahun }}


</option>


@endforeach


</select>


</div>
<!-- ================= FILTER LANJUTAN ================= -->


<div class="col-lg-2 mb-3">


<label class="form-label">

Bulan

</label>


<select name="bulan"
class="form-select">


<option value="">
Semua
</option>


@for($i=1;$i<=12;$i++)


<option value="{{ $i }}"
{{ request('bulan')==$i?'selected':'' }}>


{{ DateTime::createFromFormat('!m',$i)->format('F') }}


</option>


@endfor


</select>


</div>





<div class="col-lg-3 mb-3">


<label class="form-label">

Layanan

</label>


<select name="layanan"
class="form-select">


<option value="">
Semua
</option>


@foreach($layanans as $layanan)


<option value="{{ $layanan }}"
{{ request('layanan')==$layanan?'selected':'' }}>


{{ $layanan }}


</option>


@endforeach


</select>


</div>





<div class="col-lg-3 mb-3">


<label class="form-label">

Tipe Layanan

</label>


<select name="tipe_layanan"
class="form-select">


<option value="">
Semua
</option>


@foreach($tipes as $tipe)


<option value="{{ $tipe }}"
{{ request('tipe_layanan')==$tipe?'selected':'' }}>


{{ $tipe }}


</option>


@endforeach


</select>


</div>





<div class="col-lg-2 mb-3">


<label class="form-label">

Channel

</label>


<select name="channel"
class="form-select">


<option value="">
Semua
</option>


@foreach($channels as $channel)


<option value="{{ $channel }}"
{{ request('channel')==$channel?'selected':'' }}>


{{ $channel }}


</option>


@endforeach


</select>


</div>



</div>





<button class="btn btn-primary">

<i class="bi bi-search"></i>

Terapkan Filter

</button>



<a href="{{ route('dashboard') }}"
class="btn btn-outline-secondary">


Reset


</a>



</form>


</div>


</div>





<!-- ================= KPI ================= -->


<div class="row g-4 mb-4">



<!-- TOTAL TRANSAKSI -->


<div class="col-lg-3 col-md-6">


<div class="card border-0 shadow-sm h-100 bg-primary text-white">


<div class="card-body">


<small>
Total Transaksi
</small>


<h2 class="fw-bold">


{{ number_format($totalTransaksi) }}


</h2>


</div>


</div>


</div>





<!-- TOTAL PELANGGAN -->


<div class="col-lg-3 col-md-6">


<div class="card border-0 shadow-sm h-100 bg-success text-white">


<div class="card-body">


<small>
Total Pelanggan
</small>


<h2 class="fw-bold">


{{ number_format($totalPelanggan) }}


</h2>


</div>


</div>


</div>





<!-- TOTAL NILAI -->


<div class="col-lg-3 col-md-6">


<div class="card border-0 shadow-sm h-100 bg-warning">


<div class="card-body">


<small>
Total Nilai Transaksi
</small>


<h5 class="fw-bold">


Rp {{ number_format($totalNilai,0,',','.') }}


</h5>


</div>


</div>


</div>





<!-- TOTAL FEE -->


<div class="col-lg-3 col-md-6">


<div class="card border-0 shadow-sm h-100 bg-danger text-white">


<div class="card-body">


<small>
Total Fee KAI
</small>


<h5 class="fw-bold">


Rp {{ number_format($totalFee,0,',','.') }}


</h5>


</div>


</div>


</div>
<!-- ================= GROWTH TRANSAKSI ================= -->


<div class="col-lg-3 col-md-6">


<div class="card border-0 shadow-sm h-100 bg-info text-white">


<div class="card-body">


<small>

Growth Transaksi

</small>



<h2 class="fw-bold mt-2">


{{ number_format($growth,2) }}%


</h2>



<small>

Dibanding bulan sebelumnya

</small>



</div>


</div>


</div>


</div>





<!-- ================= GRAFIK ================= -->


<div class="row">



<!-- TREND TRANSAKSI -->


<div class="col-lg-8 mb-4">


<div class="card border-0 shadow-sm h-100">


<div class="card-header bg-white">


<h5 class="mb-0">


<i class="bi bi-graph-up-arrow text-primary"></i>

Trend Transaksi


</h5>


</div>




<div class="card-body">


<canvas id="trendChart" height="130"></canvas>


</div>



</div>


</div>





<!-- CHANNEL -->


<div class="col-lg-4 mb-4">


<div class="card border-0 shadow-sm h-100">


<div class="card-header bg-white">


<h5 class="mb-0">


<i class="bi bi-pie-chart-fill text-success"></i>

Distribusi Channel


</h5>


</div>



<div class="card-body">


<canvas id="channelChart"></canvas>


</div>



</div>


</div>


</div>






<!-- ================= GRAFIK BARIS 2 ================= -->


<div class="row">



<!-- LAYANAN -->


<div class="col-lg-6 mb-4">


<div class="card border-0 shadow-sm h-100">


<div class="card-header bg-white">


<h5 class="mb-0">


<i class="bi bi-grid-3x3-gap-fill text-warning"></i>

Distribusi Layanan


</h5>


</div>




<div class="card-body">


<canvas id="layananChart"></canvas>


</div>



</div>


</div>





<!-- TIPE -->


<div class="col-lg-6 mb-4">


<div class="card border-0 shadow-sm h-100">


<div class="card-header bg-white">


<h5 class="mb-0">


<i class="bi bi-bar-chart-fill text-danger"></i>

Top Tipe Layanan


</h5>


</div>




<div class="card-body">


<canvas id="tipeChart"></canvas>


</div>



</div>


</div>



</div>
<!-- ================= TABEL DATA ================= -->


<div class="card border-0 shadow-sm mb-4">


<div class="card-header bg-white d-flex justify-content-between align-items-center">


<h5 class="mb-0">


<i class="bi bi-clock-history text-primary"></i>

10 Data Transaksi Terbaru


</h5>




<a href="{{ route('transaksi.index', request()->query()) }}"
class="btn btn-primary btn-sm">


<i class="bi bi-table"></i>

Lihat Semua Data


</a>


</div>




<div class="card-body p-0">


<div class="table-responsive">


<table class="table table-hover table-striped align-middle mb-0">


<thead class="table-dark">


<tr>


<th>Periode</th>

<th>Layanan</th>

<th>Tipe</th>

<th>Channel</th>

<th class="text-end">Transaksi</th>

<th class="text-end">Pelanggan</th>

<th class="text-end">Nilai Transaksi</th>

<th class="text-end">Fee KAI</th>


</tr>


</thead>



<tbody>


@forelse($recentTransaksi as $item)



<tr>


<td>

{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('M Y') }}


</td>



<td>


<span class="badge bg-primary">


{{ $item->layanan }}


</span>


</td>




<td>

{{ $item->tipe_layanan }}

</td>



<td>

{{ $item->channel }}

</td>



<td class="text-end fw-semibold">

{{ number_format($item->transaksi) }}

</td>



<td class="text-end">

{{ number_format($item->jumlah_pelanggan) }}

</td>



<td class="text-end text-success fw-bold">

Rp {{ number_format($item->nilai_transaksi,0,',','.') }}

</td>



<td class="text-end text-danger fw-bold">

Rp {{ number_format($item->fee_kai,0,',','.') }}

</td>



</tr>



@empty


<tr>


<td colspan="8" class="text-center py-4">


Belum ada data transaksi.


</td>


</tr>


@endforelse



</tbody>


</table>


</div>


</div>


</div>






</div>


@endsection
@push('scripts')

<script>


// ================= TREND TRANSAKSI =================


new Chart(document.getElementById('trendChart'), {


    type: 'line',


    data: {


        labels: {!! json_encode($trendChart->pluck('bulan')) !!},


        datasets: [{


            label: 'Jumlah Transaksi',


            data: {!! json_encode($trendChart->pluck('total')) !!},


            borderWidth: 2,


            tension: 0.3


        }]


    }


});





// ================= CHANNEL =================


new Chart(document.getElementById('channelChart'), {


    type: 'pie',


    data: {


        labels: {!! json_encode($channelChart->pluck('channel')) !!},


        datasets: [{


            data: {!! json_encode($channelChart->pluck('total')) !!},


        }]


    }


});





// ================= LAYANAN =================


new Chart(document.getElementById('layananChart'), {


    type: 'bar',


    data: {


        labels: {!! json_encode($layananChart->pluck('layanan')) !!},


        datasets: [{


            label:'Transaksi',


            data: {!! json_encode($layananChart->pluck('total')) !!}


        }]


    }


});





// ================= TIPE LAYANAN =================


new Chart(document.getElementById('tipeChart'), {


    type:'bar',


    data:{


        labels:{!! json_encode($tipeChart->pluck('tipe_layanan')) !!},


        datasets:[{


            label:'Transaksi',


            data:{!! json_encode($tipeChart->pluck('total')) !!}


        }]


    }


});


</script>


@endpush