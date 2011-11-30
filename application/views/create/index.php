<h1>Create Schema</h1>
<br />Schema Name: <br /><input type="text" name="schemaname" id="schemaname" ><br /><br />
<input type="submit" id="btncreate" value="Create Schema"> <input type="button" class="cancel" value="Cancel">


<?
if($arg['ajax'])
{
	?>
		<script type="text/javascript">
		$(document).ready(function()
		{
			$("#btncreate").click(function(e)
			{
				e.preventDefault();
				$.post("/schema/ajax_create/",{create:"1",ajax:"1",name:$("#schemaname").val()},function(data)
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
