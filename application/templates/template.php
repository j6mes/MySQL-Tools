<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->title; ?> : MySQL Tools</title>
		<link rel="stylesheet" media="all" href="/static/css/style.css" type="text/css" />
		
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
		
		
		
	</body>
</html>
