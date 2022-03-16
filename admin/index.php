<?php include("includes/header.php"); ?>

<?php include("../includes/db.php"); ?>

<script type="text/javascript">document.title = "Cardiff University Taekwon-Do | Admin"</script>

<h1>Admin</h1>


<div id="admin">

	<div class="adminTitle">
		News
	</div>
	
	<div class="adminButton">
		<a href="news.php" class="fb-small addButton">Add News</a>
	</div>


<?php 	
	$query = "SELECT * FROM news ORDER BY date DESC LIMIT 5";
	$result = mysql_query($query) or die(mysql_error());
			
	if (mysql_num_rows($result) != 0)
	{
		$currentRow = 0;
		
		while($row = mysql_fetch_array($result))
		{
			$currentRow++;
?>
			<div class="adminButton <?php if ($currentRow % 2 == 1) { echo 'altRow'; } ?>">
				<div class="adminDate"><?php echo date("d/m/Y", strtotime($row['date'])); ?></div>
				<div class="adminCategory">&nbsp;</div>
				<a href="news.php?id=<?php echo $row['id']; ?>" class="fb-small"><?php echo $row['title']; ?></a>
			</div>
<?php
		}
	}
?>	
	

	
	<div class="adminTitle">
		Events
	</div>
	
	<div class="adminButton">
		<a href="event.php" class="fb-small addButton">Add Event</a>
	</div>
	
<?php 	
		$query = "SELECT * FROM events WHERE startdate >= '" . Date("Y-m-d") . "'ORDER BY startdate";
		$result = mysql_query($query) or die(mysql_error());
				
		if (mysql_num_rows($result) != 0)
		{
			$currentRow = 0;
			
			while($row = mysql_fetch_array($result))
			{
				$currentRow++;
?>
				<div class="adminButton <?php if ($currentRow % 2 == 1) { echo 'altRow'; } ?>">
					<div class="adminDate"><?php echo date("d/m/Y", strtotime($row['startdate'])); ?></div>
					<div class="adminCategory">
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
			}
		}
?>
		
	<div class="adminTitle">
		Results
	</div>
	
<?php 	
		$yearStart = 2009;
		for ($year = date("Y"); $year >= $yearStart; $year--)
		{	
			$dateFrom = date("Y-m-d", mktime(0,0,0,9,1,$year));
			$dateTo = date("Y-m-d", mktime(0,0,0,8,31,($year+1)));
			
			$query = "SELECT * FROM events WHERE category = 'competition' AND startdate >= '" . $dateFrom . "' AND startdate <= '" . $dateTo . "' AND startdate <= '" . Date("Y-m-d") . "' ORDER BY startdate DESC";
			$result = mysql_query($query) or die(mysql_error());
			
			if (mysql_num_rows($result) != 0)
			{
				$currentRow = 0;
?>
				<div class="slider">
					<h1><?php echo $year . "/" . ($year + 1); ?></h1>

					<div class="sliderContent">
<?php				
					while($row = mysql_fetch_array($result))
					{
						$currentRow++;
?>
						<div class="adminButton <?php if ($currentRow % 2 == 1) { echo 'altRow'; } ?>">
							<div class="adminDate"><?php echo date("d/m/Y", strtotime($row['startdate'])); ?></div>
							<div class="adminCategory">
								&nbsp;
							</div>
							<a href="results.php?id=<?php echo $row['id']; ?>" class="fb-result"><?php echo $row['title']; ?></a>
						</div>
<?php
					}
?>
					</div>
				</div>
<?php
			}
		}
?>
	
	
	
	
	
	<div class="adminTitle">
		Gallery
	</div>
	
	<div class="adminButton">
		<a href="gallery.php" class="fb-gallery addButton">Upload Image or Video</a>
	</div>
	
	<?php
	$yearStart = 2009;
	$currentYear = date("Y");
	$futureDate = date("Y-m-d", mktime(0,0,0,9,1,$currentYear));
	
	if (date("Y-m-d") < $futureDate)
		$year = $currentYear-1;
	else
		$year = $currentYear;
	
	for ($year; $year >= $yearStart; $year--)
	{			
		
		$dateFrom = date("Y-m-d", mktime(0,0,0,9,1,$year));
		$dateTo = date("Y-m-d", mktime(0,0,0,8,31,($year+1)));
		$date = date("Y-m-d");
		
		$query = "SELECT * FROM gallery WHERE date >= :dateFrom AND date <= :dateTo AND date <= :date ORDER BY date DESC";
		$media_exec = $db->prepare($query);
		$media_exec->bindValue("dateFrom", $dateFrom, PDO::PARAM_STR);
		$media_exec->bindValue("dateTo", $dateTo, PDO::PARAM_STR);
		$media_exec->bindValue("date", $date, PDO::PARAM_STR);
		$media_exec->execute();
		
		if ($media_exec->rowCount() != 0)
		{
?>
			<div id="admingallery">	
				<div class="slider">
					<h1><?php echo $year . "/" . ($year + 1); ?></h1>

					<div class="sliderContent">
<?php
					while($media = $media_exec->fetchObject())
					{
						// Photo
						if ($media->photo != null)
						{
?>
							<div class="photo">
								<img src="../images/gallery/<?php echo $media->photo; ?>_thumb.jpg" alt="<?php echo $media->caption; ?>"/>
								<a href="#" class="delete"></a>
							</div>
<?php
						}
						// Video
						elseif ($media->video != null)
						{
?>
							<div class="video">
								<img src="http://img.youtube.com/vi/<?php echo $media->video; ?>/mqdefault.jpg" />
								<div class="playbutton"></div>
								<a href="#" class="delete"></a>
							</div>
<?php
						}
					}
?>
					</div>
				</div>
			</div>
<?php
		}

	}
?>

</div>

<?php include("../includes/footer.php"); ?>