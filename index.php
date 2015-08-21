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
        <div class="page-header" ></div>
      <div class="kozepre">
        <?php
          $power = ($sensors['boiler']['power']) ? 'On' : 'Off';
          $color = ($sensors['boiler']['power']) ? 'green' : 'red';
        ?>
        <div class="btn-group">
            <button type="button" id="boilerpower" data-sensorid="boilerpower" data-type="<?php echo $power ?>" class="btn btn-default" onclick="turnOnOff(this)">
              <span class="glyphicon glyphicon-off" style="color: <?php echo $color ?>;"></span>
            </button>
            <button type="button" id="turnOnOffboilerpower" class="btn btn-default disabled" aria-expanded="false">Kazán: <?php echo $power ?></button>
        </div>
      </div>
      <div class="kozepre">
        <div id="container" class="js-masonry"
             data-masonry-options='{ "columnWidth": 0, "itemSelector": ".item" }'>
        <?php
          foreach ($sensors['groups'] as $group) {
            echo '<div class="item szobauj">';  
            foreach ($sensors['tempsensors'] as $sensor) {
              if ( $sensor["group"] === $group) { 
                if ( $sensor['type'] === 'heat' ) {
                    echo '<p><button id="'.$sensor["id"].'" name="'.$sensor["name"].'" type="button" class="btn btn-lg btn-default disabled" onclick="read()"><span class="glyphicon glyphicon-fire" style="{ visibility: hidden; }"></span>'.$sensor["name"].': <span class="btTemp">00.0</span>&deg;C</button></p>';
                    echo '<div class="btn-group">';
                    echo '<button type="button" class="btn btn-xs btn-danger" onclick="changeTemp(this)">-</button>';
                    echo '<button id="setTemp'.$sensor["id"].'" data-sensorid="'.$sensor["id"].'" data-type="settemp" type="button" class="btn btn-xs btn-info disabled" onclick="setTemp(this)">'.number_format($sensor['settemp'],1).'</button>';
                    echo '<button type="button" class="btn btn-xs btn-success" onclick="changeTemp(this)">+</button>&nbsp;&nbsp;';
                    echo '</div>';
                        if ($sensor['power'] && $sensor['isauto']) {
                            echo '<button type="button" id="turnOnOff'.$sensor["id"].'" data-sensorid="'.$sensor["id"].'" data-type="off" class="btn btn-xs btn-danger" onclick="turnOnOff(this)" title="Turn Off"><span class="glyphicon glyphicon-off"></span></button>&nbsp;';
                        } elseif (!$sensor['power'] && $sensor['isauto']) {
                            echo '<button type="button" id="turnOnOff'.$sensor["id"].'" data-sensorid="'.$sensor["id"].'" data-type="on" class="btn btn-xs btn-success" onclick="turnOnOff(this)" title="Turn On"><span class="glyphicon glyphicon-off"></span></button>&nbsp;';
                        }
                    echo '<p></p>';
                } elseif ( $sensor['type'] === 'air' ) {
                    echo '<p><button id="'.$sensor["id"].'" name="'.$sensor["name"].'" type="button" class="btn btn-lg btn-success disabled" onclick="read()">'.$sensor["name"].': 00.0&deg;C</button>&nbsp;';
                } elseif ( $sensor['type'] === 'floor' || $sensor['type'] === 'wall') {
                    echo '<p><button id="'.$sensor["id"].'" name="'.$sensor["name"].'" type="button" class="btn btn-sm btn-info disabled" onclick="read()">'.$sensor["name"].': 00.0&deg;C</button>&nbsp;';
                    if ( $sensor['isauto'] === true ) {
                        echo '<div class="btn-group">';
                        echo '<button type="button" class="btn btn-xs btn-danger" onclick="changeTemp(this)">-</button>';
                        echo '<button id="minTemp'.$sensor["id"].'" data-sensorid="'.$sensor["id"].'" data-type="mintemp" type="button" class="btn btn-xs btn-info disabled" onclick="setTemp(this)">'.number_format($sensor['mintemp'],1).'</button>';
                        echo '<button type="button" class="btn btn-xs btn-success" onclick="changeTemp(this)">+</button>&nbsp;&nbsp;';
                        echo '</div>';
                        if ($sensor['power'])
                            echo '<button type="button" id="turnOnOff'.$sensor["id"].'" data-sensorid="'.$sensor["id"].'" data-type="off" class="btn btn-xs btn-danger" onclick="turnOnOff(this)" title="Turn Off"><span class="glyphicon glyphicon-off"></span></button>&nbsp;';
                        else
                            echo '<button type="button" id="turnOnOff'.$sensor["id"].'" data-sensorid="'.$sensor["id"].'" data-type="on" class="btn btn-xs btn-success" onclick="turnOnOff(this)" title="Turn On"><span class="glyphicon glyphicon-off"></span></button>&nbsp;';
                        echo '<div class="btn-group">';
                        echo '<button type="button" class="btn btn-xs btn-danger" onclick="changeTemp(this)">-</button>';
                        echo '<button id="maxTemp'.$sensor["id"].'" data-sensorid="'.$sensor["id"].'" data-type="maxtemp" type="button" class="btn btn-xs btn-info disabled" onclick="setTemp(this)">'.number_format($sensor['maxtemp'],1).'</button>';
                        echo '<button type="button" class="btn btn-xs btn-success" onclick="changeTemp(this)">+</button>&nbsp;&nbsp;';
                        echo '</div><p></p>';
                        }
                    }
                }
            }
          echo '</div>';
          }
        ?>
        </div>
        <p>Frissítve <span id='counter' style='font-weight:500; font-size:20px; padding:0px 2px;'>0</span> alkalommal.</p>
        <div id="chart_div" style="width: 80%; height: 400px;"></div>
      </div>
    </div>

<script src="js/masonry.pkgd.min.js"></script>

<?php
    include 'footer.php';
?>
