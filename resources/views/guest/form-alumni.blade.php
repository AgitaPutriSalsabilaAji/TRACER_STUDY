@extends('layouts.headerguest')

@section('active-home', 'active')

@section('content')
    <style>
        .list-group-item {
            cursor: pointer;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            /* Ganti warna hover jika perlu */
        }
    </style>

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

    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Form Tracer Alumni
            </div>
            <div class="card-body">
                <form action="{{ route('submit.alumni') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="mb-3 position-relative">
                                <label for="nama" class="form-label">Nama atau NIM</label>
                                <input type="text" class="form-control" id="nama" autocomplete="off" required>
                                <input type="hidden" name="alumni_id" id="alumni_id">
                                <div class="invalid-feedback d-none" id="nama-error">Nama atau NIM tidak ditemukan.</div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi">
                                    @foreach ($prodi as $p)
                                        <option value="{{ $p->id }}">{{ $p->program_studi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Lulus</label>
                                <select class="form-select" name="tahun_lulus">
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
                                <input type="email" class="form-control" name="email">
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
                                <label for="jenis_instansi" class="form-label">Jenis Instansi</label>
                                <select class="form-select" name="jenis_instansi_id" id="jenis_instansi" required>
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
                                <select class="form-select" name="skala" id="skala_instansi" required>
                                    <option value="" disabled selected>-- Pilih Skala Instansi --</option>
                                    <option value="Multinasional/Internasional">Multinasional/Internasional</option>
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
                                <select class="form-select" name="kategori" id="kategori" required
                                    onchange="handleKategoriChange(this)">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach ($kategoriProfesi as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->kategori_profesi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="profesi" class="form-label">Profesi</label>
                                <select class="form-select" name="profesi_id" id="profesi" required>
                                    <option value="" disabled selected>-- Pilih Profesi --</option>
                                    <!-- Opsi profesi akan muncul berdasarkan kategori -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Atasan Langsung</label>
                                <input type="text" class="form-control" name="nama_atasan_langsung" required
                                    placeholder="Nama lengkap atasan langsung">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jabatan Atasan Langsung</label>
                                <input type="text" class="form-control" name="jabatan_atasan_langsung" required
                                    placeholder="Contoh: Manajer HRD">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. HP Atasan Langsung</label>
                                <input type="text" class="form-control" name="no_hp_atasan_langsung" required
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            let validName = false;

            $('#nama').on('input', function() {
                const query = $(this).val();
                validName = false;
                $('#alumni_id').val(''); // Reset ID
                $('#nama-error').addClass('d-none');
                $('.list-group').remove();

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
                                $('#nama').after(dropdown);

                                // Klik pilihan
                                $('.list-group-item').on('click', function() {
                                    const selectedText = $(this).text();
                                    const selectedId = $(this).data('id');
                                    $('#nama').val(selectedText);
                                    $('#alumni_id').val(selectedId);
                                    validName = true;
                                    $('.list-group').remove();
                                    $('#nama-error').addClass('d-none');
                                });
                            } else {
                                $('#nama-error').removeClass('d-none');
                            }
                        }
                    });
                }
            });

            // Validasi saat submit
            $('form').submit(function(e) {
                if (!validName || !$('#alumni_id').val()) {
                    e.preventDefault();
                    $('#nama-error').removeClass('d-none');
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
@endsection
