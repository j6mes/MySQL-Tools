<?php

class MTable extends MDB
{
	function __construct($database, $name=null)
	{
		
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
	
	
	function Connect()
	{
		parent::__construct();
	}
	
	
	function Drop()
	{
		$this->dbh->exec("DROP TABLE `{$this->Database}`.`{$this->Table}`");
	}
	
	
	function GetColumns()
	{
		application::load("application/models/mcolumn.php");
		
		
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
			$tables[] = $tmp;
		}

		return $tables;
	}
}
