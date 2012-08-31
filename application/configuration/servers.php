<?php 
/**
 * Server Config Class
 * Stores a white list of servers that the client can connect to.
 *  
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 31/08/2012  
 */

class ServerConfig
{
	/**
	 * getServers 
	 * Returns an array of servers
	 *
	 * @return  array of server host names /ip addresses 
	 * @author	James Thorne / MySQL Tools / Redslide
	 * @version 31/08/2012  
	 */
	public function getServers()
	{
		return array ("127.0.0.1");
	}
}
