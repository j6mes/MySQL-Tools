<?php

class core 
{
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
		
		
		//Lets try and load our controller now
		try
		{
			//Lets load our standard controller functions
			application::load("application/controllers/Controller.php");
			
			//And the controller we want
			application::load("application/controllers/".$controller.".php");
			$controller = new $controller;
			
		}
		
		catch(Exception $e)
		{
			//controller was not found. Lets show a real page.
			echo "controller not found";
			die;
			
		}
		
		
		
		try
		{
			if(strlen($url[1]))
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
	
			application::load("application/controllers/index.php");
			$controller = new Index;
			$controller->err($e->getMessage());	
			
		}
		catch(Exception $e)
		{
			echo "Controller borked";
		}
	}
}




abstract class application
{
	function load($file)
	{
		if(file_exists($file)) 
		{ 
            include_once($file); 
        } 
        else 
        { 
            throw(new Exception('File does not exist.')); 
        } 
	}
	
}

