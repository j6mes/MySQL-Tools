<?php


class Database
{
	protected $dbh;
	function __construct()
	{
		$this->dbh = new PDO("mysql:host=localhost;dbname=","","");
	}
}

