<?php

class core 
{
	
	public $s;
	function __construct()
	{
		//Get Base URL 
		$baseURL = explode("&url=",$_SERVER['QUERY_STRING']);
		if(isset($baseURL[1]))
		{
			$baseURL = str_replace($baseURL[1], "", $_SERVER['REQUEST_URI']);
		}
		else
		{
			$baseURL = "/";	
		}
		
		define("BASE",$baseURL);
	
		//Check if there is a URL to parse. if not make the default one.
		if(isset($_GET['url']))
		{
			$url = explode("/",$_GET['url']);
		}

	
		//Controller will always be first element of a URL
		$controller = $url[0]; 
		
		//Remove any dots, from URL controller.php
		@list($controller,$null) = explode(".",$controller);
		
		//Unset the temporary variable
		unset($null);
		
		
		//Lets load our standard controller functions
		application::load("application/support/controller.php");
		
		application::load("application/configuration/servers.php");
		$GLOBALS['servers'] = new ServerConfig;
		
		
		
		//start/resume a session
		$this->s = new session();

		
		if(!strlen($controller))
		{
			$controller = "index";
		}
		
		
		try
		{	
			//Lets try and load our controller now
			application::load("application/controllers/".$controller.".php");
			$controller = new $controller;
			$controller->parent = $this;
		
			
			
		}
		catch(AuthException $e)
		{
			unset($controller);
			
	
			
			$controller = new Index;
			$controller->parent = $this;
			$controller->err($e->getMessage());
			die;
		}
		catch(exception $e)
		{
			//controller was not found. Lets show a real page.
			echo "<b>Controller not found</b><br />";
			echo $e->getMessage();
	
			die;
		}

		
		try
		{
			if(!$sp)
			{
				if(isset($url[2]))
				{
					$url[1] = str_replace("__","",$url[1]);
					$controller->{$url[1]}($url[2]);	
				}
				elseif(isset($url[1]))
				{
					$url[1] = str_replace("__","",$url[1]);
					$controller->{$url[1]}();	
				}
				else
				{
					$controller->main();	
				}
			}
		}
		catch(AuthException $e)
		{
			unset($controller);
	
			
			$controller = new Index;
			$controller->parent = $this;
			$controller->err($e->getMessage());	
			
		}
		catch(Exception $e)
		{
			echo "Controller borked". $e->getMessage();
		}
		
	}


	function needsAuth()
	{

		if($this->s->validate())
		{
			return 0;
			
		}
		else 
		{
			return 1;	
		}
	}
}






