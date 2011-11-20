<?php

include("application/models/table_model.php");

class table extends Controller
{
	function view($table,$ajax=0)
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
	
	
	function ajax_drop($table)
	{
		$this->drop($table,true);
	}
	
	
	function drop($table,$ajax=false)
	{

		$this->model= new table_model();
		$this->model->parent = $this->parent;
		$table = application::sanitize($table);
			
		
		if($ajax)
		{
			$arg['ajax']=1;
		}		
						
		if(strpos($table,".")!==false)
		{
			
			list($schema,$table) = explode(".",$table);
			
			try
			{
				
			
				if($this->model->schemaExists($schema))
				{
					
					if($this->model->tableExists($table))
					{
	
	
						
						$data['ajax']=&$ajax;
						
						$data['schema']=htmlentities($schema);
						$data['table']=htmlentities($table);
						if(isset($_POST['drop']))
						{
							$data['result'] = $this->model->drop($schema,$table);
							
							$data['ajax']=$_POST['ajax'];
							$this->view->render("droppedtable",$data);	
						}
						else
						{
							$this->view->render("droptable",$data);	
						}
					
					}
				}
			}
			catch(Exception $e)
			{
				//todo some kind of error handling here
				echo $e->getMessage();
				
			}
			
		}
		
		$data['schemata'] = $schemata;
		
	}
	
	
	
	function ajax_edit($table)
	{

		$this->edit($table,1);
		
	}
	
	
	function edit($table,$ajax=0)
	{
		
		$this->model= new table_model();
		$this->model->parent = $this->parent;
		$table = application::sanitize($table);
			
		
		if($ajax)
		{
			$arg['ajax']=1;
		}		
						
		if(strpos($table,".")!==false)
		{
			
			list($schema,$table) = explode(".",$table);
			
			try
			{
				
			
				if($this->model->schemaExists($schema))
				{
					
					if($this->model->tableExists($table))
					{
	
	
			
						$stmt = $this->parent->dbh->prepare("
						SELECT * FROM information_schema.`TABLES` WHERE TABLE_SCHEMA=? AND TABLE_NAME=? LIMIT 1");
						
						$stmt->bindParam(1,$schema);
						$stmt->bindParam(2,$table);
						$stmt->execute();
						$arg['info'] = $stmt->fetch(PDO::FETCH_ASSOC);	
		
			
						$result = $this->parent->dbh->query("DESCRIBE `{$schema}`.`{$table}`");
						
						while($row = $result->fetch(PDO::FETCH_ASSOC))
						{
							$rows[]=$row;
						}
			
						$arg['columns']=$rows;
						$arg['table']=$table;
						$arg['schema']=$schema;
						
				
			
						$this->view->render("table",$arg);
						
						
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
		else
		{
			try
			{
				
				if($this->model->schemaExists($schema))
				{
					$arg['schema']=$schema;
					
					$this->view->render("table",$arg);
						
						
				}
					
			}
			catch(Exception $e)
			{
				//todo some kind of error handling here
				echo $e->getMessage();
				
			}
		}
		
		
	}
		
		
	function pinpoint($schema)
	{
		$this->model= new table_model();
		$this->model->parent = $this->parent;
		try
		{
			
		
			if($this->model->schemaExists($schema))
			{
				if($this->model->tableExists($_POST['table']))
				{
					
					$this->model->pinpoint();
				}
			}
			
		}
		catch(Exception $e)
		{
			//todo some kind of error handling here
			echo $e->getMessage();
			
		}
	}	
	
	function comit($schema)
	{
		$this->model= new table_model();
		$this->model->parent = $this->parent;
		try
		{
			
		
			if($this->model->schemaExists($schema))
			{
				if($this->model->tableExists($_POST['table']))
				{
					
					$this->model->comit();
				}
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
