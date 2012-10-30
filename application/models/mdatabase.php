<?php


/**
 * Database Model
 * Supports connections to a database
 * 
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 07/08/2012  
 */
class MDatabase extends MDB
{
	/*
	 * Constructor Connects to database layerif needs be
	 */
	function __construct($name=null)
	{
		if($name!==null)
		{
			$this->Database =ereg_replace("[^A-Za-z0-9_-]", "", $name);
			$this->Connect();
		}
	}
	
	/**
	 * Connects to the database by calling the super's constructor
	 *
	 * @return void
	 */
	function Connect()
	{
		parent::__construct();
	}
	
	/**
	 * Create a database without any parameters
	 * TODO support charset and parameters, currently assumes default
	 *
	 * @return void
	 */
	function Create()
	{
	
		try
		{
			$this->dbh->exec("CREATE DATABASE `{$this->Database}`");
			
			
		}
		catch(exception $e)
		{
			/*
			 * TODO handle this better.  Maybe pass the exception?
			 */
			die ($e->getMessage());
		}
		
		print_r($this->dbh->errorInfo());
		
	}
	
	/**
	 * Drop the database from the server
	 *
	 * @return void
	 */
	function Drop()
	{
		try
		{
			$this->dbh->exec("DROP DATABASE `{$this->Database}`");
			
			
		}
		catch(exception $e)
		{
			die ($e->getMessage());
		}
	
	}
	
	
	/**
	 * Get a list of tables for the database and return save them to this class
	 *
	 * @return void
	 */
	function LoadTables()
	{
		application::load("application/models/mtable.php");
		
		
		try
		{
			$smt = $this->dbh->query("SHOW FULL TABLES IN `{$this->Database}`");
		}
		catch(exception $e)
		{
			die ($e->getMessage());
		}
		
		while($tmp = $smt->fetchObject("MTable",array($this->Database,NULL)))
		{
			$tables[] = $tmp;
		}

		$this->tables= $tables;
	}
	

}
