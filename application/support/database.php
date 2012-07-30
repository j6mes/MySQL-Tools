<?php


class DB extends Controller
{
	protected $dbh;
	function __construct()
	{
		if(isset($_SESSION['username']) and isset($_SESSION['password']))
		{
			$this->dbh = new PDO("mysql:host={$_SESSION['server']}",$_SESSION['username'],$_SESSION['password']);	
		}
		
		parent::__construct();
		
	}
}



class MDB extends Model
{
	protected $dbh;
	function __construct()
	{
		if(isset($_SESSION['username']) and isset($_SESSION['password']))
		{
			$this->dbh = new PDO("mysql:host={$_SESSION['server']}",$_SESSION['username'],$_SESSION['password']);	
		}
		
		parent::__construct();
		
	}
}

