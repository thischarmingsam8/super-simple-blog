<?php

define('DB_HOST', 'your db host');
define('DB_USER', 'your db user');
define('DB_PASSWORD', 'your db password');
define('DB_NAME', 'your db name');

$usersettings = Array(
	'sitename'        => "Super Simple Blog",
	'sitedescription' => "",

	'googleanalytics' => "",
	'twitterhandle'   => "",
	
	'herotitle'       => "",
	'herosubtitle'    => "",

	//pick from any of the fontawesome icons, and set a url to match
	'navlinks' => Array(
		'home' => '/',
		'twitter' => 'http://twitter.com/thischarmingsam',
		'envelope-o' => 'mailto:your@email.com?Subject=Seen%20your%20blog'
	)
);