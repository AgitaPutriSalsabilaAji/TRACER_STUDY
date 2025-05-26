@extends('layouts.headerguest')

@section('active-home', 'active')

@section('content')
    <div class="container-fluid bg-siluet py-5">
        <div class="container">
            <!-- CSS Bootstrap & Font Awesome -->

            <style>
                .list-group-item {
                    cursor: pointer;
                }

                .form-label i.bi {
                    color: #0d6efd;
                }

                .list-group-item:hover {
                    background-color: #f8f9fa;
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
            <form id="alumniForm">
                @csrf
                <div class="modal" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel"
                    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="validationModalLabel">Validasi Alumni</h5>
                            </div>

                            <div class="modal-body">
                                <p class="text-center mb-3">
                                    <strong>Buktikan kamu adalah alumni mahasiswa Polinema</strong>
                                </p>

                                <div class="mb-3 position-relative">
                                    <label for="nama" class="form-label">Nama </label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        autocomplete="off" placeholder="Masukkan nama atau NIM" required>
                                    <input type="hidden" name="alumni_id_validate" id="alumni_id_validate"
                                        class="alumni_id" value="">

                                    <div class="invalid-feedback" id="nama-error">Nama atau NIM tidak ditemukan.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" id="nim" name="nim" class="form-control"
                                        placeholder="Masukkan NIM" required>
                                    <div class="invalid-feedback" id="nim-error"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Program Studi</label>
                                    <select class="form-select" name="prodi" id="prodi" required>
                                        <option value="" disabled selected>-- Pilih Program Studi --</option>
                                        @foreach ($prodi as $p)
                                            <option value="{{ $p->id }}">{{ $p->program_studi }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="prodi-error"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                                    <input type="number" id="tahun_lulus" name="tahun_lulus" class="form-control"
                                        placeholder="Tahun Lulus" min="2000" max="{{ now()->year }}" required>
                                    <div class="invalid-feedback" id="tahun_lulus-error"></div>
                                </div>

                                <div class="alert alert-danger d-none" id="general-error"></div>
                                <div class="alert alert-success d-none" id="success-alert">Validasi berhasil!</div>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="history.back()">Kembali</button>
                                <button type="submit" id="submitAlumni" class="btn btn-primary">Lanjut</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
            <div class="container my-4">
                <div class="card shadow">
                    <div class="card-header card-header-custom">
                        <i class="fas fa-user-graduate"></i> {{-- Ikon alumni --}}
                        Form Tracer Study Alumni
                    </div>
                    <br>
                    <div class="card shadow" data-aos="fade-up">
                        <div class="card-body">
                            @if (session('alert'))
                                <div id="alertWarning" class="alert alert-warning alert-dismissible fade show mt-2"
                                    role="alert"
                                    style="position: fixed; top: 20px; right: 20px; z-index: 1100; min-width: 300px;">
                                    {{ session('alert') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>

                                <script>
                                    setTimeout(() => {
                                        const alert = document.getElementById('alertWarning');
                                        if (alert) {
                                            alert.classList.remove('show');
                                            setTimeout(() => alert.remove(), 150);
                                        }
                                    }, 4000);
                                </script>
                            @endif

                            @if ($errors->has('g-recaptcha-response'))
                                <div id="errorCaptcha" class="text-danger"
                                    style="position: fixed; top: 80px; right: 20px; z-index: 1100; min-width: 300px; background: #f8d7da; padding: 10px; border-radius: 4px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    {{ $errors->first('g-recaptcha-response') }}
                                </div>

                                <script>
                                    setTimeout(() => {
                                        const errorDiv = document.getElementById('errorCaptcha');
                                        if (errorDiv) {
                                            errorDiv.style.transition = 'opacity 0.5s ease';
                                            errorDiv.style.opacity = '0';
                                            setTimeout(() => errorDiv.remove(), 500);
                                        }
                                    }, 5000);
                                </script>
                            @endif

                            <div class="card-body">
                                @if (session('alert'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('alert') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
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
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('submit.alumni') }}" id="form-alumni" method="POST">
                                    @csrf
                                    <div class="row g-4">
                                        <!-- Kolom Kiri -->
                                        <div class="col-md-6">
                                            <div class="mb-3 position-relative">
                                                <label for="nama" class="form-label">
                                                    <i class="bi bi-person"></i>
                                                    Nama atau NIM
                                                </label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ $nama ?? '' }}" readonly>
                                                <input type="hidden" name="alumni_id" id="alumni_id"
                                                    value="{{ $alumni_id ?? '' }}">
                                            </div>


                                            <div class="mb-3">
                                                <i class="bi bi-mortarboard text-primary me-2"></i>
                                                <label class="form-label">Program Studi</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $prodi_terpilih_nama ?? '' }}" readonly>
                                                <!-- Kirim id program studi secara tersembunyi -->
                                                <input type="hidden" name="prodi"
                                                    value="{{ $prodi_terpilih ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <i class="bi bi-calendar3 text-primary me-2"></i>
                                                <label class="form-label">Tahun Lulus</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $tahun_lulus_terpilih ?? '' }}" readonly>
                                                <!-- Kirim tahun lulus secara tersembunyi -->
                                                <input type="hidden" name="tahun_lulus"
                                                    value="{{ $tahun_lulus_terpilih ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <i class="bi bi-telephone text-primary me-2"></i>
                                                <label class="form-label">No. HP</label>
                                                <input type="text" class="form-control" name="no_hp" required
                                                    pattern="^[0-9]+$">
                                                <div class="invalid-feedback">
                                                    Harus diisi dengan angka saja.
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <i class="bi bi-envelope text-primary me-2"></i>
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" required>
                                            </div>

                                            <div id="field-kerja-lanjutan1" style="display: none;">
                                            
                                            <div class="mb-3">
                                                <i class="bi bi-briefcase text-primary me-2"></i>
                                                <label class="form-label">Tanggal Pertama Kerja</label>
                                                <input type="date" class="form-control" name="tgl_pertama_kerja">
                                            </div>
                                            <div class="mb-3">
                                                <i class="bi bi-building text-primary me-2"></i>
                                                <label class="form-label">Tanggal Mulai di Instansi Saat Ini</label>
                                                <input type="date" class="form-control"
                                                    name="tgl_mulai_kerja_instansi">
                                            </div>
                                            <div class="mb-3">
                                                <i class="bi bi-diagram-3 text-primary me-2"></i>
                                                <label class="form-label">Jenis Instansi</label>
                                                <select class="form-select" name="jenis_instansi_id">
                                                    <option value="" disabled selected>-- Pilih Jenis Instansi --
                                                    </option>
                                                    @foreach ($jenisInstansi as $instansi)
                                                        <option value="{{ $instansi->id }}">
                                                            {{ $instansi->jenis_instansi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <i class="bi bi-bank text-primary me-2"></i>
                                                <label class="form-label">Nama Instansi</label>
                                                <input type="text" class="form-control" name="nama_instansi">
                                            </div>
                                            </div>
                                        </div>

                                        <!-- Kolom Kanan -->
                                        <div class="col-md-6">
                                                <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-briefcase"></i> Kategori
                                                    Profesi</label>
                                                <select class="form-select" name="kategori" required id="kategori"
                                                    onchange="handleKategoriChange(this)">
                                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                                    @foreach ($kategoriProfesi as $kategori)
                                                        <option value="{{ $kategori->id }}">
                                                            {{ $kategori->kategori_profesi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <div class="mb-3" id="profesi-wrapper">
                                                <label class="form-label"><i class="bi bi-person-badge"></i>
                                                    Profesi</label>
                                                <select class="form-select" name="profesi_id" id="profesi">
                                                    <option value="" disabled selected>-- Pilih Profesi --</option>
                                                    <!-- Diisi oleh JavaScript -->
                                                </select>
                                            </div>

                                            <!-- PROFESI OUTPUT (JIKA HANYA SATU) -->
                                            <div class="mb-3" id="profesi-output" style="display: none;">
                                                <label class="form-label"><i class="bi bi-person-badge"></i>
                                                    Profesi</label>
                                                <div class="form-control bg-light fw-bold" id="profesi-name"></div>
                                            </div>


<div id="field-kerja-lanjutan2" style="display: none;">
                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-building"></i> Skala
                                                    Instansi</label>
                                                <select class="form-select" name="skala" id="skala_instansi">
                                                    <option value="" disabled selected>-- Pilih Skala Instansi --
                                                    </option>
                                                    <option value="Internasional">Multinasional/Internasional</option>
                                                    <option value="Nasional">Nasional</option>
                                                    <option value="Wirausaha">Wirausaha</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-geo-alt"></i> Lokasi
                                                    Instansi</label>
                                                <input type="text" class="form-control" name="lokasi_instansi">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-person-lines-fill"></i> Nama
                                                    Atasan Langsung</label>
                                                <input type="text" class="form-control" name="nama_atasan_langsung"
                                                    placeholder="Nama lengkap atasan langsung">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-person-vcard"></i> Jabatan
                                                    Atasan Langsung</label>
                                                <input type="text" class="form-control" name="jabatan_atasan_langsung"
                                                    placeholder="Contoh: Manajer HRD">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-telephone"></i> No. HP Atasan
                                                    Langsung</label>
                                                <input type="text" class="form-control" name="no_hp_atasan_langsung"
                                                    pattern="^[0-9]+$" placeholder="Hanya angka">
                                                <div class="invalid-feedback">
                                                    Harus diisi dengan angka saja.
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-envelope"></i> Email Atasan
                                                    Langsung</label>
                                                <input type="email" class="form-control" name="email_atasan_langsung"
                                                    placeholder="email@domain.com">
                                            </div>
</div>
                                            <div id="captcha-error" class="alert alert-danger d-none mt-2"
                                                role="alert">
                                            </div>

                                            {!! NoCaptcha::display() !!}


                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-send-fill me-1"></i>Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                {!! NoCaptcha::renderJs() !!}
                            </div>
                        </div>
                    </div>
                </div>
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
                    $('#alumni_id_validate').val('');
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
                                            `<li class="list-group-item" data-id="${item.id}">${item.nama} </li>`;
                                    });
                                    dropdown += '</ul>';
                                    $('#nama').after(dropdown);

                                    // Klik pilihan
                                    $('.list-group-item').on('click', function() {
                                        const selectedText = $(this).text();
                                        const selectedId = $(this).data('id');
                                        $('#nama').val(selectedText);
                                        $('#alumni_id_validate').val(selectedId);
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


                // Hapus dropdown jika klik di luar
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('#nama').length) {
                        $('.list-group').remove();
                    }
                });
            });
        </script>
        <script>
            const profesiData = @json($profesi);

            function handleKategoriChange(select) {
                const kategoriId = select.value;
                const profesiSelect = document.getElementById('profesi');
                const profesiWrapper = document.getElementById('profesi-wrapper'); // Bungkus dropdown untuk disembunyikan
                const profesiOutput = document.getElementById('profesi-output'); // Elemen untuk tampilkan nama langsung
  const fieldKerjaLanjutan1 = document.getElementById('field-kerja-lanjutan1');
const fieldKerjaLanjutan2 = document.getElementById('field-kerja-lanjutan2');

                // Reset dropdown
                profesiSelect.innerHTML = '<option value="" disabled selected>-- Pilih Profesi --</option>';

                // Filter berdasarkan kategori
                const filteredProfesi = profesiData.filter(p => p.kategori_profesi_id == kategoriId);

                // Jika kategori ID = 3, tampilkan satu-satunya profesi
                if (kategoriId == 3 && filteredProfesi.length === 1) {
                    profesiWrapper.style.display = 'none'; // Sembunyikan dropdown
                    profesiOutput.style.display = 'block'; // Tampilkan teks
fieldKerjaLanjutan1.style.display = 'none';
fieldKerjaLanjutan2.style.display = 'none';
                    const selectedProfesi = filteredProfesi[0];
                    profesiOutput.innerText = selectedProfesi.nama_profesi;

                    // Buat hidden input agar tetap terkirim saat submit
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'profesi_id';
                    hiddenInput.value = selectedProfesi.id;
                    profesiOutput.appendChild(hiddenInput);
                } else {
                    // Tampilkan dropdown kembali
                    profesiWrapper.style.display = 'block';
                    profesiOutput.style.display = 'none';
fieldKerjaLanjutan1.style.display = 'block';
fieldKerjaLanjutan2.style.display = 'block';
                    // Tambahkan opsi
                    filteredProfesi.forEach(p => {
                        const option = document.createElement('option');
                        option.value = p.id;
                        option.textContent = p.nama_profesi;
                        profesiSelect.appendChild(option);
                    });
                    // Deteksi saat pertama kali halaman dimuat
                }
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

                const form = document.getElementById('alumniForm');
                const submitBtn = document.getElementById('submitAlumni');

                // Input dan error elemen
                const inputs = {
                    nama: document.getElementById('nama'),
                    nim: document.getElementById('nim'),
                    prodi: document.getElementById('prodi'),
                    tahun_lulus: document.getElementById('tahun_lulus'),
                };

                const errors = {
                    nama: document.getElementById('nama-error'),
                    nim: document.getElementById('nim-error'),
                    prodi: document.getElementById('prodi-error'),
                    tahun_lulus: document.getElementById('tahun_lulus-error'),
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

                    axios.post('{{ route('validate.alumni') }}', formData)
                        .then(response => {
                            if (response.data.success) {
                                errors.success.classList.remove('d-none');
                                // Sembunyikan modal setelah 1 detik
                                setTimeout(() => {
                                    validationModal.hide();
                                    // Redirect ke halaman form alumni sebenarnya atau submit form biasa:
                                    window.location.href = '{{ route('form.alumni') }}';
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
            document.getElementById('form-alumni').addEventListener('submit', function(e) {
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


        @include('layouts.footerguest')
    @endsection
