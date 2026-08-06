@extends('layouts.app')

@section('title','Master Kategori')

@section('content')

<h2>Master Kategori</h2>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
    + Tambah Kategori
</a>

<table class="table table-bordered">

    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

    @forelse($categories as $category)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>{{ $category->kode_kategori }}</td>

        <td>{{ $category->nama_kategori }}</td>

        <td>

            <a href="{{ route('categories.edit', $category->id) }}"
               class="btn btn-warning btn-sm">
                Edit
            </a>

            <form action="{{ route('categories.destroy', $category->id) }}"
                  method="POST"
                  style="display:inline;">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                    Hapus
                </button>

            </form>

        </td>

    </tr>

    @empty

    <tr>
        <td colspan="4" class="text-center">
            Belum ada data kategori.
        </td>
    </tr>

    @endforelse

    </tbody>

</table>

@endsection