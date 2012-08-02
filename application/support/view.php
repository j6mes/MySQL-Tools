<?php 

class View
{
	public $parent;
	public function render($name, $args = array(), $template = "template")
	{
		if(isset($this->parent->core->json))
		{
			$this->ajax($args);
			die;
		}
		
		$this->cleanFragments();
		ob_start();
		$this->args = $args;
		application::load("application/views/{$name}.php");
	
		$this->content = ob_get_clean();


		application::load("application/templates/{$template}.php");
	}
	
	
	public function fragment($name,$args=array(),$group=true)
	{
		ob_start();
		$this->args = $args;
		require("application/fragments/{$name}.php");
		if($group)
		{
			
			$this->fragments[$name][] = ob_get_clean();

		}
		else 
		{

			$this->fragments[$name] = ob_get_clean();
		}
		ob_end_clean();
	}
	
	
	public function ajax($arg=array())
	{
		
		die (json_encode($arg));
	} 
	
	private function cleanFragments()
	{
		/*
		print_r($this->fragments);
		if(is_array($this->fragments))
		{
			foreach ($this->fragments as $name=> $fragment)
			{
				if(sizeof($fragment)>1)
				{
					
					
				}
				else
				{
					$this->fragments[$name]=$fragment[0];
				}
			}
		}
		print_r($this->fragments);
		 * *
		 */
	}
	
	
	
}
