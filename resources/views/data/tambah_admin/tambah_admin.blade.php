@extends('layouts.template')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 white">
                    <h1>Dasboard admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div id="adminModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formAdmin" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminModalTitle">Tambah Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" id="adminUsername" required minlength="7">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" id="adminEmail" required placeholder="admin@gmail.com">
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
                <button onclick="tambahAdmin()" class="btn btn-sm btn-success mt-1">Tambah Admin</button>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped" id="table-admin">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>


    <script>
        var tableAdmin;

        $(function() {
            tableAdmin = $('#table-admin').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.list') }}",
                dom: '<"table-responsive"t>',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#formAdmin').submit(function(e) {
                e.preventDefault();

                const username = $('#adminUsername').val().trim();
                const email = $('#adminEmail').val().trim();

                if (username.length < 7) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Username terlalu pendek',
                        text: 'Silakan masukkan username minimal 7 karakter.',
                    });
                    return;
                }

                let url = $(this).attr('action');
                let method = $('#formMethod').val();

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#adminModal').modal('hide');
                        tableAdmin.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Admin berhasil disimpan.',
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

        function tambahAdmin() {
            $('#adminModalTitle').text('Tambah Admin');
            $('#formAdmin').attr('action', "{{ route('admin.store') }}");
            $('#formMethod').val('POST');
            $('#adminUsername').val('');
            $('#adminEmail').val('');
            $('#adminModal').modal('show');
        }

        function editAdmin(url, username, email) {
            $('#adminModalTitle').text('Edit Admin');
            $('#formAdmin').attr('action', url);
            $('#formMethod').val('PUT');
            $('#adminUsername').val(username);
            $('#adminEmail').val(email);
            $('#adminModal').modal('show');
        }

        function deleteAdmin(url) {
            Swal.fire({
                title: 'Yakin ingin menghapus admin ini?',
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
                            tableAdmin.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Admin berhasil dihapus.',
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

@endsection
