@extends('layouts.app')


@section('title','Data Transaksi')


@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">


    <h3 class="fw-bold">

        Data Transaksi Unit CSTA KAI

    </h3>



    <a href="{{ route('import.index') }}"
       class="btn btn-success">


        <i class="bi bi-upload"></i>

        Import Excel


    </a>


</div>





@if(session('success'))


<div class="alert alert-success">

    {{ session('success') }}

</div>


@endif






<!-- ================= FILTER CHANNEL ================= -->


<div class="card shadow-sm mb-4">


    <div class="card-body">



        <form method="GET">


            {{-- Menyimpan layanan agar tidak hilang --}}

            <input type="hidden"
                   name="layanan"
                   value="{{ request('layanan') }}">





            <div class="row">


                <div class="col-md-4">


                    <label class="fw-bold mb-2">

                        Pilih Channel

                    </label>





                    <select name="channel"

                            class="form-select"

                            onchange="this.form.submit()">





                        <option value="">


                            Semua Channel


                        </option>






                        @foreach($channels as $channel)





                        <option value="{{ $channel }}"


                        {{ request('channel') == $channel ? 'selected' : '' }}>



                            {{ $channel }}



                        </option>






                        @endforeach






                    </select>




                </div>



            </div>





        </form>




    </div>


</div>








<!-- ================= TABLE ================= -->


<div class="card shadow">


    <div class="card-body">



        <table

            id="datatable"

            class="table table-bordered table-striped table-hover align-middle">





            <thead class="table-dark">


                <tr>


                    <th>No</th>

                    <th>Periode</th>

                    <th>Layanan</th>

                    <th>Tipe Layanan</th>

                    <th>Channel</th>

                    <th>Transaksi</th>

                    <th>Pelanggan</th>

                    <th>Nilai Transaksi</th>

                    <th>Fee KAI</th>


                </tr>



            </thead>





            <tbody>




            @foreach($transaksis as $transaksi)





                <tr>



                    <td>

                        {{ $loop->iteration }}

                    </td>



                    <td>

                        {{ $transaksi->periode }}

                    </td>



                    <td>

                        {{ $transaksi->layanan }}

                    </td>



                    <td>

                        {{ $transaksi->tipe_layanan }}

                    </td>



                    <td>

                        {{ $transaksi->channel }}

                    </td>



                    <td>

                        {{ number_format($transaksi->transaksi) }}

                    </td>



                    <td>

                        {{ number_format($transaksi->jumlah_pelanggan) }}

                    </td>



                    <td>

                        Rp {{ number_format($transaksi->nilai_transaksi,0,',','.') }}

                    </td>



                    <td>

                        Rp {{ number_format($transaksi->fee_kai,0,',','.') }}

                    </td>




                </tr>





            @endforeach





            </tbody>




        </table>



    </div>


</div>





@endsection






@push('scripts')


<script>


$(document).ready(function(){


    $('#datatable').DataTable();


});



</script>


@endpush