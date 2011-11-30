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
			
			if(isset($_SESSION['username']) and isset($_SESSION['password']))
			{
			
				$dbh = new PDO("mysql:host={$_SESSION['server']};", $_SESSION['username'], $_SESSION['password']);
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
		return array("server"=>$_SESSION['server'],"username"=>$_SESSION['username'],"password"=>$_SESSION['password']);
	}
	
}
