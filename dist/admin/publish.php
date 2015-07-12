<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/admin-config.inc.php');

$session->redirectIfNotLoggedIn();

if(isset($_POST['post_id']) && !empty($_POST['post_id']))
{
	if(!isset($_POST['date_published']) || empty($_POST['date_published']))
	{
		$stmt = $db->prepare("UPDATE posts SET date_published = now() WHERE post_id = ?");
	}
	else
	{
		$stmt = $db->prepare("UPDATE posts SET date_published = NULL WHERE post_id = ?");
	}
	

    $stmt->bind_param("s", $_POST['post_id']);

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
	//todo - error codes
	header('Location: /admin');
}