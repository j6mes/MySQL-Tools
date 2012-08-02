<?php

class MQuery extends MDB
{
	public $Query;
	
	
	function __construct($query)
	{
		$this->Query = $query;
		parent::__construct();
	}
}
