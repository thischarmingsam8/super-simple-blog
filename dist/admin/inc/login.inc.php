<?php

include_once('../inc/config.inc.php');

//bare bones atm, just needs to know if user is logged in or not

class LoginManager
{
	private $db;
	private $user;

	public function __construct($db)
	{
		$this->db = $db;

		session_start();

		if(isset($_GET['logout']))
		{
			$this->logOut();
			die;
		}

		if(isset($_SESSION['user_guid']))
		{
			$guid = $_SESSION['user_guid'];

			$getUserSql = "select userid from users where userguid = '$guid'";

			if(!$result = $this->db->query($getUserSql))
			{
			    die('There was an error running the get user info query [' . $this->db->error . ']');
			}

			if($result->num_rows == 0)
			{
				die('Invalid session token');
			}

			$this->user = $result->fetch_assoc();
		}
	}

	public function logInUser($row)
	{
		$_SESSION['user_guid'] =  $row['userguid'];

		header('Location: /admin');	
	}

	public function loggedIn()
	{
		return isset($_SESSION['user_guid']);
	}

	public function redirectIfNotLoggedIn()
	{
		if(!$this->loggedIn()) header('Location: /admin/login.php', true);
	}

	public function logOut()
	{
		if($this->loggedIn())
		{
			unset($_SESSION['user_guid']);
		}

		header('Location: /admin/login.php', true);
	}
}

$session = new LoginManager($db);

?>