
<div id="authform">
<?php if(isset($arg['error']))
{
	echo ("<div class=\"error\">{$arg['error']}</div>");
} ?>


<form method="post" action="authentication">
	Server: <div class="input"><input type="text" value="<?=$arg['server'] ?>" name="username" disabled/></div>
	Username: <div class="input"><input type="text" name="username" /></div>
	Password: <div class="input"><input type="password" name="password" /></div>
	<div class="submit"><input type="submit" value="Log In"></div>
</form>


</div>