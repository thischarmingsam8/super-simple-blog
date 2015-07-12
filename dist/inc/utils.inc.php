<?php
/*
	utilities - singleton for adding script tags and style tags
*/

class ScriptTag
{
	public $url;
	public $isExternal;
	public $isAdmin;

	public function __construct($url, $isExternal, $isAdmin)
	{
		$this->url        = $url;
		$this->isExternal = $isExternal;
		$this->isAdmin    = $isAdmin;
	}
}

class Utilities
{
	public $scripts = Array();
	public $styles  = Array();

	public function addScript($scriptName, $isExternal = false, $isAdminScript = false)
	{
		if(!in_array($scriptName, $this->scripts))
		{
			$this->scripts[] = new ScriptTag($scriptName, $isExternal, $isAdminScript);
		}
	}

	public function addScripts()
	{
		for ($i=0; $i < count($this->scripts); $i++)
		{ 
			if($this->scripts[$i]->isExternal == true)
			{
				echo('<script src="' . $this->scripts[$i]->url . '.js?v=' . VERSION_NUMBER . '"></script>');
			}
			else
			{
				if($this->scripts[$i]->isAdmin == true)
				{
					echo('<script src="/admin/js/' . $this->scripts[$i]->url . '.js?v=' . VERSION_NUMBER . '"></script>');
				}
				else
				{
					echo('<script src="/js/' . $this->scripts[$i]->url . '.js?v=' . VERSION_NUMBER . '"></script>');
				}
			}
		}
	}

	public function addStyle($styleName, $isExternal = false, $isAdminStyle = false)
	{
		if(!in_array($styleName, $this->styles))
		{
			$this->styles[] = new ScriptTag($styleName, $isExternal, $isAdminStyle);
		}
	}

	public function addStyles()
	{
		for ($i=0; $i < count($this->styles); $i++)
		{ 
			if($this->styles[$i]->isExternal == true)
			{
				echo('<link rel="stylesheet" href="' . $this->styles[$i]->url . '.css?v=' . VERSION_NUMBER . '">');
			}
			else
			{
				if($this->styles[$i]->isAdmin == true)
				{
					echo('<link rel="stylesheet" href="/admin/css/' . $this->styles[$i]->url . '.css?v=' . VERSION_NUMBER . '">');
				}
				else
				{
					echo('<link rel="stylesheet" href="/css/' . $this->styles[$i]->url . '.css?v=' . VERSION_NUMBER . '">');
				}
			}
			
		}
	}

}

$utils = new Utilities();