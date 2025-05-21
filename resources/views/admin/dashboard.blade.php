@extends('layouts.template')
@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.p-4.bg-white.shadow.rounded');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('animate-card');
                }, index * 200);
            });
        });
    </script>

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

    <div class="container-fluid py-3">
        <div class="row justify-content-between">
            <div class="col-md-5">
                <label class="form-label text-white">Program Studi</label>
                <select id="prodiSelect" class="form-select form-select-sm">
                    @foreach ($prodi as $item)
                        <!-- Menggunakan id item untuk value -->
                        <option value="{{ $item->id }}" {{ $item->id == $prodi_id ? 'selected' : '' }}>
                            {{ $item->program_studi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5 text-end">
                <div class="mb-3">
                    <label class="form-label text-white">Tahun Angkatan</label>
                    <input type="text" id="selectedYears" class="form-control" readonly data-bs-toggle="modal"
                        data-bs-target="#yearModal" placeholder="Klik untuk pilih tahun" style="cursor: pointer;"
                        value="{{ $startYear }} - {{ $endYear }}">
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid my-4 px-3 animate-card">

        <!-- Row 1: Dua Chart Sebaran Profesi dan Jenis Instansi -->
        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-right">
                    <h2 class="mb-4 fs-4">Sebaran Profesi ({{ $startYear }} - {{ $endYear }})</h2>
                    <div id="profesi_chart" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-left">
                    <h2 class="mb-4 fs-4">Sebaran Jenis Instansi ({{ $startYear }} - {{ $endYear }})</h2>
                    <div id="intansi_chart" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>

        <!-- Row 2: Full Width Table Data Lulusan -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="p-4 bg-white shadow rounded "data-aos="zoom-in-up">
                    <h2 class="mb-4 fs-4 text-center">Data Lulusan ({{ $startYear }} - {{ $endYear }})</h2>
                    <div class="table-responsive d-flex justify-content-center">
                        <table id="tabel-lulusan" class="table table-bordered table-striped table-hover"
                            style="width: auto; min-width: 600px;">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="align-middle text-center">Tahun Lulus</th>
                                    <th rowspan="2" class="align-middle text-center">Total Lulusan</th>
                                    <th rowspan="2" class="align-middle text-center">Lulusan Terlacak</th>
                                    <th rowspan="2" class="align-middle text-center">Kerja di Bidang<br>Infokom</th>
                                    <th rowspan="2" class="align-middle text-center">Kerja di Bidang<br>Non-Infokom</th>
                                    <th colspan="3" class="text-center">Tempat Kerja</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Multinasional/Internasional</th>
                                    <th class="text-center">Nasional</th>
                                    <th class="text-center">Wirausaha</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><b>Jumlah</b></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <!-- Isi data akan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Dua Tabel Rata-rata Masa Tunggu & Performa Lulusan -->
        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <h2 class="mb-4 fs-4 text-center">Tabel rata-rata masa tunggu ({{ $startYear }} -
                        {{ $endYear }})</h2>
                    <div class="table-responsive">
                        <table id="tabel-rata-rata-masa-tunggu" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Tahun Lulusan</th>
                                    <th class="text-center">Jumlah Lulusan</th>
                                    <th class="text-center">Jumlah Terlacak</th>
                                    <th class="text-center">Rata-rata Waktu Tunggu (Bulan)</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <!-- Isi data akan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <h2 class="mb-4 fs-4 text-center">Tabel performa lulusan ({{ $startYear }} - {{ $endYear }})
                    </h2>
                    <div class="table-responsive">
                        <table id="tabel-performa-lulusan" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Jenis Kemampuan</th>
                                    <th class="text-center">Sangat Baik (%)</th>
                                    <th class="text-center">Baik (%)</th>
                                    <th class="text-center">Cukup (%)</th>
                                    <th class="text-center">Kurang (%)</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Total</th>
                                    <th id="total-sangat-baik" class="text-center"></th>
                                    <th id="total-baik" class="text-center"></th>
                                    <th id="total-cukup" class="text-center"></th>
                                    <th id="total-kurang" class="text-center"></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <!-- Isi data akan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 4: Beberapa Chart Kecil -->
        <div class="row mb-3">
            <div class="col-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <strong>Kerjasama Tim ({{ $startYear }} - {{ $endYear }})</strong>
                    <div id="chart_kerjasama_tim" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <strong>Keahlian di Bidang TI ({{ $startYear }} - {{ $endYear }})</strong>
                    <div id="chart_keahlian_di_bidang_ti" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <strong>Kemampuan Bahasa Asing ({{ $startYear }} - {{ $endYear }})</strong>
                    <div id="chart_kemampuan_bahasa_asing" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <strong>Kemampuan Komunikasi ({{ $startYear }} - {{ $endYear }})</strong>
                    <div id="chart_kemampuan_komunikasi" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <strong>Pengembangan Diri ({{ $startYear }} - {{ $endYear }})</strong>
                    <div id="chart_pengembangan_diri" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <strong>Kepemimpinan ({{ $startYear }} - {{ $endYear }})</strong>
                    <div id="chart_kepemimpinan" style="height: 300px;"></div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded  "data-aos="fade-up">
                    <strong>Etos Kerja ({{ $startYear }} - {{ $endYear }})</strong>
                    <div id="chart_etos_kerja" style="height: 300px;"></div>
                </div>
            </div>
        </div>

    </div>


    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="{{ asset('js/dashboard/profesi_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/intansi_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/performa_chart.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    {{-- filter --}}
    <script>
        const yearPicker = document.getElementById("yearPicker");
        const input = document.getElementById("selectedYears");
        const saveBtn = document.getElementById("saveYearSelection");
        const prodiSelect = document.getElementById("prodiSelect");
        const yearAlert = document.getElementById("yearAlert");

        let selectedStart = null;
        let selectedEnd = null;

        for (let y = 2000; y <= new Date().getFullYear(); y++) {
            const btn = document.createElement("div");
            btn.textContent = y;
            btn.className = "year-option";
            btn.dataset.year = y;
            yearPicker.appendChild(btn);
        }

        yearPicker.addEventListener("click", (e) => {
            if (!e.target.classList.contains("year-option")) return;
            const year = parseInt(e.target.dataset.year);

            if (selectedStart === null || (selectedStart !== null && selectedEnd !== null)) {
                selectedStart = year;
                selectedEnd = null;
            } else if (year >= selectedStart) {
                selectedEnd = year;
            } else {
                selectedStart = year;
                selectedEnd = null;
            }

            document.querySelectorAll(".year-option").forEach(btn => {
                btn.classList.remove("selected");
            });

            if (selectedStart !== null) {
                document.querySelector(`.year-option[data-year='${selectedStart}']`).classList.add("selected");
            }
            if (selectedEnd !== null) {
                for (let y = selectedStart; y <= selectedEnd; y++) {
                    document.querySelector(`.year-option[data-year='${y}']`)?.classList.add("selected");
                }
                input.value = `${selectedStart} - ${selectedEnd}`;
            }
        });

        prodiSelect.addEventListener("change", () => {
            const selectedProdi = prodiSelect.value;
            const start_year = <?php echo json_encode($startYear); ?>;
            const end_year = <?php echo json_encode($endYear); ?>;
            $.get("{{ route('dashboard.filter') }}", {
                _token: '{{ csrf_token() }}',
                start_year: start_year,
                end_year: end_year,
                prodi_id: selectedProdi
            }).done(function(response) {
                window.location.href = '{{ route('dashboard') }}' +
                    `?start_year=${start_year || ''}&end_year=${end_year || ''}&prodi_id=${selectedProdi || ''}`;
            });

        });

        saveBtn.addEventListener("click", () => {
            if (selectedStart === null && selectedEnd === null) {
                yearAlert.classList.remove("d-none");
                return;
            } else if (selectedEnd === null) {
                selectedEnd = selectedStart;
            }

            yearAlert.classList.add("d-none");

            const selectedProdi = prodiSelect.value;

            $.get("{{ route('dashboard.filter') }}", {
                _token: '{{ csrf_token() }}',
                start_year: selectedStart,
                end_year: selectedEnd,
                prodi_id: selectedProdi
            }).done(function(response) {
                window.location.href = '{{ route('dashboard') }}' +
                    `?start_year=${selectedStart}&end_year=${selectedEnd}&prodi_id=${selectedProdi}`;
            });
        });
    </script>


    {{-- Chart --}}
    <script>
        const profesiChartData = [
            @foreach ($topProfesi as $profesi)
                {
                    profesi: "{{ $profesi->nama_profesi }}",
                    amount: {{ $profesi->jumlah }}
                },
            @endforeach
        ];

        const instansiChartData = [
            @foreach ($jenisInstansi as $item)
                {
                    instansi: "{{ $item->jenis_instansi }}",
                    amount: {{ $item->jumlah }}
                },
            @endforeach
        ];
        const performaChartData = @json($chartData);
    </script>
    {{-- table --}}
    <script>
        $(document).ready(function() {
            $('#tabel-lulusan').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ordering: false,
                ajax: {
                    "url": "{{ url('dashboard/lulusan/table') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        const prodi_id = <?php echo json_encode($prodi_id); ?>;
                        const start_year = <?php echo json_encode($startYear); ?>;
                        const end_year = <?php echo json_encode($endYear); ?>;
                        d.filter_prodi = prodi_id;
                        d.start_year = start_year;
                        d.end_year = end_year;

                    }
                },
                dom: '<"table-responsive"t>',
                columns: [{
                        data: 'tahun_lulus',
                        name: 'tahun_lulus'
                    },
                    {
                        data: 'total_lulusan',
                        name: 'total_lulusan'
                    },
                    {
                        data: 'lulusan_terlacak',
                        name: 'lulusan_terlacak'
                    },
                    {
                        data: 'kerja_bidang_infokom',
                        name: 'kerja_bidang_infokom'
                    },
                    {
                        data: 'kerja_bidang_non_infokom',
                        name: 'kerja_bidang_non_infokom'
                    },
                    {
                        data: 'internasional',
                        name: 'internasional'
                    },
                    {
                        data: 'nasional',
                        name: 'nasional'
                    },
                    {
                        data: 'wirausaha',
                        name: 'wirausaha'
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    var total = function(colIndex) {
                        return api
                            .column(colIndex)
                            .data()
                            .reduce(function(a, b) {
                                return parseFloat(a) + parseFloat(b) || 0;
                            }, 0);
                    };

                    $(api.column(0).footer()).html(
                        '<b>Jumlah</b>');
                    for (var i = 1; i <= 7; i++) {
                        $(api.column(i).footer()).html('<b>' + total(i) + '</b>');
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            tabel_rata_rata_masa_tunggu = $('#tabel-rata-rata-masa-tunggu').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ordering: false,
                ajax: {
                    "url": "{{ url('dashboard/masa_tunggu/table') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        const prodi_id = <?php echo json_encode($prodi_id); ?>;
                        const start_year = <?php echo json_encode($startYear); ?>;
                        const end_year = <?php echo json_encode($endYear); ?>;
                        d.filter_prodi = prodi_id;
                        d.start_year = start_year;
                        d.end_year = end_year;
                    }
                },
                dom: '<"table-responsive"t>',
                columns: [{
                        data: 'tahun_lulusan',
                        name: 'tahun_lulusan'
                    },
                    {
                        data: 'jumlah_lulusan',
                        name: 'jumlah_lulusan'
                    },
                    {
                        data: 'jumlah_terlacak',
                        name: 'jumlah_terlacak'
                    },
                    {
                        data: 'rata_rata_waktu_tunggu_bulan',
                        name: 'rata_rata_waktu_tunggu_bulan'
                    },
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    var totalJumlahLulusan = api.column(1).data().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    var totalJumlahTerlacak = api.column(2).data().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    var totalRataWaktuTunggu = api.column(3).data().reduce(function(a, b) {
                        return a + (isNaN(b) ? 0 : b);
                    }, 0);

                    $(api.column(1).footer()).html(totalJumlahLulusan);
                    $(api.column(2).footer()).html(totalJumlahTerlacak);

                    $(api.column(3).footer()).html(totalRataWaktuTunggu > 0 ? (totalRataWaktuTunggu /
                        data.length).toFixed(2) : 0);
                }
            });
            $('.filter_prodi').change(function() {
                tabel_rata_rata_masa_tunggu.draw();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#tabel-performa-lulusan').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ordering: false,
                ajax: {
                    "url": "{{ url('dashboard/performa_lulusan/table') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        const prodi_id = <?php echo json_encode($prodi_id); ?>;
                        const start_year = <?php echo json_encode($startYear); ?>;
                        const end_year = <?php echo json_encode($endYear); ?>;
                        d.filter_prodi = prodi_id;
                        d.start_year = start_year;
                        d.end_year = end_year;
                        console.log(d);
                    }
                },
                dom: '<"table-responsive"t>',
                columns: [{
                        data: 'jenis_kemampuan',
                        name: 'jenis_kemampuan'
                    },
                    {
                        data: 'sangat_baik',
                        name: 'sangat_baik',
                        render: function(data, type, row) {
                            return data + '%';
                        }
                    },
                    {
                        data: 'baik',
                        name: 'baik',
                        render: function(data, type, row) {
                            return data + '%';
                        }
                    },
                    {
                        data: 'cukup',
                        name: 'cukup',
                        render: function(data, type, row) {
                            return data + '%';
                        }
                    },
                    {
                        data: 'kurang',
                        name: 'kurang',
                        render: function(data, type, row) {
                            return data + '%';
                        }
                    }
                ],

                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var totalSangatBaik = api.column(1, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return a + parseFloat(b.replace('%', '')) || 0;
                    }, 0);

                    var totalBaik = api.column(2, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return a + parseFloat(b.replace('%', '')) || 0;
                    }, 0);

                    var totalCukup = api.column(3, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return a + parseFloat(b.replace('%', '')) || 0;
                    }, 0);

                    var totalKurang = api.column(4, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return a + parseFloat(b.replace('%', '')) || 0;
                    }, 0);

                    var totalSum = totalSangatBaik + totalBaik + totalCukup + totalKurang;
                    var percentSangatBaik = (totalSangatBaik / totalSum) * 100;
                    var percentBaik = (totalBaik / totalSum) * 100;
                    var percentCukup = (totalCukup / totalSum) * 100;
                    var percentKurang = (totalKurang / totalSum) * 100;

                    $('#total-sangat-baik').text(percentSangatBaik.toFixed(2) + '%');
                    $('#total-baik').text(percentBaik.toFixed(2) + '%');
                    $('#total-cukup').text(percentCukup.toFixed(2) + '%');
                    $('#total-kurang').text(percentKurang.toFixed(2) + '%');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        
        AOS.init({
            duration: 1200,
            easing: 'ease-in-out',
            delay: 100, // delay global, bisa juga pakai atribut data-aos-delay di elemen
            once: true,
            offset: 250
        });
    </script>
    <style>
        table.dataTable tfoot th {
            background-color: #5a8dee !important;
            color: #fafafa !important;
        }

        table.dataTable thead th {
            background-color: #5a8dee !important;
            color: #fafafa !important;
        }

        th,
        td {
            text-align: center;
            vertical-align: middle;
        }

        .year-option {
            padding: 8px;
            background: #f1f1f1;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.2s;
            user-select: none;
        }

        .year-option:hover {
            background: #e0e0e0;
        }

        .selected {
            background: #5a8dee !important;
            color: white;
        }

        .modal-content {
            border-radius: 8px;
        }

        .btn-outline-secondary {
            color: #5a8dee;
            border-color: #5a8dee;
        }

        .btn-outline-secondary:hover {
            background-color: #5a8dee;
            color: white;
        }
    </style>
@endsection
