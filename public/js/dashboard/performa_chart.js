am4core.ready(function () {
    am4core.useTheme(am4themes_animated);

    function buatPieChart(idDiv, dataChart) {
        var chart = am4core.create(idDiv, am4charts.PieChart);
        chart.innerRadius = am4core.percent(30);
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";
        pieSeries.labels.template.disabled = true;
    pieSeries.ticks.template.disabled = true;
        chart.legend = new am4charts.Legend();
        chart.data = dataChart;
    }

    Object.entries(performaChartData).forEach(([judul, data]) => {
        let idDiv = "chart_" + judul.toLowerCase().replace(/\s+/g, '_');
        buatPieChart(idDiv, data);
    });
});
