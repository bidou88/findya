<!DOCTYPE html> 
<html> 
<head>
	<meta charset="utf-8">
	<title>letsmeet</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />

	{{ Asset::styles() }}
    {{ Asset::scripts() }}

</head>
<body>
	<div data-role="page" id="home">
	
		<div data-role="header">
			<h1>findya</h1>
		</div>

		<div data-role="content">
			<img src="img/logo.png" />
			<a href="<?php echo $url; ?>">Login with Facebook</a>
		</div>
			
	</div>
</body>
</html>