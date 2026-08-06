@extends('layouts.app')

@section('title','Edit Kategori')

@section('content')

<h2>Edit Kategori</h2>

<form action="{{ route('categories.update', $category->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label>Kode Kategori</label>

        <input
            type="text"
            name="kode_kategori"
            class="form-control"
            value="{{ $category->kode_kategori }}"
            required>

    </div>

    <div class="mb-3">

        <label>Nama Kategori</label>

        <input
            type="text"
            name="nama_kategori"
            class="form-control"
            value="{{ $category->nama_kategori }}"
            required>

    </div>

    <button class="btn btn-success">
        Update
    </button>

    <a href="{{ route('categories.index') }}"
       class="btn btn-secondary">
        Kembali
    </a>

</form>

@endsection