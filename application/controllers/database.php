<?php 

class Database extends DB
{
	
	function __construct()
	{
		parent::__construct();
		application::load("application/models/mdatabase.php");
		
	}
	
	
	function main()
	{
		header("Location:/database/all");
		die;
		
	}
	

	
	function all()
	{
		$sth = $this->dbh->prepare("SHOW DATABASES");
		$sth->execute();
		
		while($tmp=$sth->fetchObject('MDatabase'))
		{
			$databases[] = $tmp;
		}	
		
		
		if(is_array($databases))
		{
			foreach($databases as $database)
			{
				$this->view->fragment("database/all/database",array("database"=>$database));
			}
		}
		$this->view->render("database/all", array("databases"=>$databases));
		
	
	}
	
	function create()
	{
		if(isset($_POST['database']))
		{
			
			$name = ereg_replace("[^A-Za-z0-9_-]", "", $_POST['database']);
			$db = new MDatabase($name);
			$db->Create();
		}
		else
		{
			$this->view->render("database/create");
				
		}
		
	}
	
	function drop($name)
	{
		echo $name;
		$db = new MDatabase($name);
		$db->Drop();
	}
	
	function view($name)
	{
		$db = new MDatabase($name);
		$db->LoadTables();
		

		if(is_array($db->tables))
		{
			foreach($db->tables as $table)
			{
				$this->view->fragment("database/view/table",array("table"=>$table));
			}
		}
		
		
		$this->view->render("database/view", array("database"=>$db));

	}
}
