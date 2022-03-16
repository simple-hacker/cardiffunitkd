<?php include("../includes/db.php"); ?>

<?php
	function get_random_string($length=10,$characters = "ABCDEFGHIJKLMNOPRQSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789")
	{
			$num_characters = strlen($characters) - 1;
			while (strlen($return) < $length) {
				$return .= $characters[mt_rand(0, $num_characters)];
			}
			return $return;
	}
	
?>

<?php
	$rand_str = "";
	$video = "";
	
	if ($_POST['video'] != null)
	{
		preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $_POST['video'], $vidid);
		$video = $vidid[1];
	}
	else
	{
		$video = "";
	}


	if ($_POST['date'] != "")
		$date = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['date']))); //This is ridiculous.
	else
		$date = date("Y-m-d");
	
	$caption = addslashes($_POST['caption']);
	

	//Save Image
	//===================================================================================
	if ($_FILES['photo']['name'] != "")
	{
		$temporary_name = $_FILES['photo']['tmp_name'];
		$mimetype = $_FILES['photo']['type'];
		$rand_str = get_random_string();
		
		$create = false;
		
		//Determine what filetype the image is.
		switch($mimetype) {
			case "image/jpg":
				$create = true;
			case "image/jpeg":
				$create = true;
			case "image/pjpeg": //IE's weird jpeg MIME type
				$create = true;
				$originalImage = imagecreatefromjpeg($temporary_name);
				break;
			case "image/gif":
				$create = true;
				$originalImage = imagecreatefromgif($temporary_name);
				break;
			case "image/png":
				$create = true;
				$originalImage = imagecreatefrompng($temporary_name);
				break;
		}
		unlink($temporary_name);
		
		if ($create != false)
		{	
			$fullsizeWidth = imagesx($originalImage);
			$fullsizeHeight = imagesy($originalImage);
			
			$thumbnailHeight = 103;
			$thumbnailWidth = $fullsizeWidth*($thumbnailHeight/$fullsizeHeight);

			//Create a FULLSIZE image with the FULLSIZE width and height.
			//This is so that that all images will be a .jpg no matter what they uploaded.
			$fullsizeImage = imagecreatetruecolor($fullsizeWidth, $fullsizeHeight);	
			//Add the originalImage data to the resizedImage.
			imagecopyresampled($fullsizeImage, $originalImage, 0, 0, 0, 0, $fullsizeWidth, $fullsizeHeight, $fullsizeWidth, $fullsizeHeight);
			
			//Create a THUMBNAIL image with the THUMBNAIL width and height.
			$thumbnailImage = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);	
			//Add the originalImage data to the resizedImage.
			imagecopyresampled($thumbnailImage, $originalImage, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $fullsizeWidth, $fullsizeHeight);

			
			//The directory the images are going to be uploaded to.
			$directory = "../images/gallery/";
			
			//FULLSIZE filepath
			$filename = $rand_str . '.jpg';
			$filepath = $directory . $filename;
			
			//THUMBNAIL filepath
			$filename_thumbnail = $rand_str . '_thumb.jpg';
			$filepath_thumbnail = $directory . $filename_thumbnail;
			
			//Save all images with their respective filepaths.
			imagejpeg($fullsizeImage, $filepath, 100);
			imagejpeg($thumbnailImage, $filepath_thumbnail, 100);
		}
	}
	
	$gallery_sql = "INSERT INTO gallery (photo, video, date, caption) VALUES (:photo, :video, :date, :caption)";
	$gallery = $db->prepare($gallery_sql);
	$gallery->bindValue("photo", $rand_str, PDO::PARAM_STR);
	$gallery->bindValue("video", $video, PDO::PARAM_STR);
	$gallery->bindValue("date", $date, PDO::PARAM_STR);
	$gallery->bindValue("caption", $caption, PDO::PARAM_STR);
	$gallery->execute();
	
?>

<?php
	echo $gallery_sql . "<br/>";
	echo $rand_str . "<br/>";
	echo $youtube . "<br/>";
	echo $date . "<br/>";
	echo $caption . "<br/>";

?>

<body>
	Saving...
	<br/>
	You will be redirected soon.
	
	<script type="text/javascript">
		setTimeout(function() {parent.location.reload(true);},5000);	
	</script>


</body>

