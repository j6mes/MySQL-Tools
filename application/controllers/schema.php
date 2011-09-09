<?php

require("application/models/schema_model.php");

class schema extends Controller
{
	

	function main()
	{
		echo "test";
	}


	function view($arg = "")
	{
		if(strlen($arg))
		{
			
			$this->model = new schema_model();
			
			$this->model->parent= $this->parent;
			
			
			$view = $this->model->view($arg);
			$data = array();
			$data['schema']= htmlentities($arg);
			if($view === false)
			{
				//Database doesnt exist.
				throw new Exception("Database don't exist bro", 1);
				
				
			
			}
			else
			{
				if(is_array($view))
				{
					
					$data['tables'] = $view;
				}	
				else 
				{
					$data['message'] = "no tables";	
				}
			}
			
			
			$this->view->render("schema",$data);
			
		}
		
				
		
		
		
	}
	
	
	

	
	
	
	
	function all()
	{
		
		
		$this->model = new schema_model();
		$this->model->parent= $this->parent;
		
		$schemata = $this->model->dbList();
		
		if(sizeof($schemata))
		{
			echo "<ul>";
			
			
			foreach($schemata as $schema)
			{
				echo "<li><a href=\"/schema/view/{$schema['name']}\">{$schema['name']}</a> ({$schema['count']})</li>";
			}
			echo "</ul>";
		}
		
		
		$this->view->render("schemata",$data);
		
		
		
		
		
	}

}
