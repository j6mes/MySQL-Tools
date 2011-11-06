<h1>Table dropped OK</h1>

<?php

if($arg['ajax'])
{
	?>
	<input type="button" id="droppedclose" value="Close Window" />
	<script>
		$(document).ready(function()
		{
			
			$("#droppedclose").click(function()
			{
				$("#droppedclose").unbind("click");
				$('#mask').fadeOut(200);
				$('.window').fadeOut(100);
				$("#create").html("");     
				
				   
			});
			
		
		});
	</script>
	<?
	die;
}