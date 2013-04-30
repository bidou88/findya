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
	<link rel="stylesheet" href="css/typicons.css" />

	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.css" />
	<script src="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script>

    <script type="text/javascript">
		$(document).ready(function() {

			//bit_url function
			function bit_url(url) { 
				var url=url;
				var username="bidou88"; // bit.ly username
				var key="R_bfb83a940e4102ea787d2a34c54cbd1b";
				$.ajax({
					url:"http://api.bit.ly/v3/shorten",
					data:{longUrl:url,apiKey:key,login:username},
					dataType:"jsonp",
					success:function(v) {
						var bit_url=v.data.url;
						$("#result").html('<a href="'+bit_url+'" target="_blank">'+bit_url+'</a>');
					}
				});
			}


			$("#short").click(function() {
				var url="http://renelataupe.com";
				var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
				var urltest=urlRegex.test(url);
				if(urltest){
					bit_url(url);
				} else {
					alert("Bad URL");
				}
			});
		});
</script>

</head>
<body>
	<div data-role="page" id="home">
	
		<div data-role="header">
			<h1>Find your friends!</h1>
		</div>

		<div data-role="content">
			<div class="center">
				<img src="img/logo.png" class="logo" />
				<a href="#" data-role="button" data-theme="b" data-corners="false">Get your map</a>
			</div>
		</div>
			<!--<div data-role="fieldcontain">
					<span id="link" data-inline="true">http://bit.ly/staticnoob</span>
					<a id="copybtn" class="typicn" href="#" data-mini="true" data-role="button"  data-inline="true">e</a>
				</div>-->
	</div>
</body>
</html>