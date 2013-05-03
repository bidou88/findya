var socket,
	mapId,
	map,
	lat,
	lng,
	personId,
	personName,
	personImage,
	markers = [], //Tableau de marqueurs
	persons = [], //Tableau de personnes sur la map
	mapPM = {}; //Hashmap de personnes et de marqueurs

$(document).ready(function($) {

	mapId = getUrlVars.mapId;

});
	
function init() {
			
	$.when(loadMap()).done(function() {
		socket = io.connect("http://ogo.heig-vd.ch", {port: 8000, transports: ["websocket"]});
		setEventHandlers();
	});
}

var setEventHandlers = function() {

	// Socket connection successful
	socket.on("connect", onSocketConnected);

	// Socket disconnection
	socket.on("disconnect", onSocketDisconnect);

	// New player message received
	socket.on("new person", onNewPerson);

	//New location updated
	socket.on("update location", onUpdateLocation);

	// New player message received
	socket.on("add person", onPersonsOnMap);

	// Player removed message received
	socket.on("remove person", onRemovePerson);

	$('#btn_ok').click(function() {

		$( "#myDialog" ).dialog( "close" );
		personName = $('#name').val();
		socket.emit("new person", {mapId: mapId, name: personName, img: personImage});
		map.locate({setView: true, maxZoom: 15, watch: true, enableHighAccuracy: true});

	});

};

// Socket connected
function onSocketConnected() {

	console.log("Connected to socket server");
	console.log(personName);
	if(!personName) {
		$.mobile.changePage( "#myDialog", { role: "dialog" } );
	} else {
		socket.emit("new person", {mapId: mapId, name: personName, img: personImage});
		map.locate({setView: true, maxZoom: 15, watch: true, enableHighAccuracy: true});
	}		

}

// Socket disconnected
function onSocketDisconnect() {

	console.log("Disconnected from socket server");
	map.stopLocate();

}	

function onPersonsOnMap(data) {
			
	console.log("Add person on map");
	persons.push(data.id);
	onUpdateLocation(data);

}	

function onNewPerson(data) {
			
	console.log("New person connected: "+data.id);
	showPopup(data, 1);
	persons.push(data.id);

}
		
function onRemovePerson(data) {

	console.log("Person removed: " +data.id);
	var newLatLng = new L.LatLng(data.latitude, data.longitude);

	for(var i = 0; i < markers.length; i++) {
		if(markers[i].getLatLng().lat == data.latitude && markers[i].getLatLng().lng == data.longitude) {
			map.removeLayer(markers[i]);
		}
	}

	showPopup(data, 0);

}

function onUpdateLocation(data) {

	var newLatLng = new L.LatLng(data.latitude, data.longitude);

	if(data.id in mapPM) {
		var marker = mapPM[data.id];
		marker.setLatLng(newLatLng);
	} else {
		if(data.img == undefined) {
			var icon = L.AwesomeMarkers.icon ({
				icon: 'user', 
				color: 'blue',
		 		labelAnchor: [8, -15]
			});
		} else {
			//Modification du plug-ing AwesomeMakers pour insérer une image dans le marker
			var icon = L.FacebookMarkers.icon ({
				icon: data.img, 
	  			color: 'blue',
	  			labelAnchor: [8, -15]
			});
		}
				
		var marker = new L.Marker(newLatLng, {icon: icon}).bindLabel(data.name).addTo(map);
		markers.push(marker);
		mapPM[data.id] = marker;
	}

}

function loadMap() {
	map = L.map('map');
    	L.tileLayer('http://a.tiles.mapbox.com/v3/bidou88.map-iukweyr5/{z}/{x}/{y}.png', {
   		attribution: 'MapBox',
   		setZoom: 8,
		maxZoom: 18
	}).addTo(map);
	//alert("Load map");

	function onLocationFound(e) {

		lat = e.latlng.lat;
		lng = e.latlng.lng;

		socket.emit("update location", {latitude: lat, longitude: lng});
		var newLatLng = new L.LatLng(lat, lng);

		if(personImage == undefined) {
			var icon = L.AwesomeMarkers.icon ({
				icon: 'user', 
				color: 'blue',
		 		labelAnchor: [8, -15]
			});
		} else {
			//Modification du plug-ing AwesomeMakers pour insérer une image dans le marker
			var icon = L.FacebookMarkers.icon ({
				icon: personImage, 
				color: 'red',
				labelAnchor: [8, -15]
			});
		}

		if(personId in mapPM) {
			console.log("Marker exists, do update");
			var marker = mapPM[personId];
			marker.setLatLng(newLatLng, {icon: icon});
		} else {
			console.log("Marker doesn't exists, do create");
			var marker = new L.Marker(newLatLng, {icon: icon}).bindLabel(personName).addTo(map);
			markers.push(marker);
			mapPM[personId] = marker;
			map.locate({setView : false});
		}
	}

	map.on('locationfound', onLocationFound);

	function onLocationError(e) {
		alert(e.message);
	}
		
	map.on('locationerror', onLocationError);
}
		
function login() {
	
	FB.login(function(response) {
	    if (response.authResponse) {
	        FB.api('/me', function(response) {
				personName = response.name;
				FB.api('/me/picture', function(response) {
					personImage = response.data.url;
					init();
				});
				//init();
			});
	    } else {
	        init();
	    }
	});

}		

window.fbAsyncInit = function() {
    FB.init({
	    appId      : '158880540947821', // App ID
	    channelUrl : 'channel.html', // Channel File
	    status     : true, // check login status
	    cookie     : true, // enable cookies to allow the server to access the session
	    xfbml      : true  // parse XFBML
	});

	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
	    	// connected
	    	FB.api('/me', function(response) {
				personName = response.name;
				FB.api('/me/picture', function(response) {
					personImage = response.data.url;
					init();
				});
				//init();
			});
		} else if (response.status === 'not_authorized') {
	    	// not_authorized
	    	init();
	  	} else {
	    	// not_logged_in
	    	init();
	  	}
	});

};
// Load the SDK Asynchronously
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/fr_FR/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

function showPopup(data, type) {

	// //Création du popup
	var popup = $("<div/>").popup({
	    dismissible : true,
	    corners : false,
	    shadow : false,
	    tolerance: "42,0,0,0"
	}).on("popupafterclose", function() {
	    $(this).remove();
	});

	if(type) {
	  	var msg = $("<p/>", {text : data.name+" is connected."});
	   	var color = "#66FF66";
	    popup.click(function() {
	   		map.panTo(data.latLng);
	   	});
	} else {
	   	var msg = $("<p/>", {text : data.name+" disconnected."});
	   	var color = "#FF0000";
	}

	//Message
	msg.css({"display" : "block", "text-align" : "center", "color" : "#000000"});
	msg.appendTo(popup);

	popup.css({"opacity": 0.60, "width": $(window).width(), "background": color});
	popup.popup("open", {x: 0,y: 0, transition: "fade", positionTo: "origin"});
		    
	var def = $.Deferred();
	setTimeout(def.resolve, 3000);

	def.done(function() {
    	popup.fadeOut("slow");
	});
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


		
		

	    
		
		

