(function ($) {
    $(document).ready(function () {
        $(document).ready(function () {
            $('#tabel-lulusan').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ordering: false,
                ajax: {
                    url: lulusanListUrl,
                    dataType: "json",
                    type: "POST",
                    data: function (d) {
                        d._token = csrfToken;
                    }
                },
                dom: '<"table-responsive"t>',
                columns: [
                    { data: 'tahun_lulus', name: 'tahun_lulus' },
                    { data: 'total_lulusan', name: 'total_lulusan' },
                    { data: 'lulusan_terlacak', name: 'lulusan_terlacak' },
                    { data: 'kerja_bidang_infokom', name: 'kerja_bidang_infokom' },
                    { data: 'kerja_bidang_non_infokom', name: 'kerja_bidang_non_infokom' },
                    { data: 'internasional', name: 'internasional' },
                    { data: 'nasional', name: 'nasional' },
                    { data: 'regional', name: 'regional' }
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();
                    var total = function (colIndex) {
                        return api
                            .column(colIndex)
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b) || 0;
                            }, 0);
                    };
                    $(api.column(0).footer()).html('<b>Jumlah</b>');
                    for (var i = 1; i <= 7; i++) {
                        $(api.column(i).footer()).html('<b>' + total(i) + '</b>');
                    }
                }
            });
        });    });
})(jQuery);