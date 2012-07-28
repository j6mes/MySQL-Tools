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
		return 1;
	}
	
}

