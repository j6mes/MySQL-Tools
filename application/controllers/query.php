<?php 

class Query extends DB
{
	function main()
	{
		$smt = $this->dbh->query($_POST['query']);
		$resultset = $smt->fetchAll(PDO::FETCH_ASSOC);
		
		
		$this->view->render("resultset",array("resultset"=>$resultset));
		
		
	}
}
