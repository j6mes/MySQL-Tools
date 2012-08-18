<?php 

class Query extends DB
{
	function main()
	{
		$smt = $this->dbh->query($_POST['query']);
		
		if(is_object($smt))
		{
			$resultset = $smt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		
		
		$errorinfo = $this->dbh->errorInfo();
		
		$this->view->render("resultset",array("resultset"=>$resultset,"error"=>$errorinfo));
		
		
	}
	
	function explain()
	{
		if(stripos($_POST['query'],"explain",0)!==false)
		{
			$this->view->render("query/readonly",array("readonly"=>"readonly"));
			die; 
		}
		
		
		$smt = $this->dbh->query("explain " . $_POST['query']);
		$resultset = $smt->fetchAll(PDO::FETCH_ASSOC);
		
		$this->view->render("resultset",array("resultset"=>$resultset));
		
	}
	
	function describeFirstTable()
	{
	
		preg_match_all("/(.*)FROM ([a-zA-Z0-9-_\.\`]+)?(as|\,)?(.*)/i", $_POST['query'],$tdata);
		
		
		$smt = $this->dbh->query(stripslashes("SHOW FULL COLUMNS FROM  " . strval($tdata[2][0])));
		
		$resultset = $smt->fetchAll(PDO::FETCH_ASSOC);
		
		$this->view->render("resultset",array("resultset"=>$resultset));
		
	}
}
