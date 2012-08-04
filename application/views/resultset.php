<link rel="stylesheet" href="/static/js/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/static/js/codemirror/theme/default.css">
<script src="/static/js/codemirror/lib/codemirror.js"></script>
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
		$(".resultset_table").html("");
		
		$.post("/query.json",{"query":query},function(data)
		{
			var rows = Array();
		
			var th = "<tr>";
			$.each(data.resultset[0],function(idx,col)
			{
				th += "<th>"+idx+"</th>"
			});
			th += "</tr>"
			
			rows.push (th)
			
			
			$.each(data.resultset,function(idx,row)
			{
				var rowtext = "<tr>"
				$.each(row, function(colname,column)
				{
					
					rowtext += "<td>" + escapeHTML(column) + "</td>";
				})
			    rowtext += '</tr>';
			    rows.push(rowtext);
			
			});
			
			$('<table id="results"></table>').append(rows.join('')).appendTo('.resultset_table');
	
		},"json");
	}
</script>