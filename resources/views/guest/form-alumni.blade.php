
@extends('layouts.headerguest')

@section('active-home', 'active')

@section('content')
<div class="container-fluid bg-siluet py-5">
    <div class="container">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>


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
                                <label for="nama" class="form-label">Nama atau NIM</label>
                                <input type="text" class="form-control" id="nama" autocomplete="off" required>
                                <input type="hidden" name="alumni_id" id="alumni_id">
                                <div class="invalid-feedback" id="nama-error">Nama atau NIM tidak ditemukan.</div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" required>
                                <option value="" disabled selected>-- Pilih Program Studi --</option>
                                    @foreach ($prodi as $p)
                                        <option value="{{ $p->id }}">{{ $p->program_studi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Lulus</label>
                                <select class="form-select" name="tahun_lulus" required>
                                <option value="" disabled selected>-- Pilih Tahun Lulus --</option>
                                    @foreach ($tahunLulus as $p)
                                        <option value="{{ $p }}">{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. HP</label>
                                <input type="text" class="form-control" name="no_hp" required pattern="^[0-9]+$">
                                <div class="invalid-feedback">
                                    Harus diisi dengan angka saja.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pertama Kerja</label>
                                <input type="date" class="form-control" name="tgl_pertama_kerja">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai di Instansi Saat Ini</label>
                                <input type="date" class="form-control" name="tgl_mulai_kerja_instansi">
                            </div>
                            <div class="mb-3">
                                      <label class="form-label">Jenis Instansi</label>
                                      <select class="form-select" name="jenis_instansi_id" required>
                                          <option value="" disabled selected>-- Pilih Jenis Instansi --</option>
                                          @foreach ($jenisInstansi as $instansi)
                                              <option value="{{ $instansi->id }}">{{ $instansi->jenis_instansi }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Instansi</label>
                                <input type="text" class="form-control" name="nama_instansi">
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Skala Instansi</label>
                                <select class="form-select" name="skala" id="skala_instansi">
                                    <option value="" disabled selected>-- Pilih Skala Instansi --</option>
                                    <option value="Internasional">Multinasional/Internasional</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Wirausaha">Wirausaha</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi Instansi</label>
                                <input type="text" class="form-control" name="lokasi_instansi">
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori profesi</label>
                                <select class="form-select" name="kategori" required id="kategori"
                                    onchange="handleKategoriChange(this)">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach ($kategoriProfesi as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->kategori_profesi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="profesi" class="form-label">Profesi</label>
                                <select class="form-select" name="profesi_id" id="profesi">
                                    <option value="" disabled selected>-- Pilih Profesi --</option>
                                    <!-- Opsi profesi akan muncul berdasarkan kategori -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Atasan Langsung</label>
                                <input type="text" class="form-control" name="nama_atasan_langsung"
                                    placeholder="Nama lengkap atasan langsung">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jabatan Atasan Langsung</label>
                                <input type="text" class="form-control" name="jabatan_atasan_langsung"
                                    placeholder="Contoh: Manajer HRD">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. HP Atasan Langsung</label>
                                <input type="text" class="form-control" name="no_hp_atasan_langsung"
                                    pattern="^[0-9]+$" placeholder="Hanya angka">
                                <div class="invalid-feedback">
                                    Harus diisi dengan angka saja.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email Atasan Langsung</label>
                                <input type="email" class="form-control" name="email_atasan_langsung"
                                    placeholder="email@domain.com">
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                        </div>
                    </div>
                </form>
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
            $('.nama-autocomplete').on('input', function() {
                const $input = $(this);
                const query = $input.val();

                // Cari elemen terkait (hidden input dan error div) secara relatif
                const $hidden = $input.siblings('.alumni_id');
                const $error = $input.siblings('.nama-error');

                $hidden.val('');
                $input.removeClass('is-invalid');
                $error.hide();
                $input.siblings('.list-group').remove();

                if (query.length >= 3) {
                    $.ajax({
                        url: "{{ route('autocomplete.alumni') }}",
                        type: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                let dropdown =
                                    '<ul class="list-group position-absolute w-100" style="z-index:1000;">';
                                data.forEach(item => {
                                    dropdown +=
                                        `<li class="list-group-item" data-id="${item.id}">${item.nama} (${item.nim})</li>`;
                                });
                                dropdown += '</ul>';

                                $input.after(dropdown);

                                $input.siblings('.list-group').find('.list-group-item').on(
                                    'click',
                                    function() {
                                        const selectedText = $(this).text();
                                        const selectedId = $(this).data('id');
                                        $input.val(selectedText);
                                        $hidden.val(selectedId);
                                        $input.siblings('.list-group').remove();
                                        $input.removeClass('is-invalid');
                                        $error.hide();
                                    });
                            } else {
                                $input.addClass('is-invalid');
                                $error.show();
                            }
                        },
                        error: function() {
                            $input.addClass('is-invalid');
                            $error.text('Terjadi kesalahan server.').show();
                        }
                    });
                }
            });

            // Hapus dropdown jika klik di luar input manapun
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.nama-autocomplete').length) {
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

            // Reset dropdown
            profesiSelect.innerHTML = '<option value="" disabled selected>-- Pilih Profesi --</option>';

            // Filter berdasarkan kategori
            const filteredProfesi = profesiData.filter(p => p.kategori_profesi_id == kategoriId);

            // Jika kategori ID = 3, tampilkan satu-satunya profesi
            if (kategoriId == 3 && filteredProfesi.length === 1) {
                profesiWrapper.style.display = 'none'; // Sembunyikan dropdown
                profesiOutput.style.display = 'block'; // Tampilkan teks

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

                // Tambahkan opsi
                filteredProfesi.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.textContent = p.nama_profesi;
                    profesiSelect.appendChild(option);
                });
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
                console.log(selectedValue);

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
 @include('layouts.footerguest')
@endsection

