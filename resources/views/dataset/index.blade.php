@extends('layouts.app')


@section('title','Pilih Data Transaksi')


@section('content')


<h3 class="fw-bold mb-4">

    Pilih Dataset Transaksi

    @if(request('layanan'))

        - {{ request('layanan') }}

    @endif

</h3>




<div class="row">


@foreach($datasets as $data)


<div class="col-md-4 mb-4">


    <div class="card shadow h-100">


        <div class="card-body">


            <h5 class="fw-bold">

                📄 {{ $data->nama_file }}

            </h5>




            <p class="text-muted">

                Jumlah Data :

                {{ $data->jumlah }}

            </p>





            <a href="{{ route('dataset.show',
                [
                    'nama_file'=>$data->nama_file,
                    'layanan'=>request('layanan')
                ]
            ) }}"
            
            class="btn btn-primary">


                Lihat Data


            </a>



        </div>


    </div>


</div>


@endforeach



</div>


@endsection