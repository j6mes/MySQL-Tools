<?php

include("application/models/table_model.php");

class table extends Controller
{
	function view($table)
	{
		list($schema,$table) = explode(".",$table);
		$table = application::sanitize($table);
		$this->model= new table_model();
		$this->model->parent = $this->parent;
		try
		{
			
		
			if($this->model->schemaExists($schema))
			{
				if($this->model->tableExists($table))
				{
					$this->_run($schema,$table);
					
				}
				else 
				{
					throw new Exception("Table not found", 1);
					
				}
				
			
			}
			else 
			{
				throw new Exception("Database not found",1);
			}
		}
		catch(Exception $e)
		{
			//todo some kind of error handling here
			echo $e->getMessage();
			
		}
		
		
		
		
	}
	
	function _run($schema,$table)
	{
		include("application/controllers/result.php");
		$result = new result($this->parent,$this->model->dbh,"SELECT * FROM `{$table}` LIMIT 0,50",$schema);
	}
	
	
}
