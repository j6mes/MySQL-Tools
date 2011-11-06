Connect to SQL Server: <?=$arg['server'] ?>
<?php if(isset($arg['error']))
{
	echo ("<div class=\"error\">{$arg['error']}</div>");
} ?>
<form method="post" action="authentication">
<div class="input"><input type="text" name="username" /></div>
<div class="input"><input type="password" name="password" /></div>
<div class="submit"><input type="submit" value="Log In"></div>
</form>