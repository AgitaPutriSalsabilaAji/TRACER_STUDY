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

    <div class="container">
        <h4>Daftar Profesi</h4>
        <button class="btn btn-success mb-3" onclick="addForm()">Tambah Profesi</button>

        <div class="table-responsive">
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


        $(document).ready(function() {
            $('#tabel-profesi').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
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
        });
    </script>
@endsection
