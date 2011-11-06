<?
	if($name=="login")
	{
		?>
			<!DOCTYPE HTML>
			<html>
				<head>
					<title>Log In</title>
					
					<link rel="stylesheet" href="/static/style.css" type="text/css" />
				</head>
				<body>
					<?=$pc?>
				</body>
			</html>

		<?
		die;
		
		
		
		
	}
	
	$arg['title']="wahaa";
	if(sizeof($schemata))
	{
		$dblist = "<ul>";
		

		
		foreach($schemata as $schema)
		{
			if($schema['name']==$GLOBALS['schema'])
			{	
				$schema['children'] .= "<div id=\"div-{$GLOBALS['schema']}\"><ul class=\"tables\" id=\"child-{$GLOBALS['schema']}\">";
				foreach($childtables as $table=>$tabledata)
				{
					$schema['children'] .= "<li class=\"jQtable table\"><a id=\"xtable-{$GLOBALS['schema']}.{$table['TABLE_NAME']}\" href=\"/table/view/{$GLOBALS['schema']}.{$table}\">{$table}</li>";
				}
				$schema['children'] .= "</ul>";
			}
			$dblist .= "<li id=\"li-{$schema['name']}\" class=\"jQschema schema\"><a id=\"schema-{$schema['name']}\" href=\"#/schema/view/{$schema['name']}\">{$schema['name']}</a>{$schema['children']}</li>";
		}
		$dblist .= "</ul>";
	}
			

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title><?=$arg['title'] ?> <? strlen($arg['title']) ? $out = " - " : $out = ""; ?><?=$out ?> MySQL Tools</title>
		<link rel="stylesheet" href="/static/style.css" type="text/css" />
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js">
	</script>
	
	<script type="text/javascript" src="/static/jquery.contextMenu.js">
	</script>
	
	
	<script type="text/javascript">
		var oRoot = "<?=$_SERVER['REQUEST_URI']?>";
		
		$(document).ready(function()
		{
			
			setInterval(function()
			{
				$.post("/keepalive",{},function(data)
				{
					if(data=="0")
					{
						window.location = "/";
					}
				});
				
			},60*1000);
			
			$("#filteridf").focus(function()
			{
				
				if($("#filteridf").css("color")=="rgb(204, 204, 204)" )
				{
					$("#filteridf").val("");
					$("#filteridf").css("color","rgb(0, 0, 0)");
				}
			});
			
			$("#filteridf").blur(function()
			{
				
				if($("#filteridf").val()=="" )
				{
					$("#filteridf").val("filter");
					$("#filteridf").css("color","rgb(204, 204, 204)");
				}
			});
			
			$("#filteridf").keyup(function()
			{
				$.post("/",{},function(result)
				{
					
				});
			});
			
			
			
			
			$("li.jQschema>a").click(function(e)
			{
				var schema = $(this).attr('id').substr(7);
				
				
				if($("#div-"+schema).length)
				{
					$("#div-"+schema).remove();
				}
				else
				{
					$("#li-"+schema).append("<div id=\"div-"+schema+"\">Loading</div>");
					tables = getTables(schema);
				}	
				
				
			});
			
			 $("li.jQschema>a").contextMenu({
			menu: 'menuSchema'
			},
			    function(action, el, pos) {
						act(action,$(el).attr('id'));
			        
			});




			  //select all the a tag with name equal to modal
	    $('a[name=modal]').click(function(e) {
	        //Cancel the link behavior
	        e.preventDefault();
	        //Get the A tag
	        var id = $(this).attr('href');
	     
	        //Get the screen height and width
	        var maskHeight = $(document).height();
	        var maskWidth = $(window).width();
	     
	        //Set height and width to mask to fill up the whole screen
	        $('#mask').css({'width':maskWidth,'height':maskHeight});
	         
	        //transition effect     
	        $('#mask').fadeIn(1000);    
	        $('#mask').fadeTo("slow",0.8);  
	     
	        //Get the window height and width
	        var winH = $(window).height();
	        var winW = $(window).width();
	               
	        //Set the popup window to center
	        $(id).css('top',  winH/2-$(id).height()/2);
	        $(id).css('left', winW/2-$(id).width()/2);
	     
	        //transition effect
	        $(id).fadeIn(2000); 
	     
	    });
     
     	$('.close').click(function () {
    	//if close button is clicked
        //Cancel the link behavior
	       e.preventDefault();
	       
	       $('#mask, .window').hide();
	  	  });     
     
    	//if mask is clicked
	    $('#mask').click(function () {
	        $(this).hide();
	        $('.window').hide();
	    	});  
			
		});
		
			
		
		function act(action,el)
		{

	       	var loc = el.substr(7);
	       	
	       	if(action=="droptable")
			{
				modal("#create","/table/ajax_drop/"+loc);
			}
			
			if(action=="dropschema")
			{
				modal("#create","/schema/ajax_drop/"+loc);
			}
			
			
			
	      
	       	if(action=="edittable")
			{
				modal("#table","/table/ajax_edit/"+loc);
			}
			
			
			if(action=="table")
			{
				loc = loc.split(".",1);
		
				modal("#table","/table/ajax_edit/"+loc[0]);
			}
			
			if(action=="schema")
			{
				loc = loc.split(".",1);
				modal("#create","/schema/ajax_create/");
			}
			
		}
		
		function modal(id,source)
		{
			 //transition effect     
	        $('#mask').fadeIn(1000);    
        	$('#mask').fadeTo("slow",0.8);  
	        //Get the window height and width
	        var winH = $(window).height();
	        var winW = $(window).width();
	               
	        //Set the popup window to center
	        $(id).css('top',  winH/2-$(id).height()/2);
	        $(id).css('left', winW/2-$(id).width()/2);
	     
	        //transition effect
	        $(id).fadeIn(2000); 
	        $(id).html("Loading...");
	        $.get(source,{},function(data){
	        	$(id).html(data);
	        });
	        
	        $(".closebutton").unbind("click");
	        $(".closebutton").click(function()
	        {
	        	alert("hey");
	        	$('#mask').fadeOut(200);
				$('.window').fadeOut(100);
	       	});
	       	
		}

		function getTables(schema)
		{
			
			$.post("/schema/menu/"+schema,{},function(data)
			{

				if(data.message)
				{
					$("#div-"+schema).remove();
					$("#li-"+schema).append("<div id=\"div-"+schema+"\"><ul class=\"tables\" id=\"child-"+schema+"\">");
					$("#child-"+schema).append("<li class=\"jQtable message\"><a href=\"return:void(0)\">"+data.message+"</a></li>");
					
					
					$("li.jQtable>a").contextMenu({
					menu: 'menuTable'
					},
					    function(action, el, pos) {
					    	//TODO make a menu for this
					    		if($(el).attr('id').length())
					    		{
									act(action,$(el).attr('id'));
					       }
					});
					
					$(this).append("</ul></div>");
				}
				else
				{
					var xTables= Array();
					$.each(data.tables,function(idx,info)
					{
				
						xTables.push(idx);
					});
					addTables(schema, xTables);
				}

			},"json");
	
			
		}
		
		function addTables(schema, tables)
		{
			if(tables.length)
			{ 
				$("#div-"+schema).remove();
				$("#li-"+schema).append("<div id=\"div-"+schema+"\"><ul class=\"tables\" id=\"child-"+schema+"\">");
				$.each(tables,function(idx,table)
				{
					
					$("#child-"+schema).append("<li class=\"jQtable table\"><a id=\"xtable-"+schema+"."+table+"\" href=\"/table/view/"+schema+"."+table+"\">"+table+"</a></li>");
				});
				
				 $("li.jQtable>a").contextMenu({
			menu: 'menuTable'
			},
			    function(action, el, pos) {
			    
						act(action,$(el).attr('id'));
					
			       
			});

				$(this).append("</ul></div>");
			}
		}
	</script>
	</head>
<body>
	
<div id="boxes">
 
     
    <!-- #customize your modal window here -->
 
    <div id="dialog" class="window">
        <b>Testing of Modal Window</b> | 
         
        <!-- close button is defined as close class -->
        <a href="#" class="close">Close it</a>
 
    </div>
    
    <div id="table" class="window">
       Loading....
 
    </div>
 
    <div id="create" class="window">
       Loading....
 
    </div>
 
 
     
    <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
    <div id="mask"></div>
</div>

<ul id="menuSchema" class="contextMenu">
    <li class="edit">
        <a href="#dropschema">Drop Schema</a>
    </li>
     <li class="edit">
        <a href="#create">Show CREATE Statement</a>
    </li>
    <li class="cut separator">
        <a href="#schema">Create Schema</a>
    </li>
    <li class="copy">
        <a href="#table">Create Table</a>
    </li>
    <li class="paste">
        <a href="#view">Create View</a>
    </li>
    <li class="delete">
        <a href="#procedure">Create Procedure</a>
    </li>
    <li class="quit separator">
        <a href="#refresh">Refresh</a>
    </li>
</ul>


<ul id="menuTable" class="contextMenu">
	 <li class="edit">
        <a href="#edittable">Edit Table</a>
    </li>
    <li class="edit">
        <a href="#droptable">Drop Table</a>
    </li>
     <li class="edit">
        <a href="#create">Show CREATE Statement</a>
    </li>
    <li class="cut separator">
        <a href="#schema">Create Schema</a>
    </li>
    <li class="copy">
        <a href="#table">Create Table</a>
    </li>
    <li class="paste">
        <a href="#view">Create View</a>
    </li>
    <li class="delete">
        <a href="#procedure">Create Procedure</a>
    </li>
    <li class="quit separator">
        <a href="#refresh">Refresh</a>
    </li>
</ul>




	<div class="topmost">
		<div id="ident">
			<a href="http://mysqltools.org">Powered by MySQL Tools</a>
		</div>
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/search">Search</a></li>
			<li><a href="/backup">Backups</a></li>
			<li><a href="/logout">Log Out</a></li>
		
		</ul>
		
	</div>
	
	<? 
	
	if (isset($arg['toolbar']))
	{
	
		echo $arg['toolbar'];
		echo "<div class=\"pushdown\">";
	}
	else
	{
		echo "<div class=\"nopushdown\">";
	}?>
	
		<div class="sideleft"><div class="ldb_schemata">
			<input type="text" value="filter" id="filteridf"><?=$dblist?></div></div>
		<div class="sideright"><?=$pc?></div>
	
	</div>
	</body>
</html>