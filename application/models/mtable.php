<?php

class MTable extends MDB
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
	
}
