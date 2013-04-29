<!DOCTYPE html> 
<html> 
<head>
	<meta charset="utf-8">
	<title>letsmeet</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />

	{{ Asset::styles() }}
    {{ Asset::scripts() }}

    <style>
		body {
		    padding: 0;
		    margin: 0;
		}
		html, body, #home, #container, #map {
		    height: 100%;
		}
    </style>

    <script>
    	$('document').ready(function(){

    		var map = L.map('map');
	    	L.tileLayer('http://a.tiles.mapbox.com/v3/bidou88.map-iukweyr5/{z}/{x}/{y}.png', {
	    		attribution: 'MapBox',
    			maxZoom: 18
			}).addTo(map);

			map.locate({setView: true, maxZoom: 16});

			var rene = new L.Icon({
			    iconUrl: 'img/rene.png',
    			iconSize: [60, 60]
			});	

			var girl = new L.Icon({
			    iconUrl: 'img/girl.png',
    			iconSize: [60, 60]
			});

			function onLocationFound(e) {
				L.marker(e.latlng, {icon: rene}).addTo(map).bindPopup('Garçon sexy').openPopup();
				L.marker(new L.LatLng(e.latlng.lat, e.latlng.lng+0.003), {icon: girl}).addTo(map).bindPopup('Fille sexy').openPopup();
			}

			map.on('locationfound', onLocationFound);

			function onLocationError(e) {
			    alert(e.message);
			}

			map.on('locationerror', onLocationError);
	    });
    </script>

</head>
<body>
	<div data-role="page" id="home">
	
		<div data-role="header">
			<h1>Let's meet</h1>
		</div>

		<div data-role="content" id="container">
			<div id="map">
			</div>	
		</div>
			
	</div>
</body>
</html>