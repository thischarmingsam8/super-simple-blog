<?php

//site-wide config values
define('VERSION_NUMBER', '0.0.1');

class Config
{
	//default values
	public $themename       = 'blog.min';
	
	public $sitename        = "";
	public $sitedescription = "";
	
	public $herotitle       = "";
	public $herosubtitle    = "";
	
	public $pagetitle       = null;
	
	public $navlinks        = null;
	public $navlinksenabled = true;
	
	public $googleanalytics = null;
	public $twitterhandle   = null;

	public function __construct($usersettings)
	{
		foreach ($usersettings as $setting => $value)
		{
			if(property_exists($this,$setting)) $this->$setting = $value;
		}
	}

	/* getters */
	public function siteDescription()
	{
		return ($this->isPopulated($this->sitedescription)) ? $this->sitedescription : $this->sitename;
	}

	public function pageTitle()
	{
		return ($this->isPopulated($this->pagetitle)) ? $this->pagetitle . ' | ' . $this->sitename : $this->sitename;
	}

	public function pageHeroTitle()
	{
		return ($this->isPopulated($this->herotitle)) ? $this->herotitle : $this->sitename;
	}

	public function navLinks()
	{
		//return empty array if option to show navlinks has been overridden
		if($this->navlinksenabled == false) return Array();

		//get nav links from db...
		if(!is_array($this->navlinks))
		{
			$this->navlinks = Array();
			$this->navlinks[] = 'todo';
		}
		
		return $this->navlinks;
	}

	public function isEnabled($propName)
	{
		//try / catch?
		switch($propName)
		{	
			default:
				return $this->isPopulated($this->$propName);
		}
	}

	public function isPopulated($value)
	{
		return isset($value) && !empty($value) && $value != null;
	}
}

include $_SERVER['DOCUMENT_ROOT'] . '/inc/usersettings.inc.php';

$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if($db->connect_errno > 0)
{
	die('Unable to connect to database [' . $db->connect_error . ']');
}

if(!isset($usersettings)) $usersettings = Array();

$ssb = new Config($usersettings);

//utilities - do not remove this
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/utils.inc.php');
