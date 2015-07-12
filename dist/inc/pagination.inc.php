<?php

function paginatePage($postslist)
{
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
		// 		echo '<a href="http://' . $_SERVER["HTTP_HOST"];

		// 		if(isset($_SERVER["REDIRECT_URL"]) && !empty($_SERVER["REDIRECT_URL"]))
		// 		{
		// 			echo $_SERVER["REDIRECT_URL"];
		// 		}

		// 		echo '?page=' . ($i + 1) . '">' . ($i + 1) . '</a>';
		// 	}
		// }

		if($postslist->currentPageNum > 1 && $postslist->currentPageNum <= $postslist->pageAmount)
		{
			echo '<a class="pagination__link" href="http://' . $_SERVER["HTTP_HOST"];

			if(isset($_SERVER["REDIRECT_URL"]) && !empty($_SERVER["REDIRECT_URL"]))
			{
				echo $_SERVER["REDIRECT_URL"];
			}

			echo '?page=' . ($postslist->currentPageNum - 1) . '"><i class="fa fa-long-arrow-left"></i>Back</a>';
		}

		echo '<span class="pagination__summary">Page ' . $postslist->currentPageNum . ' of ' . $postslist->pageAmount . '</span>';

		if($postslist->currentPageNum < $postslist->pageAmount)
		{
			echo '<a class="pagination__link" href="http://' . $_SERVER["HTTP_HOST"];

			if(isset($_SERVER["REDIRECT_URL"]) && !empty($_SERVER["REDIRECT_URL"]))
			{
				echo $_SERVER["REDIRECT_URL"];
			}

			echo '?page=' . ($postslist->currentPageNum + 1) . '">Next<i class="fa fa-long-arrow-right"></i></a>';
		}

		echo '</div>';
	}

}

