@extends('layouts.app')

@section('title','Data Transaksi')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">
            Data Transaksi PT KAI Services
        </h3>

        <a href="{{ route('import.index') }}" class="btn btn-success">

            <i class="bi bi-upload"></i>

            Import Excel

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

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

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $transaksi->periode }}</td>

                        <td>{{ $transaksi->layanan }}</td>

                        <td>{{ $transaksi->tipe_layanan }}</td>

                        <td>{{ $transaksi->channel }}</td>

                        <td>{{ number_format($transaksi->transaksi) }}</td>

                        <td>{{ number_format($transaksi->jumlah_pelanggan) }}</td>

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

</div>

@endsection

@push('scripts')

<script>

$(document).ready(function(){

    $('#datatable').DataTable({

        responsive:true,

        pageLength:10,

        ordering:true,

        searching:true,

        lengthMenu:[
            [10,25,50,100],
            [10,25,50,100]
        ],

        language:{

            search:"🔍 Cari Data :",

            lengthMenu:"Tampilkan _MENU_ data",

            info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            zeroRecords:"Data tidak ditemukan",

            paginate:{
                previous:"← Sebelumnya",
                next:"Berikutnya →"
            }

        }

    });

});

</script>

@endpush