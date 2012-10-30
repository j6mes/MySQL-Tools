<?php

/**
 * Query model
 * Doesn't really do anything exept hold data
 * 
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 06/08/2012  
 */
class MQuery extends MDB
{
	public $Query;
	
	
	function __construct($query)
	{
		$this->Query = $query;
		parent::__construct();
	}
}
