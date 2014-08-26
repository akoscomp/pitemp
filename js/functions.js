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
        
        var output = '';
        for (var property in data) {
            id = property;
            temp = data[property];
            var bt = $('#' + id)[0];
            bt.innerHTML=bt.name + ': ' + temp.toFixed(1) + '&deg;C';
            //alert(bt);
        }
    });
}

function changeTemp(bObject)
{
    var action = bObject.innerHTML;
    var val = parseFloat(bObject.parentElement.children[1].innerHTML);
    if (action == "+") {
        val += 0.5;
        bObject.parentElement.children[1].innerHTML = val.toFixed(1);
    }
    if (action == "-") {
        val -= 0.5;
        bObject.parentElement.children[1].innerHTML = val.toFixed(1);
    }
}