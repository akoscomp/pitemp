/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function read()
{
    $.ajax(
    {
        type: "POST",
        url: "read.php",
        data: { },
        dataType: "json",
        async: true
    }).done(function(data) {
      console.log(data);
      $.each(data, function(){
        id=this.id;
        temp=this.lastvalue;
        pinstatus=this.pinstatus;
        type=this.type;
        var bt = $('#' + id)[0];
	if (temp === null) { temp=0; }
        if (pinstatus && temp !== 0 && type==='heat') {
            //bt.$('.badge').
            /*
             * 
             * <div id="clickme">
  Click here
</div>
<img id="book" src="book.png" alt="" width="100" height="123">
With the element initially hidden, we can show it slowly:
$( "#clickme" ).click(function() {
  $( "#book" ).show( "slow", function() {
    // Animation complete.
  });
});
             * 
             */
    	  bt.innerHTML='<span class="glyphicon glyphicon-fire"></span>&nbsp;' + bt.name + ': ' + temp.toFixed(1) + '&deg;C';
        } else {
          var name = bt.name;
    	  bt.innerHTML=name + ': ' + temp.toFixed(1) + '&deg;C';
        }
      });
    });
}

function changeTemp(bObject)
{
    var action = bObject.innerHTML;
    var val = parseFloat(bObject.parentElement.children[1].innerHTML);
    bObject.parentElement.children[1].className = "btn btn-xs btn-warning";
    if (action === "+") {
        val += 0.5;
        bObject.parentElement.children[1].innerHTML = val.toFixed(1);
    }
    if (action === "-") {
        val -= 0.5;
        bObject.parentElement.children[1].innerHTML = val.toFixed(1);
    }
}

function setTemp(bObject)
{
    id=bObject.dataset.sensorid;
    type=bObject.dataset.type;
    temp=bObject.innerHTML;
    //alert(temp);
    $.ajax(
    {
        type: "POST",
        url: "setTemp.php",
        data: { id: id, temp: temp, type: type },
        dataType: "json",
        async: true
    }).done(function(data) {
        console.log(data);
        if (data.success) {
            if (type == 'settemp') {
                var button = document.getElementById("setTemp" + id);
            }
            if (type == 'mintemp') {
                var button = document.getElementById("minTemp" + id);
            }
            if (type == 'maxtemp') {
                var button = document.getElementById("maxTemp" + id);
            }
            button.className = "btn btn-xs btn-info disabled";
        }
    });
}

function turnOnOff(bObject) {
    var id=bObject.dataset.sensorid;
    var type=bObject.dataset.type;
    var temp = 0;
    $.ajax(
    {
        type: "POST",
        url: "setTemp.php",
        data: { id: id, temp: temp, type: type },
        dataType: "json",
        async: true
    }).done(function(data) {
        console.log(data);
        if (data.success) {
            var button = document.getElementById("turnOnOff" + id);
            if (type == 'on') {
                bObject.className = "btn btn-xs btn-danger";
                bObject.title="TurnOff";
                bObject.dataset.type="off";
            }
            if (type == 'off') {
                bObject.className = "btn btn-xs btn-success";
                bObject.title="TurnOn";
                bObject.dataset.type="on";
            }
            if (id == 'boilerpower') {
                button.textContent="Kazán: " + data.message1;
            }
        }
    });
}