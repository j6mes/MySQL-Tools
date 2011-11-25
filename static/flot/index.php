<?php
include("dbtools.php");
$_SESSION['delta']=0;
?>

<html>

<head><style>body{padding:0px;margin:0px;}</style> <script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'clean'
 };
 </script><script type="text/javascript" src="http://lolblog.net/jquery-1.4.2.js"></script><script type="text/javascript"  src="http://flx.im/md5.js"></script> 
 <script src="http://github.com/malsup/corner/raw/master/jquery.corner.js?v2.09"> 
		</script> 
		<script type="text/javascript"> 
			$(document).ready(function()
			{
	
				
			});
			
		
	 		
		
		</script> 
 <link rel="stylesheet"  href="style.css" /></head><title>SQLStat</title>
   <script language="javascript" type="text/javascript" src="jquery.flot.js"></script> 

  

  

 

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


 		
				setInterval(function()
				{
					$.get("qdelta.php",{},function(data)
					{
					
		
						FIFO.store(data.qps);
						$("#qc").html(data.qcount);
						 $('#plot').empty(); 
					
				
		plot=null;				
  plot = $.plot($("#placeholder"), [FIFO], {grid:{borderWidth:0},xaxis:{ticks: [] ,mode:0,label:0}});
						
						
						
					},"json");
				},1000);

 
 
  });
  </script> 
 <body>
 <div class="navbar_top">
	 <div class="width">
		 <div id="navbar_logo">
		SQL Status
		 </div>
		 
		 
		 
		 <div class="navbar_nav">
		 <ul>
			<li><a href="/index.php">Dashboard</a></li>
			<li><a href="/extra.php">Slow Query Log</a></li>

			
		 </ul>
		 </div>
	 </div>
 </div>

 <div class="allcontent">

 <div class="all width">
 <div id="navigation">

 </div>
 <div class="xpadding">
 <div class="forum_toolbox">
 Query Count: <span id="qc"></span>
 <div id="placeholder" style="width:920px;height:100px;"></div> 
 </div>
 

 
 
</div></div></div></body></html>