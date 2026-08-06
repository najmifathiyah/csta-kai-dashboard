@extends('layouts.app')

@section('title','Tambah Divisi')

@section('content')

<h2>Tambah Divisi</h2>

<form action="{{ route('divisions.store') }}" method="POST">

    @csrf

    <div class="mb-3">
        <label>Kode Divisi</label>
        <input
            type="text"
            name="kode_divisi"
            class="form-control"
            required>
    </div>

    <div class="mb-3">
        <label>Nama Divisi</label>
        <input
            type="text"
            name="nama_divisi"
            class="form-control"
            required>
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea
            name="deskripsi"
            class="form-control"></textarea>
    </div>

    <button class="btn btn-success">
        Simpan
    </button>

</form>

@endsection