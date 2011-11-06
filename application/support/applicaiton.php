<?php 
abstract class application
{
	function load($file)
	{
		if(file_exists($file)) 
		{ 
            include_once($file); 
        } 
        else 
        { 
            throw(new Exception('File does not exist.')); 
        } 
	}
	
}