@extends('layouts.template')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 white">
                    <h1>Data Alumni</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Alumni</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card card-outline card-primary">
<div class="card-header">
<form action="{{ route('import.alumni') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-stretch" style="gap: 10px;">
    @csrf
    <input class="form-control form-control-sm" type="file" name="file" required>
    <button class="btn btn-primary btn-sm d-flex align-items-center px-3" type="submit">
        <i class="fas fa-file-import me-1"></i> Import
    </button>
</form>

</div>

        <div class="card-body">
            <h4>Daftar Alumni</h4>

            @if (session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped w-100" id="table-alumni">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>NIM</th>
                            <th>Tanggal Lulus</th>

                            @if ($isSuperadmin)
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Deleted At</th>
                            @endif

                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        {{-- Modal Tambah/Edit Alumni --}}
        <div id="alumniModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formAlumni" method="POST" action="">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="formMethod">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="alumniModalTitle">Tambah Alumni</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" id="alumniNama" required>
                            </div>
                            <div class="mb-3">
                                <label>Program Studi</label>
                                <select name="program_studi_id" class="form-control" id="alumniProdi" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($programStudi as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->program_studi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>NIM</label>
                                <input type="text" name="nim" class="form-control" id="alumniNim" required>
                            </div>
                            <div class="mb-3">
                                <label>Tanggal Lulus</label>
                                <input type="date" name="tanggal_lulus" class="form-control" id="alumniLulus" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- CSS Tambahan --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <style>
            .dataTables_filter input {
                border: 1px solid #ced4da;
                border-radius: 5px;
                padding: 6px 12px;
                outline: none;
                transition: 0.3s;
                width: 250px;
            }

            .dataTables_filter input:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            }


            html,
            body {
                overflow-x: hidden;
            }

            .card-body {
                overflow-x: auto;
            }

            .table-responsive {
                max-height: 70vh;
                overflow-y: auto;
            }

            .dataTables_paginate .paginate_button span {
                margin: 0 4px;
            }
        </style>

        {{-- JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Setup CSRF token supaya AJAX POST/DELETE tidak gagal
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let isSuperadmin = @json($isSuperadmin);

            let columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'program_studi',
                    name: 'program_studi'
                },
                {
                    data: 'nim',
                    name: 'nim'
                },
                {
                    data: 'tanggal_lulus',
                    name: 'tanggal_lulus'
                }
            ];

            if (isSuperadmin) {
                columns.push({
                    data: 'created_at',
                    name: 'created_at'
                }, {
                    data: 'updated_at',
                    name: 'updated_at'
                }, {
                    data: 'deleted_at',
                    name: 'deleted_at'
                });
            }

            columns.push({
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false
            });

            let table;

            $(function() {
                table = $('#table-alumni').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('data-alumni.list') }}",
                    columns: columns,
                    language: {
                        emptyTable: "Tidak ada data alumni yang tersedia.",
                        processing: "Memuat...",
                        search: "",
                        searchPlaceholder: "🔍 Cari alumni...",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Tidak ditemukan data alumni sesuai pencarian",
                        paginate: {
                            next: `<span class="btn btn-sm btn-outline-primary">Selanjutnya</span>`,
                            previous: `<span class="btn btn-sm btn-outline-primary">Sebelumnya</span>`
                        },
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 data",
                    },
                    pagingType: "simple"
                });

                $('#formAlumni').submit(function(e) {
                    e.preventDefault();
                    const url = $(this).attr('action');

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function() {
                            $('#alumniModal').modal('hide');
                            $('#formAlumni')[0].reset();
                            table.ajax.reload();
                            Swal.fire('Berhasil!', 'Data alumni berhasil disimpan.', 'success');
                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                        }
                    });
                });
            });

            function tambahAlumni() {
                $('#alumniModalTitle').text('Tambah Alumni');
                $('#formAlumni').attr('action', "{{ route('data-alumni.store') }}");
                $('#formMethod').val('POST');
                $('#formAlumni')[0].reset();
                $('#alumniModal').modal('show');
            }

            function editAlumni(id) {
                $.get('/data-alumni/' + id + '/edit', function(data) {
                    const alumni = data.alumni;
                    const programStudiList = data.programStudi;

                    $('#alumniNama').val(alumni.nama);
                    $('#alumniNim').val(alumni.nim);
                    $('#alumniLulus').val(alumni.tanggal_lulus);
                    $('#formAlumni').attr('action', '/data-alumni/' + id);
                    $('#formMethod').val('PUT');
                    $('#alumniModalTitle').text('Edit Alumni');

                    // Isi ulang dropdown program studi
                    const $dropdown = $('#alumniProdi');
                    $dropdown.empty().append('<option value="">-- Pilih Program Studi --</option>');
                    programStudiList.forEach(prodi => {
                        const selected = prodi.id == alumni.program_studi_id ? 'selected' : '';
                        $dropdown.append(
                            `<option value="${prodi.id}" ${selected}>${prodi.program_studi}</option>`
                        );
                    });

                    $('#alumniModal').modal('show');
                });
            }

            function hapusAlumni(id) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data alumni ini akan hilang permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/data-alumni/' + id,
                            type: 'DELETE',
                            success: function() {
                                table.ajax.reload();
                                Swal.fire('Terhapus!', 'Data alumni berhasil dihapus.', 'success');
                            },
                            error: function() {
                                Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                            }
                        });
                    }
                });
            }
        </script>
    @endsection
