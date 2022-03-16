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
		
		<!-- Calendar pop-up -->
		<link rel="stylesheet" type="text/css" href="../code/calendar/epoch_styles.css" />
		<script type="text/javascript" src="../code/calendar/epoch_classes.js"></script>
		<script type="text/javascript">
			var dp_cal,dp_cal2;
			window.onload = function ()
			{
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('popup_container'));
				dp_cal2  = new Epoch('epoch_popup','popup',document.getElementById('popup_container2'));
			};
		</script>
		
		<?php include("../includes/db.php"); ?>
		
		<!-- WYSIWYG Text Editor -->
		<?php require_once("../code/bbeditor/nbbc.php");	?>	
		
		<!-- Form Validation -->
		<script type="text/javascript">
			function validateForm()
			{
				document.forms["form"]["title"].style.border = "1px solid #000";
				document.forms["form"]["category"].style.border = "1px solid #000";
				document.forms["form"]["startdate"].style.border = "1px solid #000";
				document.forms["form"]["enddate"].style.border = "1px solid #000";
				document.forms["form"]["starttimehour"].style.border = "1px solid #000";
				document.forms["form"]["starttimemin"].style.border = "1px solid #000";
				document.forms["form"]["endtimehour"].style.border = "1px solid #000";
				document.forms["form"]["endtimemin"].style.border = "1px solid #000";
				document.forms["form"]["price"].style.border = "1px solid #000";
			
				var title = document.forms["form"]["title"].value;
				var category = document.forms["form"]["category"].value;
				var startdate = document.forms["form"]["startdate"].value;
				var enddate = document.forms["form"]["enddate"].value;
				var starttimehour = document.forms["form"]["starttimehour"].value;
				var starttimemin = document.forms["form"]["starttimemin"].value;
				var endtimehour = document.forms["form"]["endtimehour"].value;
				var endtimemin= document.forms["form"]["endtimemin"].value;
				var price = document.forms["form"]["price"].value;


				//To get current date in dd/mm/yyyy format ready to compare - wtf.
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1;//January is 0!
				var yyyy = today.getFullYear();
				if(dd<10){dd='0'+dd;}
				if(mm<10){mm='0'+mm;}
				var currentdate = dd+'/'+mm+'/'+yyyy;
  
				var elements = "";
				var isValid = true;
				
				
				if (title=="")
				{
					document.forms["form"]["title"].style.border = "2px solid red";
					elements = elements + "\n * Title";
					isValid = false;
				}
				if (category=="")
				{
					document.forms["form"]["category"].style.border = "2px solid red";
					elements = elements + "\n * Category";
					isValid = false;
				}
				if (startdate=="")
				{
					document.forms["form"]["startdate"].style.border = "2px solid red";
					elements = elements + "\n * Start Date";
					isValid = false;
				}
				
				if ((enddate != "") && (enddate < startdate))
				{
					document.forms["form"]["startdate"].style.border = "2px solid red";
					document.forms["form"]["enddate"].style.border = "2px solid red";
					elements = elements + "\n * End Date must not be before Start Date";
					isValid = false;
				}
				
				if (startdate == enddate)
				{
					if ( (endtimehour < starttimehour) || ( (endtimehour == starttimehour) && (endtimemin < starttimemin) ) )
					{
						document.forms["form"]["starttimehour"].style.border = "2px solid red";
						document.forms["form"]["starttimemin"].style.border = "2px solid red";
						document.forms["form"]["endtimehour"].style.border = "2px solid red";
						document.forms["form"]["endtimemin"].style.border = "2px solid red";
						elements = elements + "\n * End Time cannot be before Start Time";
						isValid = false;
					}
				}
				
				if (isNaN(price) == true)
				{
					document.forms["form"]["price"].style.border = "2px solid red";
					elements = elements + "\n * Price should be numeric (0-9 with optional decimal place)";
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
		$query = "SELECT * FROM events WHERE id=" . $_GET['id'];
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($result);
			
		$id = $row['id'];
		$title = $row['title'];
		$category = $row['category'];
		$startDate = strtotime($row['startdate']);
		$endDate = strtotime($row['enddate']);
		$startTimeHour = date("H", strtotime($row['starttime']));
		$startTimeMin = date("i", strtotime($row['starttime']));
		$endTimeHour = date("H", strtotime($row['endtime']));
		$endTimeMin = date("i", strtotime($row['endtime']));
		$location = $row['location'];
		$price = $row['price'];
		$comments = $row['comments'];
		
		$pageTitle = "Edit " . $title;
	}
	else
	{
		$id = NULL;
		$title = NULL;
		$category = NULL;
		$startDate = NULL;
		$endDate = NULL;
		$startTimeHour = NULL;
		$startTimeMin = NULL;
		$endTimeHour = NULL;
		$endTimeMin = NULL;
		$location = NULL;
		$price = NULL;
		$comments = NULL;
			
		$pageTitle = 'Add Event';
	}
?>

	<div id="pageContent">

		<h1><?php echo $pageTitle; ?></h1>

		<form name="form" method="post"  enctype="multipart/form-data" action="saveevent.php" onSubmit="return validateForm();">
		
			<input name="id" type="hidden" value="<?php echo $id; ?>"/>
		
		
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">Title</div>
				</div>
				<div class="column2">
					<div class="box form"><input name="title" type="text" value="<?php echo $title; ?>"/></div>
				</div>
			</div>
					

			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">Category</div>
				</div>
				<div class="column2">
					<div class="box form">
						<select name="category" class="selectLong">
<?php
							$options=array('', 'Competition', 'Grading', 'Seminar', 'Social', 'Other');
							foreach($options as $option)
							{
								if($category == $option)
									echo "<option value=\"{$option}\" selected=\"selected\">{$option}</option>";
								else
									echo "<option value=\"{$option}\">{$option}</option>";
							}
?>
						</select>
					</div>
				</div>
			</div>			
			
			
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">Start Date</div>
				</div>
				<div class="column2">
					<div class="box form">
						<input name="startdate" id="popup_container" type="text" readonly="true" value="<?php if ($startDate != NULL) { echo date("d/m/Y", $startDate); } ?>"/>
					</div>
				</div>
			</div>
					
			
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">End Date</div>
				</div>
				<div class="column2">
					<div class="box form">
						<input name="enddate" id="popup_container2" type="text" readonly='true' value="<?php if ($endDate != NULL) { echo date("d/m/Y", $endDate); } ?>"/>
					</div>
				</div>
			</div>
			
			
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">Start Time</div>
				</div>
				<div class="column2">
					<div class="box form left">
						<select name="starttimehour">
<?php
							$options=array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
							foreach($options as $option)
							{
								if($startTimeHour == $option)
									echo "<option value=\"{$option}\" selected=\"selected\">{$option}</option>";
								else
									echo "<option value=\"{$option}\">{$option}</option>";
							}
?>				
						</select>
						 :
						<select name="starttimemin">
<?php
							$options=array('00','15','30','45');
							foreach($options as $option)
							{
								if($startTimeMin == $option)
									echo "<option value=\"{$option}\" selected=\"selected\">{$option}</option>";
								else
									echo "<option value=\"{$option}\">{$option}</option>";
							}
?>		
						</select>
					</div>
				</div>
			</div>
			
			
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">End Time</div>
				</div>
				<div class="column2">
					<div class="box form left">
						<select name="endtimehour">
<?php
							$options=array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
							foreach($options as $option)
							{
								if($endTimeHour == $option)
									echo "<option value=\"{$option}\" selected=\"selected\">{$option}</option>";
								else
									echo "<option value=\"{$option}\">{$option}</option>";
							}
?>								
						</select>
						 :
						<select name="endtimemin">
<?php
							$options=array('00','15','30','45');
							foreach($options as $option)
							{
								if($endTimeMin == $option)
									echo "<option value=\"{$option}\" selected=\"selected\">{$option}</option>";
								else
									echo "<option value=\"{$option}\">{$option}</option>";
							}
?>	
						</select>
					</div>
				</div>
			</div>
			
			
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">Location</div>
				</div>
				<div class="column2">
					<div class="box form">
						<input name="location" type="text" value="<?php echo $location; ?>"/>
					</div>
				</div>
			</div>

			
			<div class="contentwrapper">
				<div class="column1">
					<div class="box title altRow">Price (£)</div>
				</div>
				<div class="column2">
					<div class="box form">
						<input name="price" type="text" value="<?php echo $price; ?>"/>
					</div>
				</div>
			</div>

			
			<div class="contentwrapper">
				<div class="box title altRow">Comments</div>
				<div class="box">
					<script type="text/javascript">edToolbar('comments');</script>
					<textarea name="comments" id="comments" class="ed" rows="6"><?php echo $comments; ?></textarea>
				</div>
			</div>	
		
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
				var d=confirm("Are you sure you want to delete the event item '<?php echo $title; ?>'?");
				if (d==true)
					{
						parent.document.location.href ='delete.php?item=events&id=<?php echo $id; ?>'
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