@extends('layouts.headerguest')

@section('content')
<div class="container-fluid bg-siluet py-5">
    <div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('alert'))
        <div class="alert alert-danger">{{ session('alert') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-warning">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow" data-aos="fade-up">
        <div class="card-body">
            <form method="POST" action="{{ route('submit.atasan') }}">
                @csrf
                 <div class="card-header bg-primary text-white">
                Form Survei Kepuasan Pengguna Alumni
            </div>

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label for="nama_surveyor" class="form-label"><i class="bi bi-person-fill me-1"></i>Nama Surveyor</label>
                        <input type="text" class="form-control" id="nama_surveyor" name="nama_surveyor" required>
                    </div>
                    <div class="col-md-6">
                        <label for="instansi" class="form-label"><i class="bi bi-building me-1"></i>Instansi</label>
                        <input type="text" class="form-control" id="instansi" name="instansi" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jabatan" class="form-label"><i class="bi bi-briefcase-fill me-1"></i>Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label"><i class="bi bi-envelope-fill me-1"></i>Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                <div class="mb-3 position-relative">
                    <label for="nama_alumni" class="form-label"><i class="bi bi-search me-1"></i>Data Alumni</label>
                    <input type="text" class="form-control" id="nama_alumni" name="nama_alumni" autocomplete="off" required>
                    <input type="hidden" id="alumni_id" name="alumni_id">
                    <div id="nama-error" class="text-danger mt-1" style="display: none;">Nama alumni tidak valid.</div>
                </div>

                <hr>
                <h5 class="mb-3">Penilaian Kompetensi Alumni</h5>

                @php
                    $pertanyaan = [
                        'kerjasama_tim' => 'Kerjasama Tim',
                        'keahlian_di_bidang_ti' => 'Keahlian di bidang IT',
                        'pengembangan_diri' => 'Kemampuan mengembangkan diri',
                        'kepemimpinan' => 'Kemampuan kepemimpinan',
                        'kemampuan_bahasa_asing' => 'Kemampuan bahasa asing',
                        'kemampuan_komunikasi' => 'Kemampuan komunikasi',
                        'etos_kerja' => 'Etos kerja'
                    ];

                    $emojis = [
                        '1' => ['icon' => '😞', 'label' => 'Kurang'],
                        '2' => ['icon' => '😐', 'label' => 'Cukup'],
                        '3' => ['icon' => '🙂', 'label' => 'Baik'],
                        '4' => ['icon' => '😃', 'label' => 'Sangat Baik']
                    ];

                    $layout = [3, 3, 3];
                    $pertanyaan_keys = array_keys($pertanyaan);
                    $index = 0;
                @endphp

                @foreach($layout as $cols)
                    <div class="row mb-4">
                        @for($i=0; $i<$cols; $i++)
                            @php
                                if(!isset($pertanyaan_keys[$index])) break;
                                $key = $pertanyaan_keys[$index];
                                $label = $pertanyaan[$key];
                                $index++;
                            @endphp
                            <div class="col-md-6 col-lg-{{ 12 / $cols }} mb-3">
                                <label class="form-label">{{ $label }}</label>
                                <div class="d-flex gap-3 justify-content-center">
                                    @foreach($emojis as $value => $data)
                                        <div class="text-center">
                                            <input type="radio" id="{{ $key }}_{{ $value }}" name="{{ $key }}" value="{{ $value }}" class="d-none" required>
                                            <label for="{{ $key }}_{{ $value }}" class="emoji-label d-block">{{ $data['icon'] }}</label>
                                            <small class="d-block">{{ $data['label'] }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endfor
                    </div>
                @endforeach

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-x-circle me-1"></i>Kompetensi yang Belum Terpenuhi</label>
                    <textarea name="kompetensi_belum_terpenuhi" class="form-control" rows="3" placeholder="Opsional"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-lightbulb-fill me-1"></i>Saran untuk Kurikulum Kami</label>
                    <textarea name="saran_kurikulum" class="form-control" rows="3" placeholder="Opsional"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send-fill me-1"></i>Kirim Survei
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Styles --}}
 <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
    .bg-siluet {
        background: radial-gradient(circle at top right, #bad0fc 0%, #ffffff 40%, #ffffff 100%);
        min-height: 100vh;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }

    .card {
        background-color: white;
        border-radius: 1rem;
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .emoji-label {
        font-size: 2rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: gray;
    }

    .emoji-label:hover {
        transform: scale(1.3);
        color: #007bff;
    }

    input[type="radio"].d-none:checked + .emoji-label {
        color: #28a745;
        transform: scale(1.5);
    }

    input.form-control:focus, textarea.form-control:focus {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
        border-color: #80bdff;
    }

    .card:hover {
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        transition: box-shadow 0.3s ease-in-out;
    }
    .form-label i.bi {
    color: #0d6efd;
}

.form-label i.bi {
    color: #0d6efd; /* warna biru bootstrap */
}


</style>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();

    $(function () {
        let validName = false;

        $('#nama_alumni').on('keyup', function () {
            const query = $(this).val();
            $('#alumni_id').val('');
            validName = false;
            $('.list-group').remove();
            $('#nama-error').hide();

            if (query.length >= 3) {
                $.ajax({
                    url: "{{ route('autocomplete.atasan') }}",
                    type: "GET",
                    data: { q: query },
                    success: function(data) {
                        if (data.length > 0) {
                            let dropdown = '<ul class="list-group position-absolute w-100" style="z-index:1000;">';
                            data.forEach(item => {
                                dropdown += `<li class="list-group-item" data-id="${item.id}">${item.text}</li>`;
                            });
                            dropdown += '</ul>';
                            $('#nama_alumni').after(dropdown);

                            $('.list-group-item').on('click', function () {
                                const selectedText = $(this).text();
                                const selectedId = $(this).data('id');
                                $('#nama_alumni').val(selectedText);
                                $('#alumni_id').val(selectedId);
                                validName = true;
                                $('.list-group').remove();
                                $('#nama-error').hide();
                            });
                        } else {
                            $('#nama-error').text('Alumni tidak ditemukan.').show();
                        }
                    }
                });
            }
        });

        $('form').submit(function (e) {
            if (!validName || !$('#alumni_id').val()) {
                e.preventDefault();
                $('#nama-error').text('Silakan pilih alumni dari daftar.').show();
                $('#nama_alumni').addClass('is-invalid');
            }
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('#nama_alumni').length) {
                $('.list-group').remove();
            }
        });
    });
</script>

@include('layouts.footerguest')
@endsection
