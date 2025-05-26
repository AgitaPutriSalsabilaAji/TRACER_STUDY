@extends('layouts.template')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 white">
                    <h1>Data Alumni</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Alumni</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('data-alumni.create') }}" class="btn btn-sm btn-success mt-1">Tambah Alumni</a>
            </div>
        </div>

        <div class="card-body">
            <h4>Daftar Alumni</h4>

            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped w-100">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>NIM</th>
                            <th>Tanggal Lulus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumni as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->programStudi->program_studi ?? '-' }}</td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('data-alumni.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('data-alumni.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus alumni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                        @if($alumni->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">Data alumni belum ada.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
