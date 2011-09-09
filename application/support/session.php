<?php

class session
{
	public $dbh;
	function __construct()
	{
		session_start();
	}
	
	function validate()
	{
		try
		{
			
			if(strlen($_SESSION['username']) and strlen($_SESSION['password']))
			{
			
				$dbh = new PDO("mysql:host=localhost;", $_SESSION['username'], $_SESSION['password']);
				$this->dbh =$dbh;
				return 1;
			}
		}
		catch(Exception $e)
		{
		
		}
		return 0;
		
	}
	
	
	function vars()
	{
		return array("username"=>$_SESSION['username'],"password"=>$_SESSION['password']);
	}
	
}
