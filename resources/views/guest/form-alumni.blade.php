
@extends('layouts.headerguest')

@section('active-home', 'active')

@section('content')
<div class="container-fluid bg-siluet py-5">
<head>
    <!-- ...other head content -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>


    <style>
        .list-group-item {
            cursor: pointer;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            /* Ganti warna hover jika perlu */
        }
    </style>

    <div class="card shadow" data-aos="fade-up">
    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Form Tracer Alumni
            </div>
            <div class="card-body">
                @if (session('alert'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('alert') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan pada input Anda:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('submit.alumni') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                      <!-- Kolom Kiri -->
<div class="col-md-6">
    <div class="mb-3 position-relative">
        <label for="nama" class="form-label">
            <i class="bi bi-person text-primary me-2"></i>Nama atau NIM
        </label>
        <input type="text" class="form-control" id="nama" autocomplete="off" required>
        <input type="hidden" name="alumni_id" id="alumni_id">
        <div class="invalid-feedback" id="nama-error">Nama atau NIM tidak ditemukan.</div>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-journal-text text-primary me-2"></i>Program Studi
        </label>
        <select class="form-select" name="prodi" required>
            <option value="" disabled selected>-- Pilih Program Studi --</option>
            @foreach ($prodi as $p)
                <option value="{{ $p->id }}">{{ $p->program_studi }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-calendar3 text-primary me-2"></i>Tahun Lulus
        </label>
        <select class="form-select" name="tahun_lulus" required>
            <option value="" disabled selected>-- Pilih Tahun Lulus --</option>
            @foreach ($tahunLulus as $p)
                <option value="{{ $p }}">{{ $p }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-telephone text-primary me-2"></i>No. HP
        </label>
        <input type="text" class="form-control" name="no_hp" required pattern="^[0-9]+$">
        <div class="invalid-feedback">Harus diisi dengan angka saja.</div>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-envelope text-primary me-2"></i>Email
        </label>
        <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-calendar-event text-primary me-2"></i>Tanggal Pertama Kerja
        </label>
        <input type="date" class="form-control" name="tgl_pertama_kerja">
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-calendar2-week text-primary me-2"></i>Tanggal Mulai di Instansi Saat Ini
        </label>
        <input type="date" class="form-control" name="tgl_mulai_kerja_instansi">
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-building text-primary me-2"></i>Jenis Instansi
        </label>
        <select class="form-select" name="jenis_instansi_id" required>
            <option value="" disabled selected>-- Pilih Jenis Instansi --</option>
            @foreach ($jenisInstansi as $instansi)
                <option value="{{ $instansi->id }}">{{ $instansi->jenis_instansi }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-bank text-primary me-2"></i>Nama Instansi
        </label>
        <input type="text" class="form-control" name="nama_instansi">
    </div>
</div>

<!-- Kolom Kanan -->
<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-diagram-3 text-primary me-2"></i>Skala Instansi
        </label>
        <select class="form-select" name="skala" id="skala_instansi">
            <option value="" disabled selected>-- Pilih Skala Instansi --</option>
            <option value="Internasional">Multinasional/Internasional</option>
            <option value="Nasional">Nasional</option>
            <option value="Wirausaha">Wirausaha</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-geo-alt text-primary me-2"></i>Lokasi Instansi
        </label>
        <input type="text" class="form-control" name="lokasi_instansi">
    </div>

    <div class="mb-3">
        <label for="kategori" class="form-label">
            <i class="bi bi-tags text-primary me-2"></i>Kategori Profesi
        </label>
        <select class="form-select" name="kategori" required id="kategori" onchange="handleKategoriChange(this)">
            <option value="" disabled selected>-- Pilih Kategori --</option>
            @foreach ($kategoriProfesi as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->kategori_profesi }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="profesi" class="form-label">
            <i class="bi bi-person-workspace text-primary me-2"></i>Profesi
        </label>
        <select class="form-select" name="profesi_id" id="profesi">
            <option value="" disabled selected>-- Pilih Profesi --</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-person-lines-fill text-primary me-2"></i>Nama Atasan Langsung
        </label>
        <input type="text" class="form-control" name="nama_atasan_langsung" placeholder="Nama lengkap atasan langsung">
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-person-badge text-primary me-2"></i>Jabatan Atasan Langsung
        </label>
        <input type="text" class="form-control" name="jabatan_atasan_langsung" placeholder="Contoh: Manajer HRD">
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-telephone-forward text-primary me-2"></i>No. HP Atasan Langsung
        </label>
        <input type="text" class="form-control" name="no_hp_atasan_langsung" pattern="^[0-9]+$"
            placeholder="Hanya angka">
        <div class="invalid-feedback">Harus diisi dengan angka saja.</div>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-envelope-open text-primary me-2"></i>Email Atasan Langsung
        </label>
        <input type="email" class="form-control" name="email_atasan_langsung" placeholder="email@domain.com">
    </div>

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-send-fill me-1"></i>Submit
        </button>
    </div>
</div>

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
</style>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
       
        $(document).ready(function() {
            let validName = false;

            $('#nama').on('input', function() {
                const query = $(this).val();
                validName = false;
                $('#alumni_id').val('');
                $('#nama-error').hide();
                $('#nama').removeClass('is-invalid');
                $('.list-group').remove();

                if (query.length >= 3) {
                    $.ajax({
                        url: "{{ route('autocomplete.alumni') }}",
                        type: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.length > 0) {
                                let dropdown =
                                    '<ul class="list-group position-absolute w-100" style="z-index:1000;">';
                                data.forEach(item => {
                                    dropdown +=
                                        `<li class="list-group-item" data-id="${item.id}">${item.nama} (${item.nim})</li>`;
                                });
                                dropdown += '</ul>';
                                $('#nama').after(dropdown);

                                // Klik pilihan
                                $('.list-group-item').on('click', function() {
                                    const selectedText = $(this).text();
                                    const selectedId = $(this).data('id');
                                    $('#nama').val(selectedText);
                                    $('#alumni_id').val(selectedId);
                                    validName = true;
                                    $('.list-group').remove();
                                    $('#nama').removeClass('is-invalid');
                                    $('#nama-error').hide();
                                });
                            } else {
                                // Tidak ditemukan di autocomplete
                                $('#nama').addClass('is-invalid');
                                $('#nama-error').show();
                            }
                        },
                        error: function() {
                            $('#nama').addClass('is-invalid');
                            $('#nama-error').text('Terjadi kesalahan server.').show();
                        }
                    });
                }
            });

            // Validasi saat submit
            $('form').submit(function(e) {
                if (!validName || !$('#alumni_id').val()) {
                    e.preventDefault();
                    $('#nama').addClass('is-invalid');
                    $('#nama-error').show();
                }
            });

            // Hapus dropdown jika klik di luar
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#nama').length) {
                    $('.list-group').remove();
                }
            });
        });
    </script>


    <script>
        // Data profesi dari server, dikirim sebagai JSON
        const profesiData = @json($profesi); // Pastikan data ini punya properti: nama & kategori_id

        function handleKategoriChange(select) {
            const kategoriId = select.value;
            const profesiSelect = document.getElementById('profesi');

            // Reset dropdown profesi
            profesiSelect.innerHTML = '<option value="" disabled selected>-- Pilih Profesi --</option>';

            // Filter profesi sesuai kategori yang dipilih
            const filteredProfesi = profesiData.filter(p => p.kategori_profesi_id == kategoriId);

            // Tambahkan opsi profesi ke dropdown
            filteredProfesi.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = p.nama_profesi;
                profesiSelect.appendChild(option);
            });
        }
    </script>
    <script>
        function toggleAtasanFields(required) {
            const fields = [
                'tgl_pertama_kerja',
                'tgl_mulai_kerja_instansi',
                'jenis_instansi_id',
                'skala',
                'nama_instansi',
                'lokasi_instansi',
                'nama_atasan_langsung',
                'jabatan_atasan_langsung',
                'no_hp_atasan_langsung',
                'email_atasan_langsung'
            ];
            const shouldHide = true;
            fields.forEach(id => {
                const el = document.querySelector(`[name="${id}"]`);
                if (el) {
                    el.closest('.mb-3').style.display = shouldHide ? 'none' : '';
                }
            });

            document.getElementById('kategori').addEventListener('change', function() {
                const selectedValue = this.value;

                if (selectedValue === '3') {
                    toggleAtasanFields(false);
                } else { 
                    toggleAtasanFields(true);
                }
            });
            window.addEventListener('DOMContentLoaded', function() {
                const selectedValue = document.getElementById('kategori').value;
                if (selectedValue === '3') {
                    toggleAtasanFields(false);
                } else {
                    toggleAtasanFields(true);
                }
            });
            }
    </script>
    <br>
    @include('layouts.footerguest')
@endsection

