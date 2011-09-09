<?php 

class View
{
	public function render($name, $arg="")
	{
		require "application/views/{$name}/index.php";
		$pc = ob_get_contents();
		ob_end_clean();
		
		if($name != "login")
		{
			$pc = "<div class=\"sideleft\"><strong>Databases</strong><br />blah<div><strong>Users</strong></div></div>
<div class=\"sideright\">{$pc}</div>";

		}
		require "application/views/template.php";
	}
	
	
	
	
}
