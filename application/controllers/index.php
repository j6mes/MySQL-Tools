<?php

class Index extends Controller
{
	
	function main()
	{

		try
		{

			if($this->needsAuth())
			{
				
			}
			else 
			{
				header("Location:/database/all");
			}
		}
		catch (exception $e)
		{
			if(isset($this->e))
			{
				$data['error']=$this->e;
			}
			
			$servers = $GLOBALS['servers']->getServers();
			if(sizeof($servers) and is_array($servers))
			{
	
				foreach($servers as $id=>$server)
				{
					$this->view->fragment("login/optionrow",array("id"=>$id,"address"=>$server));
				}
				
				
				$this->view->fragment("login/form",null,false);
				
			}
			else 
			{
				$this->view->fragment("login/noservers");
			}
			
			
			$this->view->render("login",$data,"login");
		}
	
		
	}
	
	function err($msg)
	{
		echo $msg;
	}
}
