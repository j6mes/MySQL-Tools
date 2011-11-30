<?php

class internal
{
	function get($r=0)
	{
		$t = application::getQuery($_SESSION['server'],$_SESSION['username']);
		$t= explode("\032",$t);
		if(sizeof($t))
		{
			$t = array_reverse($t);
		}
		else {
			die("");
		}
		unset($t[0]);
		if(@isset($t[$r]))
		{
			die($t[$r]);
		}
		die("");
		print_r($t);
	}
}
