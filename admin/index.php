<?php
include(__DIR__.'/views/header.php');
include(__DIR__.'/sistema.class.php');
$app=new Sistema();
$sql = 'select m.marca, SUM(p.precio*vd.cantidad) as monto
from marca m left join producto p on m.id_marca = p.id_marca
             left join venta_detalle vd on p.id_producto = vd.id_producto
group by m.marca order by m.marca asc;';
$datos =$app->query($sql);
$app->checkRol("Administrador", true);
?>
  <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Marca", "Monto"],
         <?php foreach($datos as $dato):?>
            ["<?php echo $dato['marca']?>",<?php echo $dato['monto'];?>],
          <?php endforeach?>
        ]);
        var options = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  <body>
    <div id="barchart_material" style="width: 900px; height: 500px;"></div>
<?php
include(__DIR__.'/views/footer.php');
?>
