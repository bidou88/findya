$(document).on("facebook:ready", function() {

	$('#share').click(function() {
		if (facebook === 'connected') {
			sendRequestViaMultiFriendSelector();
		} else {
			login();
		}
	});
	
});