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
	if ($_POST['submit'])
	{			
		$id = $_POST['id'];
		$title = addslashes($_POST['title']);
		$category = $_POST['category'];
		
		$startdate = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['startdate']))); //This is ridiculous.
		if ($_GET['enddate'] != NULL)
		{
			$enddate = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['enddate']))); //This is ridiculous.
		}
		else
		{
			$enddate = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['startdate']))); //This is ridiculous.
		}
		
		$starttime = date("H:i", strtotime($_POST['starttimehour'] . ":" . $_POST['starttimemin']));
		$endtime = date("H:i", strtotime($_POST['endtimehour'] . ":" . $_POST['endtimemin']));
		
		$location = addslashes($_POST['location']);
		$price = $_POST['price'];
		$comments = addslashes($_POST['comments']);

		if ($id == NULL)
		{
			$query = "INSERT INTO events (title, category, startdate, enddate, starttime, endtime, location, price, comments) VALUES ('" . $title . "','" . $category . "','" . $startdate . "','" . $enddate . "','" . $starttime . "','" . $endtime . "','" . $location . "','" . $price . "','" . $comments . "')";
			mysql_query($query) or die(mysql_error());
		}
		else
		{
			$query = "UPDATE events SET title='" . $title . "', category='" . $category . "', startdate='" . $startdate . "', enddate='" . $enddate . "', starttime='" . $starttime . "', endtime='" . $endtime . "', location='" . $location . "', price='" . $price . "', comments='" . $comments . "' WHERE id=" . $id;
			mysql_query($query) or die(mysql_error());
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