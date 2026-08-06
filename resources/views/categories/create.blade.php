@extends('layouts.app')

@section('title','Tambah Kategori')

@section('content')

<h2>Tambah Kategori</h2>

<form action="{{ route('categories.store') }}" method="POST">

    @csrf

    <div class="mb-3">
        <label>Kode Kategori</label>
        <input
            type="text"
            name="kode_kategori"
            class="form-control"
            required>
    </div>

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input
            type="text"
            name="nama_kategori"
            class="form-control"
            required>
    </div>

    <button class="btn btn-success">
        Simpan
    </button>

    <a href="{{ route('categories.index') }}"
       class="btn btn-secondary">
        Kembali
    </a>

</form>

@endsection