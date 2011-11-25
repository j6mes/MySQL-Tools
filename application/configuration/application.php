<?php

class appConfig extends Config
{
	protected $app;
	function __construct()
	{
		//do not delete this line at any costs
		parent::__construct();

		//[RECOMMENDED] store login history
		$this->app['loginhistroy'] = 1;
		
		//display status on welcome page
		$this->app['status'] = 1;
		
		//store query history
		$this->app['history'] = 1;
		 
	}
}
