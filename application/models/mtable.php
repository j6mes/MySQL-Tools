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
	
		
	}
	
	
	function Connect()
	{
		parent::__construct();
	}
	
}
