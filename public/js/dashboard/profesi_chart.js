am4core.ready(function() {
    am4core.useTheme(am4themes_animated);

    var chart = am4core.create("profesi_chart", am4charts.PieChart3D);
    chart.hiddenState.properties.opacity = 0;

    var data = window.profesiChartData || [];

    chart.data = data;

    var series = chart.series.push(new am4charts.PieSeries3D());
    series.dataFields.value = "amount";
    series.dataFields.category = "profesi";
    series.labels.template.disabled = true;
    series.ticks.template.disabled = true;

    chart.legend = new am4charts.Legend();
    chart.legend.labels.template.fontSize = 10;
    chart.legend.valueLabels.template.fontSize = 10;
    chart.legend.position = "right";
    chart.legend.valign = "middle";
});
