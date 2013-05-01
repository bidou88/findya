/**
 * JavaScript pour la page index.php
 */

var username = "bidou88"; //bit.ly username
var key = "R_bfb83a940e4102ea787d2a34c54cbd1b";
var apiUrl = "http://api.bit.ly/v3/shorten";
var bitUrl;

$(document).ready(function() {

	$('#getMap').click(function() {
		getBitUrl();
	});

	$('#copy').click(function() {
		$('#link').select();
	});
});

function getBitUrl() {
	var mapID = Math.floor((Math.random()*10000000000)+1000000000);
	//var longUrl="http://localhost/findya/mymap?id="+mapID;
	var longUrl = "http://www.google.com";
	var request = $.ajax({
		beforeSend: function() { $.mobile.showPageLoadingMsg(); }, //Show spinner
		complete: function() { $.mobile.hidePageLoadingMsg() }, //Hide spinner
		url: apiUrl,
		data:{longUrl:longUrl,apiKey:key,login:username},
		dataType:"jsonp",
		success:function(v) {

			if(v.status_code == 200) {
				
				bitUrl=v.data.url;

				$.mobile.changePage( "share.php", { transition: "slide", type: "post", data: {url: bitUrl} });

			} else {
				alert("An error occured. Please try again.");
			}
		}
	});
}