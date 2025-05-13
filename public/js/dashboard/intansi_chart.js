am4core.ready(function () {
    am4core.useTheme(am4themes_animated);

    var chart = am4core.create("intansi_chart", am4charts.PieChart3D);
    chart.hiddenState.properties.opacity = 0;
    chart.innerRadius = am4core.percent(40);
    chart.depth = 120;

    var series = chart.series.push(new am4charts.PieSeries3D());
    series.dataFields.value = "amount";
    series.dataFields.depthValue = "amount";
    series.dataFields.category = "instansi";

    series.slices.template.cornerRadius = 5;
    series.colors.step = 3;
    series.labels.template.disabled = true;
    series.ticks.template.disabled = true;
    

    chart.legend = new am4charts.Legend();
    chart.legend.labels.template.fontSize = 10;
    chart.legend.valueLabels.template.fontSize = 10;
    chart.legend.position = "right";
    chart.legend.valign = "middle";

    chart.data =instansiChartData ;
});
