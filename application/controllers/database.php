<?php 

/**
 * Database Controller
 * Stores a whitelist of MySQL servers that the client can connect to.
 *  
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 03/07/2012  
 */
class Database extends DB
{
	/**
	 * Constructor for the controller. 
	 * Loads the mdatabase model
	 */
	function __construct()
	{
		parent::__construct();
		application::load("application/models/mdatabase.php");
		
	}
	
	
	/**
	 * Default handler for the controller
	 *
	 * @return void
	 */
	function main()
	{
		/*
		 * Redirect to /database/all instead of using this function
		 */
		header("Location:/database/all");
		die;
	}
	

	/**
	 * Show all Databases Controller
	 *
	 * @return void
	 */
	function all()
	{
		/*
		 * Get a list of databases from dbh
		 */
		$sth = $this->dbh->prepare("SHOW DATABASES");
		$sth->execute();
		
		/*
		 * Fetch into a list of MDatabases
		 */
		while($tmp=$sth->fetchObject('MDatabase'))
		{
			$databases[] = $tmp;
		}	
		
		/*
		 * If we have a list of databases then load the display frag for each database
		 */
		if(is_array($databases))
		{
			foreach($databases as $database)
			{
				$this->view->fragment("database/all/database",array("database"=>$database));
			}
		}
		
		/*
		 * And render our view with the list of databases
		 */
		$this->view->render("database/all", array("databases"=>$databases));
		
	
	}
	
	/**
	 * Create a new database
	 *
	 * @return void
	 */
	function create()
	{
		/*
		 * Use POST parameter database
		 */
		if(isset($_POST['database']))
		{
			/*
			 * Just create it
			 * TODO check for existing DB
			 */
			$name = ereg_replace("[^A-Za-z0-9_-]", "", $_POST['database']);
			$db = new MDatabase($name);
			
			try
			{
				$db->Create();
			}
			catch(exception $e)
			{
				/*
				 * TODO trigger error
				 */
				
				
			}
			
			/*
			 *	TODO Display result
			 */
		}
		else
		{
			/*
			 * Displays the create database form
			 */
			$this->view->render("database/create");
				
		}
		
	}
	
	
	/**
	 * Drop database by name 
	 *
	 * @return void
	 */
	function drop($name)
	{
		$name = ereg_replace("[^A-Za-z0-9_-]", "", $name);
		if(isset($_POST['drop']))
		{
			/*
			 * Create a new Model DB by name and drop it
			 */		
			$db = new MDatabase($name);
			$db->Drop();
		}
		else
		{
			/*
			 * Otherwise display the drop form
			 */
			$this->view->render("database/drop");
				
		}
	}
	
	/**
	 * View a list of tables in the database
	 *
	 * @return void
	 */
	function view($name)
	{
		/*
		 * Create the model by name and extract tables
		 */
		$db = new MDatabase($name);
		$db->LoadTables();
		

		/*
		 * Check if we have an array of tables and then create fragments if it exists
		 */
		if(is_array($db->tables))
		{
			foreach($db->tables as $table)
			{
				$this->view->fragment("database/view/table",array("table"=>$table));
			}
		}
		else 
		{
			$this->view->fragment("database/all/none",null,1);
		}
		
		
		/*
		 * And render the view
		 */
		$this->view->render("database/view", array("database"=>$db));

	}
}
