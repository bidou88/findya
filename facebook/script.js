$(document).ready(function() {
	console.log('document ready');

	$(document).on("facebook:ready", function() {
		console.log('document et facebook ready');
	});

});