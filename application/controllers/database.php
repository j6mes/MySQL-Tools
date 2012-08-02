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
		
		
		
		if(isset($this->core->json))
		{
			$this->view->ajax(array("databases"=>$databases));
			
		}
		else
		{
			var_dump($databases);
		}
	
	}
	
	function create($name)
	{
		echo $name;
		$db = new MDatabase($name);
		$db->Create();
	}
	
	function drop($name)
	{
		echo $name;
		$db = new MDatabase($name);
		$db->Drop();
	}
	
	function view($name)
	{
		echo $name;
		$db = new MDatabase($name);
		$tables = $db->GetTables();
		print_r($tables);
	}
}
