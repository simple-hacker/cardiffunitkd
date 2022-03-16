<?php include("../includes/db.php"); ?>

<?php
	$event_id = $_POST['event_id'];
	$event_date = $_POST['event_date'];
	
	$pattern_number = $_POST['pattern_number'];
	$sparring_number = $_POST['sparring_number'];
	$power_number = $_POST['power_number'];
	
	// Patterns
	// =========================================================
	
	$pattern_sql = "INSERT INTO results_patterns (event_id, event_date, name, medal, age, gender, grade_from, grade_to) VALUES (:event_id, :event_date, :name, :medal, :age, :gender, :grade_from, :grade_to)";
	$pattern = $db->prepare($pattern_sql);
	
	for ($i = 1; $i <= $pattern_number; $i++)
	{
		if ($_POST['pattern_name_' . $i] != null)
		{
			$pattern->bindValue("event_id", $event_id, PDO::PARAM_STR);
			$pattern->bindValue("event_date", $event_date, PDO::PARAM_STR);
			$pattern->bindValue("name", $_POST['pattern_name_' . $i], PDO::PARAM_STR);
			$pattern->bindValue("medal", $_POST['pattern_medal_' . $i], PDO::PARAM_STR);
			$pattern->bindValue("age", $_POST['pattern_age_' . $i], PDO::PARAM_STR);
			$pattern->bindValue("gender", $_POST['pattern_gender_' . $i], PDO::PARAM_STR);
			$pattern->bindValue("grade_from", $_POST['pattern_grade_from_' . $i], PDO::PARAM_STR);
			$pattern->bindValue("grade_to", $_POST['pattern_grade_to_' . $i], PDO::PARAM_STR);
			
			$pattern->execute();
		}
	}
	
	
	
	
	// Sparring
	// =========================================================
	
	$sparring_sql = "INSERT INTO results_sparring (event_id, event_date, name, medal, age, gender, type, weight, grade_from, grade_to) VALUES (:event_id, :event_date, :name, :medal, :age, :gender, :type, :weight, :grade_from, :grade_to)";
	$sparring = $db->prepare($sparring_sql);
	
	for ($i = 1; $i <= $sparring_number; $i++)
	{
		if ($_POST['sparring_name_' . $i] != null)
		{
			$sparring->bindValue("event_id", $event_id, PDO::PARAM_STR);
			$sparring->bindValue("event_date", $event_date, PDO::PARAM_STR);
			$sparring->bindValue("name", $_POST['sparring_name_' . $i], PDO::PARAM_STR);
			$sparring->bindValue("medal", $_POST['sparring_medal_' . $i], PDO::PARAM_STR);
			$sparring->bindValue("age", $_POST['sparring_age_' . $i], PDO::PARAM_STR);
			$sparring->bindValue("gender", $_POST['sparring_gender_' . $i], PDO::PARAM_STR);
			$sparring->bindValue("type", $_POST['sparring_type_' . $i], PDO::PARAM_STR);
			$sparring->bindValue("weight", $_POST['sparring_weight_' . $i], PDO::PARAM_STR);
			$sparring->bindValue("grade_from", $_POST['sparring_grade_from_' . $i], PDO::PARAM_STR);
			$sparring->bindValue("grade_to", $_POST['sparring_grade_to_' . $i], PDO::PARAM_STR);
			
			$sparring->execute();
		}
	}
	
	
	
	
	
	// Power
	// =========================================================

	
	$power_sql = "INSERT INTO results_power (event_id, event_date, name, medal, age, gender, grade_from, grade_to) VALUES (:event_id, :event_date, :name, :medal, :age, :gender, :grade_from, :grade_to)";
	$power = $db->prepare($power_sql);
	
	for ($i = 1; $i <= $power_number; $i++)
	{
		if ($_POST['power_name_' . $i] != null)
		{
			$power->bindValue("event_id", $event_id, PDO::PARAM_STR);
			$power->bindValue("event_date", $event_date, PDO::PARAM_STR);
			$power->bindValue("name", $_POST['power_name_' . $i], PDO::PARAM_STR);
			$power->bindValue("medal", $_POST['power_medal_' . $i], PDO::PARAM_STR);
			$power->bindValue("age", $_POST['power_age_' . $i], PDO::PARAM_STR);
			$power->bindValue("gender", $_POST['power_gender_' . $i], PDO::PARAM_STR);
			$power->bindValue("grade_from", $_POST['power_grade_from_' . $i], PDO::PARAM_STR);
			$power->bindValue("grade_to", $_POST['power_grade_to_' . $i], PDO::PARAM_STR);
			
			$power->execute();
		}
	}

?>

<body>
	Saving...
	<br/>
	You will be redirected soon.
	<script type="text/javascript">
		setTimeout(function() {parent.location.reload(true);},5000);	
	</script>

</body>