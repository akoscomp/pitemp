<?php
    include 'header.php';
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
          title: 'Napi hőmérséklet adatok'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
</script>

<!-- Gombok -->    
    <div class="container">
      <div class="page-header" />
        <div class="kozepre">
        <?php foreach ($sensors['tempsensors'] as $sensor) {
           echo '<div class="vonal">';
           echo '<p><button id="'.$sensor["id"].'" name="'.$sensor["name"].'" type="button" class="btn btn-lg btn-default disabled" onclick="read()"><span class="badge"></span>'.$sensor["name"].': 00.0&deg;C</button></p>';
        ?>
            <div class="btn-group">
                <button type="button" class="btn btn-danger" onclick="changeTemp(this)">-</button>
                <button id="setTemp<?php echo $sensor["id"] ?>" type="button" class="btn btn-info disabled" onclick="setTemp(this)"><?php echo number_format($sensor['settemp'],1); ?></button>
                <button type="button" class="btn btn-success" onclick="changeTemp(this)">+</button>
            </div>
            <p></p>
        <?php
            echo '</div>';
        } ?>
            <p>Frissítve <span id='counter' style='font-weight:500; font-size:20px; padding:0px 2px;'>0</span> alkalommal.</p>
            <div id="chart_div" style="width: 80%; height: 400px;"></div>
        </div>
  </div>
    </div>

<?php
    include 'footer.php';
?>
