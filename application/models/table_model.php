<?php
class table_model extends Model
{
		
	function tableLayout($schema,$table)
	{
	
		$stmt = $this->dbh->prepare("
		SELECT * FROM information_schema.`COLUMNS` WHERE TABLE_SCHEMA=? AND TABLE_NAME=?  ORDER BY TABLE_NAME ASC, ORDINAL_POSITION ASC");
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->bindParam(1,$schema);
		$stmt->bindParam(2,$table);
		$stmt->execute();
		while ($col = $stmt->fetch())	
		{
			$aTable[]=$col;
		}
		
		
		return $aTable;
		
	}
	
	function tableExists($table)
	{
	
		
		$stmt = $this->dbh->prepare("
		EXPLAIN SELECT * FROM {$table}");
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->bindParam(1,$table);
		$stmt->execute();

		return $stmt->columnCount();
		
		
	
	}
	
	function pinpoint()
	{
		
		$stmt = $this->dbh->prepare("SELECT {$_POST['index']} FROM {$_POST['table']} WHERE {$_POST['indexer']} = ?");
		$res = $stmt->execute(array($_POST['request']));
		$error = $this->dbh->errorInfo();
		$ret = $stmt->fetchColumn();	
	
		die(htmlspecialchars(stripslashes($ret)));
	}
	
	function comit()
	{
		
		$qry = "UPDATE {$_POST['table']} SET {$_POST['index']} = ? WHERE `{$_POST['indexer']}` = ? LIMIT 1";
		$stmt = $this->dbh->prepare($qry);
		$res = $stmt->execute(array($_POST['newval'],$_POST['request']));
		$error = $this->dbh->errorInfo();

	}
	
	
	function drop($schema,$table)
	{

		try
		{
			$stmt = $this->dbh->query("
		DROP TABLE `{$schema}`.`{$table}`");
		
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
}
