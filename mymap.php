<!DOCTYPE html> 
<html> 
<head>
	<meta charset="utf-8">
	<title>findya</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<link rel="apple-touch-icon" sizes="144x144" href="img/apple/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-startup-image" href="img/apple/startup-320x460.png" />

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>w

	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/style_map.css" />

	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.css" />
	<script src="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script>

	<script>
		var socket;
	</script>

	<script src="http://ogo.heig-vd.ch:8000/socket.io/socket.io.js"></script>

	<script src="js/simpledialog.min.js"></script>
	<link rel="stylsheet" href="css/simpledialog.css" />
	<script src="js/leaflet.label.js"></script>
	<link rel="stylesheet" href="css/leaflet.label.css"/>

</head>
<body>

	<div id="fb-root"></div>
	<script>

		var socket,
			mapId,
			map,
			lat,
			lng,
			personId,
			personName,
			markers = [], //Tableau de marqueurs
			persons = [], //Tableau de personnes sur la map
			mapPM = {}; //Hashmap de personnes et de marqueurs

		$(document).ready(function($) {
			<?php
				if(isset($_REQUEST['mapId'])) {
			?>
				mapId = <?php echo ($_REQUEST['mapId']); ?>;
			<?php
				} else {
					header('HTTP/1.0 404 Not Found');
					include('404.html');
					die();
				}
			?>

			init();
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
		};

		// Socket connected
		function onSocketConnected() {
			console.log("Connected to socket server");

			$('<div>').simpledialog2({
				mode: 'button',
				headerText: 'Findya',
				headerClose: false,
				buttonPrompt: 'Hey! My name is...',
				buttonInput: true,
				buttons : {
				  'OK': {
				    click: function () {
				    	personName = $.mobile.sdLastInput;
				    	socket.emit("new person", {mapId: mapId, name: personName});
				    	map.locate({setView: true, maxZoom: 15, watch: true, enableHighAccuracy: true});
				    }
				  },
				}
			});
		};

		// Socket disconnected
		function onSocketDisconnect() {

			console.log("Disconnected from socket server");
			map.stopLocate();
		};

		function onPersonsOnMap(data) {
			console.log("Add person on map");

			persons.push(data.id);

			onUpdateLocation(data);
		};

		function onNewPerson(data) {
			console.log("New person connected: "+data.id);

			persons.push(data.id);
		};

		function onRemovePerson(data) {
			console.log("Person removed: " +data.id);
			var newLatLng = new L.LatLng(data.latitude, data.longitude);

			for(var i = 0; i < markers.length; i++) {
				if(markers[i].getLatLng().lat == data.latitude && markers[i].getLatLng().lng == data.longitude) {
					map.removeLayer(markers[i]);
				}
			}
		};

		function onUpdateLocation(data) {

			var newLatLng = new L.LatLng(data.latitude, data.longitude);

			if(data.id in mapPM) {
				var marker = mapPM[data.id];
				marker.setLatLng(newLatLng);
			} else {
				var marker = new L.Marker(newLatLng).bindLabel(data.name).addTo(map);
				markers.push(marker);
				mapPM[data.id] = marker;
			}
		};

		function loadMap() {
    		map = L.map('map');
	    	L.tileLayer('http://a.tiles.mapbox.com/v3/bidou88.map-iukweyr5/{z}/{x}/{y}.png', {
	    		attribution: 'MapBox',
    			maxZoom: 18
			}).addTo(map);

			function onLocationFound(e) {
				console.log("Location Found");

				lat = e.latlng.lat;
				lng = e.latlng.lng;

				socket.emit("update location", {latitude: lat, longitude: lng});
				var newLatLng = new L.LatLng(lat, lng);


				if(personId in mapPM) {
					console.log("Marker exists, do update");
					var marker = mapPM[personId];
					marker.setLatLng(newLatLng);
				} else {
					console.log("Marker doesn't exists, do create");
					var marker = new L.Marker(newLatLng).bindLabel(personName).addTo(map);
					markers.push(marker);
					mapPM[personId] = marker;
				}
			}

			map.on('locationfound', onLocationFound);

			function onLocationError(e) {
			    alert(e.message);
			}

			map.on('locationerror', onLocationError);
		}

		/*
		function login() {
			FB.login(function(response) {
			    if (response.authResponse) {
			        // connected
			    } else {
			        // cancelled
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
		    	alert('connected');
		    	init();
			} else if (response.status === 'not_authorized') {
		    	// not_authorized
		    	login();
		  	} else {
		    	// not_logged_in
		    	login();
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
	*/
	</script>

	<div data-role="page" id="home">
	
		<div data-role="header">
			<h1>findya</h1>
		</div>

		<div data-role="content" id="content">
			<div id="map">
			</div>	
		</div>
			
	</div>
</body>
</html>