@extends('layouts.headerguest')

@section('content')
    <div class="container-fluid bg-siluet py-5">
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('alert'))
                <div class="alert alert-danger">{{ session('alert') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-warning">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <style>
                .list-group-item {
                    cursor: pointer;
                }

                .card-header-custom {
                    background: linear-gradient(45deg, #1685fc, #3d8adc);
                    color: white;
                    font-size: 1.5rem;
                    font-weight: bold;
                    text-align: center;
                    padding: 1rem;
                    border-radius: 0.5rem 0.5rem 0 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 0.5rem;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .card-header-custom i {
                    font-size: 1.7rem;
                }
            </style>

            <form id="atasanForm">
                @csrf
                <div class="modal" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel"
                    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="validationModalLabel">Validasi Atasan</h5>
                            </div>

                            <div class="modal-body">
                                <p class="text-center mb-3">
                                    <strong>Mohon masukan token yang sudah dikirimkan ke email Anda</strong>
                                </p>

                                <div class="mb-3">
                                    <label for="key" class="form-label">Token</label>
                                    <input type="text" id="key" name="key" class="form-control"
                                        placeholder="Masukkan Token" required>
                                    <div class="invalid-feedback" id="key-error"></div>
                                </div>

                                <div class="alert alert-danger d-none" id="general-error"></div>
                                <div class="alert alert-success d-none" id="success-alert">Validasi berhasil!</div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="history.back()">Kembali</button>
                                <button type="submit" id="submitAtasan" class="btn btn-primary">Lanjut</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <div class="container my-4">
                <div class="card shadow">
                    <div class="card-header card-header-custom">
                        <i class="fas fa-user-tie"></i>
                        <!-- Ikon dari Font Awesome -->
                        Form Survei Kepuasan Alumni
                    </div>
                    <br>


                    <div class="card shadow" data-aos="fade-up">
                        <div class="card-body">
                            <form method="POST" id="form-atasan" action="{{ route('submit.atasan') }}">
                                @csrf


                                <div class="row mb-3 mt-3">
                                    <div class="col-md-6">
                                        <label for="nama_surveyor" class="form-label"><i
                                                class="bi bi-person-lines-fill"></i> Nama Surveyor</label>
                                        <input type="text" class="form-control" id="nama_surveyor" name="nama_surveyor"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="instansi" class="form-label"><i
                                                class="bi bi-building me-1"></i>Instansi</label>
                                        <input type="text" class="form-control" id="instansi" name="instansi" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="jabatan" class="form-label"><i class="bi bi-person-vcard"></i>
                                            Jabatan</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label"><i class="bi bi-envelope"></i>
                                            Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <label for="nama_alumni" class="form-label"><i class="bi bi-search me-1"></i>Data
                                        Alumni</label>
                                    </label>
                                    <input type="text" class="form-control" id="nama_alumni" name="nama_alumni"
                                        value="{{ $nama ?? '' }}" readonly>
                                    <input type="hidden" name="alumni_id" id="alumni_id" value="{{ $alumni_id ?? '' }}">
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
                                        'etos_kerja' => 'Etos kerja',
                                    ];

                                    $emojis = [
                                        '1' => ['icon' => '😞', 'label' => 'Kurang'],
                                        '2' => ['icon' => '😐', 'label' => 'Cukup'],
                                        '3' => ['icon' => '🙂', 'label' => 'Baik'],
                                        '4' => ['icon' => '😃', 'label' => 'Sangat Baik'],
                                    ];

                                    $layout = [3, 3, 3];
                                    $pertanyaan_keys = array_keys($pertanyaan);
                                    $index = 0;
                                @endphp

                                @foreach ($layout as $cols)
                                    <div class="row mb-4">
                                        @for ($i = 0; $i < $cols; $i++)
                                            @php
                                                if (!isset($pertanyaan_keys[$index])) {
                                                    break;
                                                }
                                                $key = $pertanyaan_keys[$index];
                                                $label = $pertanyaan[$key];
                                                $index++;
                                            @endphp
                                            <div class="col-md-6 col-lg-{{ 12 / $cols }} mb-3">
                                                <label class="form-label">{{ $label }}</label>
                                                <div class="d-flex gap-3 justify-content-center">
                                                    @foreach ($emojis as $value => $data)
                                                        <div class="text-center">
                                                            <input type="radio"
                                                                id="{{ $key }}_{{ $value }}"
                                                                name="{{ $key }}" value="{{ $value }}"
                                                                class="d-none" required>
                                                            <label for="{{ $key }}_{{ $value }}"
                                                                class="emoji-label d-block">{{ $data['icon'] }}</label>
                                                            <small class="d-block">{{ $data['label'] }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                @endforeach

                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-x-circle me-1"></i>Kompetensi yang Belum
                                        Terpenuhi</label>
                                    <textarea name="kompetensi_belum_terpenuhi" class="form-control" rows="3" placeholder="Opsional"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="bi bi-lightbulb-fill me-1"></i>Saran untuk
                                        Kurikulum Kami</label>
                                    <textarea name="saran_kurikulum" class="form-control" rows="3" placeholder="Opsional"></textarea>
                                </div>
                                <div class="my-3">
                                    {!! NoCaptcha::display() !!}
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send-fill me-1"></i>kirim survei
                                </button>
                            </form>
                            {!! NoCaptcha::renderJs() !!}
                        </div>
                    </div>
                </div>

                {{-- Styles --}}
                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
                    rel="stylesheet" />
                <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

                    input[type="radio"].d-none:checked+.emoji-label {
                        color: #28a745;
                        transform: scale(1.5);
                    }

                    input.form-control:focus,
                    textarea.form-control:focus {
                        box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
                        border-color: #80bdff;
                    }

                    .card:hover {
                        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                        transition: box-shadow 0.3s ease-in-out;
                    }

                    .form-label i.bi {
                        color: #0d6efd;
                    }

                    .form-label i.bi {
                        color: #0d6efd;
                        /* warna biru bootstrap */
                    }
                </style>

                {{-- Scripts --}}
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
                <script>
                    AOS.init();

                    $(function() {
                        let validName = false;

                        $('#nama_alumni').on('keyup', function() {
                            const query = $(this).val();
                            $('#alumni_id').val('');
                            validName = false;
                            $('.list-group').remove();
                            $('#nama-error').hide();

                            if (query.length >= 3) {
                                $.ajax({
                                    url: "{{ route('autocomplete.atasan') }}",
                                    type: "GET",
                                    data: {
                                        q: query
                                    },
                                    success: function(data) {
                                        if (data.length > 0) {
                                            let dropdown =
                                                '<ul class="list-group position-absolute w-100" style="z-index:1000;">';
                                            data.forEach(item => {
                                                dropdown +=
                                                    `<li class="list-group-item" data-id="${item.id}">${item.text}</li>`;
                                            });
                                            dropdown += '</ul>';
                                            $('#nama_alumni').after(dropdown);

                                            $('.list-group-item').on('click', function() {
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

                        $('form').submit(function(e) {
                            if (!validName || !$('#alumni_id').val()) {
                                e.preventDefault();
                                $('#nama-error').text('Silakan pilih alumni dari daftar.').show();
                                $('#nama_alumni').addClass('is-invalid');
                            }
                        });

                        $(document).on('click', function(e) {
                            if (!$(e.target).closest('#nama_alumni').length) {
                                $('.list-group').remove();
                            }
                        });
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        @if (!$validated)
                            const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
                            validationModal.show();
                        @endif
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Bootstrap modal instance
                        const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));

                        const form = document.getElementById('atasanForm');
                        const submitBtn = document.getElementById('submitAtasan');

                        // Input dan error elemen
                        const inputs = {
                            key: document.getElementById('key'),
                        };

                        const errors = {

                            key: document.getElementById('key-error'),
                            general: document.getElementById('general-error'),
                            success: document.getElementById('success-alert'),
                        };

                        function clearErrors() {
                            errors.general.classList.add('d-none');
                            errors.success.classList.add('d-none');
                            Object.keys(inputs).forEach(key => {
                                inputs[key].classList.remove('is-invalid');
                                errors[key].textContent = '';
                            });
                        }

                        function showGeneralError(msg) {
                            errors.general.textContent = msg;
                            errors.general.classList.remove('d-none');
                        }

                        form.addEventListener('submit', function(e) {
                            e.preventDefault();

                            clearErrors();

                            // Disable tombol dan ubah text
                            submitBtn.disabled = true;
                            submitBtn.innerText = 'Memeriksa...';

                            const formData = new FormData(form);

                            axios.post('{{ route('validate.atasan') }}', formData)
                                .then(response => {
                                    if (response.data.success) {
                                        errors.success.classList.remove('d-none');
                                        // Sembunyikan modal setelah 1 detik
                                        setTimeout(() => {
                                            validationModal.hide();
                                            // Redirect ke halaman form alumni sebenarnya atau submit form biasa:
                                            window.location.href = '{{ route('form.atasan') }}';
                                        }, 1000);
                                    } else {
                                        showGeneralError(response.data.message || 'Validasi gagal.');
                                    }
                                })
                                .catch(error => {
                                    console.log(error.response);
                                    if (error.response && error.response.status === 422) {
                                        const responseErrors = error.response.data.errors;
                                        // Tandai input yang error sesuai respon Laravel
                                        for (const key in responseErrors) {
                                            if (inputs[key]) {
                                                inputs[key].classList.add('is-invalid');
                                                errors[key].textContent = responseErrors[key][0];
                                            }
                                        }
                                    } else {
                                        showGeneralError('Terjadi kesalahan pada server.');
                                    }
                                })
                                .finally(() => {
                                    submitBtn.disabled = false;
                                    submitBtn.innerText = 'Lanjut';
                                });
                        });
                    });
                </script>
                {{-- captha --}}
                <script>
                    document.getElementById('form-atasan').addEventListener('submit', function(e) {
                        var response = grecaptcha.getResponse();
                        var errorBox = document.getElementById('captcha-error');

                        if (response.length === 0) {
                            e.preventDefault(); // hentikan form dikirim
                            errorBox.textContent = 'Tolong selesaikan CAPTCHA terlebih dahulu.';
                            errorBox.classList.remove('d-none');
                        } else {
                            // Sembunyikan pesan error kalau sudah diisi
                            errorBox.classList.add('d-none');
                        }
                    });
                </script>
            @endsection
