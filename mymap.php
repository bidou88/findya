<!DOCTYPE html> 
<html> 
<head>
	<meta charset="utf-8">
	<title>findya</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="apple-touch-icon" sizes="144x144" href="img/apple/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-startup-image" href="img/apple/startup-320x460.png" />

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>

	<link rel="stylesheet" href="css/style.css" />

	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.css" />
	<script src="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script>

	<script>
		var socket;
	</script>

	<script src="http://localhost:8000/socket.io/socket.io.js"></script>

</head>
<body>

	<div id="fb-root"></div>
	<script>

		var map,
			lat,
			lng;

		function init() {
			loadMap();
			socket = io.connect("http://localhost", {port: 8000, transports: ["websocket"]});
			setEventHandlers();
		}

		var setEventHandlers = function() {
			// Socket connection successful
			socket.on("connect", onSocketConnected);

			// Socket disconnection
			socket.on("disconnect", onSocketDisconnect);

			// New player message received
			socket.on("new person", onNewPerson);

			// Player removed message received
			socket.on("remove person", onRemovePerson);
		};

		// Socket connected
		function onSocketConnected() {
			console.log("Connected to socket server");

		};

		// Socket disconnected
		function onSocketDisconnect() {
			console.log("Disconnected from socket server");
		};

		function onNewPerson(data) {
			console.log("New person connected: "+data.id);
			console.log(data.name + data.mapId);

			<?php
				if($_REQUEST['mapId']) {
			?>
					var mapId = <?php echo ($_REQUEST['mapId']); ?>;
			<?php
				}
			?>
			var newLatLng = new L.LatLng(data.latitude+0.003, data.longitude);
			L.marker(newLatLng).addTo(map);
		};

		function onRemovePerson(data) {
			console.log("New player removed: "+data.id);
		};

		function loadMap() {
    		map = L.map('map');
	    	L.tileLayer('http://a.tiles.mapbox.com/v3/bidou88.map-iukweyr5/{z}/{x}/{y}.png', {
	    		attribution: 'MapBox',
    			maxZoom: 18
			}).addTo(map);

			map.locate({setView: true, maxZoom: 15});

			function onLocationFound(e) {
				lat = e.latlng.lat;
				lng = e.latlng.lng;
				L.marker(e.latlng).addTo(map);
				socket.emit("new person", {mapId: 13, name: "toto", latitude: lat, longitude: lng});
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