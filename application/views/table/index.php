<div class="edit_table">
	<script type="text/javascript" src="/static/jquery.editable.js"></script>
	<script>

		
		
		
		$(document).ready(function()
		{
			init();
			
			$("#t_name").blur(function()
			{
				if($("#t_name").val())
				{
					
				}
			});
			
			$(".edit_add").click(function()
			{
				$(".edit_cols").append('<div class="edit_col"><div class="edit_col_field edit_pk"></div><div class="edit_col_field edit_text"></div><div class="edit_col_field edit_text"></div><div class="edit_col_field edit_check"></div><div class="edit_col_field edit_text"></div><div class="edit_col_field edit_text"></div></div>');	
		
		
				init();
			});
		});
		
		function init()
		{
			$(".edit_col>.edit_check").unbind('click');
			$(".edit_col>.edit_pk").unbind('click');
			$(".edit_col>.edit_text").unbind('click');
			
			$(".edit_col>.edit_text").editable(function(value,settings)
			{
				 if(this.revert == value)
				 {
				    this.reset()
				    
				}
  				else
  				{
  					$(this).html(value)
  				}
	
			});
			
			
			$(".edit_col>.edit_check").click(function()
			{

				if($(this).html()=="NO")
				{
					
					$(this).html("YES");
				}
				else if($(this).html()=="YES")
				{
					$(this).html("NO");
				}
			});
			
			$(".edit_col>.edit_pk").click(function()
			{

				if($(this).html()=="")
				{
					
					$(this).html("<img src=\"/static/famfamfam/key.png\" />");
				}
				else if($(this).html()=="<img src=\"/static/famfamfam/key.png\" />")
				{
					$(this).html("");
				}
			});
		}
		
		
	</script>
<?
if (strlen(@$arg['table']))
{
	echo "<h1>Edit Table: {$arg['table']}</h1>";
}
else
{
	echo "<h1>Create New Table</h1>";
}
?>
<div class="edit_top">Table Name: <input type="text" id="t_name" name="t_name" value="<?=@$arg['table']?>" />
	Database: <select><option><?=$arg['schema']?></option></select> Comment: <input type="text" name="t_comment" value="<?=@$arg['info']['TABLE_COMMENT']?>"/></div>

<div class="edit_cols">
	
	<div class="edit_col_head">
		<div class="edit_col_field">
			
			Key
		</div>
		<div class="edit_col_field">
			Column Name
		</div>
		<div class="edit_col_field">
			Type
		</div>
		<div class="edit_col_field">
			Length
		</div>
		<div class="edit_col_field">
			Nulls
		</div>
		<div class="edit_col_field">
			Extra
		</div>
		<div class="edit_col_field">
			Default Value
		</div>
		
		
	</div>	
		
		
		
		
	<?php 
	
	if(@sizeof($arg['columns'])):
	foreach($arg['columns'] as $idx=>$column):

	if($column['Key']=="PRI")
	{
		$pribit = "<img src=\"/static/icons/pri.png\">";
	}
	else
	{
		$pribit = "<img src=\"/static/icons/notpri.png\">";
	}
	

	
	if(is_int(strpos($column['Type'],"unsigned")))
	{
		$column['Unsigned']=true;
	}
	
	if(is_int(strpos($column['Extra'],"zerofill")))
	{
		$column['Zerofill']=true;
	}
	
	if(is_int(strpos($column['Extra'],"auto_increment")))
	{
		$column['Auto']=true;
	}
		@list($type,$null) = explode("(",$column['Type']);

	
	if(strlen($null))
	{
	
		list($length,$null) = explode(")",$null);
			
	}
	
	$types=application::getDataTypes();
	 

	$extrabit="";
	if(in_array("unsigned",$types[strtoupper($type)]))
	{
		
		if(isset($column['Unsigned']))
		{
			@$extrabit.= "<div title=\"Unsigned Number\" class=\"col_unsigned col_is_unsigned\"></div>";
		}
		else
		{
			@$extrabit.= "<div title=\"Signed Number\" class=\"col_unsigned col_not_unsigned\"></div>";
		}
	}
	
	if(in_array("zerofill",$types[strtoupper($type)]))
	{
		
		if(isset($column['Zerofill']))
		{
			@$extrabit.= "<div title=\"Zerofill\" class=\"col_zf col_is_zf\"></div>";
		}
		else
		{
			@$extrabit.= "<div title=\"Don't Zerofill\" class=\"col_zf col_not_zf\"></div>";
		}
	}
	
	
	if(in_array("auto_increment",$types[strtoupper($type)]))
	{
		
		if(isset($column['Auto']))
		{
			@$extrabit.= "<div title=\"Auto Increment\" class=\"col_auto col_is_auto\"></div>";
		}
		else
		{
			@$extrabit.= "<div title=\"Don't Increment\" class=\"col_auto col_not_auto\"></div>";
		}
	}
	
	$nullbit = "";
	if($column['Null']=="YES")
	{
		$nullbit = "<div title=\"Allow Null\"  class=\"col_null col_is_notnull\"></div>";
	}
	else 
	{
		$nullbit = "<div title=\"Not Null\"  class=\"col_null col_not_notnull\"></div>";
	}
	
	?>
		
	<div class="edit_col">
		<div class="edit_col_field edit_pk"><?=$pribit?></div>
		<div class="edit_col_field edit_text"><?=$column['Field']?></div>
		<div class="edit_col_field edit_type"><?=$type?></div>
		<div class="edit_col_field edit_length"><?=$length?></div>
		<div class="edit_col_field edit_check"><?=$nullbit?></div>
		<div class="edit_col_field edit_text"><?=$extrabit?></div>
		<div class="edit_col_field edit_text"><?=$column['Default']?></div>
		
		
		
	</div>	
		
		
	<?php 	
		
			endforeach;
			endif; ?>

		
		
</div>


		<div class="edit_add"><em>Add Column</em></div>
	
</div>

<?php
if(isset($arg['ajax']))
{
	die;
}
