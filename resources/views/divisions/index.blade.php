@extends('layouts.app')

@section('title','Master Divisi')

@section('content')

<h2>Master Divisi</h2>
@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<a href="/divisions/create" class="btn btn-primary mb-3">
    + Tambah Divisi
</a>

<table class="table table-bordered">

    <thead>

        <tr>

            <th>No</th>

            <th>Kode</th>

            <th>Nama Divisi</th>

            <th>Deskripsi</th>

            <th>Aksi</th>

        </tr>

    </thead>
<tbody>

@forelse($divisions as $division)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $division->kode_divisi }}</td>

    <td>{{ $division->nama_divisi }}</td>

    <td>{{ $division->deskripsi }}</td>

    <td>

        <a href="{{ route('divisions.edit',$division->id) }}"
   class="btn btn-warning btn-sm">
    Edit
</a>

        <form action="{{ route('divisions.destroy', $division->id) }}"
      method="POST"
      style="display:inline;">

    @csrf
    @method('DELETE')

    <button
        class="btn btn-danger btn-sm"
        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">

        Hapus

    </button>

</form>

    </td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center">

Belum ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

@endsection