@extends('layouts.app')

@section('title', $judul)

@section('content')

<style>

/* ==================================================
   GENERAL
================================================== */

.dashboard-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 4px;
}

.dashboard-subtitle {
    color: #6c757d;
    margin-bottom: 0;
}


/* ==================================================
   CARD
================================================== */

.dashboard-card {
    border: 0;
    border-radius: 12px;
}


/* ==================================================
   KPI
================================================== */

.kpi-card {
    min-height: 130px;
}

.kpi-label {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 8px;
}

.kpi-value {
    font-size: 25px;
    font-weight: 700;
    margin: 0;
}


/* ==================================================
   CHART
================================================== */

.chart-title {
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 18px;
}

.chart-large {
    position: relative;
    width: 100%;
    height: 320px;
}

.chart-medium {
    position: relative;
    width: 100%;
    height: 300px;
}


/* ==================================================
   DATA TRANSAKSI
================================================== */

.data-card {
    border: 0;
    border-radius: 12px;
    overflow: hidden;
}

.data-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.data-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 4px;
}

.data-description {
    font-size: 13px;
    color: #6c757d;
}

.data-count {
    background: #eaf3ff;
    color: #0d6efd;
    border: 1px solid #b9d7ff;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}


/* ==================================================
   TABLE
================================================== */

.data-table-wrapper {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #dee2e6;
    border-radius: 8px;
}

.data-table {
    width: 100%;
    min-width: 1100px;
    margin-bottom: 0;
    border-collapse: collapse;
}

.data-table thead th {
    background: #f8f9fa;
    color: #212529;
    font-size: 13px;
    font-weight: 700;
    padding: 13px 14px;
    border-bottom: 1px solid #dee2e6;
    white-space: nowrap;
}

.data-table tbody td {
    font-size: 13px;
    padding: 12px 14px;
    vertical-align: middle;
    border-bottom: 1px solid #edf0f2;
    white-space: nowrap;
}

.data-table tbody tr:last-child td {
    border-bottom: 0;
}

.data-table tbody tr:hover {
    background: #f8fbff;
}


/* ==================================================
   CHANNEL BADGE
================================================== */

.channel-badge {
    display: inline-block;
    background: #eaf3ff;
    color: #0d6efd;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}


/* ==================================================
   DATA FOOTER
================================================== */

.data-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 18px;
}

.data-info {
    color: #6c757d;
    font-size: 13px;
}


/* ==================================================
   CUSTOM PAGINATION
================================================== */

.custom-pagination {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 4px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.custom-pagination li {
    margin: 0;
}

.custom-pagination a,
.custom-pagination span {
    display: flex;
    align-items: center;
    justify-content: center;

    min-width: 38px;
    height: 36px;

    padding: 0 11px;

    border: 1px solid #dee2e6;
    border-radius: 6px;

    background: #ffffff;
    color: #0d6efd;

    font-size: 13px;
    text-decoration: none;

    transition: all 0.2s ease;
}

.custom-pagination a:hover {
    background: #f0f6ff;
    border-color: #0d6efd;
}

.custom-pagination .active span {
    background: #0d6efd;
    color: #ffffff;
    border-color: #0d6efd;
    font-weight: 600;
}

.custom-pagination .disabled span {
    background: #f8f9fa;
    color: #adb5bd;
    border-color: #dee2e6;
    cursor: not-allowed;
}


/* ==================================================
   RESPONSIVE
================================================== */

@media (max-width: 768px) {

    .dashboard-title {
        font-size: 23px;
    }

    .chart-large {
        height: 280px;
    }

    .chart-medium {
        height: 270px;
    }

    .data-header {
        align-items: flex-start;
        gap: 15px;
    }

    .data-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .custom-pagination {
        justify-content: flex-start;
        flex-wrap: wrap;
    }

}

</style>


<div class="container-fluid">


    <!-- ==================================================
         HEADER
    ================================================== -->

    <div class="mb-4">

        <h2 class="dashboard-title">
            {{ $judul }}
        </h2>

        <p class="dashboard-subtitle">
            Monitoring dan Visualisasi Data Transaksi
        </p>

    </div>


    <!-- ==================================================
         FILTER
    ================================================== -->

    <div class="card shadow-sm dashboard-card mb-4">

        <div class="card-body p-4">

            <form
                method="GET"
                action="{{ url()->current() }}"
            >

                <div class="row g-3">


                    <!-- TAHUN -->

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Tahun
                        </label>

                        <select
                            name="tahun"
                            class="form-select"
                        >

                            <option value="">
                                Semua Tahun
                            </option>

                            @foreach($tahuns as $tahun)

                                <option
                                    value="{{ $tahun }}"
                                    {{ request('tahun') == $tahun ? 'selected' : '' }}
                                >
                                    {{ $tahun }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- BULAN -->

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Bulan
                        </label>

                        <select
                            name="bulan"
                            class="form-select"
                        >

                            <option value="">
                                Semua Bulan
                            </option>

                            @for($i = 1; $i <= 12; $i++)

                                <option
                                    value="{{ $i }}"
                                    {{ request('bulan') == $i ? 'selected' : '' }}
                                >

                                    {{ DateTime::createFromFormat(
                                        '!m',
                                        $i
                                    )->format('F') }}

                                </option>

                            @endfor

                        </select>

                    </div>


                    <!-- TIPE LAYANAN -->

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Tipe Layanan
                        </label>

                        <select
                            name="tipe_layanan"
                            class="form-select"
                        >

                            <option value="">
                                Semua Tipe Layanan
                            </option>

                            @foreach($tipes as $tipe)

                                <option
                                    value="{{ $tipe }}"
                                    {{ request('tipe_layanan') == $tipe ? 'selected' : '' }}
                                >
                                    {{ $tipe }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- CHANNEL -->

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Channel
                        </label>

                        <select
                            name="channel"
                            class="form-select"
                        >

                            <option value="">
                                Semua Channel
                            </option>

                            @foreach($channels as $channel)

                                <option
                                    value="{{ $channel }}"
                                    {{ request('channel') == $channel ? 'selected' : '' }}
                                >
                                    {{ $channel }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <!-- BUTTON -->

                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >

                        <i class="bi bi-filter me-1"></i>

                        Terapkan Filter

                    </button>


                    <a
                        href="{{ url()->current() }}"
                        class="btn btn-outline-secondary px-4"
                    >

                        Reset

                    </a>

                </div>

            </form>

        </div>

    </div>


    <!-- ==================================================
         KPI
    ================================================== -->

    <div class="row g-4 mb-4">


        <!-- TOTAL TRANSAKSI -->

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm dashboard-card kpi-card h-100">

                <div class="card-body p-4">

                    <div class="kpi-label">
                        Total Transaksi
                    </div>

                    <h3 class="kpi-value">
                        {{ number_format($totalTransaksi) }}
                    </h3>

                </div>

            </div>

        </div>


        <!-- TOTAL PELANGGAN -->

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm dashboard-card kpi-card h-100">

                <div class="card-body p-4">

                    <div class="kpi-label">
                        Total Pelanggan
                    </div>

                    <h3 class="kpi-value">
                        {{ number_format($totalPelanggan) }}
                    </h3>

                </div>

            </div>

        </div>


        <!-- TOTAL NILAI -->

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm dashboard-card kpi-card h-100">

                <div class="card-body p-4">

                    <div class="kpi-label">
                        Total Nilai Transaksi
                    </div>

                    <h4 class="kpi-value">

                        Rp {{ number_format(
                            $totalNilai,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h4>

                </div>

            </div>

        </div>


        <!-- TOTAL FEE -->

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm dashboard-card kpi-card h-100">

                <div class="card-body p-4">

                    <div class="kpi-label">
                        Total Fee KAI
                    </div>

                    <h4 class="kpi-value">

                        Rp {{ number_format(
                            $totalFee,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h4>

                </div>

            </div>

        </div>

    </div>


    <!-- ==================================================
         TREND + CHANNEL
    ================================================== -->

    <div class="row g-4 mb-4">


        <!-- TREND -->

        <div class="col-lg-8">

            <div class="card shadow-sm dashboard-card h-100">

                <div class="card-body p-4">

                    <h5 class="chart-title">
                        Trend Transaksi
                    </h5>

                    <div class="chart-large">

                        <canvas id="trendChart"></canvas>

                    </div>

                </div>

            </div>

        </div>


        <!-- CHANNEL -->

        <div class="col-lg-4">

            <div class="card shadow-sm dashboard-card h-100">

                <div class="card-body p-4">

                    <h5 class="chart-title">
                        Distribusi Channel
                    </h5>

                    <div class="chart-medium">

                        <canvas id="channelChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ==================================================
         TIPE LAYANAN
    ================================================== -->

    <div class="row g-4 mb-4">

        <div class="col-12">

            <div class="card shadow-sm dashboard-card">

                <div class="card-body p-4">

                    <h5 class="chart-title">
                        Top Tipe Layanan
                    </h5>

                    <div class="chart-medium">

                        <canvas id="tipeChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ==================================================
         DATA TRANSAKSI
    ================================================== -->

    <div class="row g-4">

        <div class="col-12">

            <div class="card shadow-sm data-card">

                <div class="card-body p-4">


                    <!-- HEADER DATA -->

                    <div class="data-header">

                        <div>

                            <div class="data-title">

                                <i class="bi bi-table me-2 text-primary"></i>

                                Data Transaksi

                            </div>

                            <div class="data-description">

                                Menampilkan seluruh data
                                berdasarkan filter yang dipilih.

                            </div>

                        </div>


                        <div class="data-count">

                            <i class="bi bi-database me-1"></i>

                            {{ $transaksiData->total() }}

                            Data

                        </div>

                    </div>


                    <!-- TABLE -->

                    <div class="data-table-wrapper">

                        <table class="data-table">

                            <thead>

                                <tr>

                                    <th>
                                        No
                                    </th>

                                    <th>
                                        Periode
                                    </th>

                                    <th>
                                        Layanan
                                    </th>

                                    <th>
                                        Tipe Layanan
                                    </th>

                                    <th>
                                        Channel
                                    </th>

                                    <th class="text-end">
                                        Transaksi
                                    </th>

                                    <th class="text-end">
                                        Pelanggan
                                    </th>

                                    <th class="text-end">
                                        Nilai Transaksi
                                    </th>

                                    <th class="text-end">
                                        Fee KAI
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse(
                                    $transaksiData
                                    as $index => $item
                                )

                                    <tr>

                                        <!-- NO -->

                                        <td>

                                            {{
                                                $transaksiData->firstItem()
                                                + $index
                                            }}

                                        </td>


                                        <!-- PERIODE -->

                                        <td>

                                            {{ $item->periode }}

                                        </td>


                                        <!-- LAYANAN -->

                                        <td>

                                            {{ $item->layanan }}

                                        </td>


                                        <!-- TIPE LAYANAN -->

                                        <td>

                                            {{ $item->tipe_layanan }}

                                        </td>


                                        <!-- CHANNEL -->

                                        <td>

                                            <span class="channel-badge">

                                                {{ $item->channel }}

                                            </span>

                                        </td>


                                        <!-- TRANSAKSI -->

                                        <td class="text-end">

                                            {{
                                                number_format(
                                                    $item->transaksi
                                                )
                                            }}

                                        </td>


                                        <!-- PELANGGAN -->

                                        <td class="text-end">

                                            {{
                                                number_format(
                                                    $item->jumlah_pelanggan
                                                )
                                            }}

                                        </td>


                                        <!-- NILAI TRANSAKSI -->

                                        <td class="text-end">

                                            Rp

                                            {{
                                                number_format(
                                                    $item->nilai_transaksi,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}

                                        </td>


                                        <!-- FEE KAI -->

                                        <td class="text-end">

                                            Rp

                                            {{
                                                number_format(
                                                    $item->fee_kai,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="9"
                                            class="text-center text-muted py-5"
                                        >

                                            <i class="bi bi-database-x fs-3 d-block mb-2"></i>

                                            Tidak ada data transaksi
                                            yang sesuai dengan filter.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    <!-- ==================================================
                         FOOTER DATA
                    ================================================== -->

                    @if($transaksiData->total() > 0)

                        <div class="data-footer">


                            <!-- INFO -->

                            <div class="data-info">

                                Menampilkan

                                <strong>
                                    {{ $transaksiData->firstItem() }}
                                </strong>

                                sampai

                                <strong>
                                    {{ $transaksiData->lastItem() }}
                                </strong>

                                dari

                                <strong>
                                    {{ $transaksiData->total() }}
                                </strong>

                                data

                            </div>


                            <!-- PAGINATION -->

                            @if($transaksiData->hasPages())

                                <ul class="custom-pagination">


                                    <!-- PREVIOUS -->

                                    @if($transaksiData->onFirstPage())

                                        <li class="disabled">

                                            <span>
                                                &laquo; Sebelumnya
                                            </span>

                                        </li>

                                    @else

                                        <li>

                                            <a
                                                href="{{ $transaksiData->previousPageUrl() }}"
                                            >
                                                &laquo; Sebelumnya
                                            </a>

                                        </li>

                                    @endif


                                    <!-- NOMOR HALAMAN -->

                                    @foreach(
                                        $transaksiData->getUrlRange(
                                            1,
                                            $transaksiData->lastPage()
                                        )
                                        as $page => $url
                                    )

                                        @if(
                                            $page ==
                                            $transaksiData->currentPage()
                                        )

                                            <li class="active">

                                                <span>
                                                    {{ $page }}
                                                </span>

                                            </li>

                                        @else

                                            <li>

                                                <a
                                                    href="{{ $url }}"
                                                >
                                                    {{ $page }}
                                                </a>

                                            </li>

                                        @endif

                                    @endforeach


                                    <!-- NEXT -->

                                    @if(
                                        $transaksiData->hasMorePages()
                                    )

                                        <li>

                                            <a
                                                href="{{ $transaksiData->nextPageUrl() }}"
                                            >
                                                Selanjutnya &raquo;
                                            </a>

                                        </li>

                                    @else

                                        <li class="disabled">

                                            <span>
                                                Selanjutnya &raquo;
                                            </span>

                                        </li>

                                    @endif


                                </ul>

                            @endif

                        </div>

                    @endif


                </div>

            </div>

        </div>

    </div>


</div>


@endsection



@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* ==================================================
           DATA CHART
        ================================================== */

        const trendData =
            @json($trendChart);

        const channelData =
            @json($channelChart);

        const tipeData =
            @json($tipeChart);


        /* ==================================================
           TREND TRANSAKSI
        ================================================== */

        const trendCanvas =
            document.getElementById(
                'trendChart'
            );


        if (trendCanvas) {

            new Chart(
                trendCanvas,
                {

                    type: 'line',

                    data: {

                        labels: trendData.map(
                            item => item.bulan
                        ),

                        datasets: [

                            {

                                label: 'Transaksi',

                                data: trendData.map(
                                    item => item.total
                                ),

                                tension: 0.35,

                                borderWidth: 2,

                                pointRadius: 3,

                                pointHoverRadius: 5,

                                fill: false

                            }

                        ]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {

                                display: false

                            }

                        },

                        scales: {

                            y: {

                                beginAtZero: true

                            }

                        }

                    }

                }
            );

        }


        /* ==================================================
           CHANNEL
        ================================================== */

        const channelCanvas =
            document.getElementById(
                'channelChart'
            );


        if (channelCanvas) {

            new Chart(
                channelCanvas,
                {

                    type: 'doughnut',

                    data: {

                        labels: channelData.map(
                            item => item.channel
                        ),

                        datasets: [

                            {

                                data: channelData.map(
                                    item => item.total
                                ),

                                borderWidth: 1

                            }

                        ]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        cutout: '60%',

                        plugins: {

                            legend: {

                                position: 'bottom',

                                labels: {

                                    boxWidth: 12,

                                    padding: 12

                                }

                            }

                        }

                    }

                }
            );

        }


        /* ==================================================
           TIPE LAYANAN
        ================================================== */

        const tipeCanvas =
            document.getElementById(
                'tipeChart'
            );


        if (tipeCanvas) {

            new Chart(
                tipeCanvas,
                {

                    type: 'bar',

                    data: {

                        labels: tipeData.map(
                            item => item.tipe_layanan
                        ),

                        datasets: [

                            {

                                label: 'Transaksi',

                                data: tipeData.map(
                                    item => item.total
                                ),

                                borderWidth: 1

                            }

                        ]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        indexAxis: 'y',

                        plugins: {

                            legend: {

                                display: false

                            }

                        },

                        scales: {

                            x: {

                                beginAtZero: true

                            }

                        }

                    }

                }
            );

        }

    }

);

</script>

@endpush