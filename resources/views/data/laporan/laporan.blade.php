@extends('layouts.template')
@section('content')
    {{-- modal filter --}}
    <div id="yearAlert" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
        <strong>Peringatan!</strong> Silakan pilih rentang tahun terlebih dahulu.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="modal fade" id="yearModal" tabindex="-1" aria-labelledby="yearModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-light text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="yearModalLabel">Pilih Tahun Angkatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="yearPicker" class="d-grid gap-2" style="grid-template-columns: repeat(5, 1fr); display: grid;">
                        <!-- Konten Tahun Angkatan -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        id="saveYearSelection">Selesai</button>
                </div>
            </div>
        </div>
    </div>

     {{-- content --}}
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

    {{-- Card utama --}}
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="row pe-2">
                        {{-- Card 1 --}}
                        <div class="col-md-6 mb-3">
                            <div class="card bg-white text-dark shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Card 1</h5>
                                    <p class="card-text">Konten Card 1</p>
                                </div>
                            </div>
                        </div>
                        {{-- Card 2 --}}
                        <div class="col-md-6 mb-3">
                            <div class="card bg-white text-dark shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Card 2</h5>
                                    <p class="card-text">Konten Card 2</p>
                                </div>
                            </div>
                        </div>
                        {{-- Card 3 --}}
                        <div class="col-md-6 mb-3">
                            <div class="card bg-white text-dark shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Card 3</h5>
                                    <p class="card-text">Konten Card 3</p>
                                </div>
                            </div>
                        </div>
                        {{-- Card 4 --}}
                        <div class="col-md-6 mb-3">
                            <div class="card bg-white text-dark shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Card 4</h5>
                                    <p class="card-text">Konten Card 4</p>
                                </div>
                            </div>
                        </div>
                    </div> {{-- /.row --}}
                </div> {{-- /.card-body --}}
            </div> {{-- /.card --}}

        </div><!-- /.container-fluid -->
    </section>
@endsection