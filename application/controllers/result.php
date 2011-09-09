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
			$data['results']= $this->model->run($query);
			$data['query']=$query;
			$data['schema']= $schema;
			$this->view->render("result",$data);
		}
	}	
	
	function execute($schema="")
	{
		
		$this->model = new result_model();
		$this->model->parent= $this->parent;
		$this->model->controller= $this;
		$this->model->schemaExists($schema);
		
		$query = $_POST['query'];
		echo $query;
	}

}
