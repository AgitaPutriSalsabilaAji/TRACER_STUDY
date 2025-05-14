@extends('layouts.app')

@section('title', 'Form Atasan untuk Alumni')

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
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
    }

    input, select, textarea {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .rating-group label {
        display: inline-block;
        margin-right: 10px;
        text-align: center;
    }

    .emoji {
        font-size: 20px;
        display: block;
    }
</style>

@if(session('success'))
    <div style="background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('tracer-alumni.store') }}" method="POST">
    @csrf

    <div class="card" id="form-data">
        <div class="card-header">Data Alumni</div>
        <div class="form-group"><br>
            <label>Nama Alumni:</label>
            <input type="text" name="nama" required>
        </div>
        <div class="form-group">
            <label>Jabatan Alumni:</label>
            <input type="text" name="jabatan" required>
        </div>
        <div class="form-group">
            <label>No Telp:</label>
            <input type="text" name="telepon" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <button type="button" onclick="showSurvey()" style="margin-top: 20px;">Next</button>
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
                            <input type="radio" name="{{ $name }}" value="{{ $val }}" required>
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

        <button type="submit" style="margin-top: 20px;">Save</button>
    </div>
</form>

<script>
    function showSurvey() {
        document.getElementById('form-data').style.display = 'none';
        document.getElementById('form-survey').style.display = 'block';
    }
</script>
@endsection
