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
                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-item">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

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
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->kategori_profesi }}</option>
                                @endforeach
                            </select>                        </div>
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

    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <button onclick="tambahProfesi()" class="btn btn-sm btn-success mt-1">Tambah Profesi</button>
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


    <!-- Modals will be loaded here -->
    <div id="modal-container"></div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script>
        var tableProfesi;

        $(document).ready(function() {
            tableProfesi = $('#tabel-profesi').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ordering: false,
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
                dom: '<"table-responsive"t>',
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

        });

        function tambahProfesi() {
            $('#profesiModalTitle').text('Tambah Profesi');
            $('#formProfesi').attr('action', "{{ route('profesi.store') }}");
            $('#formMethod').val('POST');
            $('#profesiKategori').val('');
            $('#profesiProfesi').val('');
            $('#profesiModal').modal('show');
        }

        function editProfesi(url, kategori, profesi) {
            $('#profesiModalTitle').text('Edit Profesi');
            $('#formProfesi').attr('action', url);
            $('#formMethod').val('PUT');
            $('#profesiKategori option').filter(function() {
                return $(this).text() === kategori; 
                }).prop('selected', true);
            $('#profesiProfesi').val(profesi);
            $('#profesiModal').modal('show');
        }

        function deleteProfesi(url) {
            Swal.fire({
                title: 'Yakin ingin menghapus profesi ini?',
                text: "Tindakan ini tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            tableProfesi.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'profesi berhasil dihapus.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus.'
                            });
                        }
                    });
                }
            });
        }
    </script>
    <!-- Tambahkan library SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </script>
@endsection
