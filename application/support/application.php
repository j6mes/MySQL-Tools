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
			$s = "";
		}
		
		
		
		$str = str_replace(array("\r\n","\n\r","\n","\r"),"",$str);
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
	
	
	
		
		
	    return stripslashes(str_replace("",$s,substr($str, 0, $len) . '...')); 
	
	}
	
	function logLogin($server, $remoteIP,$username,$success)
	{
		if(is_dir("storage"))
		{
			$date = date("c");
			$fp = fopen ("storage/login.log","a");
			fwrite($fp,"{$date}, {$server}, {$remoteIP}, {$username}, {$success}\n\r");
			fclose($fp);
		}
		
		
		
	}
	
	function logQuery($server,$username,$query)
	{
		if(is_dir("storage"))
		{
			if(!is_dir("storage/{$server}"))
			{
				mkdir("storage/{$server}");
			}
			
			if(!is_dir("storage/{$server}/{$username}"))
			{
				mkdir("storage/{$server}/{$username}");
			}
			$date = date("c");
			$fp = fopen ("storage/{$server}/{$username}/query.log","a");
			fwrite($fp,"{$query}\032");
			fclose($fp);
		
		}
		
		
		
		
		
	}
	
	function getQuery($server,$username)
	{

		if(!is_dir("storage/{$server}/{$username}"))
		{
			return "";
		}
		

		$fp = fopen ("storage/{$server}/{$username}/query.log","r");
		
		
		$contents = fread($fp, filesize("storage/{$server}/{$username}/query.log"));
		fclose($fp);
		return $contents;
	
		
	}
	
	function getDataTypes()
	{
		return array(
		"VARCHAR"=>array("type"=>"text","length","notnull","default"=>""),
		"INT"=>array("type"=>"number","length","notnull","unsigned","zerofill","default"=>0),
		"TEXT"=>array("notnull","default"=>""),
		"TINYINT"=>array("type"=>"number","unsigned","notnull","default"=>0),
		"MEDIUMINT"=>array("type"=>"number","unsigned","notnull","default"=>0),
		"BIGINT"=>array("type"=>"number","unsigned","notnull","default"=>0),
		"FLOAT"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"DOUBLE"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"DECIMAL"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"NUMERIC"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"BIT"=>array("type"=>"bit","length","notnull","default"=>0),
		"DATETIME"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"TIME"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"YEAR"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"DATE"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"CHAR"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"BINARY"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"BLOB"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"SET"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"ENUM"=>array("type"=>"number","length","unsigned","notnull","default"=>0),
		"VARBINARY"=>array("type"=>"number","length","unsigned","notnull","default"=>0)
		);
		
	}
	

}