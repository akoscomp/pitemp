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
          title: 'Hőmérséklet adatok'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
</script>

<!-- Gombok -->    
    <div class="container">
      <div class="page-header">
        <h1>Hőmérséklet</h1>
      </div>
        <div class="kozepre">
        <?php foreach ($config['tempsensors'] as $sensor) {
           echo '<div class="vonal">';
           echo '<p><button id="'.$sensor["id"].'" name="'.$sensor["name"].'" type="button" class="btn btn-lg btn-default disabled" onclick="read()">'.$sensor["name"].': 00.0&deg;C</button></p>';
        ?>
            <div class="btn-group">
                <button type="button" class="btn btn-danger" onclick="changeTemp(this)">-</button>
                <button type="button" class="btn btn-info disabled">23.0</button>
                <button type="button" class="btn btn-success" onclick="changeTemp(this)">+</button>
            </div>
            <p></p>
        <?php
            echo '</div>';
        } ?>
        </div>
        <p>Frissítve <span id='counter' style='font-weight:500; font-size:20px; padding:0px 2px;'>0</span> alkalommal.</p>
        <p><input type="checkbox" name="my-checkbox" checked></p>
        <div class="kozepre">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary active">
              <input type="radio" name="options" id="on" checked> On
            </label>
            <label class="btn btn-primary">
              <input type="radio" name="options" id="off"> Off
            </label>
          </div>
        </div>
        <div id="chart_div" style="width: 700px; height: 400px;"></div>
  </div>
    </div>

<?php
    include 'footer.php';
?>