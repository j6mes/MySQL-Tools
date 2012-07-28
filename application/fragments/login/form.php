<select>
	<?php 
	if(is_array($this->fragments['login/optionrow']))
	{
		foreach ($this->fragments['login/optionrow'] as $optionrow)
		{
			echo $optionrow;
		}
	}
	?>
</select>