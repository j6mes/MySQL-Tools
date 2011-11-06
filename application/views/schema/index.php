<h2>Tables In Schema <?=$arg['schema']?></h2>
<?php

echo $arg['message'];


if(isset($arg['tables']))
{
	echo "<h3><a href=\"/table/view/{$arg['schema']}.{$table}\">{$table}</a></h3>";
		echo "<div class=\"schema_table\">";
		echo "<div class=\"schema_row\">
		
		<div class=\"schema_col schema_first\">Table Name</div>
		<div class=\"schema_col schema_first\">Engine</div>
		<div class=\"schema_col schema_first\">Size</div>
		<div class=\"schema_col schema_first\">Collation</div>
		<div class=\"schema_col schema_first schema_lc\">Comments</div>
		</div>";
		foreach ($arg['tables'] as $table=>$cols)
		{
	
				$cols[0]['DATA_LENGTH'] = $cols[0]['DATA_LENGTH']/1024;
				
				echo "<div class=\"schema_row\">
				
				<div class=\"schema_col\"><a href=\"/table/view/{$arg['schema']}.{$table}\">{$cols[0]['TABLE_NAME']}</a></div>
				<div class=\"schema_col\">{$cols[0]['ENGINE']}</div>
				<div class=\"schema_col\">{$cols[0]['TABLE_ROWS']} rows ({$cols[0]['DATA_LENGTH']} kb)</div>
				<div class=\"schema_col\">{$cols[0]['TABLE_COLLATION']}</div>
				<div class=\"schema_col schema_lc\">{$cols[0]['TABLE_COMMENT']}</div>
				</div>";
				
				
				
				
				
		
		}
				
		echo "</div>";
}


/*

if(isset($arg['tables']))
{
	foreach ($arg['tables'] as $table=>$cols)
	{
		echo "<h3><a href=\"/table/view/{$arg['schema']}.{$table}\">{$table}</a></h3>";
		echo "<div class=\"schema_table\">";
		echo "<div class=\"schema_row\">
			
			<div class=\"schema_col schema_first\">Column Name</div>
			<div class=\"schema_col schema_first\">Data Type</div>
			<div class=\"schema_col schema_first\">Extra</div>
			<div class=\"schema_col schema_first schema_lc\">Comments</div>
			</div>";
		foreach ($cols as $column)
		{
			$pricon = "";
			if($column['COLUMN_KEY']=="PRI")
			{
				$pricon = "KEY ";
			}
			
			$def = "";
			if(strlen($column['COLUMN_DEFAULT']))
			{
				$def = "(default: <em>{$column['COLUMN_DEFAULT']}</em>)";
			}
			echo "<div class=\"schema_row\">
			
			<div class=\"schema_col\">{$pricon}{$column['COLUMN_NAME']}</div>
			<div class=\"schema_col\">{$column['COLUMN_TYPE']} {$def}</div>
			<div class=\"schema_col\">{$column['EXTRA']}</div>
			<div class=\"schema_col schema_lc\">{$column['COLUMN_COMMENT']}</div>
			</div>";
			
			
		}
		
		
		echo "</div>";
	
	}
}
*/
