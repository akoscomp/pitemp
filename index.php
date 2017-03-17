<?php
    include 'header.php';
?>

<!-- Gombok -->    
    <div class="container">
        <div class="page-header" ></div>
      <div class="kozepre">
      <?php
        $gpioList=gpioList();
      ?>
        <div id="container" class="js-masonry"
          data-masonry-options='{ "columnWidth": 0, "itemSelector": ".item" }'>
            <?php
	    foreach ($gpioList as $gpio) {
              echo '<div class="item szobauj">';
	      if ($gpio["value"] == 1) {
                echo '<p><button id="'.$gpio["id"].'" name="name" type="button" class="btn btn-lg btn-default disabled" onclick="pushButton()"><span class="glyphicon glyphicon" style="{ visibility: hidden; }"></span>'.$gpio["name"].': <span class="btTemp">'.getTemp($gpio["id"]).'</span>&deg;C</button></p>';
	      } else {
                echo '<p><button id="'.$gpio["id"].'" name="name" type="button" class="btn btn-lg btn-default disabled" onclick="pushButton()"><span class="glyphicon glyphicon-fire" style="{ visibility: hidden; }"></span>'.$gpio["name"].': <span class="btTemp">'.getTemp($gpio["id"]).'</span>&deg;C</button></p>';
	      }
                    echo '<div class="btn-group">';
                    echo '<button type="button" class="btn btn-xs btn-danger" onclick="changeTemp(this)">-</button>';
                    echo '<button id="setTempSensorid" data-sensorid="sensorid" data-type="settemp" type="button" class="btn btn-xs btn-info disabled" onclick="setTemp(this)">'.number_format(5,1).'</button>';
                    echo '<button type="button" class="btn btn-xs btn-success" onclick="changeTemp(this)">+</button>&nbsp;&nbsp;';
                    echo '</div>';
	            if ($gpio["value"] == 1) {
                      echo '<button type="button" id="turnOnOff'.$gpio["id"].'" data-sensorid="'.$gpio["id"].'" data-type="off" class="btn btn-xs btn-danger" onclick="turnOnOff(this)" title="Turn On"><span class="glyphicon glyphicon-off"></span></button>&nbsp;';
		    } else {
                      echo '<button type="button" id="turnOnOff'.$gpio["id"].'" data-sensorid="'.$gpio["id"].'" data-type="on" class="btn btn-xs btn-success" onclick="turnOnOff(this)" title="Turn Off"><span class="glyphicon glyphicon-off"></span></button>&nbsp;';
		    }
                    echo '<p></p>';
             echo '</div>';
	   }
           ?>
        </div>

        <?php
if ( 0 === 1) {
          $power = ($gpioList['0']['value']) ? 'Off' : 'On';
          $color = ($gpioList['0']['value']) ? 'red' : 'green';
        ?>
        <div class="btn-group">
            <button type="button" id="boilerpower" data-sensorid="boilerpower" data-type="<?php echo $power ?>" class="btn btn-default" onclick="turnOnOff(this)">
              <span class="glyphicon glyphicon-off" style="color: <?php echo $color ?>;"></span>
            </button>
            <button type="button" id="turnOnOffboilerpower" class="btn btn-default disabled" aria-expanded="false">Kazán: <?php echo $power ?></button>
        </div>
      </div>
<?php } ?>

      <div class="kozepre">
          <p>Frissítve <span id='counter' style='font-weight:500; font-size:20px; padding:0px 2px;'>0</span> alkalommal.</p>
      </div>
      <div id="flot-placeholder" style="width:300px;height:150px"></div>
    </div>

<script src="js/masonry.pkgd.min.js"></script>

<?php
    include 'footer.php';
?>
