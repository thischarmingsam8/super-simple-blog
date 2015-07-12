<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/admin-config.inc.php';

$session->redirectIfNotLoggedIn();

include $_SERVER['DOCUMENT_ROOT'] . '/inc/models/Postman.php';

//list posts
$pat = new PostMan($db);
$pat->postsPerPage = 10;

$postslist = $pat->getPosts(true);

$pageTitle = "Posts";

include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/header.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/inc/postslist.inc.php';

echo '<section class="section section--rubyred">
  <div class="section__content">';

echo '<a href="edit.php" class="post-list-card__link--edit">Add new post</a>';

printPosts($postslist, true, true);

//pagination
if($postslist->pageAmount > 1)
{
	echo '<div class="pagination">';

	// for ($i=0; $i < $postslist->pageAmount; $i++)
	// { 
	// 	if(($i + 1) == $postslist->currentPageNum)
	// 	{
	// 		echo '<span>' . ($i + 1) . '</span>';
	// 	}
	// 	else
	// 	{
	// 		echo '<a href="/admin/';

	// 		echo '?page=' . ($i + 1) . '">' . ($i + 1) . '</a>';
	// 	}
	// }

	if($postslist->currentPageNum > 1 && $postslist->currentPageNum <= $postslist->pageAmount)
	{
		echo '<a class="pagination__link" href="/admin/?page=' . ($postslist->currentPageNum - 1) . '"><i class="fa fa-long-arrow-left"></i>Back</a>';
	}

	echo '<span class="pagination__summary">Page ' . $postslist->currentPageNum . ' of ' . $postslist->pageAmount . '</span>';

	if($postslist->currentPageNum < $postslist->pageAmount)
	{
		echo '<a class="pagination__link" href="/admin/?page=' . ($postslist->currentPageNum + 1) . '">Next<i class="fa fa-long-arrow-right"></i></a>';
	}

	echo '</div>';
}

echo '</div></section>';

include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/footer.inc.php';

?>


