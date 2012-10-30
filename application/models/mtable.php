<?php

/**
 * Table Model
 * 
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 01/08/2012  
 */
class MTable extends MDB
{
	/*
	 * Constructors will connect to db server if a name is specified else defer connection
	 */
	function __construct($database, $name=null)
	{
		/*
		 * Chec to see if the name's set and store the parameters in the class
		 */
		if($name!==null)
		{
			$this->Table= ereg_replace("[^A-Za-z0-9_-]", "", $name);
			$this->Connect();
		}
		else
		{
			$this->Table=  ($this->{"Tables_in_{$database}"});
			unset ($this->{"Tables_in_{$database}"});
		}
		
		$this->Database = ereg_replace("[^A-Za-z0-9_-]", "", $database);;
		
	}
	
	/*
	 * Connect to the DB server by calling the constructor
	 */
	function Connect()
	{
		parent::__construct();
	}
	
	/*
	 * Drop the table from the database
	 * TODO catch exception
	 */
	function Drop()
	{
		$this->dbh->exec("DROP TABLE `{$this->Database}`.`{$this->Table}`");
	}
	
	/*
	 * List the columns inside the table
	 */
	function LoadColumns()
	{
		application::load("application/models/mcolumn.php");
		
		/*
		 * Describe table and put results into a list of MColumns
		 */
		try
		{
			$smt = $this->dbh->query("DESCRIBE `{$this->Database}`.`{$this->Table}`");
		}
		catch(exception $e)
		{
			echo "error";
			die ($e->getMessage());
		}
		
		while($tmp = $smt->fetchObject("MColumn",array($this->Database,NULL)))
		{
			$cols[] = $tmp;
		}

	 	$this->columns = $cols;
	}
	
	
	/*
	 * Add column to the table
	 * TODO support extra fields
	 */
	function AddColumn($name,$type)
	{
		$this->dbh->exec("ALTER TABLE `{$this->Database}`.`{$this->Table}` ADD COLUMN `{$name}` {$type}" );
		print_r($this->dbh->errorInfo());
	}
	
	/*
	 * Drop the column from the database by table
	 */
	function DropColumn($name)
	{
		$this->dbh->exec("ALTER TABLE `{$this->Database}`.`{$this->Table}` DROP COLUMN `{$name}`" );
		print_r($this->dbh->errorInfo());
	}
}
