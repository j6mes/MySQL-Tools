<script type="text/javascript">
	$(document).ready(function()
	{
		$("#btn-exe").click(function()
		{

			$.post("/result/execute/<?=htmlentities($arg['schema'])?>",{query: $("#qry").val()},function(data,status)
			{
				$("table#resulttable").remove();
				$(".resultset").html("<table id=\"resulttable\"></table>");
				
				
				if(data.result!==undefined)
				{
					
					if(data.result!==null) 
					{
						var headcontent = "<tr>";
							
						$.each(data.result[0], function(idx,col)
						{
							
							headcontent += "<th>"+idx+"</th>";
						});
						
						headcontent += "</tr>";
						$("table#resulttable").append(headcontent);
						
					
					
					
							
						$.each(data.result,function(idx,row)
						{	
							var rowcontents = "<tr>";
							
							$.each(row, function(idx,col)
							{
								
								rowcontents += "<td>"+col+"</td>";
							});
							
							rowcontents += "</tr>";
							$("table#resulttable").append(rowcontents);
						});
					}
					else
					{
						var rowcontents = "<tr>";
						
					
						rowcontents += "<th>Query Returned No Resultset. "+data.status+" rows affected</th>";
					
						
						rowcontents += "</tr>";
						$("table#resulttable").append(rowcontents);
					}
				}
				else
				{
					var rowcontents = "<tr>";
						
				
					rowcontents += "<th colspan=2>Query Returned an Error</th>";
				
					
					
					rowcontents += "</tr>";
					
					
					$.each(data.error,function(idx,row)
					{	
						rowcontents+="<tr>";
						var etext="";
						switch(idx)
						{
							case 0: etext+="SQL State: "; break;
							case 1: etext+="Error Code: "; break;
							case 2: etext+="Info: "; break;
						}
						rowcontents += "<td>"+etext+"</td><td>"+row+"</td>";
						rowcontents += "</tr>";
		
					});
						
					
					
					$("table#resulttable").append(rowcontents);
					
					
				}
			},"json");
		});
	});
	
	
</script>
<div class="masterqry">

<form method="post" action="/result/execute/<?=htmlentities($arg['schema'])?>">
	
<textarea id="qry" wrap="off" name="query"><?=htmlentities($arg['query'])?></textarea>
</form>
</div>
<?php

$arg['toolbar'] = <<<EOD
<div class="mstoolbar">
	<ul>
		<li id="btn-back">Back</li>
		<li id="btn-fwd">Forward</li>
		<li id="btn-exe">Execute</li>
	</ul>
</div>
EOD;



	echo "<div class=\"resultset\">

	<table id=\"resulttable\">
		<tr>";
	if(is_array($arg['results']))
	{
				
		foreach($arg['results'][0] as $key=>$null)
		{
			echo "<th>{$key}</th>";
			
		}
		
		
		echo "</tr>";
		foreach($arg['results'] as $row)
		{
			
			echo "<tr>";
			
			
			foreach($row as $col)
			{
				echo "<td><pre>";
				echo application::short(htmlentities($col));
				echo "</pre></td>";
			}
			echo "</tr>";
			
		}
	}
	else
	{
	
		echo "<tr><th>Query Returned No Resultset.</th></tr>";
		
	}
	echo "</table></div>";
