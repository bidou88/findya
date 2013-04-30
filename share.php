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

	<script src="js/scripts.js"></script>

</head>
<body>
	<div data-role="page" id="home">
	
		<div data-role="header">
			<h1>Find your friends!</h1>
		</div>

		<div data-role="content">
			<div class="centerShare">
				
					<?php 
						if(isset($_POST['url'])) { 
							?><a id="link" href="<?php echo $_POST["url"]?>"><?php echo $_POST['url']; ?></a><?php
						} else {
							header('HTTP/1.0 404 Not Found');
						}
					?>
				</a>
				<div id="sharebtns" class="ui-grid-a">
					<div class="ui-block-a"><a href="#" data-role="button" data-theme="b" data-corners="false" >Share</a></div>
					<div class="ui-block-b"><a href="#" data-role="button" data-theme="b" data-corners="false">Tweet</a></div>
					<div class="ui-block-a"><a href="mailto:" data-role="button" data-theme="b" data-corners="false" rel="external">Mail</a></div>
					<div class="ui-block-b"><a href="#" data-role="button" data-theme="b" data-corners="false" >Copy</a></div>
				</div>
			</div>
		</div>
			
	</div>
</body>
</html>