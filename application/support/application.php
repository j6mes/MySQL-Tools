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
	
	function sanitize($input)
	{
		return str_replace(array(";","\"","'","\\","`","."),"",$input);
	}
	
	function short($str)
	{
		$len = 100;
		 if ( strlen($str) <= $len ) {
	        return $str;
	    }
	
	    // find the longest possible match
	    $pos = 0;
	    foreach ( array('. ', '? ', '! ') as $punct ) {
	        $npos = strpos($str, $punct);
	        if ( $npos > $pos && $npos < $len ) {
	            $pos = $npos;
	        }
	    }
	

	    return substr($str, 0, $len) . '...'; 
	
	}
	
}