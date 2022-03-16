<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
        <!-- 
			Cardiff University Taekwon-Do
        -->
		
		
<head>      

        <!-- Meta Tags -->
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
	
        <!-- CSS -->
        <link rel="stylesheet" href="../style/style-fancybox.css" type="text/css" media="screen" />
		
		<!-- Rich Text Box Editor -->
		<script type="text/javascript" src="../code/bbeditor/ed.js"></script>
		
		<!-- Calendar pop-up -->
		<link rel="stylesheet" type="text/css" href="../code/calendar/epoch_styles.css" />
		<script type="text/javascript" src="../code/calendar/epoch_classes.js"></script>
		<script type="text/javascript">
			var dp_cal;
			window.onload = function ()
			{
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('popup_container'));
			};
		</script>
		
		<?php include("../includes/db.php"); ?>
		
		<!-- WYSIWYG Text Editor -->
		<?php require_once("../code/bbeditor/nbbc.php");	?>	
</head>

<body>


<div id="pageContent">

	<h1>Upload Image or Video</h1>

	<form name="form" method="post"  enctype="multipart/form-data" action="savegallery.php">
		
		<h2>Upload Image</h2>
		<input type="file" name="photo" id="photo" />
		
		<h2>or</h2>
		
		<h2>Youtube Link</h2>
		<input type="url" name="video" id="video" />
		
		<br/><br/><br/>
		
		<h2>Date</h2>
		<input type="text" name="date" id="popup_container" readonly="true" />
		
		<h2>Caption</h2>
		<input type="text" name="caption" id="caption" />
		
		<input name="submit" type="submit" class="formButton" value="Submit"/>
		

	</form>
		

</div>

</body>

</html>