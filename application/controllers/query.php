<?php 

/**
 * Query Controller
 * Provides connectivity and error handling to the world
 *  
 * @package default
 * @author	James Thorne / MySQL Tools / Redslide
 * @version 23/10/2012  
 */
class Query extends DB
{
	/**
	 * Default handler - just executes a query
	 *
	 * @return void
	 */
	function main()
	{
		/*
		 * This may look like a security issue, it allows users to send raw queries to the DB
		 * TODO check to see if request is from our server or a remote source for security
		 */	
		$smt = $this->dbh->query($_POST['query']);
		
		/*
		 * If the result is an actual object, the query was successful 
		 * - get the results into a array
		 */
		if(is_object($smt))
		{
			$resultset = $smt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		
		/*
		 * And also add the error info to the JSON response
		 */
		$errorinfo = $this->dbh->errorInfo();
		
		$this->view->render("resultset",array("resultset"=>$resultset,"error"=>$errorinfo));
	}
	
	/**
	 * Get information about a query
	 *
	 * @return void
	 */
	function explain()
	{
		/*
		 * If we are doing an explain on an explain then the query represents read-only data
		 */
		if(stripos($_POST['query'],"explain",0)!==false)
		{
			$this->view->render("query/readonly",array("readonly"=>"readonly"));
			die; 
		}
		
		/*
		 * Else get info about the query
		 */
		$smt = $this->dbh->query("explain " . $_POST['query']);
		$resultset = $smt->fetchAll(PDO::FETCH_ASSOC);
		
		$this->view->render("resultset",array("resultset"=>$resultset));
		
	}
	
	/**
	 * Gets info about the first table in a query
	 *
	 * @return void
	 */
	function describeFirstTable()
	{
		/*
		 * Get the table name from the Query
		 */
		preg_match_all("/(.*)FROM ([a-zA-Z0-9-_\.\`]+)?(as|\,)?(.*)/i", $_POST['query'],$tdata);
		
		/*
		 * And then get the collumns for it
		 */
		$smt = $this->dbh->query(stripslashes("SHOW FULL COLUMNS FROM  " . strval($tdata[2][0])));
		$resultset = $smt->fetchAll(PDO::FETCH_ASSOC);
		
		$this->view->render("resultset",array("table"=>strval($tdata[2][0]),"resultset"=>$resultset));
		
	}
}
