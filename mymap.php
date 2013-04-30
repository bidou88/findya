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

</head>
<body>

	<div data-role="page" id="home">
	
		<div data-role="header">
			<h1>findya</h1>
		</div>

		<div data-role="content" id="content">
			<div id="map">
			</div>	
		</div>
			
	</div>

	<script>
    	$('document').ready(function(){

    		var map = L.map('map');
	    	L.tileLayer('http://a.tiles.mapbox.com/v3/bidou88.map-iukweyr5/{z}/{x}/{y}.png', {
	    		attribution: 'MapBox',
    			maxZoom: 18
			}).addTo(map);

			map.locate({setView: true, maxZoom: 16});

			function onLocationFound(e) {
				L.marker(e.latlng).addTo(map);
			}

			map.on('locationfound', onLocationFound);

			function onLocationError(e) {
			    alert(e.message);
			}

			map.on('locationerror', onLocationError);
			
	    });
    </script>
</body>
</html>