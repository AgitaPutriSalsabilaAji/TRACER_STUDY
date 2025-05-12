@extends('layouts.headerguest')

@section('content')
<div class="container my-4" id="data-alumni">
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

      <form id="alumni-form" action="{{ route('submit.alumni') }}" method="POST">
        @csrf
        <div class="row g-4">
          <!-- Kolom Kiri -->
          <div class="col-md-6">
            <x-form-group type="text" name="nama" label="Nama/NIM" />
            <x-form-group type="select" name="prodi" label="Program Studi" :options="['Sistem Informasi Bisnis' => 'D-IV Sistem Informasi Bisnis', 'Teknik Informatika' => 'D-IV Teknik Informatika']" />
            <x-form-group type="select" name="tahun" label="Tahun Lulus" :options="$tahunLulus" />
            <x-form-group type="text" name="no_hp" label="No. HP" />
            <x-form-group type="email" name="email" label="Email" />
            <x-form-group type="date" name="tgl_pertama_kerja" label="Tanggal Pertama Kerja" />
            <x-form-group type="date" name="tgl_instansi" label="Tanggal Mulai Kerja pada Instansi Saat Ini" />
          </div>

          <!-- Kolom Kanan -->
          <div class="col-md-6">
            <x-form-group type="text" name="jenis_instansi" label="Jenis Instansi" />
            <x-form-group type="text" name="nama_instansi" label="Nama Instansi" />
            <x-form-group type="select" name="skala_instansi" label="Skala Instansi" :options="['Multinasional/Internasional' => 'Multinasional/Internasional', 'Nasional' => 'Nasional', 'Wirausaha' => 'Wirausaha']" />
            <x-form-group type="text" name="lokasi_instansi" label="Lokasi Instansi" />
            <x-form-group type="select" name="kategori" label="Kategori Profesi" :options="['Developer/Programmer/Software Engineer' => 'Developer/Programmer/Software Engineer']" />
            <x-form-group type="text" name="profesi" label="Profesi" />

            <!-- Menambahkan bagian survei -->
            <div class="col-12 mt-4">
              <h5>Isi Survei</h5>
              <x-form-group type="textarea" name="feedback" label="Saran untuk Program Studi" />
              <x-form-group type="textarea" name="survei" label="Feedback Umum" />
              <x-form-group type="radio" name="kepuasan" label="Tingkat Kepuasan" :options="['Sangat Puas' => 'Sangat Puas', 'Puas' => 'Puas', 'Tidak Puas' => 'Tidak Puas']" />
            </div>

            <div class="text-end mt-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
