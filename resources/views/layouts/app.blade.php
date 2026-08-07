<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - Dashboard KAI</title>


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

</head>


<body class="bg-light">


<div class="container-fluid">

<div class="row">


<!-- ================= SIDEBAR ================= -->


<div class="col-md-2 bg-dark text-white min-vh-100 p-0">


    <div class="p-3 text-center border-bottom">

        <h4 class="fw-bold">
            🚆 KAI Dashboard
        </h4>

        <small>
            Business Intelligence
        </small>

    </div>



    <ul class="nav flex-column p-3">


        <!-- Dashboard -->

        <li class="nav-item mb-2">

            <a href="{{ route('dashboard') }}"
               class="nav-link text-white">

                <i class="bi bi-speedometer2 me-2"></i>

                Dashboard

            </a>

        </li>



        <!-- Data -->

        <li class="nav-item mb-2">

            <a href="{{ route('dataset.index') }}"
               class="nav-link text-white">

                <i class="bi bi-table me-2"></i>

                Data Transaksi

            </a>

        </li>



        <!-- Import -->

        <li class="nav-item mb-2">

            <a href="{{ route('import.index') }}"
               class="nav-link text-white">

                <i class="bi bi-upload me-2"></i>

                Import Excel

            </a>

        </li>



        <hr class="text-secondary">



        <!-- Layanan -->

        <li class="nav-item mb-2">

            <span class="nav-link text-white fw-bold">

                <i class="bi bi-grid me-2"></i>

                Layanan

            </span>

        </li>


        <li class="nav-item mb-2">

           <a href="{{ route('dataset.index',['layanan'=>'Tiket KAI']) }}"
   class="nav-link text-white">

    🚆 Tiket KAI

</a>

        </li>



        <li class="nav-item mb-2">

       <a href="{{ route('dataset.index',['layanan'=>'Mitra KAI Group']) }}"
   class="nav-link text-white">

    🤝 Mitra KAI Group

</a>

        </li>



        <li class="nav-item mb-2">

          <a href="{{ route('dataset.index',['layanan'=>'Mitra Non KAI Group']) }}"
   class="nav-link text-white">

    🏪 Mitra Non KAI Group

</a>

        </li>



    </ul>


</div>
<!-- ================= CONTENT ================= -->


<div class="col-md-10 p-0">


    <nav class="navbar navbar-expand-lg bg-white shadow-sm">


        <div class="container-fluid">


            <span class="navbar-brand fw-bold">

                Dashboard Monitoring Transaksi Unit CSTA KAI

            </span>


        </div>


    </nav>



    <div class="container-fluid p-4">


        @yield('content')


    </div>



</div>


</div>


</div>



<!-- JQuery -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>



<!-- DataTables -->

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>


<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>



<!-- Chart JS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</body>

</html>