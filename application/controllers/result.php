<?php 

require("application/models/result_model.php");
class result extends Controller
{
	public $dbh;
	function __construct($parent="",$dbh="", $query = "", $schema = "")
	{
		parent::__construct();
		
		if(strlen($query)>0)
		{
		
			$this->parent = $parent;
			$this->dbh = $dbh;
			$this->model = new result_model();
			$this->model->parent= $this->parent;
			$this->model->controller= $this;
			
				/*3
			$sa = $this->model->run($query);
			 * 
			 */
			$data = $this->run2($schema,$query);
			//$data['status']= $this->dbh->rowCount;
			$data['query']=$query;
			$data['schema']= $schema;
			$data['title']= "View Resultset ({$schema})";
			
			$this->view->render("result",$data);
			
			
			/*
			$data['results']= $sa['result'];
			
			$data['status']= $this->dbh->rowCount;
			$data['query']=$query;
			$data['schema']= $schema;
			$data['title']= "View Resultset ({$schema})";
			 * 
			 */
			
		}
	}	
	
	function execute($schema="")
	{
		
		$this->model = new result_model();
		$this->model->parent= $this->parent;
		$this->model->controller= $this;
		$this->model->schemaExists($schema);
		
		$query = $_POST['query'];
		application::logQuery($_SESSION['server'],$_SESSION['username'],htmlentities($_POST['query']));
		try
		{
			$stmt = $this->model->dbh->query(stripslashes($query));
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
		$edit=0;
  		$error = $this->model->dbh->errorInfo();
	
  		if(intval($error[0])>0) 
  		{
   			echo json_encode(array("error"=>$error));
		}
		else
		{
			try
			{
				$stmtck = $this->model->dbh->query(stripslashes("DESCRIBE " . $query));
			}
			catch (PDOException $e)
			{
				echo $e->getMessage();
			}
			$rc= strval($stmt->rowCount());
			
			
			
			
			$error = $this->model->dbh->errorInfo();
			if(intval($error[0])>0) 
			{
   				
			}
			else 
			{
		
				
				while($row = $stmtck->fetch(PDO::FETCH_ASSOC))
				{
					$ck[]=$row;
				}
				
				
				if($stmtck->rowCount()==1)
				{
					
					preg_match_all("/(.*)FROM ([a-zA-Z0-9-_\.\`]+)?(as|\,)?(.*)/i", $query,$tdata);

					$stmtcol = $this->model->dbh->query(stripslashes("SHOW FULL COLUMNS FROM  " . strval($tdata[2][0])));
					$error = $this->model->dbh->errorInfo();
					if(intval($error[0])>0) 
					{
		   				die(print_r($error));	
					}
					else 
					{
						while($col = $stmtcol->fetch(PDO::FETCH_ASSOC))
						{
							$cols[]=$col;
							
						}
					}
					
				}
			}
		
		
	  		if(sizeof($cols))
			{
				foreach ($cols as $col)
				{
					if($col['Key']=="PRI")
					{
						$indexk = $col['Field'];
					}
				}
			}
			
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$idx=0;
		
				if(sizeof($row))
				{
					foreach ($row as $k=>$data)
					{
						$tmprow[$k]=htmlspecialchars(application::short($data,true));
						
					}
					
					
					
				}
				@$rows[$tmprow[$indexk]]=$tmprow;
				
			}
		
			if(sizeof($rows))
			{
				$k = array_keys($rows);
				
				foreach ($rows[$k[0]] as $dcol=>$rdata)
				{
					foreach ($cols as $col)
					{
						if($col['Field']==$dcol and $col['Key']=="PRI")
						{
							$edit = 1;
						}
					}
				}
			}
			$tmpArr = array("edit"=>$edit,"table"=>$tdata[2][0],"idxcol"=>@$indexk, "cols"=>$cols, "desc"=>$ck, "status"=>$rc,"result"=>$rows);
			echo json_encode($tmpArr);
		}
	}


	function run2($schema,$query)
	{
		$this->model = new result_model();
		$this->model->parent= $this->parent;
		$this->model->controller= $this;
		$this->model->schemaExists($schema);
		
		
		try
		{
			$stmt = $this->model->dbh->query(stripslashes($query));
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
		
		
		$edit=0;
  		$error = $this->model->dbh->errorInfo();

  		if(intval($error[0])>0) 
  		{
   			echo json_encode(array("error"=>$error));
		}
		else
		{
			try
			{
				$stmtck = $this->model->dbh->query(stripslashes("DESCRIBE " . $query));
			}
			catch (PDOException $e)
			{
				echo $e->getMessage();
			}
			$rc= strval($stmt->rowCount());
			
			
			
			
			$error = $this->model->dbh->errorInfo();
			
			if(intval($error[0])>0) 
			{
   				
			}
			else 
			{
		
				
				while($row = $stmtck->fetch(PDO::FETCH_ASSOC))
				{
					$ck[]=$row;
					
					
				}
				
				
				if($stmtck->rowCount()==1)
				{
					
					preg_match_all("/(.*)FROM ([a-zA-Z0-9-_\.\`]+)?(as|\,)?(.*)/i", $query,$tdata);

					$stmtcol = $this->model->dbh->query(stripslashes("SHOW FULL COLUMNS FROM  " . strval($tdata[2][0])));
					$error = $this->model->dbh->errorInfo();
					if(intval($error[0])>0) 
					{
		   				die(print_r($error));	
					}
					else 
					{
						while($col = $stmtcol->fetch(PDO::FETCH_ASSOC))
						{
							$cols[]=$col;
							
						}
					}
					
				}
			}
		
		
	  		if(sizeof($cols))
			{
				foreach ($cols as $col)
				{
					if($col['Key']=="PRI")
					{
						$indexk = $col['Field'];
					}
					
						
				}
			}
			
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$idx=0;
		
				if(sizeof($row))
				{
					foreach ($row as $k=>$data)
					{
						$tmprow[$k]=$data;
						
					}
					
					
					
				}
				@$rows[$tmprow[$indexk]]=$tmprow;
				
			}
		
			if(sizeof(@$rows))
			{
				$k = array_keys($rows);
				
				foreach ($rows[$k[0]] as $dcol=>$rdata)
				{
					foreach ($cols as $col)
					{
						if($col['Field']==$dcol and $col['Key']=="PRI")
						{
							$edit = 1;
						}
					}
				}
			}
			$tmpArr = array("edit"=>$edit,"xtable"=>$tdata[2][0],"idxcol"=>@$indexk, "cols"=>$cols, "desc"=>$ck, "status"=>$rc,"results"=>@$rows);

			return($tmpArr);
		}
	}
}
