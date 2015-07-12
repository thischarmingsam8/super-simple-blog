<?php

include_once('/inc/config.inc.php');
include_once('/inc/404.inc.php');
include_once('/inc/models/Postman.php');

$pat   = new PostMan($db);
$parts = Array();

if(isset($_GET['path']) && !empty($_GET['path']))
{
	$parts = explode('/',$_GET['path']);
}

switch (count($parts))
{
	case 0:

		$postslist = $pat->getPosts();

		include 'inc/pages/posts.page.inc.php';
		break;

	case 1:

		$post = $pat->getPostBySlug($parts[0]);

		if($post == null)
		{
			fourofour('post');
			break;
		}

		include 'inc/pages/post.page.inc.php';
		break;

	case 2:

		//if not category fourofour
		if(strtolower($parts[0]) != 'category')
		{
			fourofour('category');
			break;
		}

		//if category does not exist, fourofour
		$category = $pat->getPostsInCategory($parts[1]);

		if($category == null)
		{
			fourofour('category');
			break;
		}

		//show posts for category, with category's name as page title
		include 'inc/pages/category.page.inc.php';
		break;
	
	default:
		fourofour();
		break;
}
