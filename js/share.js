$(document).ready(function() {

	$('#link').click(function() {
		window.location.href= $('#link').text();
	});

	$('#share').click(function() {
		if (facebook === 'connected') {
			sendRequestViaMultiFriendSelector();
		} else {
			login();
		}
	});

});