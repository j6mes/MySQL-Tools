<h1>Tables in <?php echo $this->args['database']->Database; ?></h1>
<?php 

	foreach ($this->fragments["database/view/table"] as $line)
	{
		echo $line;
	}
	