<?php
/**
 * Authentication Controller
 * Stores a whitelist of MySQL servers that the client can connect to.
 *  
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 21/07/2012  
 */
class Authentication extends Controller
{
	/**
	 * The login form
	 *
	 * @return void
	 */
	public function main()
	{
		/*
		 * Get the list of servers from local configs
		 * TODO streamline getting the config from somewhere
		 */
		$tmpservers = $GLOBALS['servers']->getServers();
		

		/*
		 * Check to see if the server the user has selected is an item in the config
		 */
		if(!strlen($tmpservers[intval($_POST['server'])]))
		{
			throw new AuthException("Error Processing Request", 1);
		}
		
		/*
		 * Check we have a username
		 */
		if(strlen($_POST['username'])<1)
		{
			throw new AuthException("The username is too short.", 1);
		}
		
		/*
		 * Check the password length is suitable
		 * Password length is set to 1 to prevent logins without password
		 */
		if(strlen($_POST['password'])<1)
		{
			throw new AuthException("Password length too short, MySQL Tools does not support logins without password", 1);
		}
		
		
		try 
		{
			/*
			 * Create new PDO connection
			 */
			$pdo = new PDO("mysql:host={$tmpservers[intval($_POST['server'])]};", $_POST['username'], $_POST['password']);
		}
		catch(PDOException $e)
		{
			/*
			 * Pass exception
			 */
	    	throw new AuthException($e->getMessage(), 1);
			
	    }
		
		/*
		 * Log the login to file
		 */
		application::logLogin($server, $_SERVER['REMOTE_ADDR'],$username,1);
		
		/*
		 * Destroy the connection as we no longer need it
		 */
		unset ($dbh);
		
		/*
		 * Put the login information into a session
		 */
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
		$_SESSION['server'] = $tmpservers[$_POST['server']];
		
		/*
		 * Go back to the start.
		 */
		header("Location:/");
		die;
		
		
	}	
	
	
	/**
	 * The logout action
	 *
	 * @return void
	 */
	public function logout()
	{
		session_destroy();	
	}
}

