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
		return str_replace(array(";","\"","'","\\","`"),"",$input);
	}
	
	function short($str,$special=false)
	{
		$s= "&para;";
		if($special)
		{
			$s = "¶";
		}
		
		
		
		$str = str_replace(array("\r\n","\n","\r"),"¶",$str);
		$len = 100;
		
		if ( strlen($str) <= $len ) 
		{
			if(!$special)
			{
				$str = str_replace("¶",$s,$str);
			}
	        return $str;
	    }
		
	    // find the longest possible match
	    $pos = 0;
	    foreach ( array('. ', '? ', '! ',"\"","\'") as $punct ) {
	        $npos = strpos($str, $punct);
	        if ( $npos > $pos && $npos < $len ) {
	            $pos = $npos;
	        }
	    }
	
	
	
		
		
	    return stripslashes(str_replace("¶",$s,substr($str, 0, $len) . '...')); 
	
	}
	

}