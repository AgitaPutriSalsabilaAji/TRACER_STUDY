@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h4>Edit Alumni</h4></div>
        <div class="card-body">
            <form method="POST" action="{{ route('data-alumni.update', $alumni->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $alumni->nama }}" required>
                </div>
                <div class="form-group mb-3">
                    <label>Program Studi</label>
                    <input type="text" name="program_studi" class="form-control" value="{{ $alumni->program_studi }}" required>
                </div>
                <div class="form-group mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" value="{{ $alumni->nim }}" required>
                </div>
                <div class="form-group mb-3">
                    <label>Tanggal Lulus</label>
                    <input type="date" name="tanggal_lulus" class="form-control" value="{{ $alumni->tanggal_lulus }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('data-alumni.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
