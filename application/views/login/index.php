<div id="authform">
<?php if(isset($arg['error']))
{
	echo ("<div class=\"error\">{$arg['error']}</div>");
}

if(!sizeof($arg['servers']))
{
	echo "No servers to connect to</div>";	
	die;
} ?>


<form method="post" action="/authentication">
	Server: <div class="input"><select name="server"/>
		<?php
		foreach($arg['servers'] as $k=>$server)
		{
			echo "<option value=\"{$k}\">{$server}</option>";
			
		}
		?>
	</select></div>
	Username: <div class="input"><input type="text" name="username" /></div>
	Password: <div class="input"><input type="password" name="password" /></div>
	<div class="submit"><input type="submit" value="Log In"></div>
</form>


</div>