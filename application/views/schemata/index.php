 <script language="javascript" type="text/javascript" src="/static/flot/jquery.flot.js"></script> 
  <style type="text/css" media="screen"> 
    .jqplot-axis {
      font-size: 0.85em;
    }
    .jqplot-title {
      font-size: 1.1em;
    }
  </style> 
  <script type="text/javascript" language="javascript"> 
  
  $(document).ready(function(){
  var i= 0;
  Array.prototype.store = function (info) {
  if(this.length>100)
  {
	this.shift();
  }
  

  
  this.push([i++,info]);
}
Array.prototype.fetch = function() {
  if (this.length <= 0) { return ''; }  // nothing in array
  return this.shift(); 
}
Array.prototype.display = function() {
  return this.join('<br />');
}


 
function StoreEntry() {

	FIFO.store([i++,sel.value]);

}
function FetchEntry() {
	document.getElementById('entry').value = FIFO.fetch();
}



  
	
    var FIFO = new Array();

for (i=0;i<100;++i)
{FIFO.store(0);
}
 		
				setInterval(function()
				{
					$.get("/status",{},function(data)
					{
					
		
						FIFO.store(data.delta);
						$("#qc").html(data.questions);
						 $('#plot').empty(); 
					
				
		plot=null;				
  plot = $.plot($("#plot"), [FIFO], {grid:{borderWidth:0},xaxis:{ticks: [] ,mode:0,label:0}});
						
						
						
					},"json");
				},1000);

 
 
  });
  </script> 

<div class="modifier">
<div style="float:right; padding-top:0px;">
	MySQL Uptime: 3 days<br />Query Count: 30
</div>
<h2>MySQL Tools</h2>

<div class="statcontainer">
	<div class="statbox">
		Query Hitrate
		<div id="plot" style="height:80px">
			
		</div>
		
	</div>
</div>
<div class="schemata_drum">
	<div class="schemata_schemalist">
		<h3>Schema</h3>
<?php

if(isset($arg['schemata']))
{
	
	$schemata =$arg['schemata'];
	
	if(sizeof($schemata))
	{
		echo "<ul>";
		
		
		foreach($schemata as $schema)
		{
			$schema['size']=number_format(intval($schema['size'])/1024/1024,2);
			echo "<li class=\"schema-li\"><a href=\"/schema/view/{$schema['name']}\">{$schema['name']}</a><span class=\"li-schema-tablebit\">{$schema['count']} Tables</span>{$schema['size']}MB</li>";
		}
		echo "</ul>";
	}
	
}
?>
</div>
</div>
</div>