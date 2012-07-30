<form method="post" action="<?php echo BASE; ?>authentication">
<select name="server">
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


<input type="text" name="username" />
<input type="password" name="password" />
<input type="submit" /> 
</form>