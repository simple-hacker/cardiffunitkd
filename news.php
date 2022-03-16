<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
        <!-- 
			Cardiff University Taekwon-Do
        -->
		
		
<head>      

        <!-- Meta Tags -->
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
	
        <!-- CSS -->
        <link rel="stylesheet" href="./style/style-fancybox.css" type="text/css" media="screen" />
		
		<?php include("includes/db.php"); ?>
		
		<!-- WYSIWYG Text Editor -->
		<?php require_once("code/bbeditor/nbbc.php");	?>
</head>

<body>

	<div id="pageContent">
			
<?php
		if ($_GET["id"] == NULL)
		{
			echo "You must specify a correct news ID.";
		}
		else
		{

			$query = "SELECT * FROM news WHERE id =" . $_GET["id"];
			$result = mysql_query($query) or die(mysql_error());
			
			if (mysql_num_rows($result) == 0)
			{
				echo "No news found in the database.";
			}
			else
			{
				//Display news items.
				
				while($row = mysql_fetch_array($result))
				{
?>
					<h1><?php echo ucwords($row['title']); ?></h1>

					<div>
<?php 
						$bbcode = new BBCode;
						$bbmessage = $row['message'];
						$message = $bbcode->Parse($bbmessage);
						echo $message;
?>
					</div>

					<div>
						<br/>
						<h3>Posted on <?php echo date("d/m/Y", strtotime($row['datetime'])); ?></h3>
					</div>
<?php
				}
			}
		}
?>			
	</div>

</body>

</html>