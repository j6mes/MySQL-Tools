<?php

/*	MySQL Tools will only connect to the servers in this file.
 *	Allowing MySQLTools to connect to any remote server is HIGHLY UNADVISED
 * 	There is no functionality to allow MySQLTools to connect to a user specified
 * 	server. Should you need this you will have to edit the source yourself.  
 */
//

class serverConfig extends Config
{
	protected $servers;
	function __construct()
	{
		//do not delete this line at any costs
		parent::__construct();
		
		//specify the servers which MySQLTools can connect to.
		//adding ports: 	$this->servers[] = "127.0.0.1:3306";
		//					$this->servers[] = "mysql1.myhost.local"
		
		$this->servers[] = "127.0.0.1";
		$this->servers[] = "205.185.125.57";
	}
	
	function getServers()
	{
		
		return $this->servers;
		
	}
	
	
}
