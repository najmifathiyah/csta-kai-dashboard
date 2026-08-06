@extends('layouts.app')

@section('title','Edit Divisi')

@section('content')

<h2>Edit Divisi</h2>

<form action="{{ route('divisions.update',$division->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label>Kode Divisi</label>

        <input
            type="text"
            name="kode_divisi"
            class="form-control"
            value="{{ $division->kode_divisi }}"
            required>

    </div>

    <div class="mb-3">

        <label>Nama Divisi</label>

        <input
            type="text"
            name="nama_divisi"
            class="form-control"
            value="{{ $division->nama_divisi }}"
            required>

    </div>

    <div class="mb-3">

        <label>Deskripsi</label>

        <textarea
            name="deskripsi"
            class="form-control">{{ $division->deskripsi }}</textarea>

    </div>

    <button class="btn btn-success">

        Update

    </button>

    <a href="{{ route('divisions.index') }}"
       class="btn btn-secondary">

        Kembali

    </a>

</form>

@endsection