<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->title; ?> : MySQL Tools</title>
		<link rel="stylesheet" media="all" href="/static/css/style.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	</head>
	
	<body>
		
		
		
		<div id="header">
			<a href="/">MySQL Tools</a>
		</div>
		
		
		
		<div id="main">
			<div id="sidebar">
				sidebar
			</div>
			<div id="content">
			<?php 
				echo $this->content;
			?>
			</div>
		</div>
		
				
				
		<ul id="resultsetMenu" class="contextMenu">
		    <li class="edit">
		        <a href="#edit">Quick Edit</a>
		    </li>
		    <li class="fedit">
		        <a href="#fedit">Open Editor</a>
		    </li>
		    <li class="copy separator">
		        <a href="#copy">Copy Cell</a>
		    </li>
		    
		    <li class="copyr">
		        <a href="#copy">Copy Row</a>
		    </li>
		    
		    
		    <li class="paste separator">
		        <a href="#paste">Paste Cell</a>
		    </li>
		    
		    
		    <li class="paste">
		        <a href="#paste">Paste Row</a>
		    </li>
		    
		      <li class="deleterow separator">
		        <a href="#delete">Delete Row</a>
		    </li>
		</ul>

		<div class="modal">
			<div class="modalbg">
				
			</div>
			<div class="modalobj">
				
			</div>
		</div>
	</body>
</html>
