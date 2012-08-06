<h1>Databases</h1>
<?php 
if(is_array($this->fragments['database/all/database']))
{
	foreach ($this->fragments["database/all/database"] as $line)
	{
		echo $line;
	}
}
else
{
	echo $this->fragments['database/all/none'];
}
