<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >

<head>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
	
	<link rel="stylesheet" href="./style/style-fancybox.css" type="text/css" media="screen" />
	
	<script type="text/javascript" src="/code/fancybox/source/resize_fancybox.js"></script>
	
	<?php include("includes/db.php"); ?>
		
	<!-- WYSIWYG Text Editor -->
	<?php
		require_once("code/bbeditor/nbbc.php");
	?>
	
</head>
					
<body>

	<div id="pageContent">
		<div id="event">
<?php
			if ($_GET["id"] != NULL)
			{
				$query = "SELECT * FROM events WHERE id =" . $_GET["id"];
				$event_exec = $db->prepare($query);
				$event_exec->execute();

				if ($event_exec->rowCount() != 0)
				{
					$event = $event_exec->fetchObject();
					
					echo "<h1>" . $event->title . " (" . $event->category . ")</h1>";
					
					echo "<h2>" . date("l jS \of F Y", strtotime($event->startdate)) . "</h2>";
					echo "<h2>" . date("H:i", strtotime($event->starttime)) . "</h2>";
					
					if ($event->endtime != "00:00:00")
					{
						echo "<h3>to</h3>";
						if ($event->startdate != $event->enddate)
						{
							echo "<h2>" . date("l jS \of F Y", strtotime($event->enddate)) . "</h2>";
						}
						echo "<h2>" . date("H:i", strtotime($event->endtime)) . "</h2>";
					}
					
					if ($event->location != null)
					{
						echo "<h3>at</h3>";
						echo "<h2>" . $event->location . "</h2>";
					}
					
					if ($event->price != "0.00")
					{
						echo "<h3>Cost</h3>";
						echo "<h2>£" . $event->price . "</h2>";
					}
					
					if ($event->comments != null)
					{
						echo "<h3>Comments</h3>";
						$bbcode = new BBCode;
						echo "<h2>" . $bbcode->Parse($event->comments) . "</h2>";
					}
					
				}
				else
				{
					echo "No event found in the database.";
				}
			}
			else
			{
				echo "You must specify a correct event ID.";
			}
?>
		</div>
	</div>
					
</body>


</html>