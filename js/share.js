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
