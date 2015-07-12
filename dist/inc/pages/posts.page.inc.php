<?php

include $_SERVER['DOCUMENT_ROOT'] . '/inc/header.inc.php';

?>

<header class="hero hero--darkred">
	<h1 class="hero__title"><?= $ssb->pageHeroTitle(); ?></h1>

	<?php
		if($ssb->isEnabled('herosubtitle'))
		{
			echo '<p class="hero__text">'. $ssb->herosubtitle .'</p>';
		}

		$navLinks = $ssb->navLinks();

		if(count($navLinks) > 0)
		{

			echo '<p class="hero__text">';

			foreach ($navLinks as $icon => $href)
			{
				echo '<a href="' . $href . '" target="_blank" class="hero__link">';
		        echo '<i class="fa fa-' . $icon . ' hero__linkicon"></i>';
		    	echo '</a>';
			}

			echo '</p>';
		 } 
	 ?>
</header>

<section class="section section--topflush">
  <div class="section__content">
      
	<?php

	include $_SERVER['DOCUMENT_ROOT'] . '/inc/postslist.inc.php'; 
	printPosts($postslist);

	?>

	<?php

	include $_SERVER['DOCUMENT_ROOT'] . '/inc/pagination.inc.php';
	paginatePage($postslist);

	?>

  </div>
</section>

<?php

include $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.inc.php';

?>