<?php
    include 'header.php';
?>

<div class="map">
    <h3>Szobák:</h3>
    <div id="haz">
        <div id="div111" class="szoba div1">
            <div class="hofok btn btn-warning btn-sm">#1</div>
        </div>
        <div id="div222" class="szoba div2">
           <div class="hofok">#2</div>
        </div>
        <div id="div333" class="szoba div3">
           <span class="hofok btn btn-warning btn-sm"><?php echo number_format($sensors['tempsensors']['28-00042c66a9ff']['lastvalue'], 1).'&deg;C' ?></span>
        </div>
        <div id="div444" class="szoba div4">
           <div class="hofok">#4</div>
        </div>
        <div id="div555" class="szoba div5">
           <div class="hofok">#5</div>
            <div id="div5111" class="szoba div51">
            </div>
            <div id="div5222" class="szoba div52">
            </div>
        </div>
        <div id="div666" class="szoba div6">
           <div class="hofok">#6</div>
            <div id="div61" class="szoba div61">
            </div>
        </div>
        <div id="div777" class="szoba div7">
           <div class="hofok">#7</div>
        </div>
        <div id="div888" class="szoba div8">
           <div class="hofok">#8</div>
        </div>
        <div id="div999" class="szoba div9">
           <div class="hofok">00.0</br>&deg;C</div>
        </div>
        <div id="div1000" class="szoba div10">
           <div class="hofok">#10</div>
        </div>
        <div id="div1111" class="szoba div11">
           <div class="hofok">#11</div>
        </div>
    </div>
</div>

<?php
    include 'footer.php';
?>