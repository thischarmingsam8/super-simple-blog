<?php

function printPosts($listOfPosts, $showCategories = true, $editMode = false)
{
	echo '<ul class="list--blank">';

	for ($i = 0; $i < count($listOfPosts->posts); $i++)
	{ 
		$post = $listOfPosts->posts[$i];

			if($editMode == true)
			{
				echo '<li class="post-list-card post-list-card--admin">';
			}
			else
			{
				echo '<li class="post-list-card">';
			}

			echo '<h3 class="post-list-card__title">';

			if($editMode == true)
			{
				echo '<a  class="post-list-card__link post-list-card__link--title" href="/admin/preview.php?post_id=' . $post->id . '" target="blank">'  . $post->title . '</a>'; 
			}
			else
			{
				echo '<a  class="post-list-card__link post-list-card__link--title" href="/' . $post->slug . '">' . $post->title . '</a>'; 
			}

			echo '</h3>';

			if($editMode == false  && $post->hasSubtitle() == true)
			{
				echo '<p class="post-list-card__subtitle">' . $post->subtitle . '</p>';
			}

		echo '<p class="post-list-card__info">';

		$info = Array();

		if($editMode == true)
		{
			$info[] = 'ID: ' . $post->id;
			$info[] = 'URL: ' . $_SERVER['HTTP_HOST'] . '/' . $post->slug;
	 		$info[] = 'last edited: ' . $post->timestamp;
		}

 		if(count($post->categories) > 0 && $showCategories == true)
		{
			$categoryTags = Array();

			for ($j = 0; $j < count($post->categories); $j++)
			{ 
				$categoryTag = '<a class="post-list-card__link post-list-card__link--category" href="/category/' . $post->categories[$j]['category_slug'] . '">' . $post->categories[$j]['category_name'] . '</a>';
				$categoryTags[] = $categoryTag;
			}

			$info[] = 'Posted in ' . implode(', ',$categoryTags);
		}
		
		if($post->date_published != null)
		{
		 	$info[] = $post->date_published;
		}

		echo implode(' | ', $info);

		echo '</p>';

		if($editMode == true)
		{
			echo '<form action="publish.php" method="post">';
			echo '<input type="hidden" name="date_published" value="' . $post->date_published . '"/>';
			echo '<input type="hidden" name="post_id" value="' . $post->id . '"/>';
			echo '<hr/>';
			echo '<a class="post-list-card__link post-list-card__link--edit" href="/admin/edit.php?post_id=' . $post->id . '">Edit</a>';

			if($post->isPublished() == true)
			{
				echo '<input class="post-list-card__link post-list-card__link--edit post-list-card__link--negative" type="submit" value="Unpublish"/>';
			}
			else
			{
				echo '<input class="post-list-card__link post-list-card__link--edit post-list-card__link--positive" type="submit" value="Publish"/>';
			}
			
			echo '</form>';
		}

	 	echo '</li>';
	}

	echo '</ul>';
}