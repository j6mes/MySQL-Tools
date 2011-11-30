<?php
//SELECT COUNT(*) FROM `SCHEMA_PRIVILEGES` WHERE `TABLE_SCHEMA` = ? AND `PRIVILEGE_TYPE` = ? AND  GRANTEE LIKE \"'".$user."'@%\"   


require_once("application/models/schema_model.php");

class schema extends Controller
{
	

	function main()
	{
		echo "test";
	}


	function view($arg = "",$internal=false)
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
			
			if(!$internal)
			{
				
				$data['title'] = "View Tables in {$data['schema']}";
				$this->view->render("schema",$data);
			}
			else {
				return @$data['tables'];
			}
		}
		
				
		
		
		
	}


	function ajax_create()
	{
		$this->create(1);
	}

	function create($ajax)
	{
		$arg = array();
		if($ajax)
		{
			$arg['ajax']=$ajax;
		}
		
		if(isset($_POST['create']))
		{
			
			$this->model = new schema_model();
			
			$this->model->parent= $this->parent;
			
			$result= $this->model->create($_POST['name']);
			
			if($result===1)
			{
				$this->view->render("created",$arg);
			}
			else
			{
				$this->view->render("createerror",array("ajax"=>$ajax,"result"=>$result));	
			}
			die;
			
		}
		$this->view->render("create",$arg);
		
		
		
	}
	function menu($arg = "")
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
			
			
			$this->view->ajax("schema",$data);
			
		}
		
				
		
		
		
	}
	
	function ajax_drop($schema)
	{
		$this->drop($schema,true);
	}
	
	
	function drop($schema,$ajax=false)
	{

		$this->model = new schema_model($schema);
		$this->model->parent= $this->parent;
		
		if($this->model->schemaExists($schema))
		{
			
			
			
			$data['ajax']=$_POST['ajax']^$ajax;
				
			$data['schema']=htmlentities($schema);

			if(isset($_POST['drop']))
			{
				$data['result'] = $this->model->drop($schema,$table);
				
				
				$this->view->render("droppedschema",$data);	
			}
			else
			{
				$this->view->render("dropschema",$data);	
			}
		}

		
	}
	function all($render= true)
	{
		

		$this->model = new schema_model();
		$this->model->parent= $this->parent;
		
		$schemata = $this->model->dbList();
		
		$data['schemata'] = $schemata;
		
		
		if($render==true)
		{
			if(@$_POST['ajax']==1)
			{
				die(json_encode($data));
			}
			else 
			{
				$this->view->render("schemata",$data);
			}

			
		}
	
		return $schemata;
		
		
	}


	function filter()
	{
		//if(strlen($_POST['q'])>1)
		if(true)
		{
			$this->model = new schema_model();
			$this->model->parent= $this->parent;
			
			$schemata = $this->model->tabList(application::sanitize($_POST['q']));
			
			if(!sizeof($schemata))
			{
				$data['isempty']=1;
				$data['error']="No Results Found!";
			}
			else 
			{
				
			
				
				foreach($schemata as $item)
				{
					$data['result'][$item['TABLE_SCHEMA']][]= array("name"=>$item['TABLE_NAME'],"type"=>$item['TABLE_TYPE']);
				}
			}
		//$data['tables'] = $schemata;
		}
		else
		{
			$data['error']="Length!";	
		}

		echo json_encode($data);
		
	}
}
