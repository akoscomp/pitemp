<?php
    include 'header.php';
    $configUrl = "/home/akos/pitemp/data/config.json";
    $jsonConfig = file_get_contents($configUrl);
    $config = json_decode($jsonConfig, TRUE);
    $fileTempLog = '/home/akos/pitemp/sensors/templog.json';
    $jsonTempLog = file_get_contents($fileTempLog);
    $tempdata = json_decode($jsonTempLog, TRUE);
    
?>


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var jsonData = $.ajax({
          url: "getData.php",
          dataType:"json",
          async: false
          }).responseText;
          
        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);

        var options = {
          title: 'Company Performance'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>


<?php
    include 'footer.php';
?>