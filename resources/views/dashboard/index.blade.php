@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>

/* =========================================================
   DASAR
========================================================= */

:root {

    --primary: #3B6EA5;

    --primary-dark: #315D8B;

    --primary-soft: #EEF4F8;

    --text: #172033;

    --muted: #718096;

    --border: #D7E0E8;

    --background: #F5F7F9;

}


body {

    background: var(--background);

}


/* =========================================================
   JUDUL
========================================================= */

.dashboard-title {

    font-size: 27px;

    font-weight: 700;

    color: var(--text);

    margin-bottom: 5px;

    line-height: 1.25;

}


.dashboard-subtitle {

    color: var(--muted);

    font-size: 14px;

    margin-bottom: 22px;

}


/* =========================================================
   TAB LAYANAN
========================================================= */

.service-tabs {

    display: flex;

    width: 100%;

    border: 1px solid #B8C7D6;

    border-radius: 7px;

    overflow: hidden;

    background: #FFFFFF;

}


.service-tab {

    flex: 1;

    min-height: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    padding: 8px 12px;

    background: #FFFFFF;

    color: var(--primary);

    border-right: 1px solid #B8C7D6;

    text-decoration: none;

    font-size: 16px;

    font-weight: 500;

    transition: all 0.2s ease;

}


.service-tab:last-child {

    border-right: none;

}


.service-tab:hover {

    background: #F1F5F8;

    color: var(--primary-dark);

}


.service-tab.active {

    background: var(--primary);

    color: #FFFFFF;

    font-weight: 600;

}


/* =========================================================
   FILTER
========================================================= */

.filter-card {

    border: none;

    border-radius: 9px;

    overflow: hidden;

    background: #FFFFFF;

}


.filter-header {

    background: var(--primary);

    color: #FFFFFF;

    padding: 13px 20px;

}


.filter-header h5 {

    margin: 0;

    font-size: 17px;

    font-weight: 600;

}


.filter-body {

    padding: 22px 20px;

}


.filter-body label {

    font-size: 15px;

    margin-bottom: 7px;

    color: #263238;

}


.filter-body .form-select {

    min-height: 46px;

    border-radius: 7px;

    border-color: #D4DDE5;

    font-size: 15px;

    color: #29313A;

    box-shadow: none;

}


.filter-body .form-select:focus {

    border-color: #7D9BB7;

    box-shadow:
        0 0 0 0.15rem
        rgba(59, 110, 165, 0.10);

}


/* =========================================================
   BUTTON
========================================================= */

.btn-primary {

    background-color: var(--primary) !important;

    border-color: var(--primary) !important;

    font-size: 14px;

    padding: 9px 18px;

    border-radius: 6px;

}


.btn-primary:hover {

    background-color: var(--primary-dark) !important;

    border-color: var(--primary-dark) !important;

}


.btn-outline-secondary {

    font-size: 14px;

    padding: 9px 18px;

    border-radius: 6px;

    color: #59636E;

    border-color: #AEB8C2;

}


.btn-outline-secondary:hover {

    background: #F3F5F7;

    color: #39434D;

    border-color: #9CA8B3;

}


/* =========================================================
   KPI
========================================================= */

.kpi-card {

    border: none;

    border-radius: 10px;

    min-height: 135px;

    background: #FFFFFF;

    transition:
        transform 0.15s ease,
        box-shadow 0.15s ease;

}


.kpi-card:hover {

    transform: translateY(-2px);

}


.kpi-label {

    color: #718096;

    font-size: 14px;

    margin-bottom: 8px;

}


.kpi-value {

    font-size: 25px;

    font-weight: 700;

    color: var(--text);

    line-height: 1.25;

    word-break: break-word;

}


.kpi-growth {

    margin-top: 8px;

    font-size: 12px;

}


/* =========================================================
   INSIGHT OTOMATIS
========================================================= */

.insight-card {

    border: none;

    border-radius: 10px;

    background: #FFFFFF;

}


.insight-title {

    font-size: 17px;

    font-weight: 600;

    color: var(--text);

    margin-bottom: 15px;

}


.insight-item {

    display: flex;

    align-items: flex-start;

    gap: 10px;

    padding: 10px 0;

    border-bottom: 1px solid #EDF0F2;

    color: #39434D;

    font-size: 14px;

    line-height: 1.6;

}


.insight-item:last-child {

    border-bottom: none;

}


.insight-icon {

    color: var(--primary);

    font-size: 16px;

    margin-top: 2px;

    flex-shrink: 0;

}


/* =========================================================
   CARD GRAFIK
========================================================= */

.chart-card {

    border: none;

    border-radius: 10px;

    background: #FFFFFF;

}


.chart-title {

    font-size: 17px;

    font-weight: 600;

    margin-bottom: 18px;

    color: var(--text);

}


.chart-large {

    height: 290px;

    position: relative;

}


.chart-medium {

    height: 270px;

    position: relative;

}


/* =========================================================
   DATA TRANSAKSI
========================================================= */

.data-card {

    border: none;

    border-radius: 10px;

    background: #FFFFFF;

}


.data-title {

    font-size: 17px;

    font-weight: 600;

    color: var(--text);

}


.data-description {

    color: var(--muted);

    font-size: 12px;

    margin-top: 3px;

}


.data-count {

    background: var(--primary-soft);

    color: var(--primary);

    border: 1px solid #CBD9E5;

    border-radius: 6px;

    padding: 7px 11px;

    font-size: 12px;

    font-weight: 600;

}


/* =========================================================
   TABLE
========================================================= */

.data-table-wrapper {

    width: 100%;

    overflow-x: auto;

    border: 1px solid #DFE5EA;

    border-radius: 7px;

}


.data-table {

    width: 100%;

    min-width: 1050px;

    margin-bottom: 0;

    border-collapse: collapse;

}


.data-table thead th {

    background: #F4F6F8;

    color: #39434D;

    padding: 11px 12px;

    font-size: 12px;

    font-weight: 600;

    white-space: nowrap;

    border-bottom: 1px solid #DFE5EA;

}


.data-table tbody td {

    padding: 10px 12px;

    font-size: 12px;

    color: #303943;

    white-space: nowrap;

    border-bottom: 1px solid #EDF0F2;

}


.data-table tbody tr:last-child td {

    border-bottom: none;

}


.data-table tbody tr:hover {

    background: #F8FAFB;

}


/* =========================================================
   CHANNEL BADGE
========================================================= */

.channel-badge {

    display: inline-block;

    background: #EEF4F8;

    color: var(--primary);

    padding: 4px 8px;

    border-radius: 5px;

    font-size: 11px;

    font-weight: 600;

}


/* =========================================================
   FOOTER DATA
========================================================= */

.data-footer {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-top: 16px;

}


.data-info {

    color: var(--muted);

    font-size: 12px;

}


/* =========================================================
   PAGINATION
========================================================= */

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

    min-width: 34px;

    height: 32px;

    padding: 0 9px;

    border: 1px solid #D6DDE3;

    border-radius: 5px;

    background: #FFFFFF;

    color: var(--primary);

    font-size: 12px;

    text-decoration: none;

}


.custom-pagination a:hover {

    background: var(--primary-soft);

    color: var(--primary-dark);

}


.custom-pagination .active span {

    background: var(--primary);

    color: #FFFFFF;

    border-color: var(--primary);

}


.custom-pagination .disabled span {

    color: #ADB5BD;

    background: #F7F8F9;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .service-tab {

        font-size: 15px;

    }

}


@media (max-width: 768px) {

    .service-tabs {

        flex-direction: column;

    }


    .service-tab {

        border-right: none;

        border-bottom: 1px solid #B8C7D6;

    }


    .service-tab:last-child {

        border-bottom: none;

    }


    .dashboard-title {

        font-size: 23px;

    }


    .dashboard-subtitle {

        font-size: 13px;

    }


    .filter-body {

        padding: 18px;

    }


    .data-footer {

        flex-direction: column;

        align-items: flex-start;

        gap: 12px;

    }


    .custom-pagination {

        justify-content: flex-start;

        flex-wrap: wrap;

    }

}

</style>


<!-- =========================================================
     JUDUL DASHBOARD
========================================================= -->

<div class="mb-4">

    <h1 class="dashboard-title">

        Dashboard Monitoring Transaksi Unit CSTA KAI

    </h1>


    <p class="dashboard-subtitle">

        Monitoring dan Visualisasi Data Transaksi

    </p>

</div>


<!-- =========================================================
     TAB LAYANAN
========================================================= -->

<div class="mb-4">

    <div class="service-tabs">


        <!-- SEMUA -->

        <a
            href="{{ route('dashboard') }}"
            class="service-tab
            {{ !request('layanan') ? 'active' : '' }}"
        >

            <span>📊</span>

            <span>Semua</span>

        </a>


        <!-- TIKET KAI -->

        <a
            href="{{ route(
                'dashboard',
                ['layanan' => 'Tiket KAI']
            ) }}"
            class="service-tab
            {{ request('layanan') == 'Tiket KAI'
                ? 'active'
                : '' }}"
        >

            <span>🚆</span>

            <span>Tiket KAI</span>

        </a>


        <!-- MITRA KAI GROUP -->

        <a
            href="{{ route(
                'dashboard',
                ['layanan' => 'Mitra KAI Group']
            ) }}"
            class="service-tab
            {{ request('layanan') == 'Mitra KAI Group'
                ? 'active'
                : '' }}"
        >

            <span>🤝</span>

            <span>Mitra KAI Group</span>

        </a>


        <!-- MITRA NON KAI GROUP -->

        <a
            href="{{ route(
                'dashboard',
                ['layanan' => 'Mitra Non KAI Group']
            ) }}"
            class="service-tab
            {{ request('layanan') == 'Mitra Non KAI Group'
                ? 'active'
                : '' }}"
        >

            <span>🏪</span>

            <span>Mitra Non KAI Group</span>

        </a>


    </div>

</div>


<!-- =========================================================
     FILTER
========================================================= -->

<div class="card shadow-sm filter-card mb-4">


    <div class="filter-header">

        <h5>

            <i class="bi bi-funnel me-2"></i>

            Filter Dashboard

        </h5>

    </div>


    <div class="filter-body">

        <form
            method="GET"
            action="{{ route('dashboard') }}"
        >

            <div class="row g-3">


                <!-- TAHUN -->

                <div class="col-xl-2 col-lg-4 col-md-6">

                    <label class="form-label">

                        Tahun

                    </label>


                    <select
                        name="tahun"
                        class="form-select"
                    >

                        <option value="">

                            Semua

                        </option>


                        @foreach($tahuns as $tahun)

                            <option
                                value="{{ $tahun }}"
                                {{ request('tahun') == $tahun
                                    ? 'selected'
                                    : '' }}
                            >

                                {{ $tahun }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- BULAN -->

                <div class="col-xl-2 col-lg-4 col-md-6">

                    <label class="form-label">

                        Bulan

                    </label>


                    <select
                        name="bulan"
                        class="form-select"
                    >

                        <option value="">

                            Semua

                        </option>


                        @for($i = 1; $i <= 12; $i++)

                            <option
                                value="{{ $i }}"
                                {{ request('bulan') == $i
                                    ? 'selected'
                                    : '' }}
                            >

                                {{
                                    DateTime::createFromFormat(
                                        '!m',
                                        $i
                                    )->format('F')
                                }}

                            </option>

                        @endfor

                    </select>

                </div>


                <!-- LAYANAN -->

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <label class="form-label">

                        Layanan

                    </label>


                    <select
                        name="layanan"
                        class="form-select"
                    >

                        <option value="">

                            Semua

                        </option>


                        @foreach($layanans as $layanan)

                            <option
                                value="{{ $layanan }}"
                                {{ request('layanan') == $layanan
                                    ? 'selected'
                                    : '' }}
                            >

                                {{ $layanan }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- TIPE LAYANAN -->

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <label class="form-label">

                        Tipe Layanan

                    </label>


                    <select
                        name="tipe_layanan"
                        class="form-select"
                    >

                        <option value="">

                            Semua

                        </option>


                        @foreach($tipes as $tipe)

                            <option
                                value="{{ $tipe }}"
                                {{ request('tipe_layanan') == $tipe
                                    ? 'selected'
                                    : '' }}
                            >

                                {{ $tipe }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- CHANNEL -->

                <div class="col-xl-2 col-lg-4 col-md-6">

                    <label class="form-label">

                        Channel

                    </label>


                    <select
                        name="channel"
                        class="form-select"
                    >

                        <option value="">

                            Semua

                        </option>


                        @foreach($channels as $channel)

                            <option
                                value="{{ $channel }}"
                                {{ request('channel') == $channel
                                    ? 'selected'
                                    : '' }}
                            >

                                {{ $channel }}

                            </option>

                        @endforeach

                    </select>

                </div>


            </div>


            <div class="mt-3">

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="bi bi-search me-1"></i>

                    Terapkan Filter

                </button>


                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-outline-secondary"
                >

                    Reset

                </a>

            </div>


        </form>

    </div>

</div>


<!-- =========================================================
     KPI
========================================================= -->

<div class="row g-3 mb-4">


    <!-- TOTAL TRANSAKSI -->

    <div class="col-xl-3 col-md-6">

        <div class="card shadow-sm kpi-card h-100">

            <div class="card-body p-4">

                <div class="kpi-label">

                    Total Transaksi

                </div>


                <div class="kpi-value">

                    {{ number_format($totalTransaksi) }}

                </div>


                @if($growth != 0)

                    <div
                        class="kpi-growth
                        {{ $growth >= 0
                            ? 'text-success'
                            : 'text-danger' }}"
                    >

                        <i
                            class="bi
                            {{ $growth >= 0
                                ? 'bi-arrow-up'
                                : 'bi-arrow-down' }}"
                        ></i>

                        {{ number_format(
                            abs($growth),
                            1
                        ) }}%

                    </div>

                @endif

            </div>

        </div>

    </div>


    <!-- TOTAL PELANGGAN -->

    <div class="col-xl-3 col-md-6">

        <div class="card shadow-sm kpi-card h-100">

            <div class="card-body p-4">

                <div class="kpi-label">

                    Total Pelanggan

                </div>


                <div class="kpi-value">

                    {{ number_format(
                        $totalPelanggan
                    ) }}

                </div>

            </div>

        </div>

    </div>


    <!-- TOTAL NILAI -->

    <div class="col-xl-3 col-md-6">

        <div class="card shadow-sm kpi-card h-100">

            <div class="card-body p-4">

                <div class="kpi-label">

                    Total Nilai Transaksi

                </div>


                <div class="kpi-value">

                    Rp {{ number_format(
                        $totalNilai,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>

    </div>


    <!-- TOTAL FEE -->

    <div class="col-xl-3 col-md-6">

        <div class="card shadow-sm kpi-card h-100">

            <div class="card-body p-4">

                <div class="card-body p-4">

                    <div class="kpi-label">

                        Total Fee KAI

                    </div>


                    <div class="kpi-value">

                        Rp {{ number_format(
                            $totalFee,
                            0,
                            ',',
                            '.'
                        ) }}

                    </div>

                </div>

            </div>

        </div>

    </div>


</div>


<!-- =========================================================
     INSIGHT OTOMATIS
========================================================= -->

<div class="card shadow-sm insight-card mb-4">

    <div class="card-body p-4">

        <div class="insight-title">

            <i
                class="bi bi-lightbulb me-2"
                style="color: var(--primary);"
            ></i>

            Insight Otomatis

        </div>


        @forelse($insights as $insight)

            <div class="insight-item">

                <i
                    class="bi bi-check-circle-fill insight-icon"
                ></i>

                <div>

                    {{ $insight }}

                </div>

            </div>

        @empty

            <div class="text-muted">

                Belum ada insight yang dapat ditampilkan.

            </div>

        @endforelse

    </div>

</div>


<!-- =========================================================
     GRAFIK TREND + CHANNEL
========================================================= -->

<div class="row g-3 mb-3">


    <!-- TREND -->

    <div class="col-lg-8">

        <div class="card shadow-sm chart-card h-100">

            <div class="card-body p-4">

                <div class="chart-title">

                    Trend Transaksi Bulanan

                </div>


                <div class="chart-large">

                    <canvas id="trendChart"></canvas>

                </div>

            </div>

        </div>

    </div>


    <!-- CHANNEL -->

    <div class="col-lg-4">

        <div class="card shadow-sm chart-card h-100">

            <div class="card-body p-4">

                <div class="chart-title">

                    Distribusi Channel

                </div>


                <div class="chart-medium">

                    <canvas id="channelChart"></canvas>

                </div>

            </div>

        </div>

    </div>


</div>


<!-- =========================================================
     LAYANAN + TIPE LAYANAN
========================================================= -->

<div class="row g-3 mb-4">


    <!-- LAYANAN -->

    <div class="col-lg-6">

        <div class="card shadow-sm chart-card h-100">

            <div class="card-body p-4">

                <div class="chart-title">

                    Perbandingan Layanan

                </div>


                <div class="chart-medium">

                    <canvas id="layananChart"></canvas>

                </div>

            </div>

        </div>

    </div>


    <!-- TIPE LAYANAN -->

    <div class="col-lg-6">

        <div class="card shadow-sm chart-card h-100">

            <div class="card-body p-4">

                <div class="chart-title">

                    Perbandingan Tipe Layanan

                </div>


                <div class="chart-medium">

                    <canvas id="tipeChart"></canvas>

                </div>

            </div>

        </div>

    </div>


</div>


<!-- =========================================================
     DATA TRANSAKSI
========================================================= -->

<div class="card shadow-sm data-card mb-4">

    <div class="card-body p-4">


        <div
            class="d-flex
            justify-content-between
            align-items-center
            mb-3"
        >

            <div>

                <div class="data-title">

                    <i
                        class="bi bi-table me-2"
                        style="color: var(--primary);"
                    ></i>

                    Data Transaksi

                </div>


                <div class="data-description">

                    Seluruh data sesuai filter yang dipilih.

                </div>

            </div>


            <div class="data-count">

                <i class="bi bi-database me-1"></i>

                {{ $transaksiData->total() }}

                Data

            </div>

        </div>


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

                            <td>

                                {{
                                    $transaksiData->firstItem()
                                    + $index
                                }}

                            </td>


                            <td>

                                {{ $item->periode }}

                            </td>


                            <td>

                                {{ $item->layanan }}

                            </td>


                            <td>

                                {{ $item->tipe_layanan }}

                            </td>


                            <td>

                                <span class="channel-badge">

                                    {{ $item->channel }}

                                </span>

                            </td>


                            <td class="text-end">

                                {{
                                    number_format(
                                        $item->transaksi
                                    )
                                }}

                            </td>


                            <td class="text-end">

                                {{
                                    number_format(
                                        $item->jumlah_pelanggan
                                    )
                                }}

                            </td>


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
                                class="text-center
                                text-muted
                                py-5"
                            >

                                <i
                                    class="bi
                                    bi-database-x
                                    fs-3
                                    d-block
                                    mb-2"
                                ></i>

                                Tidak ada data transaksi
                                sesuai filter.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- PAGINATION -->

        @if($transaksiData->total() > 0)

            <div class="data-footer">


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


                @if($transaksiData->hasPages())

                    <ul class="custom-pagination">


                        @if(
                            $transaksiData->onFirstPage()
                        )

                            <li class="disabled">

                                <span>
                                    &laquo;
                                </span>

                            </li>

                        @else

                            <li>

                                <a
                                    href="{{
                                        $transaksiData
                                        ->previousPageUrl()
                                    }}"
                                >

                                    &laquo;

                                </a>

                            </li>

                        @endif


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

                                    <a href="{{ $url }}">

                                        {{ $page }}

                                    </a>

                                </li>

                            @endif

                        @endforeach


                        @if(
                            $transaksiData->hasMorePages()
                        )

                            <li>

                                <a
                                    href="{{
                                        $transaksiData
                                        ->nextPageUrl()
                                    }}"
                                >

                                    &raquo;

                                </a>

                            </li>

                        @else

                            <li class="disabled">

                                <span>
                                    &raquo;
                                </span>

                            </li>

                        @endif


                    </ul>

                @endif

            </div>

        @endif

    </div>

</div>


@endsection


<!-- =========================================================
     JAVASCRIPT GRAFIK
========================================================= -->

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =====================================================
           DATA DARI CONTROLLER
        ===================================================== */

        const trendData =
            @json($trendChart);


        const channelData =
            @json($channelChart);


        const layananData =
            @json($layananChart);


        const tipeData =
            @json($tipeChart);



        /* =====================================================
           WARNA CHANNEL
           
           WARNA BERDASARKAN NAMA CHANNEL.
           
           Jadi kalau urutan channel berubah,
           warna tetap sama.
        ===================================================== */

        const channelColors = {

            'Access by KAI':
                '#3B6EA5',

            'B2B':
                '#D28B3C',

            'WEB KAI':
                '#5A8F6B',

            'CC121':
                '#8B5E83',

            'Loket':
                '#C45A5A',

            'Vending Machine':
                '#4F8F9D',

            'Top Up KMT':
                '#806B9B',

            'Tiket KA Bandara Railink':
                '#B08A4A',

            'Pulsa':
                '#557A95',

            'PPOB':
                '#9B6A55',

            'Railfood':
                '#4D8A70',

            'Hotel':
                '#A76565',

            'Lainnya':
                '#718096'

        };


        /* =====================================================
           WARNA CADANGAN
           
           Kalau nanti ada channel baru di Excel/database
           yang belum dimasukkan ke daftar di atas,
           sistem tetap memberikan warna.
        ===================================================== */

        const fallbackColors = [

            '#3B6EA5',

            '#D28B3C',

            '#5A8F6B',

            '#8B5E83',

            '#C45A5A',

            '#4F8F9D',

            '#806B9B',

            '#B08A4A',

            '#557A95',

            '#9B6A55'

        ];


        let fallbackIndex = 0;


        function getChannelColor(channel) {


            if (
                channelColors[channel]
            ) {

                return channelColors[channel];

            }


            const color =
                fallbackColors[
                    fallbackIndex %
                    fallbackColors.length
                ];


            fallbackIndex++;


            return color;

        }



        /* =====================================================
           TREND TRANSAKSI
        ===================================================== */

        const trendCanvas =
            document.getElementById(
                'trendChart'
            );


        if (
            trendCanvas &&
            trendData &&
            trendData.length > 0
        ) {


            new Chart(

                trendCanvas,

                {

                    type:
                        'line',


                    data:
                    {

                        labels:

                            trendData.map(

                                function(item) {

                                    return item.bulan;

                                }

                            ),


                        datasets:
                        [

                            {

                                label:
                                    'Total Transaksi',


                                data:

                                    trendData.map(

                                        function(item) {

                                            return Number(
                                                item.total
                                            );

                                        }

                                    ),


                                borderColor:
                                    '#3B6EA5',


                                backgroundColor:
                                    'rgba(59, 110, 165, 0.10)',


                                borderWidth:
                                    2.5,


                                pointBackgroundColor:
                                    '#3B6EA5',


                                pointBorderColor:
                                    '#FFFFFF',


                                pointBorderWidth:
                                    2,


                                pointRadius:
                                    3.5,


                                pointHoverRadius:
                                    5,


                                tension:
                                    0.35,


                                fill:
                                    true

                            }

                        ]

                    },


                    options:
                    {

                        responsive:
                            true,


                        maintainAspectRatio:
                            false,


                        interaction:
                        {

                            intersect:
                                false,

                            mode:
                                'index'

                        },


                        plugins:
                        {

                            legend:
                            {

                                display:
                                    false

                            }

                        },


                        scales:
                        {

                            x:
                            {

                                grid:
                                {

                                    display:
                                        false

                                }

                            },


                            y:
                            {

                                beginAtZero:
                                    true,


                                grid:
                                {

                                    color:
                                        '#EDF1F4'

                                },


                                ticks:
                                {

                                    callback:

                                        function(value) {

                                            return Number(
                                                value
                                            ).toLocaleString(
                                                'id-ID'
                                            );

                                        }

                                }

                            }

                        }

                    }

                }

            );

        }



        /* =====================================================
           DISTRIBUSI CHANNEL
        ===================================================== */

        const channelCanvas =
            document.getElementById(
                'channelChart'
            );


        if (
            channelCanvas &&
            channelData &&
            channelData.length > 0
        ) {


            const channelLabels =

                channelData.map(

                    function(item) {

                        return item.channel;

                    }

                );


            const channelValues =

                channelData.map(

                    function(item) {

                        return Number(
                            item.total
                        );

                    }

                );


            const channelBackgroundColors =

                channelLabels.map(

                    function(channel) {

                        return getChannelColor(
                            channel
                        );

                    }

                );


            new Chart(

                channelCanvas,

                {

                    type:
                        'doughnut',


                    data:
                    {

                        labels:
                            channelLabels,


                        datasets:
                        [

                            {

                                data:
                                    channelValues,


                                backgroundColor:
                                    channelBackgroundColors,


                                borderColor:
                                    '#FFFFFF',


                                borderWidth:
                                    2

                            }

                        ]

                    },


                    options:
                    {

                        responsive:
                            true,


                        maintainAspectRatio:
                            false,


                        cutout:
                            '58%',


                        plugins:
                        {

                            legend:
                            {

                                position:
                                    'bottom',


                                labels:
                                {

                                    boxWidth:
                                        12,


                                    boxHeight:
                                        12,


                                    padding:
                                        10,


                                    font:
                                    {

                                        size:
                                            11

                                    }

                                }

                            },


                            tooltip:
                            {

                                callbacks:
                                {

                                    label:

                                        function(context) {

                                            const value =
                                                context.parsed;


                                            return (

                                                ' ' +

                                                context.label +

                                                ': ' +

                                                Number(
                                                    value
                                                ).toLocaleString(
                                                    'id-ID'
                                                )

                                            );

                                        }

                                }

                            }

                        }

                    }

                }

            );

        }



        /* =====================================================
           GRAFIK LAYANAN
        ===================================================== */

        const layananCanvas =
            document.getElementById(
                'layananChart'
            );


        if (
            layananCanvas &&
            layananData &&
            layananData.length > 0
        ) {


            new Chart(

                layananCanvas,

                {

                    type:
                        'bar',


                    data:
                    {

                        labels:

                            layananData.map(

                                function(item) {

                                    return item.layanan;

                                }

                            ),


                        datasets:
                        [

                            {

                                label:
                                    'Transaksi',


                                data:

                                    layananData.map(

                                        function(item) {

                                            return Number(
                                                item.total
                                            );

                                        }

                                    ),


                                backgroundColor:
                                    '#6F8FA8',


                                borderColor:
                                    '#5F7F99',


                                borderWidth:
                                    1,


                                borderRadius:
                                    5

                            }

                        ]

                    },


                    options:
                    {

                        responsive:
                            true,


                        maintainAspectRatio:
                            false,


                        plugins:
                        {

                            legend:
                            {

                                display:
                                    false

                            }

                        },


                        scales:
                        {

                            x:
                            {

                                grid:
                                {

                                    display:
                                        false

                                }

                            },


                            y:
                            {

                                beginAtZero:
                                    true,


                                grid:
                                {

                                    color:
                                        '#EDF1F4'

                                },


                                ticks:
                                {

                                    callback:

                                        function(value) {

                                            return Number(
                                                value
                                            ).toLocaleString(
                                                'id-ID'
                                            );

                                        }

                                }

                            }

                        }

                    }

                }

            );

        }



        /* =====================================================
           GRAFIK TIPE LAYANAN
        ===================================================== */

        const tipeCanvas =
            document.getElementById(
                'tipeChart'
            );


        if (
            tipeCanvas &&
            tipeData &&
            tipeData.length > 0
        ) {


            new Chart(

                tipeCanvas,

                {

                    type:
                        'bar',


                    data:
                    {

                        labels:

                            tipeData.map(

                                function(item) {

                                    return item.tipe_layanan;

                                }

                            ),


                        datasets:
                        [

                            {

                                label:
                                    'Transaksi',


                                data:

                                    tipeData.map(

                                        function(item) {

                                            return Number(
                                                item.total
                                            );

                                        }

                                    ),


                                backgroundColor:
                                    '#8DA6BA',


                                borderColor:
                                    '#7895AA',


                                borderWidth:
                                    1,


                                borderRadius:
                                    5

                            }

                        ]

                    },


                    options:
                    {

                        responsive:
                            true,


                        maintainAspectRatio:
                            false,


                        indexAxis:
                            'y',


                        plugins:
                        {

                            legend:
                            {

                                display:
                                    false

                            }

                        },


                        scales:
                        {

                            x:
                            {

                                beginAtZero:
                                    true,


                                grid:
                                {

                                    color:
                                        '#EDF1F4'

                                },


                                ticks:
                                {

                                    callback:

                                        function(value) {

                                            return Number(
                                                value
                                            ).toLocaleString(
                                                'id-ID'
                                            );

                                        }

                                }

                            },


                            y:
                            {

                                grid:
                                {

                                    display:
                                        false

                                }

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