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
        async: true,
    }).done(function(data) {
      console.log(data);
      $.each(data, function(){
        id=this.id;
        temp=this.lastvalue;
        pinstatus=this.pinstatus;
        var bt = $('#' + id)[0];
	if (temp == null) { temp=0; }
        if (pinstatus && temp != 0) {
    	  bt.innerHTML='<span class="glyphicon glyphicon-fire"></span>&nbsp;' + bt.name + ': ' + temp.toFixed(1) + '&deg;C';
        } else {
    	  bt.innerHTML=bt.name + ': ' + temp.toFixed(1) + '&deg;C';
        }
      });
    });
}

function changeTemp(bObject)
{
    var action = bObject.innerHTML;
    var val = parseFloat(bObject.parentElement.children[1].innerHTML);
    bObject.parentElement.children[1].className = "btn btn-info";
    if (action == "+") {
        val += 0.5;
        bObject.parentElement.children[1].innerHTML = val.toFixed(1);
    }
    if (action == "-") {
        val -= 0.5;
        bObject.parentElement.children[1].innerHTML = val.toFixed(1);
    }
}

function setTemp(bObject)
{
    id=bObject.parentElement.parentElement.children[0].children[0].id;
    temp=bObject.innerHTML;
    //alert(temp);
    $.ajax(
    {
        type: "POST",
        url: "setTemp.php",
        data: { id: id, temp: temp },
        dataType: "json",
        async: true,
    }).done(function(data) {
        console.log(data);
        if (data) {
            var button = document.getElementById("setTemp" + id);
            button.className = "btn btn-info disabled";
        }
    });
}
