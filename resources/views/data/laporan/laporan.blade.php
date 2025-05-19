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

    {{-- Card utama --}}
    <div class="card mt-4">
        <div class="card-body">
            <div class="row">
                <div class="row pe-2">
                    {{-- Card 1 --}}
                    <div class="col-md-6 mb-3">
                        <div class="card bg-white text-dark shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-4 fs-4">Rekap Hasil Tracer Study Lulusan</h5>
                                <div id="profesi_chart" style="width: 100%; height: 400px;"></div>

                                <form action="{{ route('laporan.export.tracer') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="start_year" value="{{ $startYear }}">
                                    <input type="hidden" name="end_year" value="{{ $endYear }}">
                                    <input type="hidden" name="prodi_id" value="{{ $prodi_id }}">

                                    <button type="submit" class="btn btn-success btn-sm">
                                        Download Laporan
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="col-md-6 mb-3">
                        <div class="card bg-white text-dark shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-4 fs-4">Rekap Hasil Survei Kepuasan Pengguna Lulusan</h5>
                                <div id="performa_chart" style="width: 100%; height: 400px;"></div>
                                <form action="{{ route('laporan.export.kepuasan') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="start_year" value="{{ $startYear }}">
                                    <input type="hidden" name="end_year" value="{{ $endYear }}">
                                    <input type="hidden" name="prodi_id" value="{{ $prodi_id }}">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Download Laporan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Card 3 --}}
                    <div class="col-md-6 mb-3">
                        <div class="card bg-white text-dark shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-4 fs-4">Rekap Lulusan Yang Belum Mengisi Tracer Study</h5>
                                <div id="belum_tracer_chart" style="width: 100%; height: 400px;"></div>
                                <form action="{{ route('laporan.export.belumTracer') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="start_year" value="{{ $startYear }}">
                                    <input type="hidden" name="end_year" value="{{ $endYear }}">
                                    <input type="hidden" name="prodi_id" value="{{ $prodi_id }}">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Download Laporan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Card 4 --}}
                    <div class="col-md-6 mb-3">
                        <div class="card bg-white text-dark shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-4 fs-4">Rekap Atasan Yang Belum Mengisi Survei Kepuasan</h5>
                                <div id="belum_survei_chart" style="width: 100%; height: 400px;"></div>
                                <form action="{{ route('laporan.export.belumSurvei') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="start_year" value="{{ $startYear }}">
                                    <input type="hidden" name="end_year" value="{{ $endYear }}">
                                    <input type="hidden" name="prodi_id" value="{{ $prodi_id }}">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Download Laporan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> {{-- /.row --}}
            </div> {{-- /.card-body --}}
        </div> {{-- /.card --}}
    </div>

    </div><!-- /.container-fluid -->
    </section>

    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="{{ asset('js/dashboard/profesi_chart.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    {{-- Chart --}}
    <script>
        // Data 1: Rekap hasil tracer study lulusan (Donut Chart)
        const profesiChartData = [
            @foreach ($topProfesi as $profesi)
                {
                    category: "{{ $profesi->nama_profesi }}",
                    value: {{ $profesi->jumlah }}
                },
            @endforeach
        ];

        // Data 2: Rekap hasil survei kepuasan pengguna lulusan (Bar Chart)
        const performaChartData = @json($chartData);

        am4core.ready(function() {
            am4core.useTheme(am4themes_animated);

            // Chart 1: Pie / Donut Chart
            var chart1 = am4core.create("profesi_chart", am4charts.PieChart);
            chart1.data = profesiChartData;
            chart1.innerRadius = am4core.percent(40);
            var pieSeries1 = chart1.series.push(new am4charts.PieSeries());
            pieSeries1.dataFields.value = "value";
            pieSeries1.dataFields.category = "category";
            pieSeries1.labels.template.disabled = true;
            pieSeries1.ticks.template.disabled = true;
            chart1.legend = new am4charts.Legend();

            // Chart 2: Bar Chart
            var chart2 = am4core.create("performa_chart", am4charts.XYChart);
            chart2.data = performaChartData;
            let categoryAxis = chart2.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "kategori";
            categoryAxis.renderer.grid.template.location = 0;
            let valueAxis = chart2.yAxes.push(new am4charts.ValueAxis());

            let seriesColors = ["#5B8FF9", "#61DDAA", "#F6BD16", "#E8684A"];
            ["sangat_baik", "baik", "cukup", "kurang"].forEach((key, idx) => {
                let series = chart2.series.push(new am4charts.ColumnSeries());
                series.name = key.replace('_', ' ').toUpperCase();
                series.dataFields.valueY = key;
                series.dataFields.categoryX = "kategori";
                series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
                series.columns.template.fill = am4core.color(seriesColors[idx]);
            });
            chart2.legend = new am4charts.Legend();

            var label = chart4.seriesContainer.createChild(am4core.Label);
            label.text = "731"; // Totalnya bisa kamu hitung otomatis kalau mau
            label.horizontalCenter = "middle";
            label.verticalCenter = "middle";
            label.fontSize = 24;
        });
    </script>


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
            $.get("{{ route('laporan.filter') }}", {
                _token: '{{ csrf_token() }}',
                start_year: start_year,
                end_year: end_year,
                prodi_id: selectedProdi
            }).done(function(response) {
                window.location.href = '{{ route('laporan') }}' +
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

            $.get("{{ route('laporan.filter') }}", {
                _token: '{{ csrf_token() }}',
                start_year: selectedStart,
                end_year: selectedEnd,
                prodi_id: selectedProdi
            }).done(function(response) {
                window.location.href = '{{ route('laporan') }}' +
                    `?start_year=${selectedStart}&end_year=${selectedEnd}&prodi_id=${selectedProdi}`;
            });
        });
    </script>
    <style>
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
