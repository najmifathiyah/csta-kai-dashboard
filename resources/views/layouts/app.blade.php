<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
    @yield('title', 'Dashboard') - Dashboard KAI
</title>


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

    body {

        margin: 0;

        background-color: #f5f6f8;

        font-family: Arial, Helvetica, sans-serif;

    }


    /* ==================================================
       SIDEBAR
    ================================================== */

    .sidebar {

        width: 298px;

        min-height: 100vh;

        background-color: #212529;

        position: fixed;

        top: 0;

        left: 0;

        z-index: 1000;

    }


    .sidebar .nav-link {

        border-radius: 6px;

        padding: 10px 12px;

        transition: 0.2s;

    }


    .sidebar .nav-link:hover {

        background-color: rgba(255, 255, 255, 0.10);

    }


    /* ==================================================
       MAIN
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

    }


    /* ==================================================
       CONTENT
    ================================================== */

    .content-wrapper {

        padding: 32px;

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



<!-- ================================================== -->
<!-- SIDEBAR -->
<!-- ================================================== -->

<aside class="sidebar text-white">


    <!-- ==================================================
         LOGO / HEADER
    ================================================== -->

    <div class="p-3 text-center border-bottom">


        <h4 class="fw-bold mb-1">

            🚆 KAI Dashboard

        </h4>


        <small>

            Business Intelligence

        </small>


    </div>



    <!-- ==================================================
         MENU
    ================================================== -->

    <ul class="nav flex-column p-3">


        <!-- ==================================================
             DASHBOARD
        ================================================== -->

        <li class="nav-item mb-2">


            <a
                href="{{ route('dashboard') }}"
                class="nav-link text-white">


                <i class="bi bi-speedometer2 me-2"></i>


                Dashboard


            </a>


        </li>



        <!-- ==================================================
             DATA TRANSAKSI
        ================================================== -->

        <li class="nav-item mb-2">


            <a
                href="{{ route('dataset.index') }}"
                class="nav-link text-white">


                <i class="bi bi-table me-2"></i>


                Data Transaksi


            </a>


        </li>



        <!-- ==================================================
             IMPORT EXCEL
        ================================================== -->

        <li class="nav-item mb-2">


            <a
                href="{{ route('import.index') }}"
                class="nav-link text-white">


                <i class="bi bi-upload me-2"></i>


                Import Excel


            </a>


        </li>



        <!-- ==================================================
             PEMBATAS
        ================================================== -->

        <hr class="text-secondary">



        <!-- ==================================================
             LAYANAN
        ================================================== -->

        <li class="nav-item mb-2">


            <span class="nav-link text-white fw-bold">


                <i class="bi bi-grid me-2"></i>


                Layanan


            </span>


        </li>



        <!-- ==================================================
             TIKET KAI
        ================================================== -->

        <li class="nav-item mb-2">


            <a
                href="{{ route(
                    'layanan.index',
                    [
                        'layanan' => 'Tiket KAI'
                    ]
                ) }}"
                class="nav-link text-white">


                🚆 Tiket KAI


            </a>


        </li>



        <!-- ==================================================
             MITRA KAI GROUP
        ================================================== -->

        <li class="nav-item mb-2">


            <a
                href="{{ route(
                    'layanan.index',
                    [
                        'layanan' => 'Mitra KAI Group'
                    ]
                ) }}"
                class="nav-link text-white">


                🤝 Mitra KAI Group


            </a>


        </li>



        <!-- ==================================================
             MITRA NON KAI GROUP
        ================================================== -->

        <li class="nav-item mb-2">


            <a
                href="{{ route(
                    'layanan.index',
                    [
                        'layanan' => 'Mitra Non KAI Group'
                    ]
                ) }}"
                class="nav-link text-white">


                🏪 Mitra Non KAI Group


            </a>


        </li>


    </ul>


</aside>



<!-- ================================================== -->
<!-- MAIN CONTENT -->
<!-- ================================================== -->

<main class="main-content">


    <!-- ==================================================
         NAVBAR
    ================================================== -->

    <nav class="navbar navbar-expand-lg bg-white shadow-sm">


        <div class="container-fluid">


            <span class="navbar-brand fw-bold">


                Dashboard Monitoring Transaksi Unit CSTA KAI


            </span>


        </div>


    </nav>



    <!-- ==================================================
         PAGE CONTENT
    ================================================== -->

    <div class="content-wrapper">


        @yield('content')


    </div>


</main>



<!-- ================================================== -->
<!-- JAVASCRIPT -->
<!-- ================================================== -->


<!-- ==================================================
     jQuery
================================================== -->

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js">
</script>



<!-- ==================================================
     Bootstrap
================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>



<!-- ==================================================
     DataTables
================================================== -->

<script
    src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js">
</script>


<script
    src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js">
</script>



<!-- ==================================================
     CUSTOM SCRIPTS
================================================== -->

@stack('scripts')