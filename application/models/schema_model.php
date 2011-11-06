<?php 

class Schema_Model extends Model
{
	
	private $schema;

	function __construct($schema="")
	{
		$this->schema = $schema;
		parent::__construct();
	}
	
	function view($schema)
	{
		if($this->schemaExists($schema)===true)
		{
			
			$tables = $this->getTables($schema);
			
			return $tables;	
		}
		return false;
	}
	
	function dbList()
	{
	
		$stmt = $this->parent->s->dbh->query("
		SELECT `SCHEMA_NAME`, COUNT(`TABLE_NAME`) as CC
		FROM `information_schema`.`SCHEMATA`
		LEFT JOIN `information_schema`.`TABLES` ON `TABLES`.`TABLE_SCHEMA`=`SCHEMATA`.`SCHEMA_NAME`
		GROUP BY `TABLES`.`TABLE_SCHEMA`");
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		while ($schema = $stmt->fetch())
		{
			$schemata[]=array("name"=>$schema['SCHEMA_NAME'],"count"=>$schema['CC']);
		}
		
		return $schemata;
	}
	
	
	function drop($schema)
	{


		try
		{
			$stmt = $this->dbh->query("
		DROP SCHEMA `{$schema}`");
		
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	
		$error = $this->dbh->errorInfo();
		if(intval($error[0])) 
		{
		    return $error;
	  	}
		
		return 1;
	
	
	}
	
		
	function permission($permission)
	{
		/*
		$stmt = $this->dbh->prepare("SHOW GRANTS FOR ``";
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->bindParam(1,$schema);
		$stmt->bindParam(2,$schema);
		$stmt->execute();
		while ($col = $stmt->fetch())	
		{
			$tables[$col['TABLE_NAME']][]=$col;
		}
		 * *
		 */
		
		return 1;
	}
	
	function getTables($schema)
	{
	
		$stmt = $this->dbh->prepare("
		SELECT * FROM information_schema.`COLUMNS` INNER JOIN information_schema.`TABLES` ON `TABLES`.`TABLE_NAME` = `COLUMNS`.`TABLE_NAME` WHERE `TABLES`.TABLE_SCHEMA=? AND `COLUMNS`.`TABLE_SCHEMA` = ? ORDER BY ORDINAL_POSITION ASC");
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->bindParam(1,$schema);
		$stmt->bindParam(2,$schema);
		$stmt->execute();
		while ($col = $stmt->fetch())	
		{
			$tables[$col['TABLE_NAME']][]=$col;
		}

		return $tables;
		
	}
	
}
