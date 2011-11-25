<?
class authentication
{
	private $username;
	private $password;
	
	function __construct()
	{
		try
		{
			if(is_array($_POST))
			{
				
				$tmpservers = $GLOBALS['servers']->getServers();
				if(!strlen($tmpservers[intval($_POST['server'])]))
				{
					throw new Exception("Error Processing Request", 1);
				}
				
				if(strlen($_POST['username'])<1)
				{
					throw new Exception("Error Processing Request", 1);
					
				}
				
				if(strlen($_POST['password'])<1)
				{
					throw new Exception("Error Processing Request", 1);
					
				}
				
				$this->username = $_POST['username'];
				$this->password = $_POST['password'];
				$this->server = $tmpservers[intval($_POST['server'])];
			}
		
			
			
		}
		catch(Exception $e)
		{
			throw new AuthException ("Username Password Failure");
		}
	}
	
	function main()
	{
		require("application/models/authentication_model.php");
		try
		{
			
			$this->model = new Authentication_Model($this->server, $this->username, $this->password);
		
		}
		catch (Exception $e)
		{
			throw new AuthException ($e->getMessage());
		}
	
	}
	
}

