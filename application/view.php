<?php 

class View
{
	public function render($name, $arg="")
	{
		
		require "views/{$name}/index.php";
		$pc = ob_get_contents();
		ob_end_clean();
		if($name != "login")
		{
			include_once("application/controllers/schema.php");
			$tmpIndex = new schema();
			
			$tmpIndex->parent = $this->parent->parent;
			$schemata = $tmpIndex->all(false);
		}
		require "views/template.php";
	}
	
	
}
