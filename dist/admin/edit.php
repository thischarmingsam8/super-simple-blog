<?php

include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/admin-config.inc.php';

$session->redirectIfNotLoggedIn();

include $_SERVER['DOCUMENT_ROOT'] . '/inc/models/Post.php';

$pageTitle = "Edit post";

$utils->addStyle('tagmanager',false,true);

include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/header.inc.php';

?>

<section class="section section--rubyred">
  <div class="section__content">

<?php

$post              = new Post();
$postCategories = "";

if(isset($_GET['post_id']) && !empty($_GET['post_id']))
{
    //if get param, find post and show it
    $stmt    = $db->prepare("SELECT * from posts WHERE post_id = ? LIMIT 1");
    $post_id = $_GET['post_id'];
    $stmt->bind_param("s", $post_id);

    if ($stmt->execute())
    {
        $result = $stmt->get_result();

        //todo - show error msg
        if($result->num_rows === 0)  die('Post does not exist');

        $post = new Post($result->fetch_object(), $db);

        $postCategoryNames = array_map(function($c)
        { 
            return $c['category_name'];

        }, $post->categories);

        $postCategories    = implode(',',$postCategoryNames);
    }
    else
    {
         die('There was an error running the query [' . $db->error . ']');
    }
}
else if(isset($_POST['post_id']))
{
    //if post...
    if(!empty($_POST['post_id']))
    {
        $post->id = $_POST['post_id'];
    }
    
    if(isset($_POST['body']) && !empty($_POST['body'])) $post->body                 = $_POST['body'];
    if(isset($_POST['title']) && !empty($_POST['title'])) $post->title              = $_POST['title'];
    if(isset($_POST['post_slug']) && !empty($_POST['post_slug'])) $post->slug       = $_POST['post_slug'];
    if(isset($_POST['subtitle']) && !empty($_POST['subtitle'])) $post->subtitle     = $_POST['subtitle'];
    if(isset($_POST['categories']) && !empty($_POST['categories'])) $postCategories = $_POST['categories'];

    $errors = validatePostEdit($post);

    //validate post categories...

    if(count($errors) == 0)
    {
        if($post->id > 0)
        {
            $stmt = $db->prepare("UPDATE posts SET title=?, subtitle=?, body=? WHERE post_id = ?");

            $stmt->bind_param("ssss", $post->title, $post->subtitle, $post->body, $post->id);
        }
        else
        {
            // Remove any character that is not alphanumeric, white-space, or a hyphen 
            $post->slug = preg_replace("/[^a-z0-9\-]/i", "", $post->slug);
            // Replace multiple hyphens with a single hyphen
            $post->slug = preg_replace("/\-\-+/", "-", $post->slug);
            // Remove leading and trailing hyphens
            $post->slug = trim($post->slug, "-");
            // Lowercase the URL
            $post->slug = strtolower($post->slug);

            if (strlen($post->slug) > 80)
            {
                // Cut the URL after 80 characters
                $post->slug = substr($post->slug, 0, 80);

                if (strpos(substr($post->slug, -20), '-') !== false)
                {
                    // Cut the URL before the last hyphen, if there is one
                    $post->slug = substr($post->slug, 0, strrpos($post->slug, '-'));
                }
            }

            $stmt = $db->prepare("INSERT INTO posts (title, subtitle, body, post_slug) VALUES (?,?,?,?)");

            $stmt->bind_param("ssss", $post->title, $post->subtitle, $post->body, $post->slug);
        }

        if ($stmt->execute())
        {
            header('Location: /admin');
        }
        else
        {
             die('There was an error running the query [' . $db->error . ']');
        }
    }
    else
    {
        echo '<div class="post-edit-form__errors">';
        echo '<p>Post contains the following errors:</p>';
        echo '<p>' . implode(', ', $errors) . '</p>';
        echo '</div>';
    } 
}
else
{
    //new post, do nothing
}

function validatePostEdit($post)
{
    global $db;

    $errors = array();

    if(strlen($post->title) == 0) $errors[] = "Title cannot be empty"; 
    if(strlen($post->body)  == 0) $errors[] = "Body cannot be empty";

    if($post->id == 0)
    {
        if(strlen($post->slug) > 0)
        {
            if(preg_match('/^([a-z0-9]+-)*[a-z0-9]+$/i', $post->slug) <= 0) $errors[] = "Invalid slug (alphanumeric and dashes only)";
            
            $stmt = $db->prepare("select post_slug from posts WHERE post_slug = ?");

            $stmt->bind_param("s", $post->slug);

            if($stmt->execute())
            {
                $result = $stmt->get_result();

                if($result->num_rows > 0) $errors[] =  "Slug already exists";
            }
            else
            {
                $errors[] = 'There was an error running the query [' . $db->error . ']';
            }
        }
        else
        {
            $errors[] = "Slug cannot be empty";
        }
    }

    //todo: don't save if post is file or folder

    return $errors;
}

//todo - categories

?>

<form action="edit.php" method="post" class="post-edit-form">

    <input type="hidden" name="post_id" value="<?= $post->id ?>" />
    <input type="hidden" name="js-prefilled-categories" value="<?= $postCategories ?>" />

	<div class="post-edit-form__row">
		<input type="text" name="title" placeholder="title" value="<?= $post->title ?>" maxlength="80"/>
        <input type="text" name="subtitle" placeholder="subtitle (optional)" value="<?= $post->subtitle ?>"/>

        <?php if($post->id > 0 && strlen($post->slug) > 0)
        {
            echo '<p>Post URL: /' . $post->slug . '</p>';
        }
        else
        {
            echo '<input type="hidden" name="post_slug" value="' . $post->slug . '"/>';
            echo '<p>Post URL: /<span id="js-post-slug">' . $post->slug . '</span></p>';
        }
        ?>
	</div>

    <div>
        <textarea id="post-editor" name="body" placeholder="post text" style="visibility: hidden; min-height: 300px;"><?= $post->body ?></textarea>
    </div>
    <p>Categories:</p>
    <div class="post-edit-form__categories">
        <input type="text" name="tags" placeholder="Click here to add a category..." class="tm-input tm-input-typeahead"/>
    </div>

	<input type="submit" value="Save" class="post-list-card__link--edit"/>
</form>
</div></section>

<?php 
    $utils->addScript('https://code.jquery.com/jquery-2.1.4.min', true);
    $utils->addScript('ckeditor/ckeditor',false,true);
    $utils->addScript('typeahead.bundle',false,true);
    $utils->addScript('tagmanager',false,true);
    $utils->addScript('post-edit',false,true);

    include $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/footer.inc.php';
?>