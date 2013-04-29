<?php

class Base_Controller extends Controller {

	public function __construct() 
	{
		parent::__construct();

		Asset::add('jquery', 'http://code.jquery.com/jquery-1.8.2.min.js');
		Asset::add('jquery-mobile-js', 'http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js');
		Asset::add('jquery-mobile-css', 'http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css');
		Asset::add('leaflet-js', 'http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js');
		Asset::add('leaflet-css', 'http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.css');
	}

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}