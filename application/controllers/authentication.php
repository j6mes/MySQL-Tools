<?php

class Authentication extends Controller
{
	function main()
	{
		$tmpservers = $GLOBALS['servers']->getServers();
		if(!strlen($tmpservers[intval($_POST['server'])]))
		{
			throw new Exception("Error Processing Request", 1);
		}
		
		if(strlen($_POST['username'])<1)
		{
			throw new Exception("Error Processing Request", 1);
			
		}
		
		if(strlen($_POST['password'])<1)
		{
			throw new Exception("Error Processing Request", 1);
			
		}
		
		
		
		
		try 
		{
			
			$pdo = new PDO("mysql:host={$server};", $_POST['username'], $_POST['password']);
		
		}
		catch(PDOException $e)
		{
	    	throw new AuthException($e->getMessage(), 1);
			
	    }
		
		application::logLogin($server, $_SERVER['REMOTE_ADDR'],$username,1);
		unset ($dbh);
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
		$_SESSION['server'] = $_POST['server'];
		
		echo "ok";
		
		
	}	
	
	function logout()
	{
		session_destroy();	
	}
}

