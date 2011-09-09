<?php

class logout extends Controller
{
	function __construct()
	{
		
	}	
	
	function main()
	{
		session_destroy();
		header("Location:/");
	}
	
	
}