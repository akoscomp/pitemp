<?php
    include 'header.php';
?>

<style type="text/css">
div { font: 12px Arial; }
span.bold { font-weight: bold; }
#haz {
    position: relative;
}
.szoba {
   height: 80px;
   width: 80px;
   position: absolute;
   border: 1px dashed #669966;
   background-color: #ccffcc;
   text-align: center;
}
#div2 {
   top: 0px;
   left: 80px;
}
#div3 {
   top: 80px;
   left: 0px;
}
#div4 {
   top: 80px;
   left: 80px;
}
#div5 {
   top: 0px;
   left: 160px;
   width: 60px;
}
#div51 {
   top: 3px;
   left: 3px;
   width: 52px;
   height: 30px;
   background-color: #d9534f;
}
#div52 {
   top: 43px;
   left: 3px;
   width: 52px;
   height: 30px;
   background-color: #f0ad4e;
}
#div6 {
   top: 80px;
   left: 160px;
   height: 40px;
   width: 60px;
}
#div7 {
   top: 0px;
   left: 220px;
   height: 40px;
   width: 60px;
}
#div8 {
   top: 40px;
   left: 220px;
   height: 40px;
   width: 40px;
}
#div9 {
   top: 40px;
   left: 260px;
   height: 40px;
   width: 20px;
}
</style>

<div id="haz">
    <div id="div1" class="szoba">
        <br /><span class="bold">DIV #1</span>
        <br />position: relative;
    </div>
    <div id="div2" class="szoba">
       <br /><span class="bold">DIV #2</span>
    </div>
    <div id="div3" class="szoba">
       <br /><span class="bold">DIV #3</span>
    </div>
    <div id="div4" class="szoba">
       <br /><span class="bold">DIV #4</span>
    </div>
    <div id="div5" class="szoba">
       <br /><span class="bold">DIV #5</span>
        <div id="div51" class="szoba">
           <br /><span class="bold">DIV #51</span>
        </div>
        <div id="div52" class="szoba">
           <br /><span class="bold">DIV #52</span>
        </div>
    </div>
    <div id="div6" class="szoba">
       <br /><span class="bold">DIV #6</span>
    </div>
    <div id="div7" class="szoba">
       <br /><span class="bold">DIV #7</span>
    </div>
    <div id="div8" class="szoba">
       <br /><span class="bold">DIV #8</span>
    </div>
    <div id="div9" class="szoba">
       <br /><span class="bold">DIV #9</span>
    </div>
</div>


<?php
    include 'footer.php';
?>