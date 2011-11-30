<?php

class Authentication_Model extends Model
{
	function __construct($server,$username,$password)
	{
		parent::__construct();
	
		try 
		{
			$dbh = new PDO("mysql:host={$server};", $username, $password);
			
		}
		catch(PDOException $e)
		{
	    	throw new AuthException($e->getMessage(), 1);
			
	    }
		
		application::logLogin($server, $_SERVER['REMOTE_ADDR'],$username,1);
		unset ($dbh);
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['server'] = $server;
		
		
		header("Location:/");
		
		
	}
}

