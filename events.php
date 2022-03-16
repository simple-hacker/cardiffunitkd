<?php include("includes/header.php"); ?>

<?php include("includes/db.php"); ?>

<script type="text/javascript">document.title = "Cardiff University Taekwon-Do | Events"</script>

<h1>Upcoming Events</h1>

<div id="events">

<?php 	
		$query = "SELECT * FROM events WHERE startdate >= '" . Date("Y-m-d") . "'ORDER BY startdate";
		$result = mysql_query($query) or die(mysql_error());
				
		if (mysql_num_rows($result) == 0)
		{
			echo "No upcoming events.";
		}
		else
		{
			//Display events
			$currentRow = 0;
			
			$month = 0;
			$year = 0;
			
			while($row = mysql_fetch_array($result))
			{
				$compareMonth = date("m", strtotime($row['startdate']));
				$compareYear = date("Y", strtotime($row['startdate']));
				
				if ($compareYear > $year)
				{
					$month = 0;
				}
						
				if ($compareMonth > $month)
				{
?>
						<div class="eventTitle">
							<?php echo date("F Y", strtotime($row['startdate'])); ?>
						</div>
<?php
						$month = date("m", strtotime($row['startdate']));
						$year = date("Y", strtotime($row['startdate']));
				}
?>
				<div class="event <?php if ($currentRow % 2 == 1) { echo 'altRow'; } ?>">
					<div class="eventDate"><?php echo date("d/m/Y", strtotime($row['startdate'])); ?></div>
					<div class="eventCategory">
						<?php
							if ($row['category'] == NULL)
							{
						?>
								&nbsp;
						<?php
							}
							else
							{
								echo $row['category'];
							}
						?>
					</div>
					<a href="event.php?id=<?php echo $row['id']; ?>" class="fb-small"><?php echo $row['title']; ?></a>
				</div>
<?php
				$currentRow++;
			}
		}
?>

</div>
		
	
				
				
<?php include("includes/footer.php"); ?>


