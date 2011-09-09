<h2>Resultset</h2>
<form method="post" action="/result/execute/<?=htmlentities($arg['schema'])?>">
<textarea name="query"><?=htmlentities($arg['query'])?></textarea><br />
<input type="submit" value="Execute" />
</form>
<?php

if(is_array($arg['results']))
{
	echo "<div class=\"result_table\">";
		echo "<div class=\"result_row\">";
			
		foreach($arg['results'][0] as $key=>$null)
		{
			echo "<div class=\"result_col result_first\">{$key}</div>";
			
		}
		
		
		echo "</div>";
	foreach($arg['results'] as $row)
	{
		
		echo "<div class=\"result_row\">";
		foreach($row as $col)
		{
			echo "<div class=\"result_col\">";
			echo application::short(htmlentities($col));
			echo "</div>";
		}
		echo "</div>";
	}
	echo "</div>";
}
