<?php 

class View
{
	public $parent;
	public function render($name, $arg="")
	{
		require "application/views/{$name}/index.php";
		$pc = ob_get_contents();
		ob_end_clean();
		
		if($name != "login")
		{
			include_once("application/controllers/schema.php");
			$tmpIndex = new schema();
			
			$tmpIndex->parent = $this->parent->parent;
			$schemata = $tmpIndex->all(false);
			//todo: list
			//<?=$GLOBALS['schema'];
			if(isset($GLOBALS['schema']))
			{
				$childtables = $tmpIndex->view($GLOBALS['schema'],true);
			}
			else 
			{
				$childtables = array();	
			}
			
			
		}
		
				
		require "application/views/template.php";
	}
	
	
	public function ajax($view,$arg=array())
	{
		
		die (json_encode($arg));
	} 
	
	
	
}
