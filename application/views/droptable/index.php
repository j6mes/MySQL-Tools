<h1>Drop Table</h1>
<p class="warning">
	Are you sure you want to drop this Table? <br /><br />ALL data and cascaded relationships associated with it will be permanently lost.</p>
<form id="frmdroptable" action="/table/drop/<?=$arg['schema']?>.<?=$arg['table']?>" method="post"><input type="submit" id="btndrop" value="Drop Table" /><input type="hidden" name="drop" value="1"><input type="button" id="btnclose" class="closebutton" value="Cancel"/></form>
<?

if($arg['ajax'])
{
	?>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#btndrop").click(function(e)
			{
				event.preventDefault();
				$.post("/table/drop/<?=$arg['schema']?>.<?=$arg['table']?>",{drop:"1",ajax:"1"},function(data)
        		{
        			$("#create").html (data);
        			
        		});
        		
			
        		

			});
			
				   $(".closebutton").click(function()
	        {
	           	$('#mask').fadeOut(200);
				$('.window').fadeOut(100);
	       	});
		});
	</script>
	<?
	die;
}
