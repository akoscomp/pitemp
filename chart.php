<?php
    include 'header.php';
    $fileTempLog = '/home/akos/pitemp/sensors/templog.json';
    $jsonTempLog = file_get_contents($fileTempLog);
    $tempdata = json_decode($jsonTempLog, TRUE);
?>


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var jsonDataDay = $.ajax({
          url: "getData.php?day=1",
          dataType:"json",
          async: false
          }).responseText;
          
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonDataDay);
        var options = {
          title: 'Napi hőmérséklet adatok'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_day'));
        chart.draw(data, options);
      }
      google.setOnLoadCallback(drawChartWeek);
      function drawChartWeek() {
        var jsonDataDay = $.ajax({
          url: "getData.php?day=7",
          dataType:"json",
          async: false
          }).responseText;
          
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonDataDay);
        var options = {
          title: 'Heti hőmérséklet adatok'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_week'));
        chart.draw(data, options);
      }
      google.setOnLoadCallback(drawChartYear);
      function drawChartYear() {
        var jsonDataDay = $.ajax({
          url: "getData.php?day=365",
          dataType:"json",
          async: false
          }).responseText;
          
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonDataDay);
        var options = {
          title: 'Éves hőmérséklet adatok'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_year'));
        chart.draw(data, options);
      }
</script>
<div id="chart_div_day" style="width: 900px; height: 500px;"></div>
<div id="chart_div_week" style="width: 900px; height: 500px;"></div>
<div id="chart_div_year" style="width: 900px; height: 500px;"></div>


<?php
    include 'footer.php';
?>