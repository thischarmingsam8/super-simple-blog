<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/config.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/login.inc.php');

$session->redirectIfNotLoggedIn();

include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/404.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/models/Postman.php');

$pat   = new PostMan($db);

if(isset($_GET['post_id']) && !empty($_GET['post_id']))
{
	$post = $pat->getPostBySlug($_GET['post_id'], true);

	if($post == null)
	{
		fourofour('post');
		return;
	}

	//show published status
	$utils->addScript('admin-preview-refresh',false,true);
	$ssb->googleanalytics = null;
	
	include $_SERVER['DOCUMENT_ROOT'] . '/inc/pages/post.page.inc.php';
}
else
{
	fourofour('post');
}