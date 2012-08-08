<link rel="stylesheet" href="/static/js/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/static/js/codemirror/theme/default.css">
<script src="/static/js/codemirror/lib/codemirror.js"></script>
<script src="/static/js/jquery.contextMenu.js"></script>
<script src="/static/js/codemirror/mode/sparql/sparql.js"></script>


<div class="resultset_textarea">
	<textarea id="qry"><?php echo $this->args['query']->Query; ?></textarea>
</div>
<div class="resultset_toolbar">
	<a href="#">Execute</a>
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

	$(document).ready(function()
	{
		if($("#qry").val().length)
		{
			qry($("#qry").val());
		}
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
		
		
		$.post("/query.json",{"query":query},function(data)
		{
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
			$.each(data.resultset,function(idx,row)
			{
				var rowtext = "<tr>"
				i++
				var j = 0;
				$.each(row, function(colname,column)
				{
					
					rowtext += "<td rowid=\""+i+"\" colid=\""+ (j++) +"\">" + escapeHTML(column) + "</td>";
				})
			    rowtext += '</tr>';
			    rows.push(rowtext);
			
			});
			
			$('<table id="results"></table>').append(rows.join('')).appendTo('.resultset_table');
			
			
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
			
				
			$("#results td").contextMenu({menu: 'resultsetMenu'},function(action,el,pos)
			{
				alert($(el).html());
			});
			
			
			
			
			$("#results td").bind('mousedown',function(el)
			{
				
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

