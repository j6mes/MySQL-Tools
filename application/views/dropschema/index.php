<h1>Drop Schema</h1>
<p class="warning">
	Are you sure you want to drop this Schema? <br /><br />ALL tables, data, views and functions associated with it will be permanently lost.
</p>
<form id="frmdropschema" action="/schema/drop/<?=$arg['schema']?>" method="post"><input name="drop" id="btndrop" type="submit" value="Drop Schema" /><input class="closebutton" type="button" value="Cancel"/></form>
<?


if($arg['ajax'])
{
	?>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#btndrop").click(function(e)
			{
				e.preventDefault();
				$.post("/schema/drop/<?=$arg['schema']?>",{drop:"1",ajax:"1"},function(data)
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
