@extends('layouts.app')

@section('content')
<div class="container my-4">
  <div class="card">
    <div class="card-header bg-primary text-white">Form Data Alumni</div>
    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

      <form action="{{ route('alumni.store') }}" method="POST">
        @csrf
        <div class="row g-4">
          <!-- Kolom Kiri -->
          <div class="col-md-6">
            <x-form.text name="nama" label="Nama/NIM" :value="old('nama')" />
            <x-form.select name="prodi" label="Program Studi" :options="['Sistem Informasi Bisnis' => 'D-IV Sistem Informasi Bisnis', 'Teknik Informatika' => 'D-IV Teknik Informatika']" :selected="old('prodi')" />
            <x-form.select name="tahun" label="Tahun Lulus" :options="$tahunLulus" :selected="old('tahun')" />
            <x-form.text name="no_hp" label="No. HP" :value="old('no_hp')" />
            <x-form.email name="email" label="Email" :value="old('email')" />
            <x-form.date name="tgl_pertama_kerja" label="Tanggal Pertama Kerja" :value="old('tgl_pertama_kerja')" />
            <x-form.date name="tgl_instansi" label="Tanggal Mulai Kerja pada Instansi Saat Ini" :value="old('tgl_instansi')" />
          </div>

          <!-- Kolom Kanan -->
          <div class="col-md-6">
            <x-form.text name="jenis_instansi" label="Jenis Instansi" :value="old('jenis_instansi')" />
            <x-form.text name="nama_instansi" label="Nama Instansi" :value="old('nama_instansi')" />
            <x-form.select name="skala_instansi" label="Skala Instansi" :options="['Multinasional/Internasional' => 'Multinasional/Internasional', 'Nasional' => 'Nasional', 'Wirausaha' => 'Wirausaha']" :selected="old('skala_instansi')" />
            <x-form.text name="lokasi_instansi" label="Lokasi Instansi" :value="old('lokasi_instansi')" />
            <x-form.select name="kategori" label="Kategori Profesi" :options="['Developer/Programmer/Software Engineer' => 'Developer/Programmer/Software Engineer']" :selected="old('kategori')" />
            <x-form.text name="profesi" label="Profesi" :value="old('profesi')" />
            <div class="text-end">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
