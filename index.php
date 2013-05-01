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

</head>
<body>

	<div id="fb-root"></div>
	<script>

		var facebook;
		var urlbit;
		var urlParams = {};

		function checkRequest() {

		    (function () {
		        var match,
		        pl     = /\+/g,  // Regex for replacing addition symbol with a space
		        search = /([^&=]+)=?([^&]*)/g,
		        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
		        query  = window.location.search.substring(1);

		    while (match = search.exec(query))
		        urlParams[decode(match[1])] = decode(match[2]);
		    })();

		}

		function processIncomingRequest() {
		    
		    var requestType = urlParams["app_request_type"];

		    if (requestType == "user_to_user") {
		         var requestID = urlParams["request_ids"];  

		        FB.api(requestID, function(response) {
		            //console.log(response.data);
		            urlbit = response.data;
		            deleteRequest(requestID);
		        });
		      }
		}

		function deleteRequest(requestId) {
		  FB.api(requestId, 'delete', function(response) {
		    //console.log(urlbit);
		    window.location.href = urlbit;
		  });
		}

		function login() {
			FB.login(function(response) {
			    if (response.authResponse) {
			        
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

	    checkRequest();

	    FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
		    	// connected
		    	facebook = response.status;
		    	if(urlParams['request_ids']) {
		    		processIncomingRequest();
		    	}
			} else if (response.status === 'not_authorized') {
		    	// not_authorized
		  	} else {
		    	// not_logged_in
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

		<div data-role="content">
			<div class="center">
				<img src="img/logo.png" class="logo" />
				<a id="getMap" data-role="button" data-theme="b" data-corners="false">Get your map!</a>
			</div>
		</div>

	</div>

	<script src="js/scripts.js"></script>
</body>
</html>