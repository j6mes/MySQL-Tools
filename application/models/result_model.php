<?php

class result_model extends Model
{
	public $controller;
	function run($query)
	{
		
		try
		{
		$stmt = $this->controller->dbh->query($query);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		while ($row = $stmt->fetch())
		{
			$data[]=$row;
		}
		}
		catch(PDOStatement $e)
		{
			echo ($e);
		}
		
		return ($data);		
	}
}
