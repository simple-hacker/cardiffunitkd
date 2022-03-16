<?php include("includes/header.php"); ?>

<?php include("includes/db.php"); ?>

<?php require_once("code/bbeditor/nbbc.php");	?>
		


<script type="text/javascript">document.title = "Cardiff University Taekwon-Do | News"</script>


<div id="contentWrapper">

	<div id="contentColumn">		
	
	<div class="innerTube">
		<h1>Latest Media</h1>
		<div id="gallery">
<?php
			$query = "SELECT * FROM gallery ORDER BY date DESC, id DESC LIMIT 6";
			$media_exec = $db->prepare($query);
			$media_exec->execute();
			
			if ($media_exec->rowCount() != 0)
			{
				while($media = $media_exec->fetchObject())
				{
					// Photo
					if ($media->photo != null)
					{
?>
						<div class="photo">
							<a href="images/gallery/<?php echo $media->photo; ?>.jpg" class="fancybox" rel="media" title="<?php echo $media->caption; ?>" alt="<?php echo $media->caption; ?>" >
								<img src="images/gallery/<?php echo $media->photo; ?>_thumb.jpg" />
							</a>
						</div>
<?php
					}
					// Video
					elseif ($media->video != null)
					{
?>
						<div class="video">
							<img src="http://img.youtube.com/vi/<?php echo $media->video; ?>/mqdefault.jpg" />
							<a href="http://www.youtube.com/v/<?php echo $media->video; ?>" class="youtube" title="<?php echo $media->caption; ?>"></a>
						</div>
<?php
					}
				}
			}
?>
		</div>

	</div>
	


</div>


<?php include("includes/footer.php"); ?>