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

	<div id="fb-root"></div>
	<script>
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
	     js.src = "//connect.facebook.net/en_US/all.js";
	     ref.parentNode.insertBefore(js, ref);
	   }(document));
	</script>

	<div data-role="page" id="home">
	
		<div data-role="header">
			<h1>findya</h1>
		</div>

		<div data-role="content">
			<div class="center">
				<img src="img/logo.png" class="logo" />
			</div>
			<select name="select-choice-9" id="select-choice-9" multiple="multiple" data-native-menu="false" tabindex="-1">
				<option data-placeholder="true">Select some friends</option>
				<option value="standard">Standard: 7 day</option>
				
			</select>
			<div class="center">
				<a href="<?php echo $url; ?>">Login with Facebook</a>
				<div id="result"></div>
				<input type="submit" id="short" value="Submit"/> 
			</div>
		</div>
			
	</div>
</body>
</html>