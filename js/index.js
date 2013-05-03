var facebook,
	urlbit,
	urlParams = {};

function checkRequest() {(function () {
	
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
			//connected		        
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