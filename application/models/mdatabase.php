<?php

class MDatabase extends MDB
{
	function __construct($name=null)
	{
		if($name!==null)
		{
			$this->Database =ereg_replace("[^A-Za-z0-9_-]", "", $name);
			$this->Connect();
		}
	
		
	}
	
	function Connect()
	{
		parent::__construct();
	}
	
	function Create()
	{
	
		try
		{
			$this->dbh->exec("CREATE DATABASE `{$this->Database}`");
			
			
		}
		catch(exception $e)
		{
			echo "error";
			die ($e->getMessage());
		}
		
		print_r($this->dbh->errorInfo());
		
	}
	
	function Drop()
	{
		try
		{
			$this->dbh->exec("DROP DATABASE `{$this->Database}`");
			
			
		}
		catch(exception $e)
		{
			echo "error";
			die ($e->getMessage());
		}
		
		print_r($this->dbh->errorInfo());
	}
	
	function GetTables()
	{
		application::load("application/models/mtable.php");
		
		
		try
		{
			$smt = $this->dbh->query("SHOW FULL TABLES IN `{$this->Database}`");
					
		}
		catch(exception $e)
		{
			echo "error";
			die ($e->getMessage());
		}
		
		while($tmp = $smt->fetchObject("MTable",array($this->Database,NULL)))
		{
			$tables[] = $tmp;
		}

		return $tables;
	}
}
