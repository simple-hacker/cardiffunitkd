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
		
		<!-- Rich Text Box Editor -->
		<script type="text/javascript" src="../code/bbeditor/ed.js"></script>
		
		<?php include("../includes/db.php"); ?>
		
		<!-- WYSIWYG Text Editor -->
		<?php require_once("../code/bbeditor/nbbc.php");	?>
		
		<!-- Form Validation -->
		<script type="text/javascript">
			function validateForm()
			{
				document.forms["form"]["title"].style.border = "1px solid #000";
				document.forms["form"]["message"].style.border = "1px solid #000";
			
				var title = document.forms["form"]["title"].value;
				var message = document.forms["form"]["message"].value;
				var elements = "";
				
				var isValid = true;
				
				if (title=="")
				{
					document.forms["form"]["title"].style.border = "2px solid red";
					elements = elements + "\n * Title";
					isValid = false;
				}
				if (message=="")
				{
					document.forms["form"]["message"].style.border = "2px solid red";
					elements = elements + "\n * Message";
					isValid = false;
				}
				
				
				if (isValid==true)
				{
					return true;
				}
				else
				{
					alert("Please make sure the follwing elements are completed and correct:\n" + elements);
					return false;
				}
			}
		</script>
		
</head>

<body>

<?php
	if ($_GET['id'] != NULL)
	{
		$query = "SELECT * FROM news WHERE id=" . $_GET['id'];
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($result);
			
		$id = $row['id'];
		$date = $row['date'];
		$title = $row['title'];
		$message = $row['message'];
		$photo = $row['photo'];
		
		$pageTitle = "Edit " . $title;
	}
	else
	{
			$id = NULL;
			$date = NULL;
			$title = NULL;
			$message = NULL;
			$photo = NULL;
			
			$pageTitle = 'Add News';
	}
?>

	<div id="pageContent">

		<h1><?php echo $pageTitle; ?></h1>

		<form name="form" method="post"  enctype="multipart/form-data" action="savenews.php" onSubmit="return validateForm();">
		
			<input name="id" type="hidden" value="<?php echo $id; ?>"/>
			<input name="date" type="hidden" value="<?php echo $date; ?>"/>
		
		
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">Title</div>
				</div>

				<div class="column2">
					<div class="box form"><input name="title" type="text" value="<?php echo $title; ?>"/></div>
				</div>
			</div>
			
			<div class="contentwrapper">
				<div class="box title altRow">Message</div>
				<div class="box">
					<script type="text/javascript">edToolbar('message');</script>
					<textarea name="message" id="message" class="ed" rows="8"><?php echo $message; ?></textarea>
				</div>
			</div>	
		
			
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">Photo Upload</div>
				</div>

				<div class="column2">
					<div class="box form"><input name="image" type="file" class="file"/></div>
				</div>
			</div>
			
	<?php		
			if ($photo != NULL)
			{
	?>
	
				<div class="contentwrapper">
					<div class="column1">
						<div class="box title altRow">Current Photo</div>
					</div>

					<div class="column2">
						<div class="box"><img src="../images/news/<?php echo $photo; ?>"  alt="<?php echo $title; ?>"/></div>
					</div>
				</div>
	<?php
			}
	?>	
			<div class="contentwrapper">
				<div class="box form">
					<input name="submit" type="submit" class="formButton" value="Submit"/>
				</div>
			</div>
			
		</form>
			
			
<?php
	if ($_GET['id'] != NULL)
	{
?>
			<script type="text/javascript">
				function confirmDelete()
				{
				var d=confirm("Are you sure you want to delete the news item '<?php echo $title; ?>'?");
				if (d==true)
					{
						parent.document.location.href ='delete.php?item=news&id=<?php echo $id; ?>'
					}
				else
					{				
						parent.$.fancybox.close();
					}
				}
			</script>

			<div class="contentwrapper">
				<div class="box form">
					<input name="delete" type="submit" class="formButton" value="Delete?" onclick="confirmDelete()"/>
				</div>
			</div>
<?php
	}
?>

</div>

</body>

</html>