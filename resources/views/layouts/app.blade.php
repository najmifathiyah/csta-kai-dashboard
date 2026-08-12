<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - Dashboard KAI
    </title>


    <!-- ================================================== -->
    <!-- GOOGLE FONT -->
    <!-- ================================================== -->

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">


    <!-- ================================================== -->
    <!-- BOOTSTRAP -->
    <!-- ================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- ================================================== -->
    <!-- BOOTSTRAP ICONS -->
    <!-- ================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- ================================================== -->
    <!-- DATATABLES BOOTSTRAP 5 -->
    <!-- ================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">


    <!-- ================================================== -->
    <!-- STYLE -->
    <!-- ================================================== -->

    <style>

        /* ==================================================
           GLOBAL
        ================================================== */

        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }


        body {

            background-color: #f4f7fb;

            font-family:
                'Nunito',
                Arial,
                Helvetica,
                sans-serif;

            color: #172b4d;

        }


        /* ==================================================
           SIDEBAR
        ================================================== */

        .sidebar {

            width: 298px;

            min-height: 100vh;

            background:
                linear-gradient(
                    180deg,
                    #123f73 0%,
                    #174f8f 55%,
                    #123f73 100%
                );

            position: fixed;

            top: 0;

            left: 0;

            z-index: 1000;

            color: white;

            box-shadow:
                4px 0 18px
                rgba(18, 63, 115, 0.12);

        }


        /* ==================================================
           SIDEBAR HEADER
        ================================================== */

        .sidebar-header {

            padding:
                24px 18px 22px;

            text-align: center;

            border-bottom:
                1px solid
                rgba(255, 255, 255, 0.18);

        }


        .sidebar-logo {

            font-size: 25px;

            font-weight: 900;

            letter-spacing: -0.5px;

            margin: 0;

            color: #ffffff;

        }


        /* ==================================================
           SIDEBAR NAV
        ================================================== */

        .sidebar .nav {

            padding:
                20px 14px;

        }


        .sidebar .nav-link {

            color: #ffffff;

            border-radius: 12px;

            padding:
                12px 14px;

            margin-bottom: 5px;

            font-size: 16px;

            font-weight: 700;

            transition:
                all 0.2s ease;

            display: flex;

            align-items: center;

        }


        .sidebar .nav-link:hover {

            background-color:
                rgba(255, 255, 255, 0.13);

            transform:
                translateX(3px);

            color: #ffffff;

        }


        .sidebar .nav-link.active {

            background-color:
                rgba(255, 255, 255, 0.18);

            color: #ffffff;

            box-shadow:
                0 5px 14px
                rgba(0, 0, 0, 0.10);

        }


        .sidebar .nav-link i {

            font-size: 19px;

            min-width: 26px;

        }


        /* ==================================================
           PEMBATAS SIDEBAR
        ================================================== */

        .sidebar hr {

            margin:
                18px 8px;

            border-color:
                rgba(255, 255, 255, 0.18);

        }


        /* ==================================================
           JUDUL LAYANAN
        ================================================== */

        .sidebar .service-title {

            color: #ffffff;

            font-size: 17px;

            font-weight: 900;

            padding:
                10px 14px;

            margin-bottom: 5px;

        }


        .sidebar .service-title i {

            margin-right: 8px;

        }


        /* ==================================================
           MAIN CONTENT
        ================================================== */

        .main-content {

            margin-left: 298px;

            min-height: 100vh;

        }


        /* ==================================================
           NAVBAR
        ================================================== */

        .navbar {

            min-height: 84px;

            background-color:
                #ffffff !important;

            border-bottom:
                1px solid #e9eef5;

        }


        .navbar-brand {

            font-size: 22px;

            font-weight: 800;

            color: #123f73 !important;

            letter-spacing:
                -0.3px;

        }


        /* ==================================================
           CONTENT
        ================================================== */

        .content-wrapper {

            padding: 32px;

        }


        /* ==================================================
           CARD
        ================================================== */

        .card {

            border:
                1px solid #e8edf4;

            border-radius: 16px;

            box-shadow:
                0 5px 18px
                rgba(25, 55, 90, 0.06);

        }


        /* ==================================================
           BUTTON UTAMA
        ================================================== */

        .btn-primary {

            background-color:
                #2867a8;

            border-color:
                #2867a8;

            font-weight: 700;

            border-radius: 10px;

        }


        .btn-primary:hover {

            background-color:
                #20588f;

            border-color:
                #20588f;

        }


        /* ==================================================
           SELECT & INPUT
        ================================================== */

        .form-select,
        .form-control {

            border-radius: 10px;

            border-color:
                #d8e1ec;

            font-family:
                'Nunito',
                Arial,
                sans-serif;

        }


        .form-select:focus,
        .form-control:focus {

            border-color:
                #4b82b5;

            box-shadow:
                0 0 0 0.2rem
                rgba(40, 103, 168, 0.12);

        }


        /* ==================================================
           TABLE
        ================================================== */

        table {

            font-family:
                'Nunito',
                Arial,
                sans-serif;

        }


        table thead th {

            font-weight: 800;

        }


        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media (max-width: 992px) {

            .sidebar {

                width: 240px;

            }


            .main-content {

                margin-left: 240px;

            }

        }


        @media (max-width: 768px) {

            .sidebar {

                position: relative;

                width: 100%;

                min-height: auto;

            }


            .main-content {

                margin-left: 0;

            }


            .content-wrapper {

                padding: 20px;

            }

        }

    </style>


    @stack('styles')

</head>


<body>


<!-- ================================================== -->
<!-- SIDEBAR -->
<!-- ================================================== -->

<aside class="sidebar text-white">


    <!-- ================================================== -->
    <!-- LOGO / HEADER -->
    <!-- ================================================== -->

    <div class="sidebar-header">

        <h4 class="sidebar-logo">

            🚆 KAI Dashboard

        </h4>

    </div>


    <!-- ================================================== -->
    <!-- MENU -->
    <!-- ================================================== -->

    <ul class="nav flex-column">


        <!-- ================================================== -->
        <!-- DASHBOARD -->
        <!-- ================================================== -->

        <li class="nav-item">

            <a
                href="{{ route('dashboard') }}"

                class="nav-link
                {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >

                <i class="bi bi-speedometer2 me-2"></i>

                Dashboard

            </a>

        </li>


        <!-- ================================================== -->
        <!-- DATA TRANSAKSI -->
        <!-- ================================================== -->

        <li class="nav-item">

            <a
                href="{{ route('dataset.index') }}"

                class="nav-link
                {{ request()->routeIs('dataset.*') ? 'active' : '' }}"
            >

                <i class="bi bi-table me-2"></i>

                Data Transaksi

            </a>

        </li>


        <!-- ================================================== -->
        <!-- IMPORT EXCEL -->
        <!-- ================================================== -->

        <li class="nav-item">

            <a
                href="{{ route('import.index') }}"

                class="nav-link
                {{ request()->routeIs('import.*') ? 'active' : '' }}"
            >

                <i class="bi bi-upload me-2"></i>

                Import Excel

            </a>

        </li>


        <!-- ================================================== -->
        <!-- PEMBATAS -->
        <!-- ================================================== -->

        <hr class="text-secondary">


        <!-- ================================================== -->
        <!-- LAYANAN -->
        <!-- ================================================== -->

        <li class="nav-item">

            <div class="service-title">

                <i class="bi bi-grid"></i>

                Layanan

            </div>

        </li>


        <!-- ================================================== -->
        <!-- TIKET KAI -->
        <!-- ================================================== -->

        <li class="nav-item">

            <a
                href="{{ route('dashboard.tiket') }}"

                class="nav-link"
            >

                🚆

                <span class="ms-2">

                    Tiket KAI

                </span>

            </a>

        </li>


        <!-- ================================================== -->
        <!-- MITRA KAI GROUP -->
        <!-- ================================================== -->

        <li class="nav-item">

            <a
                href="{{ route('dashboard.mitra') }}"

                class="nav-link"
            >

                🤝

                <span class="ms-2">

                    Mitra KAI Group

                </span>

            </a>

        </li>


        <!-- ================================================== -->
        <!-- MITRA NON KAI GROUP -->
        <!-- ================================================== -->

        <li class="nav-item">

            <a
                href="{{ route('dashboard.mitra.non') }}"

                class="nav-link"
            >

                🏪

                <span class="ms-2">

                    Mitra Non KAI Group

                </span>

            </a>

        </li>


    </ul>

</aside>



<!-- ================================================== -->
<!-- MAIN CONTENT -->
<!-- ================================================== -->

<main class="main-content">


    <!-- ================================================== -->
    <!-- NAVBAR -->
    <!-- ================================================== -->

    <nav class="navbar navbar-expand-lg shadow-sm">


        <div class="container-fluid">


            <span class="navbar-brand fw-bold">

                Dashboard Monitoring Transaksi Unit CSTA KAI

            </span>


        </div>

    </nav>


    <!-- ================================================== -->
    <!-- PAGE CONTENT -->
    <!-- ================================================== -->

    <div class="content-wrapper">

        @yield('content')

    </div>


</main>



<!-- ================================================== -->
<!-- JAVASCRIPT -->
<!-- ================================================== -->


<!-- jQuery -->

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js">
</script>


<!-- Bootstrap -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>


<!-- DataTables -->

<script
    src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js">
</script>


<script
    src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js">
</script>


<!-- Custom Scripts -->

@stack('scripts')


</body>

</html>