<?php

include $_SERVER['DOCUMENT_ROOT'] . '/inc/admin/admin-config.inc.php';

$username = "";
$password = "";

if(isset($_POST['username']))
{
	if(!empty($_POST['username']))
	{
		$username = strtolower($_POST['username']);
	}
	else
	{
		$error = 'Please specify a username';
		echo('<div class="msgbox">' . $error . '</div>');
	}
}

if(isset($_POST['password']))
{
	if(!empty($_POST['password']))
	{
		$password = $_POST['password'];
	}
	else
	{
		$error = 'Please specify a password';
		echo('<div class="msgbox">' . $error . '</div>');
	}
}

if(strlen($username) > 0 && strlen($password) > 0)
{
	$stmt = $db->prepare("SELECT userguid FROM users where username = ? AND password = ?");
	$stmt->bind_param("ss", $username, $password);
	if ($stmt->execute())
	{
		$result = $stmt->get_result();

	  		if($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();
				$session->logInUser($row);
			}
			else
			{
				$error = 'No user found with that username and password, please try again';
				echo('<div class="msgbox">' . $error . '</div>');
			}
	}
	else
	{
		 die('There was an error running the query [' . $db->error . ']');
	}
}

?>

<form action="login.php" method="post">
	<input type="text" name="username" value="<?=$username?>" placeholder="username"/>
	<input type="password" name="password" placeholder="password"/>
	<input type="submit" value="submit"/>
</form>