<?php
class Model
{
	public $parent;
	public $dbh;
	function __construct()
	{

	}
	
	function schemaExists($schema)
	{
		$GLOBALS['schema']= "";
		//lets get the parameters from our session and make a new dbh to this schema.
		$vars = $this->parent->s->vars();
		
		try
		{
			$dbh = new PDO("mysql:host={$vars['server']};dbname={$schema}", $vars['username'], $vars['password']);
			$this->dbh =$dbh;
			
		}
		catch(PDOException $e)
		{
			throw new Exception($e->getMessage());
		}
		
		$GLOBALS['schema']= $schema;
		
		
		return true;
	}
	
}
