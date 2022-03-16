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
	if ($_GET['id'] != NULL && ($_GET['item'] == "news" || $_GET['item'] == "events"))
	{
		//Delete and refresh admin index page.
		$query = "DELETE FROM " . $_GET['item'] . " WHERE id=" . $_GET['id'];
		mysql_query($query) or die(mysql_error());
		
		echo "Deleting item.";
		
		Header("Location: index.php");

	}
	else
	{
		Header("Location: index.php");
	}
?>

			
</div>

</body>

</html>