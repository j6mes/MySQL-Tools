
<script type="text/javascript">
	var editmode = 0;
		var idxcol="";
		var idxtab="";
		var idxschem="";
		
		window.onbeforeunload = function() 
		{
			if(editmode==1)
			{
  				return "You have unsaved changes on this page.\Leaving this page will lose ALL UNSAVED CHANGES.";
  			}
  			
		}

	$(document).ready(function()
	{

		bindRows();
		$("#btn-discard").css("display","none");	
		$("#btn-edit").click(function()
		{
			if($("#btn-edit").html()=="Edit")
			{
				$("#btn-edit").html("Save");	
				$("#btn-discard").css("display","inline");
				editmode=1;
				
		
				
		
			}
			else
			{
				$("#btn-edit").html("Edit");
				$("#btn-discard").css("display","none");
				editmode=0;	
				
	
				
			}
			
			
		});
		
	
		$("#btn-exe").click(function()
		{
			if(editmode==1)
			{
				
				if(!confirm("Executing this query will cause you to lose all unsaved changes"))
				{
					return false;
				}
			
			}
			idxcol="";
			idxtab="";
		
			$.post("/result/execute/<?=htmlentities($arg['schema'])?>",{query: $("#qry").val()},function(data,status)
			{
				idxcol=data.idxcol;
				idxtab=data.table;
				idxschem=data.schema;
				$("table#resulttable").remove();
				$(".resultset").html("<table id=\"resulttable\"></table>");
				
				
				if(data.result!==undefined)
				{
					
					if(data.result!==null) 
					{
						var headcontent = "<tr>";
						
						for (i in data.result)
						{
							first = i;
							
							break;
						}
						
						$.each(data.result[first], function(idx,col)
						{
							
							headcontent += "<th>"+idx+"</th>";
						});
						
						headcontent += "</tr>";
						$("table#resulttable").append(headcontent);
						
					
					
					
					
							
						$.each(data.result,function(rowk,row)
						{	
							//var rowcontents = "<tr>";
							$("table#resulttable").children().append("<tr class=\"jqrow\"></tr>");
							$.each(row, function(idx,col)
							{
							
								$("table#resulttable>tbody>tr:last").append("<td row=\""+rowk+"\" col=\""+idx+"\" class=\"editzone\"><pre></pre></td>");
								$("table#resulttable>tbody>tr:last>td:last>pre").html(col);
								//rowcontents += "<td col=\""+idx+"\ class=\"editzone\"><pre>hi"+col+"</pre></td>";
							});
							

						});
						bindRows();
					}
					else
					{
					
						var rowcontents = "<tr>";
						
					
						rowcontents += "<th>Query Returned No Resultset.</th><th>"+data.status+" rows affected</th>";
					
						
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
							case 0: etext="SQL State: "; break;
							case 1: etext="Error Code: "; break;
							case 2: etext="Info: "; break;
						}
						rowcontents += "<td>"+etext+"</td><td>"+row+"</td>";
						rowcontents += "</tr>";
		
					});
						
					
					
					$("table#resulttable").append(rowcontents);
					
					
				}
			},"json");
		});
	});
	var editing =0;
	var pinpoint = "";
	
	function bindRows()
	{
		$("td.editzone").unbind('click');
		
		
		$("td.editzone>pre").click(function(event)
		{
			
			if(editmode==1 && editing !=1)
			{
	
				var areaoid = $(this).parent();
				//$(this).parent().html("<textarea id=\"tmpeditstr\">"+$(this).html()+"</textarea>");
				pinpoint = "";
				$.post("/table/pinpoint/<?=htmlentities($arg['schema'])?>",{table:idxtab,indexer:idxcol,index:$(this).parent().attr("col"),request:$(this).parent().attr("row")},function(data)
				{
					pinpoint = data;
					if(data.indexOf("\n",0)>0)
					{
						areaoid.html("<textarea id=\"tmpeditstr\" class=\"superlong\" >"+data+"</textarea>");
						$("#tmpeditstr").css("height","200px");
					}
					else
					{
						areaoid.html("<textarea id=\"tmpeditstr\">"+data+"</textarea>");
					}
				});
				event.stopPropagation();
				$("td.editzone>pre").unbind("click");
				/*
				$("td.editzone>pre").not("#tmpeditstr").click(function(event)
				{
					
					if(event.target.id!="tmpeditstr")
					{
						$("td.editzone>pre").not("#tmpeditstr").unbind("click");
						releaseEdit();
					}
				});
				*/
				$("div").not("#tmpeditstr").click(function(event)
				{
					
					if(event.target.id!="tmpeditstr")
					{
						$("div").not("#tmpeditstr").unbind("click");
						releaseEdit();
					}
				});
				editing =1;
			}
		});
		
		
		

	}
	
	function releaseEdit()
	{
		editing =0;
		if($(this).attr("id")!="tmpeditstr")
		{
			text = $("#tmpeditstr").val();
			
			$("#tmpeditstr").parent().append("<pre></pre>");
		
			$("#tmpeditstr").parent().find("pre").text(text);
	
			if(text=pinpoint)
			{
		
				$("#tmpeditstr").parent().css("background-color","#DDFFDD");
				$("#tmpeditstr").parent().find("pre").attr("changed",1);
			}
			
			
			$("#tmpeditstr").remove();
			$("td.editzone>pre").not("#tmpeditstr").unbind("click");
			
			
			bindRows();
			
		}
	}
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
		
		<li id="btn-export">Export</li>
		<li id="btn-edit">Edit</li>
		<li id="btn-discard">Discard</li>
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
			
			
			foreach($row as $key=> $col)
			{
				echo "<td col=\"{$key}\" class=\"editzone\"><pre>".application::short(htmlentities($col))."</pre></td>";
			}
			echo "</tr>";
			
		}
	}
	else
	{
	
		echo "<tr><th>Query Returned No Resultset.</th></tr>";
		
	}
	echo "</table></div>";
