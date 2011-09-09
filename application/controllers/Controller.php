<?php

class Controller
{
	public $parent;
	public $view;

	function isAuthed()
	{
		return 1;
	}

	
	function __construct()
	{
				
		$this->view = new View();

		
	}	
	
}

