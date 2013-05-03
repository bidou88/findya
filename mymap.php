<?php

if(!isset($_REQUEST['mapId'])) {
	header('HTTP/1.0 404 Not Found');
	include('404.html');
	die();
}

?>

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
	<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>

	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/style_map.css" />

	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.css" />
	<script src="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script>

	<script src="http://ogo.heig-vd.ch:8000/socket.io/socket.io.js"></script>

	<link rel="stylesheet" href="css/font-awesome.min.css">

	<script src="js/leaflet.label.js"></script>
	<link rel="stylesheet" href="css/leaflet.label.css"/>

	<link rel="stylesheet" href="css/leaflet.awesome-markers.css">
	<script src="js/leaflet.awesome-markers.js"></script>

	<script src="js/mymap.js"></script>
</head>
<body>

	<div id="fb-root"></div>

	<div data-role="page" id="home">
	
		<div data-role="header">
			<a href="#" data-role="button" data-rel="back" data-icon="arrow-l">Back</a>
			<h1>findya</h1>
		</div>

		<div data-role="content" id="content">
			<div id="map">
			</div>	
		</div>
			
	</div>

	<div data-role="page" id="myDialog" data-close-btn="none">
	  <div data-role="header">
	    <h2>Nickname</h2>
	  </div>
	  <div data-role="content">
	    <p><input type="text" name="name" id="name" value=""></p>
	    <a id="btn_ok" href="#" data-role="button" data-theme="b">Go to map</a>
	</div>
</div>
</body>
</html>