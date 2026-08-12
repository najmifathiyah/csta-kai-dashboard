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


                {{ number_format($data->jumlah_data) }}


            </p>



            {{-- ================================================== --}}
            {{-- LAYANAN --}}
            {{-- ================================================== --}}


            @if($data->layanan)


                <p class="text-muted mb-2">


                    Layanan :


                    <strong>


                        {{ $data->layanan }}


                    </strong>


                </p>


            @endif



            {{-- ================================================== --}}
            {{-- STATUS DATASET --}}
            {{-- ================================================== --}}


            <p class="mb-3">


                Status :


                @if($data->is_active)


                    <span class="badge bg-success">


                        Aktif


                    </span>


                @else


                    <span class="badge bg-secondary">


                        Arsip


                    </span>


                @endif


            </p>





            {{-- ================================================== --}}
            {{-- TOMBOL LIHAT DATA --}}
            {{-- ================================================== --}}


            <a
                href="{{ route(
                    'dataset.show',
                    [
                        'nama_file' => $data->nama_file,
                        'layanan' => request('layanan')
                    ]
                ) }}"

                class="btn btn-primary"
            >


                Lihat Data


            </a>



            {{-- ================================================== --}}
            {{-- TOMBOL HAPUS DATASET --}}
            {{-- ================================================== --}}


            <form
                action="{{ route(
                    'dataset.destroy',
                    $data->nama_file
                ) }}"

                method="POST"

                class="d-inline"

                onsubmit="return confirm(
                    'Yakin ingin menghapus dataset ini? Semua transaksi dari file ini juga akan dihapus.'
                );"
            >


                @csrf


                @method('DELETE')



                <button
                    type="submit"
                    class="btn btn-outline-danger"
                >


                    🗑️ Hapus


                </button>


            </form>




        </div>



    </div>



</div>



@endforeach




</div>



@endsection