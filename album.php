<?php include("includes/header.php"); ?>

<?php include("includes/db.php"); ?>

<?php
	if ($_GET['id'] != NULL)
	{
	
		$albumID = $_GET['id'];
		
		$query_album = "SELECT * FROM gallery_albums WHERE id='" . $albumID . "'";
		$result_album = mysql_query($query_album) or die(mysql_error());
		$row_album = mysql_fetch_array($result_album);
		
		if (mysql_num_rows($result_album) == 0)
		{
?>
			<h1>Unknown Album</h1>
			Please provide a correct album ID.
<?php
		}
		else
		{
		
?>
			<script type="text/javascript">document.title = "Cardiff University Taekwon-Do | Gallery | <?php echo $row_album['title']; ?>"</script>

			<h1><?php echo $row_album['title']; ?></h1>
<?php
			$query_photos = "SELECT * FROM gallery_photos WHERE albumID='" . $albumID . "'";
			$result_photos = mysql_query($query_photos) or die(mysql_error());
			//$row_photos = mysql_fetch_array($result_photos);
						
			if (mysql_num_rows($result_photos) != 0)
			{
?>
				<div class="albumTitle">
					Photos
				</div>
				
				<div id="photos">
<?php
				$photoNum = 1;
				while($row_photos = mysql_fetch_array($result_photos))
				{
?>			
						<a href="images/gallery/<?php echo $albumID; ?>/<?php echo $albumID; ?>_<?php echo $row_photos['photoID']; ?>.jpg" class="fancybox" rel="album" title="<?php echo $photoNum . ' / ' .  mysql_num_rows($result_photos); ?>">
							<img src="images/gallery/<?php echo $albumID; ?>/<?php echo $albumID; ?>_<?php echo $row_photos['photoID']; ?>_thumbnail.jpg" alt="<?php echo $photoNum . ' / ' .  mysql_num_rows($result_photos); ?>" />						
						</a>
<?php
					$photoNum++;
				}
?>
				</div>
<?php
			}
			
			$query_videos = "SELECT * FROM gallery_videos WHERE albumID='" . $albumID . "'";
			$result_videos = mysql_query($query_videos) or die(mysql_error());
			//$row_videos = mysql_fetch_array($result_videos);
			
			
			//Replace youtube links so it's consistent and works with fancybox
			function youtubeLink($url)
			{	
				$newurl = str_replace("youtu.be/", "youtube.com/v/", $url);
				$newurl = str_replace("watch?v=", "v/", $newurl);
				$newurl = str_replace("embed/", "v/", $newurl);
				return $newurl;
			}
						
			if (mysql_num_rows($result_videos) != 0)
			{
			
?>
				<div class="albumTitle">
					Videos
				</div>
<?php		
				$currentRow = 0;
?>
				<div id="videos">
<?php
				while($row_videos = mysql_fetch_array($result_videos))
				{
?>
					<div class="video"><a class="youtube <?php if ($currentRow % 2 == 1) { echo 'altRow'; } ?>" href="<?php echo youtubeLink($row_videos['video']); ?>"><?php echo $row_videos['title']; ?></a></div>
<?php			
					$currentRow++;
				}
?>
				
				</div>
<?php
			}
		}
	}
	else
	{
?>
		<h1>Unknown Album</h1>
		
		Please specify a correct album ID.
<?php
	}
?>



	

<?php include("includes/footer.php"); ?>