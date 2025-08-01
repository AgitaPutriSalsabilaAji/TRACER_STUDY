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
                    <h1>Rekap Laporan </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan</li>
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
    <div class="container-fluid my-4 px-3">
        <div class="row">
            <div class="row pe-2">
                {{-- Card 1 --}}
                <div class="col-md-6 mb-3">
                    <div class="card bg-white text-dark shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-4 fs-4">Rekap Hasil Tracer Study Lulusan ({{ $startYear }} -
                                {{ $endYear }})</h5>
                            <div id="profesi_chart" style="width: 100%; height: 500px;"></div>

                            <form action="{{ route('laporan.export.tracer') }}" method="post">
                                @csrf
                                <input type="hidden" name="start_year" value="{{ $startYear }}">
                                <input type="hidden" name="end_year" value="{{ $endYear }}">
                                <input type="hidden" name="prodi_id" value="{{ $prodi_id }}">

                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-download"></i> Download Laporan
                                </button>

                            </form>

                        </div>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="col-md-6 mb-3">
                    <div class="card bg-white text-dark shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-4 fs-4">Rekap Hasil Survei Kepuasan Pengguna Lulusan ({{ $startYear }} -
                                {{ $endYear }})</h5>
                            <div id="chart_rekap_survei_kepuasan" style="width: 100%; height: 500px;"></div>
                            <form action="{{ route('laporan.export.kepuasan') }}" method="post">
                                @csrf
                                <input type="hidden" name="start_year" value="{{ $startYear }}">
                                <input type="hidden" name="end_year" value="{{ $endYear }}">
                                <input type="hidden" name="prodi_id" value="{{ $prodi_id }}">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-download"></i> Download Laporan
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
                {{-- Card 3 --}}
                <div class="col-md-6 mb-3">
                    <div class="card bg-white text-dark shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-4 fs-4">Rekap Lulusan Yang Belum Mengisi Tracer Study ({{ $startYear }} -
                                {{ $endYear }})</h5>
                            <div id="belum_tracer"></div>
                            <form action="{{ route('laporan.export.belumTracer') }}" method="post">
                                @csrf
                                <input type="hidden" name="start_year" value="{{ $startYear }}">
                                <input type="hidden" name="end_year" value="{{ $endYear }}">
                                <input type="hidden" name="prodi_id" value="{{ $prodi_id }}">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-download"></i> Download Laporan
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
                {{-- Card 4 --}}
                <div class="col-md-6 mb-3">
                    <div class="card bg-white text-dark shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-4 fs-4">Rekap Atasan Yang Belum Mengisi Survei Kepuasan ({{ $startYear }} -
                                {{ $endYear }})</h5>
                            <div id="belum_survey"></div>
                            <form action="{{ route('laporan.export.belumSurvei') }}" method="post">
                                @csrf
                                <input type="hidden" name="start_year" value="{{ $startYear }}">
                                <input type="hidden" name="end_year" value="{{ $endYear }}">
                                <input type="hidden" name="prodi_id" value="{{ $prodi_id }}">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-download"></i> Download Laporan
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div> {{-- /.row --}}
        </div>
    </div>

    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="{{ asset('js/dashboard/profesi_chart.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

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

        for (let y = 2015; y <= new Date().getFullYear(); y++) {
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

    <!-- Styles -->
    <style>
        #chart_rekap_survei_kepuasan {
            width: 100%;
            height: 300px;
        }
    </style>

    <!-- Chart code -->
    <script>
        am5.ready(function() {
            var root = am5.Root.new("chart_rekap_survei_kepuasan");
            root.setThemes([am5themes_Animated.new(root)]);

            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: root.verticalLayout
            }));

            var legend = chart.children.push(am5.Legend.new(root, {
                centerX: am5.p50,
                x: am5.p50
            }));

            // Ambil data dari Blade
            var data = {!! json_encode($chart_survei, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!};

            // Konversi string ke number
            data = data.map(d => ({
                ...d,
                sangat_baik: parseFloat(d.sangat_baik),
                baik: parseFloat(d.baik),
                cukup: parseFloat(d.cukup),
                kurang: parseFloat(d.kurang)
            }));
            // Gabungkan data berdasarkan jenis_kemampuan
            let groupedData = {};

            data.forEach(item => {
                const key = item.jenis_kemampuan;
                if (!groupedData[key]) {
                    groupedData[key] = {
                        jenis_kemampuan: key,
                        sangat_baik: 0,
                        baik: 0,
                        cukup: 0,
                        kurang: 0
                    };
                }

                groupedData[key].sangat_baik += item.sangat_baik;
                groupedData[key].baik += item.baik;
                groupedData[key].cukup += item.cukup;
                groupedData[key].kurang += item.kurang;
            });

            // Ubah ke bentuk array lagi
            data = Object.values(groupedData);

            // Buat axis
            var xRenderer = am5xy.AxisRendererX.new(root, {
                cellStartLocation: 0.1,
                cellEndLocation: 0.9
            });

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                categoryField: "jenis_kemampuan",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
            }));

            xAxis.data.setAll(data);

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {
                    strokeOpacity: 0.1
                })
            }));

            // Fungsi bikin series
            function makeSeries(name, fieldName) {
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: name,
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: fieldName,
                    categoryXField: "jenis_kemampuan"
                }));

                series.columns.template.setAll({
                    tooltipText: "{name}, {categoryX}: {valueY}%",
                    width: am5.percent(90),
                    tooltipY: 0,
                    strokeOpacity: 0
                });

                series.data.setAll(data);

                series.appear();

                legend.data.push(series);
            }

            // Tambahkan series
            makeSeries("Sangat Baik", "sangat_baik");
            makeSeries("Baik", "baik");
            makeSeries("Cukup", "cukup");
            makeSeries("Kurang", "kurang");

            chart.appear(1000, 100);
        });
    </script>

    <!-- Styles -->
    <style>
        #belum_tracer {
            width: 100%;
            height: 500px;
        }
    </style>

    <!-- Chart code -->
    <script>
        const belumTracerData = @json($belum_tracer);
        am5.ready(function() {

            var root = am5.Root.new("belum_tracer");

            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX",
                pinchZoomX: true,
                paddingLeft: 0,
                paddingRight: 1
            }));

            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
            cursor.lineY.set("visible", false);

            var xRenderer = am5xy.AxisRendererX.new(root, {
                minGridDistance: 30,
                minorGridEnabled: true
            });

            xRenderer.labels.template.setAll({
                rotation: 0,
            });

            xRenderer.grid.template.setAll({
                location: 1
            })

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "country",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
            }));

            var yRenderer = am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1
            });

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                renderer: yRenderer
            }));

            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: "Jumlah Belum Mengisi",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                sequencedInterpolation: true,
                categoryXField: "country",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{valueY}"
                })
            }));

            series.columns.template.setAll({
                cornerRadiusTL: 5,
                cornerRadiusTR: 5,
                strokeOpacity: 0
            });
            series.columns.template.adapters.add("fill", function(fill, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });
            series.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            // Format data dari Laravel
            const chartData = belumTracerData.map(item => ({
                country: ` ${item.tahun_lulus}`,
                value: item.jumlah_belum_mengisi
            }));

            xAxis.data.setAll(chartData);
            series.data.setAll(chartData);

            series.appear(1000);
            chart.appear(1000, 100);

        }); // end am5.ready()
    </script>

    <style>
        #belum_survey {
            width: 100%;
            height: 500px;
        }
    </style>

    <script>
        let belumSurveiData = @json($belum_survey);
        let data = belumSurveiData[0];
        am5.ready(function() {

            // Buat root element
            let chartData = [{
                    value: data.jumlah_belum_mengisi_survei,
                    category: "Belum Mengisi Survei"
                },
                {
                    value: data.jumlah_mengisi_survei,
                    category: "Sudah Mengisi Survei"
                }
            ];

            // Buat root element
            var root = am5.Root.new("belum_survey");

            // Tema animasi
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            // Pie chart
            var chart = root.container.children.push(am5percent.PieChart.new(root, {
                layout: root.verticalLayout
            }));

            // Series
            var series = chart.series.push(am5percent.PieSeries.new(root, {
                valueField: "value",
                categoryField: "category"
            }));

            // Masukkan data ke chart
            series.data.setAll(chartData);
            series.labels.template.set("visible", false);
            series.ticks.template.set("visible", false);

            // Legend
            var legend = chart.children.push(am5.Legend.new(root, {
                centerX: am5.percent(50),
                x: am5.percent(50),
                marginTop: 15,
                marginBottom: 15
            }));

            legend.data.setAll(series.dataItems);

            // Animasi muncul
            series.appear(1000, 100);

        }); // end am5.ready()
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
