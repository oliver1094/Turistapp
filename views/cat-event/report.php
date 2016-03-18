<?php

use miloschuman\highcharts\Highcharts;

$this->registerJs("		

$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            backgroundColor: '#f1f1f1',
        },
        title: {
            text: 'Mis eventos'
        },
        subtitle:{
            text: '(Esta gráfica muestra las calificaciones de cada evento que has registrado y el número de turistas que han agregado los eventos a su itinerario)'
        },
        xAxis: {
            categories: [" . $namesEvents . "],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cantidad'
            }
        },
       
        tooltip: {
            headerFormat: '<span style=\'font-size:10px\'>{point.key}</span><table>',
            pointFormat: '<tr><td style=\'color:{series.color};padding:0\'>{series.name}: </td>' +
                '<td style=\'padding:0\'><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
        },
        series: [{
            name: 'Calificación',
            data: [" . $scoresEvents . "]                
        }, {
            name: 'No. turistas',
            data: [" . $numberOfTourist . "]
        }],       
    });
});");
?>

<div id="container" class="ibox-content animated fadeInDown"></div><br><br>

<div style="height: 1px; width: 100%; background-color: black"></div><br><br>
<div class="ibox-content animated fadeInDown">
<?php

echo Highcharts::widget([
    'options' => [        
        'title' => ['text' => 'Ganancias esperadas x Evento'],
        'subtitle' => ['text' => '(Esta gráfica muestra las ganancias que se esperan por cada evento, estas ganancias dependen de cuántos turistas han agregado el evento a su itininerario)'],
        'xAxis' => [
            'categories' => $namesEventsArray
        ],
        'yAxis' => [
            'title' => ['text' => 'Cantidad ($)']
        ],
        'series' => [
            ['name' => 'Ganancia', 'data' => $earnings],
        ],
        'tooltip' => [
            'pointFormat' => 'Ganancia: <b>${point.y:.2f}</b>'
        ],
        'chart' => [
            'backgroundColor' => '#f1f1f1'
        ]
    ]
]);
?>

<p>Ganancias totales esperadas: <strong>$<?php echo number_format((float) $totalEarnings, 2, '.', '') ?></</p>
</div>