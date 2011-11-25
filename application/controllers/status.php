<?php

class status extends Controller
{
	function main()
	{
		$stmt = $this->parent->s->dbh->query("SHOW STATUS WHERE `Variable_Name` IN (\"Uptime\",\"Questions\");");
		$stuff =$stmt->fetchAll();
		$delta = $stuff[0][1]-$_SESSION['delta'];
		
		if($_SESSION['delta']==0)
		{
			$delta=0;
		}
		$_SESSION['delta']=$stuff[0][1];
		die(json_encode(array("delta"=>$delta,"uptime"=>$stuff[1][1],"questions"=>$stuff[0][1])));
	}
}
	