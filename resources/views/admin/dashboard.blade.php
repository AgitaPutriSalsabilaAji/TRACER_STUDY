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

    <div class="container-fluid py-3">
        <div class="row justify-content-between">

            <div class="col-md-5">
                <label class="form-label text-white">Program Studi</label>
                <select class="form-select form-select-sm">
                    <option selected>Pilih Program Studi</option>
                    <option value="1">Teknik Informatika</option>
                    <option value="2">Teknik Elektro</option>
                </select>
            </div>

            <div class="col-md-5 text-end">
                <label class="form-label text-white">Tahun Angkatan</label>
                <select class="form-select form-select-sm">
                    <option value="2021-2024">2021 - 2024</option>
                    <option value="2022-2025">2022 - 2025</option>
                    <option value="2023-2026">2023 - 2026</option>
                </select>
            </div>

        </div>
    </div>

    <div class="container-fluid my-6 px-4">
        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="p-4 bg-white shadow rounded">
                    <div class="container pt-0"> Sebaran Profesi
                        <div id="profesi_chart" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="p-4 bg-white shadow rounded">
                    <div class="container pt-0"> Sebaran Jenis Instansi
                        <div id="intansi_chart" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: 1 full column -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="p-4 bg-white shadow rounded">
                    <div class="container mt-5">
                        <div class="card-header">
                            <strong>Data Lulusan (2025 - 2030)</strong>
                        </div>
                        <div class="card-body ">
                            <table id="tabel-lulusan" class="table table-bordered table-striped table w-100">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Tahun Lulus</th>
                                        <th rowspan="2">Total Lulusan</th>
                                        <th rowspan="2">Lulusan Terlacak</th>
                                        <th rowspan="2">Kerja Bidang Infokom</th>
                                        <th rowspan="2">Kerja Bidang Non-Infokom</th>
                                        <th colspan="3" class="text-center">Tempat Kerja</th> <!-- Kolom gabungan -->
                                    </tr>
                                    <tr>
                                        <th>Internasional</th> <!-- Tempat Kerja -->
                                        <th>Nasional</th> <!-- Tempat Kerja -->
                                        <th>Regional</th> <!-- Tempat Kerja -->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><b>Jumlah</b></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><b></b></th>
                                        <th><b></b></th>
                                        <th><b></b></th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: 2 columns -->
        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="p-4 bg-white shadow rounded">Box 4
                    <div class="container mt-5">
                        <h2 class="mb-4">Contoh Tabel Bootstrap 5</h2>

                        <!-- Tabel -->
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>johndoe@example.com</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>janesmith@example.com</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <!-- Baris lainnya -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 bg-white shadow rounded">Box 5
                    <div class="container mt-5">
                        <h2 class="mb-4">Contoh Tabel Bootstrap 5</h2>

                        <!-- Tabel -->
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>johndoe@example.com</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>janesmith@example.com</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <!-- Baris lainnya -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded">Box 6
                    <div id="chartdiv4"></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded">Box 7
                    <div id="chartdiv4"></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded">Box 8
                    <div id="chartdiv4"></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded">Box 9
                    <div id="chartdiv4"></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded">Box 10
                    <div id="chartdiv4"></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded">Box 11
                    <div id="chartdiv4"></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="p-4 bg-white shadow rounded">Box 12
                    <div id="chartdiv4"></div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="p-4 bg-white shadow rounded">Box 3 (full)
                    <div id="chartdiv5"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ini 1 bos --}}
   

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <script src="{{ asset('js/dashboard/profesi_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/intansi_chart.js') }}"></script> 

    <script>
        window.profesiChartData = [
            @foreach ($topProfesi as $profesi)
                {
                    profesi: "{{ $profesi->nama_profesi }}",
                    amount: {{ $profesi->jumlah }}
                },
            @endforeach
        ];
        
        window.instansiChartData = [
            @foreach ($jenisInstansi as $item)
                {
                    instansi: "{{ $item->jenis_instansi }}",
                    amount: {{ $item->jumlah }}
                },
            @endforeach
        ];
    </script>
    


    {{-- ini 4 bos --}}
    <style>
        #chartdiv4 {
            width: 100%;
            height: 500px;
        }
    </style>



    <!-- Chart code -->
    <script>
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create chart instance
            var chart = am4core.create("chartdiv4", am4charts.PieChart);

            // Add and configure Series
            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "litres";
            pieSeries.dataFields.category = "country";

            // Let's cut a hole in our Pie chart the size of 30% the radius
            chart.innerRadius = am4core.percent(30);

            // Put a thick white border around each Slice
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.slices.template
                // change the cursor on hover to make it apparent the object can be interacted with
                .cursorOverStyle = [{
                    "property": "cursor",
                    "value": "pointer"
                }];

            pieSeries.alignLabels = false;
            pieSeries.labels.template.bent = true;
            pieSeries.labels.template.radius = 3;
            pieSeries.labels.template.padding(0, 0, 0, 0);

            pieSeries.ticks.template.disabled = true;

            // Create a base filter effect (as if it's not there) for the hover to return to
            var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
            shadow.opacity = 0;

            // Create hover state
            var hoverState = pieSeries.slices.template.states.getKey(
                "hover"); // normally we have to create the hover state, in this case it already exists

            // Slightly shift the shadow and make it more prominent on hover
            var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
            hoverShadow.opacity = 0.7;
            hoverShadow.blur = 5;

            // Add a legend
            chart.legend = new am4charts.Legend();

            chart.data = [{
                "country": "Lithuania",
                "litres": 501.9
            }, {
                "country": "Germany",
                "litres": 165.8
            }, {
                "country": "Australia",
                "litres": 139.9
            }, {
                "country": "Belgium",
                "litres": 60
            }];

        }); // end am4core.ready()
    </script>

    {{-- ini 5 bos --}}
    <!-- Styles -->
    <style>
        #chartdiv5 {
            width: 100%;
            height: 500px;
        }
    </style>



    <!-- Chart code -->
    <script>
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            var container = am4core.create("chartdiv5", am4core.Container);
            container.width = am4core.percent(100);
            container.height = am4core.percent(100);
            container.layout = "horizontal";


            var chart = container.createChild(am4charts.PieChart);

            // Add data
            chart.data = [{
                "country": "Lithuania",
                "litres": 500,
                "subData": [{
                    name: "A",
                    value: 200
                }, {
                    name: "B",
                    value: 150
                }, {
                    name: "C",
                    value: 100
                }, {
                    name: "D",
                    value: 50
                }]
            }, {
                "country": "Czech Republic",
                "litres": 300,
                "subData": [{
                    name: "A",
                    value: 150
                }, {
                    name: "B",
                    value: 100
                }, {
                    name: "C",
                    value: 50
                }]
            }, {
                "country": "Ireland",
                "litres": 200,
                "subData": [{
                    name: "A",
                    value: 110
                }, {
                    name: "B",
                    value: 60
                }, {
                    name: "C",
                    value: 30
                }]
            }, {
                "country": "Austria",
                "litres": 120,
                "subData": [{
                    name: "A",
                    value: 60
                }, {
                    name: "B",
                    value: 30
                }, {
                    name: "C",
                    value: 30
                }]
            }];

            // Add and configure Series
            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "litres";
            pieSeries.dataFields.category = "country";
            pieSeries.slices.template.states.getKey("active").properties.shiftRadius = 0;
            //pieSeries.labels.template.text = "{category}\n{value.percent.formatNumber('#.#')}%";

            pieSeries.slices.template.events.on("hit", function(event) {
                selectSlice(event.target.dataItem);
            })

            var chart2 = container.createChild(am4charts.PieChart);
            chart2.width = am4core.percent(30);
            chart2.radius = am4core.percent(80);

            // Add and configure Series
            var pieSeries2 = chart2.series.push(new am4charts.PieSeries());
            pieSeries2.dataFields.value = "value";
            pieSeries2.dataFields.category = "name";
            pieSeries2.slices.template.states.getKey("active").properties.shiftRadius = 0;
            //pieSeries2.labels.template.radius = am4core.percent(50);
            //pieSeries2.labels.template.inside = true;
            //pieSeries2.labels.template.fill = am4core.color("#ffffff");
            pieSeries2.labels.template.disabled = true;
            pieSeries2.ticks.template.disabled = true;
            pieSeries2.alignLabels = false;
            pieSeries2.events.on("positionchanged", updateLines);

            var interfaceColors = new am4core.InterfaceColorSet();

            var line1 = container.createChild(am4core.Line);
            line1.strokeDasharray = "2,2";
            line1.strokeOpacity = 0.5;
            line1.stroke = interfaceColors.getFor("alternativeBackground");
            line1.isMeasured = false;

            var line2 = container.createChild(am4core.Line);
            line2.strokeDasharray = "2,2";
            line2.strokeOpacity = 0.5;
            line2.stroke = interfaceColors.getFor("alternativeBackground");
            line2.isMeasured = false;

            var selectedSlice;

            function selectSlice(dataItem) {

                selectedSlice = dataItem.slice;

                var fill = selectedSlice.fill;

                var count = dataItem.dataContext.subData.length;
                pieSeries2.colors.list = [];
                for (var i = 0; i < count; i++) {
                    pieSeries2.colors.list.push(fill.brighten(i * 2 / count));
                }

                chart2.data = dataItem.dataContext.subData;
                pieSeries2.appear();

                var middleAngle = selectedSlice.middleAngle;
                var firstAngle = pieSeries.slices.getIndex(0).startAngle;
                var animation = pieSeries.animate([{
                    property: "startAngle",
                    to: firstAngle - middleAngle
                }, {
                    property: "endAngle",
                    to: firstAngle - middleAngle + 360
                }], 600, am4core.ease.sinOut);
                animation.events.on("animationprogress", updateLines);

                selectedSlice.events.on("transformed", updateLines);

                //  var animation = chart2.animate({property:"dx", from:-container.pixelWidth / 2, to:0}, 2000, am4core.ease.elasticOut)
                //  animation.events.on("animationprogress", updateLines)
            }


            function updateLines() {
                if (selectedSlice) {
                    var p11 = {
                        x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle),
                        y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle)
                    };
                    var p12 = {
                        x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle + selectedSlice
                            .arc),
                        y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle + selectedSlice.arc)
                    };

                    p11 = am4core.utils.spritePointToSvg(p11, selectedSlice);
                    p12 = am4core.utils.spritePointToSvg(p12, selectedSlice);

                    var p21 = {
                        x: 0,
                        y: -pieSeries2.pixelRadius
                    };
                    var p22 = {
                        x: 0,
                        y: pieSeries2.pixelRadius
                    };

                    p21 = am4core.utils.spritePointToSvg(p21, pieSeries2);
                    p22 = am4core.utils.spritePointToSvg(p22, pieSeries2);

                    line1.x1 = p11.x;
                    line1.x2 = p21.x;
                    line1.y1 = p11.y;
                    line1.y2 = p21.y;

                    line2.x1 = p12.x;
                    line2.x2 = p22.x;
                    line2.y1 = p12.y;
                    line2.y2 = p22.y;
                }
            }

            chart.events.on("datavalidated", function() {
                setTimeout(function() {
                    selectSlice(pieSeries.dataItems.getIndex(0));
                }, 1000);
            });


        }); // end am4core.ready()
    </script>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#tabel-lulusan').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ordering: false,
                ajax: {
                    "url": "{{ url('lulusan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
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
                        data: 'regional',
                        name: 'regional'
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Fungsi untuk menghitung total untuk kolom tertentu
                    var total = function(colIndex) {
                        return api
                            .column(colIndex)
                            .data()
                            .reduce(function(a, b) {
                                // Pastikan data yang digunakan adalah angka
                                return parseFloat(a) + parseFloat(b) || 0;
                            }, 0);
                    };

                    // Update footer dengan total untuk kolom yang sesuai
                    $(api.column(0).footer()).html(
                        '<b>Jumlah</b>'); // Menampilkan 'Jumlah' di kolom Tahun Lulus
                    for (var i = 1; i <= 7; i++) {
                        $(api.column(i).footer()).html('<b>' + total(i) + '</b>');
                    }
                }
            });
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
    </style>
@endsection
