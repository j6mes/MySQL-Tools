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
	
}
