window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
        appId      : '158880540947821', // App ID
        channelUrl : 'channel.html', // Channel File
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
    });

    console.log('facebook chargé');
    $(document).trigger("facebook:ready");

    // Additional initialization code such as adding Event Listeners goes here
};

// Load the SDK asynchronously
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/fr_FR/all.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));