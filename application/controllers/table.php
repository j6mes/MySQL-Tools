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
	
	function update($table)
	{
		
		if(isset($_POST['load']))
		{
			$load = json_decode(stripcslashes($_POST['load']));
		
			$bits = explode(".",$table,2);
			
			$bits[0] = "`{$bits[0]}`";
			$bits[1] = "`{$bits[1]}`";
			
			$table = $bits[0].".".$bits[1];
			
			
			foreach ($load as $rowid=>$fields)
			{
				$qry = "UPDATE {$table} SET ";
				$fieldqry = array();
				foreach($fields as $field=>$data)
				{
					$field = "`{$field}`";
					$data = addslashes($data);
					$fieldqry[] = "{$field} = \"{$data}\"";
				}
				
				$qry.= implode(", ",$fieldqry);
				$index = ereg_replace("[^A-Za-z0-9_-]", "", $_POST['index'] );
				$qry .= " WHERE `{$index}` = \"{$rowid}\"";
				
				echo $qry."\n";
				
				$this->dbh->exec($qry);
				$eif = $this->dbh->errorInfo();
				if(intval($eif[0]) != 0)
				{
					$errors[] = $eif;
				}
				
			
			}
			
			print_r($errors);
			
		}

	}
	
	
	function insert($table)
	{
		
		if(isset($_POST['load']))
		{
			$load = json_decode(stripcslashes($_POST['load']));
		
			$bits = explode(".",$table,2);
			
			$bits[0] = "`{$bits[0]}`";
			$bits[1] = "`{$bits[1]}`";
			
			$table = $bits[0].".".$bits[1];
			
			
			foreach ($load as $rowid=>$fields)
			{
				$qry = "INSERT INTO {$table} (";
				$fieldqry = array();
				foreach($fields as $field=>$data)
				{
					$field = "`{$field}`";
					$data = addslashes($data);
					$fieldqry[] = "{$field}";
					$dataqry[] = "\"{$data}\"";
				}
				
				$qry.= implode(", ",$fieldqry);
				$qry.= ") VALUES(";
				$qry.= implode(", ",$dataqry);
				$qry.= ");";
				
				
				echo $qry."\n";
				
				$this->dbh->exec($qry);
				$eif = $this->dbh->errorInfo();
				if(intval($eif[0]) != 0)
				{
					$errors[] = $eif;
				}
				
			
			}
			
		}

	}

	function droprow($table)
	{
		
		if(isset($_POST['load']))
		{
			$load = json_decode(stripcslashes($_POST['load']));
		
			$bits = explode(".",$table,2);
			
			$bits[0] = "`{$bits[0]}`";
			$bits[1] = "`{$bits[1]}`";
			
			$table = $bits[0].".".$bits[1];

		
			$qry = "DELETE FROM {$table} ";
			
			$index = ereg_replace("[^A-Za-z0-9_-]", "", $_POST['index'] );
	
	
			$tr = implode(", ",$load->$index);
			$qry .= " WHERE `{$index}` IN ({$tr})";
			

			
			$this->dbh->exec($qry);
			$eif = $this->dbh->errorInfo();
			if(intval($eif[0]) != 0)
			{
				$errors[] = $eif;
			}
			
			
			
			
			print_r($errors);
			
		}


	}
}