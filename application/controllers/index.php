<?

require("application/models/index_model.php");
	
	
class Index extends Controller
{
	private $e; 
	public $parent;
	function __construct()
	{
		parent::__construct();
	}
	
	function main()
	{
		
		$this->model = new Index_Model();
		$this->model->parent = $this->parent;
		if($this->parent->needsAuth())
		{
			$data['servers']= $GLOBALS['servers']->getServers(); 
			if(isset($this->e))
			{
				$data['error']=$this->e;
			}
			$this->view->render("login",$data);
		}
		else 
		{
			header("Location:/schema/all");
		}
		
	}
	
	function err($e)
	{
		$this->e = $e;
		$this->main();
	}
	
	
	
}



