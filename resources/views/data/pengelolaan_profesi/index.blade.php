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
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
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
            <button onclick="tambahProfesi()" class="btn btn-sm btn-success mt-1">Tambah Profesi</button>
            <button class="btn btn-sm btn-warning mt-1" data-bs-toggle="modal" data-bs-target="#kategoriModal">Kelola Kategori</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

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
                <button onclick="tambahKategori()" class="btn btn-success mb-3">Tambah Kategori</button>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kategoriList">
                        @foreach($kategoriList as $kategori)
                        <tr data-id="{{ $kategori->id }}">
                            <td class="kategori-nama">{{ $kategori->kategori_profesi }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editKategori({{ $kategori->id }}, '{{ $kategori->kategori_profesi }}')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="hapusKategori({{ $kategori->id }})">Hapus</button>
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
                        <input type="text" class="form-control" id="kategoriNama" name="kategori_profesi" required>
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
            tableProfesi = $('#tabel-profesi').DataTable({
                processing: true,
                serverSide: true,
                pagingType: "simple_numbers", // Menampilkan "Previous 1 2 3 Next"
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                },

                ajax: {
                    url: "{{ url('/profesi/list') }}",
                    type: "get",
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
                ]
            });
            $('#formProfesi').submit(function(e) {
                e.preventDefault();

                const kategori = $('#profesiKategori').val().trim();
                const profesi = $('#profesiProfesi').val().trim();

                let url = $(this).attr('action');
                let method = $('#formMethod').val();

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#profesiModal').modal('hide');
                        $('#formProfesi')[0].reset();
                        $('#profesiTable').DataTable().ajax.reload();
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

    $(document).ready(function () {
        tableProfesi = $('#tabel-profesi').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/profesi/list') }}",
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kategori_profesi' },
                { data: 'nama_profesi' },
                { data: 'aksi', orderable: false, searchable: false }
            ],
            language: {
                paginate: {
                    previous: "<i class='fas fa-angle-left'></i>",
                    next: "<i class='fas fa-angle-right'></i>"
                }
            }
        });

        $('#formProfesi').submit(function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let method = $('#formMethod').val();

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function() {
                    $('#profesiModal').modal('hide');
                    $('#formProfesi')[0].reset();
                    tableProfesi.ajax.reload();
                    Swal.fire('Berhasil', 'Profesi berhasil disimpan.', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseText, 'error');
                }
            });
        });

        $('#formKategori').submit(function(e) {
            e.preventDefault();
            const id = $('#kategoriId').val();
            const url = id ? `/kategori-profesi/update/${id}` : "{{ route('kategori.store') }}";
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: 'POST',
                data: $(this).serialize() + '&_method=' + method,
                success: function () {
                    location.reload();
                },
                error: function (xhr) {
                    Swal.fire('Error', xhr.responseText, 'error');
                }
            });
        });
    });

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
        $('#profesiKategori').val($('#profesiKategori option').filter(function () {
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
                url: '/destroy/' + id,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    tableProfesi.ajax.reload();
                    Swal.fire('Terhapus!', 'Profesi berhasil dihapus.', 'success');
                },
                error: function () {
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

    // Tutup modal kategori utama dulu, baru buka form tambah
    $('#kategoriModal').modal('hide');
    setTimeout(function () {
        $('#modalFormKategori').modal('show');
    }, 500); // beri jeda agar modal pertama benar-benar tertutup
}


function editKategori(id, nama) {
    $('#kategoriId').val(id);
    $('#kategoriNama').val(nama);
    $('#formKategoriTitle').text('Edit Kategori');

    $('#kategoriModal').modal('hide');
    setTimeout(function () {
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
                $.post(`/kategori-profesi/delete/${id}`, {
                    _token: "{{ csrf_token() }}",
                    _method: 'DELETE'
                }, function () {
                    location.reload();
                }).fail(function () {
                    Swal.fire('Gagal', 'Tidak dapat menghapus kategori.', 'error');
                });
            }
        });
    }

 $('#formKategori').submit(function(e) {
        e.preventDefault();

        const id = $('#kategoriId').val();
        const url = id 
            ? `/kategori-profesi/update/${id}` 
            : `/kategori-profesi/store`;

        $.ajax({
            url: url,
            method: 'POST', // Selalu gunakan POST
            data: $(this).serialize(), // Tanpa _method=PUT untuk hindari error
            success: function(response) {
                $('#modalFormKategori').modal('hide');
                // Bisa sesuaikan kalau pakai DataTables
                location.reload(); 
            },
            error: function(xhr) {
                // Kalau response JSON, bisa pakai xhr.responseJSON.message
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

        // Tambahan opsional untuk membuka modal "Edit"
    $(document).on('click', '.btn-edit-kategori', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        $('#kategoriId').val(id);
        $('#nama_kategori').val(nama);
        $('#modalFormKategori').modal('show');
    });

    // Tambahan opsional untuk "Reset" form saat tambah
    $('#btnTambahKategori').click(function() {
        $('#formKategori')[0].reset();
        $('#kategoriId').val('');
        $('#modalFormKategori').modal('show');
    });

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
    </script>
    <!-- Tambahkan library SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </script>

    <style>
        .dataTables_paginate {
            display: flex;
            justify-content: right;
            /* atau right/left sesuai keinginan */
            align-items: center;
            gap: 5px;
            /* memberi jarak antar tombol */
            margin-top: 15px;
        }

        .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            border: 1px solid #007bff;
            color: #007bff !important;
            border-radius: 4px;
            background-color: #fff;
            text-align: center;
            min-width: 36px;
            /* memastikan tombol berukuran sama */
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

      

        thead th {
            background-color: #5a8dee !important;
            color: #fafafa !important;
        }

        th,
        td {
            text-align: center;
            vertical-align: middle;
        }
    </style>

@endsection
