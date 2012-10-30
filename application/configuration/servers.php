<?php 
/**
 * Server Config Class
 * Stores a whitelist of MySQL servers that the client can connect to.
 *  
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 31/08/2012  
 */
class ServerConfig
{
	/**
	 * Returns an array of servers
	 *
	 * @return  array of server host names /ip addresses 
	 */
	public function getServers()
	{
		return array ("127.0.0.1");
	}
}
