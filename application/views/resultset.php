<link rel="stylesheet" href="/static/js/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/static/js/codemirror/theme/default.css">
<script src="/static/js/codemirror/lib/codemirror.js"></script>
<script src="/static/js/jquery.contextMenu.js"></script>
<script src="/static/js/codemirror/mode/sparql/sparql.js"></script>


<div class="resultset_textarea">
	<textarea id="qry"><?php echo $this->args['query']->Query; ?></textarea>
</div>
<div class="resultset_toolbar">
	<a href="#" id="exec">Execute</a>
</div>
<div class="resultset_table">
	Loading Results
</div>


<script>
	var editor = CodeMirror.fromTextArea(document.getElementById("qry"), {
  	mode: "application/x-sparql-query",
  	lineNumbers: true
});
</script>

<script>
var activel = "";


jQuery.fn.selText = function() {
    var obj = this[0];
    if ($.browser.msie) {
        var range = obj.offsetParent.createTextRange();
        range.moveToElementText(obj);
        range.select();
    } else if ($.browser.mozilla || $.browser.opera) {
        var selection = obj.ownerDocument.defaultView.getSelection();
        var range = obj.ownerDocument.createRange();
        range.selectNodeContents(obj);
        selection.removeAllRanges();
        selection.addRange(range);
    } else if ($.browser.safari) {
        var selection = obj.ownerDocument.defaultView.getSelection();
        selection.setBaseAndExtent(obj, 0, obj, 1);
    }
    return this;
}

	function doedit(el)
	{
		var contents = $(el).attr("contents");
		$(el).unbind("mouseup");
		$(el).unbind("click");
		$(el).unbind("mousedown");
		
		$(el).addClass("edited");
		
		activel = $(el);
		hz= $(el).css("height");
		wz= $(el).css("width");
		
	
		$(el).html("");
		$(el).append("<textarea id=\"tbe\"></textarea>");
		
		
		$(el).find("textarea").val(contents);
		
		
		
		$(el).css("width",wz);
		$("#tbe").css("height",hz);
		$("#tbe").css("width",wz);
	}
	
	function addrowbind()
	{
		
		var row = "<tr class=\"new\">";
		
		for(i=0;i<parseInt($(this).attr("colspan"));++i)
		{
			row += "<td></td>";
		}
		
		row += "</tr><tr>"+$(this).parent().html()+"</tr>";
		
		
		$(this).parent().parent().append(row);
		
		$(this).parent().remove();
		
		$(".addrow").bind("click",addrowbind);
		
		
		$("tr.new>td").bind("click",function()
		{
			doedit(this);
		});
	}
	
	
	$(document).ready(function()
	{
		if($("#qry").val().length)
		{
			qry($("#qry").val());
			
			
			
		}
		
		$("#exec").click(function()
		{
			alert(" qry "+ $("#qry").val())
			qry(editor.getValue());
		});
	});
	
	function escapeHTML (str)
	{
	   	var div = document.createElement('div');
	   	var text = document.createTextNode(str);
	   	div.appendChild(text);
	   	return div.innerHTML;
	}
	

	function qry(query)
	{
		$("#results td").unbind("dblclick");
		$("#results td").unbind("mouseover");
		$("#results td").unbind("mousedown");
		$("body").unbind("mouseup");
		$("body").unbind("click");
		
		$.post("/query.json",{"query":query},function(data)
		{
			$.post("/query/explain.json",{"query":query},function(data)
			{
				if(data.readonly!="readonly")
				{
					
					$.post("/query/describeFirstTable.json",{"query":query},function(data)
					{
						$.each(data.resultset,function(idx,mrt)
						{
							if(mrt.Key == "PRI")
							{
								
							}
						});
						
					},"json");
				}
				 
			},"json");
			
			
			$(".resultset_table").html("");
			var rows = Array();
		
			var th = "<tr>";
			$.each(data.resultset[0],function(idx,col)
			{
				th += "<th>"+idx+"</th>"
			});
			th += "</tr>"
			
			rows.push (th)
			
			var i = 0;
			var j = 0;
			$.each(data.resultset,function(idx,row)
			{
				var rowtext = "<tr>"
				i++
				j=0;
				$.each(row, function(colname,column)
				{
					
					rowtext += "<td rowid=\""+i+"\" colid=\""+ (j++) +"\">" + column + "</td>";
					
				})
				
				rowtext += '</tr>';
			    rows.push(rowtext);
			
			});
			
			var tf = "<tr>"
		
			tf += "<td class=\"addrow\" colspan=\""+j+"\">Add Row</td>"
				
			tf += "</tr>"
			
			rows.push (tf)
			
			
			$('<table id="results"></table>').append(rows.join('')).appendTo('.resultset_table');
			
			$("#results td").each(function(idx, obj)
			{
				$(obj).attr("contents",$(obj).html());
				$(obj).html(escapeHTML($(obj).html()));
			});
								
			$("#results td").contextMenu({menu: 'resultsetMenu'},function(action,el,pos)
			{
				var contents = $(el).attr("contents");
				if(action=="edit")
				{
					
					doedit(el);
					
				
				}
				else if(action=="fedit")
				{
					$(".modal").show("slow");
					$(".modalobj").html("<h1>Edit Cell Value</h1>");
					$(".modalobj").append("<textarea></textarea><br />");
					$(".modalobj").append("<button action='save'>Save</button>");
					$(".modalobj").append("<button action='cancel'>Cancel</button>");
					$(".modalobj textarea").val(contents);
			
					$("button[action=save]").click(function()
					{
						$(".modal").hide("slow");
						$(el).attr("contents",$(".modalobj textarea").val());
						$(el).html(escapeHTML($(".modalobj textarea").val()));
						
					});
				}
				else if(action=="delete")
				{
					
					$(el).parent().addClass("todelete");
					$(el).parent().find("td").addClass("deleted")
				}
			});
			
			
			if( $.browser.mozilla ) {
				$('#results td' ).each( function() { $(this).css({ 'MozUserSelect' : 'none' }); });
			} else if( $.browser.msie ) {
				$('#results td').each( function() { $(this).bind('selectstart.disableTextSelect', function() { return false; }); });
			} else {
				$('#results td').each(function() { $(this).bind('mousedown.disableTextSelect', function() { return false; }); });
			}
		
			var active = 0;
			
			var startrow = 0;
			var startcol = 0;
			

			
			$("#results td").bind("dblclick",function()
			{
				
			})
			
			$("#results td").bind('mousedown',function(el)
			{
				if(activel != "")
				{
					cpxcontent = activel.find("textarea").val();
					activel.html(escapeHTML(cpxcontent));
					activel.attr("contents",cpxcontent);
					activel ="";
					
				}
				
				
				if(el.which==1)
				{
					$("#results td").removeClass("selrow");
					$(this).addClass("selrow")
					startrow = parseInt($(this).attr('rowid'));
					startcol = parseInt($(this).attr('colid'));
					
					active =1;
					
					
				}
				else if(el.which)
				{
					//check if in range
					
					//if not, then sel single
				}
			
			});
			
			$("body").bind('mouseup',function(el)
			{
				
				active =0;
				
			});
			
			$("body").bind('click',function(el)
			{
				active =0;
				
			});
			
			$(".addrow").bind('click',addrowbind);
			
			
			$("#results td").bind('mouseover',function(el)
			{
				if(active)
				{
					$("#results td").removeClass("selrow");
					
					
					xoffs = parseInt($(this).attr('colid'))-startcol;
					yoffs = parseInt($(this).attr('rowid'))-startrow;
					
				
					if((xoffs>=0)&&(yoffs>=0))
					{
						for(x = startcol;x<=parseInt($(this).attr('colid'));x++)
						{
		
							for(y = startrow;y<=parseInt($(this).attr('rowid'));y++)
							{
								$("tr:nth-child("+(y+1)+ ") > td:nth-child("+(x+1)+")").addClass("selrow");
							}
							
						}
					}	
					else if((xoffs>=0)&&(yoffs<=0))
					{
						for(x = startcol;x<=parseInt($(this).attr('colid'));x++)
						{
		
							for(y = startrow;y>=parseInt($(this).attr('rowid'));y--)
							{
								$("tr:nth-child("+(y+1)+ ") > td:nth-child("+(x+1)+")").addClass("selrow");
							}
							
							
						}
					}
					else if((xoffs<=0)&&(yoffs>=0))
					{
						for(x = startcol;x>=parseInt($(this).attr('colid'));x--)
						{
		
							for(y = startrow;y<=parseInt($(this).attr('rowid'));y++)
							{
								$("tr:nth-child("+(y+1)+ ") > td:nth-child("+(x+1)+")").addClass("selrow");
							}
							
						}
					}
					else if((xoffs<=0)||(yoffs<=0))
					{
						for(x = startcol;x>=parseInt($(this).attr('colid'));x--)
						{
		
							for(y = startrow;y>=parseInt($(this).attr('rowid'));y--)
							{
								$("tr:nth-child("+(y+1)+ ") > td:nth-child("+(x+1)+")").addClass("selrow");
							}
							
						}
					}
					else
					{
						$(this).addClass("selrow")
					}													
				}
				
			});
			
			

			
		
	
		},"json");
	}
	

</script>

