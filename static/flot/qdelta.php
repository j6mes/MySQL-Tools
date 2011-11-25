{"qps":<?php
include("dbtools.php");



$db = new dbTools();
			
$stat = explode(": ",$db->_link->stat());

foreach ($stat as $k=>$status)
{
	if($k){
	
	$x=  explode(" ",$status);
	$ar[]= $x[0];
	}
}
$delta = $ar[2]-$_SESSION['delta'];
#echo "<strong>{$ar[2]}</strong>";
#echo " (".$delta ." per second)";
if($_SESSION['delta']==0)
{
echo 0;
}
else
{
	echo $delta;
}
$_SESSION['delta'] = $ar[2];
?>,"qcount":<?=$ar['2']?>
}
