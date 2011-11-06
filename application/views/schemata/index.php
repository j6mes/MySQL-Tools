<div style="background: #FF33FF"><strong>to do: menu</strong></div>
<h2>Databases</h2>


<?php

if(isset($arg['schemata']))
{
	
	$schemata =$arg['schemata'];
	
	if(sizeof($schemata))
	{
		echo "<ul>";
		
		
		foreach($schemata as $schema)
		{
			echo "<li><a href=\"/schema/view/{$schema['name']}\">{$schema['name']}</a> ({$schema['count']})</li>";
		}
		echo "</ul>";
	}
	
}