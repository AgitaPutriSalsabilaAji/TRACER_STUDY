@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h4>Tambah Alumni</h4></div>
        <div class="card-body">
            <form method="POST" action="{{ route('alumni.store') }}">
                @csrf
                <div class="form-group mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label>Program Studi</label>
                    <input type="text" name="program_studi" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label>Tanggal Lulus</label>
                    <input type="date" name="tanggal_lulus" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('data-alumni.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
