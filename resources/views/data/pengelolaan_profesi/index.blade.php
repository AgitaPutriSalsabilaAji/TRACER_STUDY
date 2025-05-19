@extends('layouts.template')

@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 white">
                    <h1>ChartJS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-item">Home</a></li>
                        <li class="breadcrumb-item active">ChartJS</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

<div class="card border-primary mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $page->title }}</h5>
        <div>
            <button onclick="addForm()" class="btn btn-sm btn-outline-primary me-2">Tambah Kategori</button>
            <button onclick="addForm()" class="btn btn-sm btn-primary">Tambah Profesi</button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        
    </div>
</div>

<!-- Modals will be loaded here -->
<div id="modal-container"></div>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

<script>
    function addForm() {
        $.get("{{ route('profesi.create_ajax') }}", function(data) {
            $('#modal-container').html(data);
            $('#modalCreate').modal('show');
        });
    }

    function editForm(id) {
        $.get("{{ url('profesi') }}/" + id + "/edit_ajax", function(data) {
            $('#modal-container').html(data);
            $('#modalEdit').modal('show');
        });
    }

    function deleteForm(id) {
        $.get("{{ url('profesi') }}/" + id + "/confirm_ajax", function(data) {
            $('#modal-container').html(data);
            $('#modalConfirm').modal('show');
        });
    }

  $(document).ready(function() {
                $('#tabel-profesi').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    ordering: false,
                    ajax: {
                        "url": "{{ url('/profesi/list') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function(d) {
                            d._token = '{{ csrf_token() }}';
                            console.log(d);
                        }
                    },
                    dom: '<"table-responsive"t>',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'kategori_profesi', name: 'kategori_profesi' },
            { data: 'nama_profesi', name: 'nama_profesi' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });
});

</script>
@endsection