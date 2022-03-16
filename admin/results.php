<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
        <!-- 
			Cardiff University Taekwon-Do
        -->
		
		
<head>      

        <!-- Meta Tags -->
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
	
        <!-- CSS -->
        <!-- <link rel="stylesheet" href="../style/style-fancybox.css" type="text/css" media="screen" /> -->
		<link rel="stylesheet" type="text/css"href="../style/admin-results.css" />
		
		<?php include("../includes/db.php"); ?>
		
		
		<!-- Javascript-->
		<!-- ***************************************** -->
		
		
		<!-- jQuery Tools-->
		<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
		<script type="text/javascript">
			$(function() {
		  // initialize scrollable
		  $(".scrollable").scrollable();
		});
		</script>
		
		<!-- FormClone-->
		<script type="text/javascript" src="js/jquery.cloneform.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){

				//The jQuery Setup
				$('#pattern_add').click(function(){
					var yourclass=".pattern_result";  //The class you have used in your form
					var clonecount = $(yourclass).length;	//how many clones do we already have?
					var newid = Number(clonecount) + 1;		//Id of the new clone   
					
					$(yourclass+":first").fieldclone({		//Clone the original elelement
						newid_: newid,						//Id of the new clone, (you can pass your own if you want)
						target_: $('#pattern_add'),			//where do we insert the clone? (target element)
						insert_: "before",					//where do we insert the clone? (after/before/append/prepend...)
						limit_: 0							//Maximum Number of Clones
					});
					$('#pattern_number').val(newid);
					return false;
				});
				
				$('#sparring_add').click(function(){
					var yourclass=".sparring_result";  //The class you have used in your form
					var clonecount = $(yourclass).length;	//how many clones do we already have?
					var newid = Number(clonecount) + 1;		//Id of the new clone   
					
					$(yourclass+":first").fieldclone({		//Clone the original elelement
						newid_: newid,						//Id of the new clone, (you can pass your own if you want)
						target_: $('#sparring_add'),			//wefwefhere do we insert the clone? (target element)
						insert_: "before",					//where do we insert the clone? (after/before/append/prepend...)
						limit_: 0							//Maximum Number of Clones
					});
					$('#sparring_number').val(newid);
					return false;
				});
				
				$('#power_add').click(function(){
					var yourclass=".power_result";  //The class you have used in your form
					var clonecount = $(yourclass).length;	//how many clones do we already have?
					var newid = Number(clonecount) + 1;		//Id of the new clone   
					
					$(yourclass+":first").fieldclone({		//Clone the original elelement
						newid_: newid,						//Id of the new clone, (you can pass your own if you want)
						target_: $('#power_add'),			//where do we insert the clone? (target element)
						insert_: "before",					//where do we insert the clone? (after/before/append/prepend...)
						limit_: 0							//Maximum Number of Clones
					});
					$('#power_number').val(newid);
					return false;
				});
			});
		 </script>

		
</head>

<body>

<?php
	if ($_GET['id'] != "")
	{
		$eventid_sql = "SELECT * FROM events WHERE id = :id";

		 //prepare the statements
		$eventid = $db->prepare($eventid_sql);
		//give value to named parameter :username
		$eventid->bindValue("id", $_GET['id'], PDO::PARAM_STR);
		$eventid->execute();
		
		$eventid_result = $eventid->fetchObject();
		
		echo "<h1>" . $eventid_result->title . "</h1>";
	}
?>


<form name="form" method="post"  enctype="multipart/form-data" action="saveresults.php">

	<input type="hidden" name="event_id" value="<?php echo $_GET['id']; ?>"/>
	<input type="hidden" name="event_date" value="<?php echo $eventid_result->startdate; ?>"/>

	<!-- "previous page" action -->
	<a class="prev browse left">&lt;</a>

	<!-- root element for scrollable -->
	<div class="scrollable" id="scrollable">

	  <!-- root element for the items -->
	  <div class="items">

		<div>
				<!--
				// Patterns
				// =========================================================
				-->
				
				<h2>Patterns</h2>

					<div class="pattern_result">
						<input name="pattern_name_1" type="text" placeholder="Name"/>
						<select name="pattern_medal_1">
							<option value="gold">Gold</option>
							<option value="silver">Silver</option>
							<option value="bronze">Bronze</option>
						</select>
						<select name="pattern_age_1">
							<option value="adult">Adult</option>
							<option value="1617">16-17</option>
							<option value="veteran">Veteran</option>
						</select>
						<select name="pattern_gender_1">
							<option value="mixed">Mixed</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
						<select name="pattern_grade_from_1">
							<option value="0">Grade From</option>
							<option value="10">10th Kup</option>
							<option value="9">9th Kup</option>
							<option value="8">8th Kup</option>
							<option value="7">7th Kup</option>
							<option value="6">6th Kup</option>
							<option value="5">5th Kup</option>
							<option value="4">4th Kup</option>
							<option value="3">3rd Kup</option>
							<option value="2">2nd Kup</option>
							<option value="1">1st Kup</option>
							<option value="-1">I Dan</option>
							<option value="-2">II Dan</option>
							<option value="-3">III Dan</option>
							<option value="-4">IV Dan</option>
							<option value="-5">V Dan</option>
							<option value="-6">VI Dan</option>
						</select>
						<select name="pattern_grade_to_1">
							<option value="0">Grade To</option>
							<option value="10">10th Kup</option>
							<option value="9">9th Kup</option>
							<option value="8">8th Kup</option>
							<option value="7">7th Kup</option>
							<option value="6">6th Kup</option>
							<option value="5">5th Kup</option>
							<option value="4">4th Kup</option>
							<option value="3">3rd Kup</option>
							<option value="2">2nd Kup</option>
							<option value="1">1st Kup</option>
							<option value="-1">I Dan</option>
							<option value="-2">II Dan</option>
							<option value="-3">III Dan</option>
							<option value="-4">IV Dan</option>
							<option value="-5">V Dan</option>
							<option value="-6">VI Dan</option>
						</select>
					</div>
				
				<div class="add" id="pattern_add" name="pattern_add">+</div>
				<input type="hidden" id="pattern_number" name="pattern_number" value="1"/>
		</div>
		  
		  
		<div>
		
			<!--
			// Sparring
			// =========================================================
			-->
			
			<h2>Sparring</h2>
			
			<div class="sparring_result">
				<input name="sparring_name_1" type="text" placeholder="Name"/>
				<select name="sparring_medal_1">
					<option value="gold">Gold</option>
					<option value="silver">Silver</option>
					<option value="bronze">Bronze</option>
				</select>
				<select name="sparring_age_1">
					<option value="adult">Adult</option>
					<option value="1617">16-17</option>
					<option value="veteran">Veteran</option>
				</select>
				<select name="sparring_gender_1">
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
				<select name="sparring_type_1">
					<option value="continuous">Continuous</option>
					<option value="point stop">Point Stop</option>
				</select>
				<select name="sparring_grade_from_1">
					<option value="0">Grade From</option>
					<option value="10">10th Kup</option>
					<option value="9">9th Kup</option>
					<option value="8">8th Kup</option>
					<option value="7">7th Kup</option>
					<option value="6">6th Kup</option>
					<option value="5">5th Kup</option>
					<option value="4">4th Kup</option>
					<option value="3">3rd Kup</option>
					<option value="2">2nd Kup</option>
					<option value="1">1st Kup</option>
					<option value="-1">I Dan</option>
					<option value="-2">II Dan</option>
					<option value="-3">III Dan</option>
					<option value="-4">IV Dan</option>
					<option value="-5">V Dan</option>
					<option value="-6">VI Dan</option>
					<option value="-100">Black Belts</option>
				</select>
				<select name="sparring_grade_to_1">
					<option value="0">Grade To</option>
					<option value="10">10th Kup</option>
					<option value="9">9th Kup</option>
					<option value="8">8th Kup</option>
					<option value="7">7th Kup</option>
					<option value="6">6th Kup</option>
					<option value="5">5th Kup</option>
					<option value="4">4th Kup</option>
					<option value="3">3rd Kup</option>
					<option value="2">2nd Kup</option>
					<option value="1">1st Kup</option>
					<option value="-1">I Dan</option>
					<option value="-2">II Dan</option>
					<option value="-3">III Dan</option>
					<option value="-4">IV Dan</option>
					<option value="-5">V Dan</option>
					<option value="-6">VI Dan</option>
					<option value="-100">Black Belts</option>
				</select>
				<select name="sparring_weight_1">
					<option value="0">Weight</option>
					<option value="-45">-45 kg</option>
					<option value="-50">-50 kg</option>
					<option value="-51">-51 kg</option>
					<option value="-55">-55 kg</option>
					<option value="-57">-57 kg</option>
					<option value="-63">-63 kg</option>
					<option value="-64">-64 kg</option>
					<option value="-65">-65 kg</option>
					<option value="65">65+ kg</option>
					<option value="-69">-69 kg</option>
					<option value="-71">-71 kg</option>
					<option value="-75">-75 kg</option>
					<option value="75">75+ kg</option>
					<option value="-78">-78 kg</option>
					<option value="-85">-85 kg</option>
					<option value="85">85+ kg</option>
					<option value="lightweight">Lightweight</option>
					<option value="middleweight">Middleweight</option>
					<option value="heavyweight">Heavyweight</option>
					<option value="all">All Weights</option>
					
				</select>
			</div>
			
			<div class="add" id="sparring_add" name="sparring_add">+</div>
			<input type="hidden" id="sparring_number" name="sparring_number" value="1"/>
			
		</div>
	  
	  
		<div>
		
			<!--
			// Power
			// =========================================================
			-->
			
			<h2>Power/Special Technique</h2>
			
			<div class="power_result">
				<input name="power_name_1" type="text" placeholder="Name"/>
				<select name="power_medal_1">
					<option value="gold">Gold</option>
					<option value="silver">Silver</option>
					<option value="bronze">Bronze</option>
				</select>
				<select name="power_age_1">
					<option value="adult">Adult</option>
					<option value="1617">16-17</option>
					<option value="veteran">Veteran</option>
				</select>
				<select name="power_gender_1">
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
				<select name="power_grade_from_1">
					<option value="0">Grade From</option>
					<option value="10">10th Kup</option>
					<option value="9">9th Kup</option>
					<option value="8">8th Kup</option>
					<option value="7">7th Kup</option>
					<option value="6">6th Kup</option>
					<option value="5">5th Kup</option>
					<option value="4">4th Kup</option>
					<option value="3">3rd Kup</option>
					<option value="2">2nd Kup</option>
					<option value="1">1st Kup</option>
					<option value="-1">I Dan</option>
					<option value="-2">II Dan</option>
					<option value="-3">III Dan</option>
					<option value="-4">IV Dan</option>
					<option value="-5">V Dan</option>
					<option value="-6">VI Dan</option>
					<option value="-100">Black Belts</option>
				</select>
				<select name="power_grade_to_1">
					<option value="0">Grade To</option>
					<option value="10">10th Kup</option>
					<option value="9">9th Kup</option>
					<option value="8">8th Kup</option>
					<option value="7">7th Kup</option>
					<option value="6">6th Kup</option>
					<option value="5">5th Kup</option>
					<option value="4">4th Kup</option>
					<option value="3">3rd Kup</option>
					<option value="2">2nd Kup</option>
					<option value="1">1st Kup</option>
					<option value="-1">I Dan</option>
					<option value="-2">II Dan</option>
					<option value="-3">III Dan</option>
					<option value="-4">IV Dan</option>
					<option value="-5">V Dan</option>
					<option value="-6">VI Dan</option>
					<option value="-100">Black Belts</option>
				</select>
			</div>
			
			<div class="add" id="power_add" name="power_add">+</div>
			<input type="hidden" id="power_number" name="power_number" value="1"/>
		</div>

		<div>
			<h2>Overall Individual</h2>
		</div>

	  </div>

	</div>

	<!-- "next page" action -->
	<a class="next browse right">&gt;</a>

	
<input type="submit" value="Save Results" class="button" />
</form>



</body>

</html>