<?php
	if(isset($_REQUEST['url'])) {
		$url = urldecode($_REQUEST['url']);
	} else {
		header('HTTP/1.0 404 Not Found', true, 404);
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

	<div id="fb-root"></div>

	<script>

		var facebook;

		function login() {
			FB.login(function(response) {
			    if (response.authResponse) {
			        sendRequestViaMultiFriendSelector();
			    } else {
			        // cancelled
			    }
		    });
		}

		function sendRequestViaMultiFriendSelector() {
	    	FB.ui({method: 'apprequests',
        		message: 'Join my map',
        		title: 'Access the map',
        		data: $('#link').text(),
        		frictionlessRequests : true
      		}, requestCallback);
    	}

    	function requestCallback(response) {
          // Handle callback here
        }

	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '158880540947821', // App ID
	      channelUrl : 'channel.html', // Channel File
	      status     : true, // check login status
	      cookie     : true, // enable cookies to allow the server to access the session
	      xfbml      : true  // parse XFBML
	    });

	    $(document).trigger("facebook:ready");

	    FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
		    	// connected
		    	facebook = response.status;
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
			<h1>Find your friends!</h1>
		</div>

		<div data-role="content">
			<div class="centerShare">
				
					<?php 
						if(isset($_REQUEST['url'])) { 
							?><a id="link" href="<?php echo $_REQUEST["url"]?>"><?php echo $_REQUEST['url']; ?></a><?php
						} else {
							header('HTTP/1.0 404 Not Found');
						}
					?>
				</a>
				<div id="sharebtns" class="ui-grid-a">
					<div class="ui-block-a"><a id="share" href="#" data-role="button" data-theme="b" data-corners="false">Share</a></div>
					<div class="ui-block-b"><a href="#" data-role="button" data-theme="b" data-corners="false">Tweet</a></div>

					<div class="ui-block-a"><a href="mailto:?subject=Tell your friend where you are!&body=Hi, I wanna share my position with you, just click on this Findya link and show your friends where you are : "+<?php echo $_POST['url'];?>+"." data-role="button" data-theme="b" data-corners="false" rel="external">Mail</a></div>
					<div class="ui-block-b"><a id="copy" href="#" data-role="button" data-theme="b" data-corners="false" >Copy</a></div>
				</div>
			</div>
		</div>
			
	</div>

	<script src="js/scripts.js"></script>
</body>
</html>