<?php

class Table extends DB
{
	function __construct()
	{
		application::load("application/models/mtable.php");

		
		
		
		parent::__construct();
	}
	
	
	function view($name)
	{
		
		list($database,$name) = explode(".", $name,2);
		$table = new MTable($database, $name);
		
		
		application::load("application/models/mquery.php");
		
		
		$query = new MQuery("SELECT * FROM `{$table->Database}`.`{$table->Table}`");	
		$this->view->render("resultset",array("query"=>$query));
		
		

		
	}
	
	function  drop ($name)
	{		
		list($database,$name) = explode(".", $name,2);
		$table = new MTable($database, $name);
		
		$table->Drop();
	}



	function alter($name)
	{
		list($database,$name) = explode(".", $name,2);
		$table = new MTable($database, $name);
		
		$table->LoadColumns();
		
		$table->AddColumn("test","INT(20) unsigned zerofill unique NOT NULL default '123'");
	}
	
	function dropcolumn($name)
	{
		list($database,$name) = explode(".", $name,2);
		$table = new MTable($database, $name);

		$table->DropColumn("test");
	}
	

}