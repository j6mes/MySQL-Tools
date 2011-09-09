<?php

class Authentication_Model extends Model
{
	function __construct($username,$password)
	{
		parent::__construct();
	
		try 
		{
			$dbh = new PDO("mysql:host=localhost;", $username, $password);
			
		}
		catch(PDOException $e)
		{
	    	throw new AuthException($e->getMessage(), 1);
			
	    }
		
		
		unset ($dbh);
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
	
		header("Location:/");
		
		
	}
}

