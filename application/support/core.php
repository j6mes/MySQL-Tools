<?php

class core 
{
	public $s;
	public $test = "hello";
	function __construct()
	{
		//Check if there is a URL to parse. if not make the default one.
		if(isset($_GET['url']))
		{
			$url = explode("/",$_GET['url']);
		}
		
		//Controller will always be first element of a URL
		$controller = $url[0]; 
		
		//Remove any dots, from URL controller.php
		list($controller,$null) = explode(".",$controller);
		
		//Unset the temporary variable
		unset($null);
		
		//Lets load our standard controller functions
		application::load("application/controllers/Controller.php");

		application::load("application/controllers/index.php");		
				
				
		//start/resume a session
		$this->s = new session();
		
	
			//Lets try and load our controller now
			try
			{
			
				if($controller=="index" or $controller=="authentication")
				{
				}
				else
				{
					if($this->needsAuth())
					{
						throw new AuthException("Need Authentication");
						
					}
				}
				
	
				//And the controller we want
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
			catch(Exception $e)
			{
				//controller was not found. Lets show a real page.
				echo "controller not found";
				die;
				
			}
			
			
			
			
			try
			{
				if(strlen($url[2]))
				{
					$url[1] = str_replace("__","",$url[1]);
					$controller->{$url[1]}($url[2]);	
				}
				elseif(strlen($url[1]))
				{
					$url[1] = str_replace("__","",$url[1]);
					$controller->{$url[1]}();	
				}
				else
				{
					$controller->main();	
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
				echo "Controller borked";
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






