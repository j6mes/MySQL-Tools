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
	res
</div>


<script>
	var editor = CodeMirror.fromTextArea(document.getElementById("qry"), {
  	mode: "application/x-sparql-query",
  	lineNumbers: true
});
</script>