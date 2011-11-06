<?php

class Controller
{
	public $parent;
	public $view;
	public $dbh;
	function isAuthed()
	{
		return 1;
	}

	
	function __construct()
	{
		$this->dbh =& $this->parent->s->dbh;
		$this->view = new View();
		$this->view->parent = $this;
		
	}	
	
}

