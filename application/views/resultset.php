<link rel="stylesheet" href="/static/js/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/static/js/codemirror/theme/default.css">
<script src="/static/js/codemirror/lib/codemirror.js"></script>
<script src="/static/js/jquery.contextMenu.js"></script>
<script src="/static/js/json.js"></script>
<script src="/static/js/codemirror/mode/sparql/sparql.js"></script>


<div class="resultset_textarea">
	<textarea id="qry"><?php echo $this->args['query']->Query; ?></textarea>
</div>
<div class="resultset_toolbar">
	<a href="#" id="exec">Execute</a> | <a href="#" id="commit">Commit Changes</a> | <a href="#" class="restore">Restore Changes</a>
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
var table;
var activel = "";

function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}

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
		if(activel != "")
		{
			cpxcontent = activel.find("textarea").val();
			activel.html(escapeHTML(cpxcontent));
			activel.attr("contents",cpxcontent);
			activel ="";
			
		}
				
				
		var contents = $(el).attr("contents");
		$(el).unbind("mouseup");
		$(el).unbind("click");
		$(el).unbind("mousedown");
		
		$(el).addClass("edited");
		$(el).attr("original",$(el).attr("contents"));
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
	
	function str_replace (subject, search, replace, count) {
    // Replaces all occurrences of search in haystack with replace  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/str_replace
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Gabriel Paderni
    // +   improved by: Philip Peterson
    // +   improved by: Simon Willison (http://simonwillison.net)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   bugfixed by: Anton Ongson
    // +      input by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    tweaked by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   input by: Oleg Eremeev
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Oleg Eremeev
    // %          note 1: The count parameter must be passed as a string in order
    // %          note 1:  to find a global variable in which the result will be given
    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
    // *     returns 1: 'Kevin.van.Zonneveld'
    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
    // *     returns 2: 'hemmo, mars'
    var i = 0,
        j = 0,
        temp = '',
        repl = '',
        sl = 0,
        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',
        sa = Object.prototype.toString.call(s) === '[object Array]';
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    }
 
    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + '';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {
                this.window[count] += (temp.length - s[i].length) / f[j].length;
            }
        }
    }
    return sa ? s : s[0];
}

	
	function addrowbind()
	{
		
		if(activel != "")
		{
			cpxcontent = activel.find("textarea").val();
			activel.html(escapeHTML(cpxcontent));
			activel.attr("contents",cpxcontent);
			activel ="";
			
		}
				
				
		var row = "<tr class=\"new\">";
		
		for(i=0;i<parseInt($(this).attr("colspan"));++i)
		{
			row += "<td colid='"+i+"'></td>";
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
			
			
			$.post("/query/explain.json",{"query":query},function(data)
			{
				if(data.readonly!="readonly")
				{
					/*
					 * TODO enable/disable edits
					 * 
					 */
					
					
					$.post("/query/describeFirstTable.json",{"query":query},function(data)
					{
						table = data.table;
						$.each(data.resultset,function(idx,mrt)
						{
							
							$("#results th").each(function(idx,col)
							{
								
								if($(col).html()==mrt.Field)
								{
									$(col).attr("field",mrt.Field);
									$(col).attr("type",mrt.Type);
									$(col).attr("key",mrt.Key);
									$(col).attr("colid",idx);
								}
							});
							
						});
						
					},"json");
				}
				 
			},"json");
			
			
			
								
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
					$(el).attr("original",$(el).attr("contents"));
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
			
			
			$("#commit").bind('click',function()
			{
				if(activel != "")
				{
					cpxcontent = activel.find("textarea").val();
					activel.html(escapeHTML(cpxcontent));
					activel.attr("contents",cpxcontent);
					activel ="";
					
				}
				
				var data = new Object();
		
				$(".edited:not(tr.new .edited)").each(function(idx,obj)
				{
					var id= $(obj).parent().find($("td[colid=" + ($("#results th[key=PRI]").attr("colid")) + "]")).attr("contents");
					var field = $("#results th[colid="+$(obj).attr("colid")+"]").attr("field") ;
					if(data[id] instanceof Object)
					{
						
					}
					else 
					{
						data[id]= new Object();
					}
					data[id][field] = $(obj).attr("contents");
					
					
					
					
				});
				
				var rows = new Object();
				
				
			
				$.post("/table/update/"+str_replace(table,"`",""),{index:$("#results th[key=PRI]").attr("field"),load:JSON.stringify(data)},function(data)
				{
					$(".edited:not(tr.new .edited)").each(function(idx,obj)
					{
						$(obj).removeClass("edited");
					});
					alert(data)
				});
				
				
				data = new Object();
				var id =0;
				$("tr.new").each(function(idx,obja)
				{
					
					$(obja).find(".edited").each(function(idx,obj)
					{
						
						var field = $("#results th[colid="+$(obj).attr("colid")+"]").attr("field") ;
						if(data[id] instanceof Object)
						{
							
						}
						else 
						{
							data[id]= new Object();
						}
						data[id][field] = $(obj).attr("contents");
						
						
						
						
					});
					
					id++;
					
				});
				
				$.post("/table/insert/"+str_replace(table,"`",""),{index:$("#results th[key=PRI]").attr("field"),load:JSON.stringify(data)},function(data)
				{
					$(".edited").each(function(idx,obj)
					{
						$(obj).removeClass("edited");
					});
					alert(data)
				});
				
				
				data = new Object();
				var id =0;
				$("tr.todelete").each(function(idx,obj)
				{

					var id= $(obj).find($("td[colid=" + ($("#results th[key=PRI]").attr("colid")) + "]")).attr("contents");
					
					var field = $("#results th[key=PRI]").attr("field") ;
					
				
					if(data[field] instanceof Array)
					{
						
					}
					else 
					{
						data[field]= new Array();
					}
					data[field].push(id);
					
					
						
					
					
					id++;
					
				});
			
					
				
				$.post("/table/droprow/"+str_replace(table,"`",""),{index:$("#results th[key=PRI]").attr("field"),load:JSON.stringify(data)},function(data)
				{
					$(".todelete").each(function(idx,obj)
					{
						$(".todelete").remove();
		
					});
					
					
				});
			
					
				
			});
			
			$(".restore").bind("click",function()
			{
				$("tr.new").remove();
				$(".edited").each(function(idx,obj)
				{
					$(obj).removeClass("edited");
					$(obj).attr("contents",$(obj).attr("original"));
					$(obj).html($(obj).attr("original"));
				});
			});
		
	
		},"json");
	}
	

</script>

