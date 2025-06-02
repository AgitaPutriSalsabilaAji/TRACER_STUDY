@extends('layouts.template')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 white">
                    <h1>Pengelolaan Profesi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Manajemen Data</li>
                        <li class="breadcrumb-item active">Pengelolaan Profesi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    {{-- Modal Profesi --}}
    <div id="profesiModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formProfesi" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profesiModalTitle">Tambah Profesi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Kategori</label>
                            <select name="kategori_profesi_id" class="form-control" id="profesiKategori">
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->kategori_profesi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Profesi</label>
                            <input type="text" name="profesi" class="form-control" id="profesiProfesi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Profesi --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
              <!-- Tombol Tambah Profesi -->
            <button onclick="tambahProfesi()" class="btn btn-sm btn-success mt-1">
                <i class="fas fa-plus-circle me-1"></i> Tambah Profesi
            </button>

            <!-- Tombol Kelola Kategori -->
            <button class="btn btn-sm btn-warning mt-1" data-bs-toggle="modal" data-bs-target="#kategoriModal">
                <i class="fas fa-folder-open me-1"></i> Kelola Kategori
            </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table id="tabel-profesi" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Profesi</th>
                        <th>Nama Profesi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal Kelola Kategori -->
    <div id="kategoriModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Kategori Profesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
<button onclick="tambahKategori()" class="btn btn-success mb-3"><i class="fas fa-plus-circle me-1"></i> Tambah Kategori</button>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kategoriList">
                            @foreach ($kategoriList as $kategori)
                                <tr data-id="{{ $kategori->id }}">
                                    <td class="kategori-nama">{{ $kategori->kategori_profesi }}</td>
                                    <td>
                                    <button class="btn btn-warning btn-sm"onclick="editKategori({{ $kategori->id }}, '{{ $kategori->kategori_profesi }}')"><i class="fas fa-edit me-1"></i> Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="hapusKategori({{ $kategori->id }})"><i class="fas fa-trash-alt me-1"></i> Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah/Edit Kategori -->
    <div id="modalFormKategori" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formKategori">
                @csrf
                <input type="hidden" id="kategoriId" name="kategoriId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formKategoriTitle">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kategoriNama" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="kategoriNama" name="kategori_profesi"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnSimpanKategori" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    {{-- Script --}}
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var tableProfesi;

        $(document).ready(function() {
            // Inisialisasi DataTable sekali saja
            tableProfesi = $('#tabel-profesi').DataTable({
                processing: true,
                serverSide: true,
                pagingType: "simple",
                ajax: {
                    url: "{{ url('/profesi/list') }}",
                    type: "GET",
                    dataType: "json",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                    },
                    error: function(xhr) {
                        console.error("AJAX Error:", xhr.responseText);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kategori_profesi',
                        name: 'kategori_profesi'
                    },
                    {
                        data: 'nama_profesi',
                        name: 'nama_profesi'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                    language: {
                        emptyTable: "Tidak ada Profesi yang tersedia.",
                        processing: "Memuat...",
                        search: "",
                        searchPlaceholder: "🔍 Cari Profesi...",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Tidak ditemukan data profesi yang sesuai pencarian",
                        paginate: {
                            next: "Selanjutnya >",
                            previous:"< Sebelumnya"
                        },
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 data",
                    },

            });

            // Submit handler untuk form Profesi
            $('#formProfesi').submit(function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                let method = $('#formMethod').val();

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#profesiModal').modal('hide');
                        $('#formProfesi')[0].reset();
                        tableProfesi.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Profesi berhasil disimpan.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan: ' + xhr.responseText,
                        });
                    }
                });
            });

            // Submit handler untuk form Kategori
            $('#formKategori').submit(function(e) {
                e.preventDefault();

                const id = $('#kategoriId').val();
                const url = id ? `profesi/kategori-profesi/update/${id}` : "{{ route('kategori.store') }}";
                const method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: 'POST', // gunakan POST dengan _method untuk PUT
                    data: $(this).serialize() + '&_method=' + method,
                    success: function() {
                        $('#modalFormKategori').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        let errorMessage = "Terjadi kesalahan.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            errorMessage = xhr.responseText;
                        }
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });
        });

        // Fungsi diluar $(document).ready agar bisa dipanggil dari HTML
        function tambahProfesi() {
            $('#profesiModalTitle').text('Tambah Profesi');
            $('#formProfesi').attr('action', "{{ route('profesi.store') }}");
            $('#formMethod').val('POST');
            $('#formProfesi')[0].reset();
            $('#profesiModal').modal('show');
        }

        function editProfesi(url, kategori, profesi) {
            $('#profesiModalTitle').text('Edit Profesi');
            $('#formProfesi').attr('action', url);
            $('#formMethod').val('PUT');
            $('#profesiKategori').val($('#profesiKategori option').filter(function() {
                return $(this).text() === kategori;
            }).val());
            $('#profesiProfesi').val(profesi);
            $('#profesiModal').modal('show');
        }

        function deleteProfesi(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus profesi ini?',
                text: "Tindakan ini tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'profesi/destroy/' + id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            tableProfesi.ajax.reload();
                            Swal.fire('Terhapus!', 'Profesi berhasil dihapus.', 'success');
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus.', 'error');
                        }
                    });
                }
            });
        }

        function tambahKategori() {
            $('#kategoriId').val('');
            $('#kategoriNama').val('');
            $('#formKategoriTitle').text('Tambah Kategori');
            $('#kategoriModal').modal('hide');
            setTimeout(function() {
                $('#modalFormKategori').modal('show');
            }, 500);
        }

        function editKategori(id, nama) {
            $('#kategoriId').val(id);
            $('#kategoriNama').val(nama);
            $('#formKategoriTitle').text('Edit Kategori');
            $('#kategoriModal').modal('hide');
            setTimeout(function() {
                $('#modalFormKategori').modal('show');
            }, 500);
        }

        function hapusKategori(id) {
            Swal.fire({
                title: 'Yakin hapus kategori?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `profesi/kategori-profesi/delete/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            location.reload();
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Tidak dapat menghapus kategori.', 'error');
                        }
                    });
                }
            });
        }
    </script>

    <style>
        .dataTables_paginate {
            display: flex;
            justify-content: right;
            align-items: center;
            gap: 5px;
            margin-top: 15px;
        }

        .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            border: 1px solid #007bff;
            color: #007bff !important;
            border-radius: 4px;
            background-color: #fff;
            min-width: 36px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #007bff !important;
            color: white !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #0056b3 !important;
            color: white !important;
            cursor: pointer;
        }

     
    </style>
@endsection
