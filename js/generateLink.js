/**
 * JavaScript pour la page index.php
 */
var username="bidou88"; // bit.ly username
var key="R_bfb83a940e4102ea787d2a34c54cbd1b";
var apiUrl = "http://api.bit.ly/v3/shorten";

$(document).ready(function() {

          $('#getMap').click(function() {
                getBitUrl();
          });  
});

//bit_url function
function getBitUrl() {

    var mapID =  Math.floor((Math.random()*10000000000)+1000000000);
    //var longUrl="http://localhost/findya/mymap?id="+mapID;
    var longUrl="http://www.google.com";

    
    $.ajax({
        url: apiUrl,
        data:{longUrl:longUrl,apiKey:key,login:username},
        dataType:"jsonp",
        success:function(v) {
            var bit_url=v.data.url;
            window.location.href="http://localhost/findya/share.php?url="+bit_url;
        }
    });
}