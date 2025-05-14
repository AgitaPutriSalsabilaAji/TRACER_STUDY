@extends('layouts.app') {{-- Pastikan layout utama ada di layouts/app.blade.php --}}

@section('title', 'Form Alumni')

@section('content')
<style>
    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 1000px;
        margin: auto;
    }

    .form-header {
        background-color: #0d6efd;
        color: white;
        padding: 15px 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        font-size: 18px;
        font-weight: bold;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .form-group {
        flex: 1 1 45%;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
    }

    input, select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
</style>

<div class="card" id="form-data">
    <div class="card-header">Data</div>
    <div class="form-group"><br>
        <label>Nama Alumni:</label>
        <input type="text" name="nama">
    </div>
    <div class="form-group">
        <label>Jabatan Alumni:</label>
        <input type="text" name="jabatan">
    </div>
    <div class="form-group">
        <label>No Telp:</label>
        <input type="text" name="telepon">
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email">
    </div>
    <div class="form-group">
        <label>Nama Alumni:</label>
        <input type="text" name="nama_ulang">
    </div>
    <button onclick="showSurvey()">Next</button>
</div>

<div class="card" id="form-survey" style="display: none;">
    <div class="card-header" style="background-color: #4CAF50;">Survey Kepuasan Atasan</div>

    @php
        $aspek = [
            'kerjasama' => 'Kerjasama Tim',
            'kualitas' => 'Kualitas',
            'pengembangan' => 'Pengembangan Diri',
            'kepemimpinan' => 'Kepemimpinan',
            'bahasa' => 'Kemampuan Berbahasa Asing',
            'komunikasi' => 'Kemampuan Berkomunikasi',
            'etos' => 'Etos Kerja'
        ];
        $nilai = [
            1 => ['icon' => '😟', 'text' => 'Kurang'],
            2 => ['icon' => '😐', 'text' => 'Cukup'],
            3 => ['icon' => '🙂', 'text' => 'Baik'],
            4 => ['icon' => '😄', 'text' => 'Sangat Baik']
        ];
    @endphp

    <div style="display: flex; flex-wrap: wrap; gap: 30px;">
        @foreach ($aspek as $name => $label)
        <div>
            <label>{{ $label }}</label>
            <div class="rating-group">
                @foreach ($nilai as $val => $data)
                    <label>
                        <input type="radio" name="{{ $name }}" value="{{ $val }}">
                        <span class="emoji">{{ $data['icon'] }}</span>
                        <div>{{ $data['text'] }}</div>
                    </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <div class="form-group mt-3">
        <label>Kompetensi yang dibutuhkan tapi belum dapat dipenuhi</label>
        <textarea name="kompetensi" rows="3" placeholder="Kompetensi yang dibutuhkan tapi belum dapat dipenuhi"></textarea>
    </div>

    <div class="form-group">
        <label>Saran untuk kurikulum program studi</label>
        <textarea name="saran" rows="3" placeholder="Saran untuk kurikulum program studi"></textarea>
    </div>

    <button type="submit">Save</button>
</div>

<script>
    function showSurvey() {
        document.getElementById('form-data').style.display = 'none';
        document.getElementById('form-survey').style.display = 'block';
    }
</script>
@endsection
