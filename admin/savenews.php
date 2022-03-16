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

		<?php include("../includes/db.php"); ?>

</head>

<body>

<?php
	function uploadImage($newsID)
	{
		//$types_array = array("image/gif","image/pjpeg", "image/x-png");	
		
		//Resizing the image
		//------------------------------------------------------------------------
		$temporary_name = $_FILES['image']['tmp_name'];
		$mimetype = $_FILES['image']['type'];

		//Determine what filetype the image is.
		switch($mimetype) {
			case "image/jpg":
			case "image/jpeg":
			case "image/pjpeg": //IE's weird jpeg MIME type
				$originalImage = imagecreatefromjpeg($temporary_name);
				break;
			case "image/gif":
				$originalImage = imagecreatefromgif($temporary_name);
				break;
			case "image/png":
				$originalImage = imagecreatefrompng($temporary_name);
				break;
		}
		unlink($temporary_name);
		
		
		//Get the resize width and height.
		//If width > height then change width.
		if (imagesx($originalImage) >= imagesy($originalImage))
		{
			$width = 200;
			$height = imagesy($originalImage)*($width/imagesx($originalImage));
		}
		//Else height > width so change the height.
		else
		{
			$height = 200;
			$width = imagesx($originalImage)*($height/imagesy($originalImage));
		}
		
		//Create a blank image with the new width and height sizes.
		$resizedImage = imagecreatetruecolor($width, $height);
		
		//Add the originalImage data to the resizedImage.
		imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $width, $height, imagesx($originalImage), imagesy($originalImage));
		
		//The directory the images are going to be uploaded to.
		$directory = "../images/news/";
		$filename = 'newsImage' . $newsID . '.jpg';
		$filepath = $directory . $filename;
		
		//Save the resizedImage as the filepath.
		imagejpeg($resizedImage, $filepath, 100);
		
		
		//Add the newsImage filename to the database.
		$query = "UPDATE news SET photo='". $filename . "' WHERE id = '" . $newsID . "'";
		mysql_query($query);
	}
?>


<?php
		if ($_POST['submit'] == true)
		{
			$id = $_POST['id'];
			
			if ($_POST['date'] == NULL)
			{
				$currentdate = date("Y-m-d");
			}
			else
			{
				$currentdate = $_POST['date'];
			}
			
			$title = $_POST['title'];
			$message = addslashes($_POST['message']); //Needed so you can have apostrophes in the message.

			
			if ($id == NULL)
			{
				$query = "INSERT INTO news (date, title, message) VALUES ('" . $currentdate . "','" . $title . "','" . $message . "')";
				mysql_query($query) or die(mysql_error());
				
				//Get the newsID of the row that is going to be inserted.
				$id = mysql_insert_id();
			}
			else
			{
				$query = "UPDATE news SET date='" . $currentdate . "', title='" . $title . "', message='" . $message . "' WHERE id=" . $id;
				mysql_query($query) or die(mysql_error());
			}

			
			if ($_FILES['image']['name'] != "")
			{			
				uploadImage($id);
			}
			
			echo "Currently saving " . $title;
?>
			<script type="text/javascript">
				parent.location.reload(true);
			</script>
<?php
		}
?>
			
</div>

</body>

</html>