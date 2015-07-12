<?php

function fourofour($errorType = "")
{
	global $ssb;
	global $utils;

	switch ($errorType)
	{
		case 'category':
			$errorMsg = '404 - category not found';
			break;
		case 'post':
			$errorMsg = '404 - post not found';
			break;
		default:
			$errorMsg = '404 - sorry, what you\'re looking for does not exist';
			break;
	}

	header('HTTP/1.0 404 Not Found');

	include $_SERVER['DOCUMENT_ROOT'] .  '/inc/pages/404.page.inc.php';
}
