<?php
    include 'header.php';
?>


<div class="container">
<div class="map">
    <h3>Szobák:</h3>
    <div id="haz">
        <div id="div111" class="szoba div1">
           <div class="hofok">#1</div>
        </div>
        <div id="div222" class="szoba div2">
           <div class="hofok">#2</div>
        </div>
        <div id="div333" class="szoba div3">
           <span class="hofok btn btn-info btn-sm disabled"><?php echo number_format($sensors['tempsensors']['28-000006152465']['lastvalue'], 1).'&deg;C' ?></span>
        </div>
        <div id="div444" class="szoba div4">
           <div class="hofok">#4</div>
        </div>
        <div id="div555" class="szoba div5">
                <span class="hofok btn btn-info btn-sm disabled"><?php echo number_format($sensors['tempsensors']['28-00042c66a9ff']['lastvalue'], 1).'&deg;C' ?></span>
            <div id="div5111" class="szoba div51">
                <span class="hofok btn btn-info btn-sm disabled"><?php echo number_format($sensors['tempsensors']['28-00042d40e2ff']['lastvalue'], 1).'&deg;C' ?></span>
            </div>
            <div id="div5222" class="szoba div52">
                <span class="hofok btn btn-info btn-sm disabled"><?php echo number_format($sensors['tempsensors']['28-00042d3d7cff']['lastvalue'], 1).'&deg;C' ?></span>
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
           <span class="hofok btn btn-info btn-sm disabled"><?php echo number_format($sensors['tempsensors']['28-000006156648']['lastvalue'], 1).'&deg;C' ?></span>
        </div>
        <div id="div999" class="szoba div9">
           <div class="hofok">#9</div>
        </div>
        <div id="div1000" class="szoba div10">
           <span class="hofok btn btn-info btn-sm disabled"><?php echo number_format($sensors['tempsensors']['28-000006152627']['lastvalue'], 1).'&deg;C' ?></span>
        </div>
        <div id="div1111" class="szoba div11">
            <span class="hofok btn btn-info btn-sm disabled"><?php echo number_format($sensors['tempsensors']['28-000006153cc5']['lastvalue'], 1).'&deg;C' ?></span>
        </div>
    </div>
</div>
</div>
<?php
    include 'footer.php';
?>