<?php


/**
 * Index Controller
 * Default action, this should just redirect or route to another contoller
 *  
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 06/07/2012  
 */
class Index extends Controller
{
	/*
	 * Default action on controller
	 */
	function main()
	{
		try
		{
			/*
			 * If we need to log in then go to login page, else list databases
			 */
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
			/*
			 * Display the login form
			 */
			if(isset($this->e))
			{
				$data['error']=$this->e;
			}
			
			/*
			 * Get list of servers and render fragments for dropdown box
			 */
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
