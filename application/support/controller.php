<?php

class Controller
{
	public $parent;
	public $view;
	protected $dbh;
	function isAuthed()
	{
		return 1;
	}

	
	function __construct()
	{
		//parent::__construct();

		$this->view = new View();
		$this->view->parent = $this;
		
	}	
	
	function template()
	{
		$this->content = ob_get_clean();
		application::load("application/templates/template.php");
	}
	
	
	function needsAuth()
	{
		
		try
		{
			
			if(isset($_SESSION['username']) and isset($_SESSION['password']))
			{
			
				$dbh = new PDO("mysql:host={$_SESSION['server']};", $_SESSION['username'], $_SESSION['password']);
				$this->dbh =$dbh;
			
				return 0;
			}
			throw new AuthException("d");
		}
		catch(Exception $e)
		{
			throw new AuthException("d");
		}
		
		
		
		return 1;
		
	}
	
}

