function HighChartPie( renderTo, type, height, data_view, chartTitleText, chartSubtitleText, seriesName, pieSize){
    var chart = Highcharts.chart( renderTo,{
        lang: {
          loading: 'Betöltés...',
          viewFullscreen: 'Teljes képernyő',
          exitFullscreen: 'Kilépés a teljes képernyőből',
          months: ['január', 'február', 'március', 'április', 'május','június',
                  'július', 'augusztus', 'szeptember', 'október', 'november', 'december'],
          shortMonths:  ['jan', 'febr', 'márc', 'ápr', 'máj', 'jún', 'júl', 'aug', 'szept', 'okt', 'nov', 'dec'],
          weekdays: ['vasárnap', 'hétfő', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat'],
          exportButtonTitle: "Exportál",
          printButtonTitle: "Importál",
          rangeSelectorFrom: "ettől",
          rangeSelectorTo: "eddig",
          rangeSelectorZoom: "mutat:",
          downloadCSV: 'Letöltés CSV fileként',
          downloadXLS: 'Letöltés XLS fileként',
          downloadPNG: 'Letöltés PNG képként',
          downloadJPEG: 'Letöltés JPEG képként',
          downloadPDF: 'Letöltés PDF dokumentumként',
          downloadSVG: 'Letöltés SVG formátumban',
          resetZoom: "Visszaállít",
          resetZoomTitle: "Visszaállít",
          thousandsSep: "",
          decimalPoint: ',',
          viewData: 'Táblázat',
          printChart: 'Nyomtatás'
        },
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            height: height,
            type: type
        },
        title: {
            text: chartTitleText
        },
        subtitle: {
            text: chartSubtitleText
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
              valueSuffix: '%'
            }
        },
        plotOptions: {
        pie: {
            size: pieSize,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: seriesName,
            colorByPoint: true,
            data: data_view
            }]
    });
    return chart;
}
