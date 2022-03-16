<?php include("includes/header.php"); ?>

<?php include("includes/db.php"); ?>

<script type="text/javascript">document.title = "Cardiff University Taekwon-Do | Gallery"</script>

<h1>Gallery</h1>

<div id="gallery">

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
		
		$query = "SELECT * FROM gallery WHERE date >= :dateFrom AND date <= :dateTo AND date <= :date ORDER BY date DESC, id DESC";
		$media_exec = $db->prepare($query);
		$media_exec->bindValue("dateFrom", $dateFrom, PDO::PARAM_STR);
		$media_exec->bindValue("dateTo", $dateTo, PDO::PARAM_STR);
		$media_exec->bindValue("date", $date, PDO::PARAM_STR);
		$media_exec->execute();
		
		if ($media_exec->rowCount() != 0)
		{
?>
			<div class="year">
				<?php echo $year . "/" . ($year + 1); ?>
			</div>
<?php
			while($media = $media_exec->fetchObject())
			{
				// Photo
				if ($media->photo != null)
				{
?>
					<div class="photo">
						<a href="images/gallery/<?php echo $media->photo; ?>.jpg" class="fancybox" rel="photos" title="<?php echo $media->caption; ?>">
							<img src="images/gallery/<?php echo $media->photo; ?>_thumb.jpg" alt="<?php echo $media->caption; ?>" />
						</a>
					</div>
<?php
				}
				// Video
				elseif ($media->video != null)
				{
?>
					<div class="video">
						<img src="http://img.youtube.com/vi/<?php echo $media->video; ?>/mqdefault.jpg" alt="<?php echo $media->caption; ?>" />
						<a href="http://www.youtube.com/v/<?php echo $media->video; ?>" class="youtube" title="<?php echo $media->caption; ?>"></a>
					</div>
<?php
				}
			}
		}

	}
?>
	
	
</div>



<?php include("includes/footer.php"); ?>