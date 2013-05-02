/**
 * JavaScript pour la page index.php
 */

var username = "bidou88"; //bit.ly username
var key = "R_bfb83a940e4102ea787d2a34c54cbd1b";
var apiUrl = "http://api.bit.ly/v3/shorten";
var bitUrl;
var sel = window.getSelection(),
    range = document.createRange();
var elemToSelect = document.getElementById("link");					

function ranges() {       

    range.selectNodeContents(elemToSelect);
    sel.removeAllRanges();
    sel.addRange(range);
	
}

$('#getMap').click(function() {
	getBitUrl();
});

$('#copy').click(function() {
	ranges();
});

$(document).on("facebook:ready", function() {

	$('#share').click(function() {
		if (facebook === 'connected') {
			sendRequestViaMultiFriendSelector();
		} else {
			login();
		}
	});
	
});

function getBitUrl() {
	var mapID = Math.floor((Math.random()*10000000000)+1000000000);
	var longUrl="http://poulpe.heig-vd.ch/ogo13/julien/findya/mymap.php?mapId="+mapID;
	//var longUrl = "http://www.google.com";
	var request = $.ajax({
		beforeSend: function() { $.mobile.showPageLoadingMsg(); }, //Show spinner
		complete: function() { $.mobile.hidePageLoadingMsg() }, //Hide spinner
		url: apiUrl,
		data:{longUrl:longUrl,apiKey:key,login:username},
		dataType:"jsonp",
		success:function(v) {

			if(v.status_code == 200) {
				
				bitUrl=v.data.url;

				window.location.href = 'share.php?url='+encodeURIComponent(bitUrl);

				//$.mobile.changePage( "http://poulpe.heig-vd.ch/ogo13/julien/findya/share.php", { reloadPage:true, transition: "slide", type: "post", data: {url: bitUrl} });

			} else {
				alert("An error occured. Please try again.");
			}
		}
	});
}