<?php

$ssb->pagetitle = $post->title;

include $_SERVER['DOCUMENT_ROOT'] . '/inc/header.inc.php';

echo '<section class="section section--fullheight"><div class="section__content">';
echo '<h1 class="section__title">' . $post->title . '</h1>';

  echo '<p class="post__info">';

    $info = Array();

    if(count($post->categories) > 0)
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

if($post->date_published != null && $ssb->isPopulated('twitterhandle'))
{
?>
  <div style="min-height: 33px;">
    <a class="twitter-share-button" data-size="large" href="https://twitter.com/intent/tweet?via=<?= $ssb->twitterhandle ?>"></a>
  </div>
<?php
}

if($post->hasSubtitle() == true)
{
  echo '<h3 class="post-list-card__subtitle">' . $post->subtitle . '</h3>';
}

echo '<div class="post-list-card__postbody">' . $post->body . '</div>';

?>
</div></section>

<link rel="stylesheet" href="/admin/js/ckeditor/plugins/codesnippet/lib/highlight/styles/monokai_sublime.css">
<script src="/admin/js/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);
 
  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };
 
  return t;
}(document, "script", "twitter-wjs"));</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.inc.php'; ?>