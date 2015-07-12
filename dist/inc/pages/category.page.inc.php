<?php 

$ssb->pagetitle       = $category->name;
$ssb->herotitle       = $category->name;
$ssb->herosubtitle    = $category->totalPosts . ' posts in this category';
$ssb->navlinksenabled = false;

$postslist    = $category;

include($_SERVER['DOCUMENT_ROOT'] . '/inc/pages/posts.page.inc.php');