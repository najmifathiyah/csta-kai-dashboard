@extends('layouts.app')

@section('title','Import Excel')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-7">

        <div class="card shadow">

            <div class="card-header bg-success text-white">

                <h4 class="mb-0">
                    📥 Import Data Transaksi
                </h4>

            </div>

            <div class="card-body">

                @if(session('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>

                @endif

                @if($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form
                    action="{{ route('import.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Pilih File Excel

                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control"
                            accept=".xlsx,.xls"
                            required>

                    </div>

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Mode Import

                        </label>

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="mode"
                                value="replace"
                                checked>

                            <label class="form-check-label">

                                <strong>Ganti Semua Data</strong>

                                <br>

                                <small class="text-muted">

                                    Menghapus seluruh data lama lalu mengimpor data baru.

                                </small>

                            </label>

                        </div>

                        <div class="form-check mt-2">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="mode"
                                value="append">

                            <label class="form-check-label">

                                <strong>Tambahkan Data</strong>

                                <br>

                                <small class="text-muted">

                                    Menambahkan data baru tanpa menghapus data lama.

                                </small>

                            </label>

                        </div>

                    </div>

                    <button class="btn btn-success">

                        📥 Import Excel

                    </button>

                    <a href="{{ route('transaksi.index') }}"
                       class="btn btn-secondary">

                        Kembali

                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection