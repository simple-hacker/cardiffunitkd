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
		<link rel="stylesheet" type="text/css"href="style/results.css" />
		
		<?php include("includes/db.php"); ?>
</head>

<body>

<?php
	$event_id = $_GET['id'];
	$ordinals = array('th','st','nd','rd','th','th','th','th','th','th','th');
	
	if ($event_id != "")
	{
		$event_sql = "SELECT * FROM events WHERE id = :id";
		$event = $db->prepare($event_sql);
		$event->bindValue("id", $event_id, PDO::PARAM_STR);
		$event->execute();
		$event_result = $event->fetchObject();
		
		echo "<h1>" . $event_result->title . "</h1>";
?>

		<h2>Total</h2>
<?php
		
		// ====================================================================================================
		//  Total
		// ====================================================================================================
		
		$total_sql = "	SELECT SUM(gold) as Gold, SUM(silver) as Silver, SUM(bronze) as Bronze
						FROM (
								SELECT name,
										IF (medal='Gold', 1,0) as gold,
										IF (medal='Silver', 1,0) as silver,
										IF (medal='Bronze', 1,0) as bronze
								FROM results_patterns
								WHERE event_id = :event_id
								UNION ALL
								SELECT name,
										IF (medal='Gold', 1,0) as gold,
										IF (medal='Silver', 1,0) as silver,
										IF (medal='Bronze', 1,0) as bronze
								FROM results_sparring
								WHERE event_id = :event_id
								UNION ALL
								SELECT name,
										IF (medal='Gold', 1,0) as gold,
										IF (medal='Silver', 1,0) as silver,
										IF (medal='Bronze', 1,0) as bronze
								FROM results_power
								WHERE event_id = :event_id
								) as medals";
		
		$total_medals_exec = $db->prepare($total_sql);
		$total_medals_exec->bindValue("event_id", $event_id, PDO::PARAM_STR);
		$total_medals_exec->execute();
		$total_medals = $total_medals_exec->fetchObject();
		
		if (($total_medals->Gold == null) && ($total_medals->Silver == null) && ($total_medals->Bronze == 0))
		{
			echo "No competitors from Cardiff University entered this competition.<br/>";
		}
		else
		{
			echo "<div class='totalMedal Gold'><img src='images/results/Gold.png'/>" . $total_medals->Gold . "</div>";
			echo "<div class='totalMedal Silver'><img src='images/results/Silver.png'/>" . $total_medals->Silver . "</div>";
			echo "<div class='totalMedal Bronze'><img src='images/results/Bronze.png'/>" . $total_medals->Bronze . "</div>";
		}
?>
<?php
		// ====================================================================================================
		//  PATTERNS
		// ====================================================================================================
		
		$patterns_sql = "SELECT * FROM results_patterns WHERE event_id = :event_id ORDER BY grade_to ASC,
						CASE
							WHEN age = 'Veteran' THEN 0
							WHEN age = 'Adult' THEN 1
							WHEN age = '1617' THEN 2
						END,
						CASE
							WHEN gender = 'Mixed' THEN 0
							WHEN gender = 'Male' THEN 1
							WHEN gender = 'Female' THEN 2
						END,
						CASE
							WHEN medal = 'Gold' THEN 0
							WHEN medal = 'Silver' THEN 1
							WHEN medal = 'Bronze' THEN 2
						END";
		$patterns = $db->prepare($patterns_sql);
		$patterns->bindValue("event_id", $event_id, PDO::PARAM_STR);
		$patterns->execute();
		
		if ($patterns->rowCount() > 0)
		{
			echo "<h2>Patterns</h2>";
			
			while($pattern = $patterns->fetchObject())
			{
				echo "<div class='medal'>";
				
					echo "<div class='medalImage'><img src='images/results/" . $pattern->medal . ".png'/></div>";
					
					echo "<span class='medalInformation'>";
					
						echo "<h3>" . $pattern->name . "</h3>";
						
						if ($pattern->age == "1617")
							echo "<p>16-17</p>";
						else
							echo "<p>" . $pattern->age . "</p>";
							
						echo "<p>" . $pattern->gender . "</p>";
						
						$grade_from = $pattern->grade_from;
						$grade_to = $pattern->grade_to;
						
						if (($grade_from != 0) && ($grade_to == 0))
						{
							$grade_to = $grade_from;
						}
						elseif (($grade_to != 0) && ($grade_from == 0))
						{
							$grade_from = $grade_to;
						}
						
						if (($grade_from < 0) && ($grade_to < 0))
						{
							$grade_from *= -1;
							$grade_to *= -1;
							
							if ($grade_from == $grade_to)
							{
								if ($grade_from == 100)
								{
									echo "<p>Black Belts</p>";
									echo "<img src='images/results/" . $grade_to . "dan.png'/>";
								}
								else
								{
									echo "<p>" . $grade_to . $ordinals[$grade_to] . " Dan</p>";
									echo "<img src='images/results/" . $grade_to . "dan.png'/>";
								}
							}
							else
							{
								echo "<p>" . $grade_from . $ordinals[$grade_from] . " Dan to " . $grade_to . $ordinals[$grade_to] . " Dan</p>";
								echo "<img src='images/results/" . $grade_from . "dan.png'/> <img src='images/results/" . $grade_to . "dan.png'/>";
							}
						}
						else
						{
							if ($grade_from == $grade_to)
							{
								echo "<p>" . $grade_to . $ordinals[$grade_to] . " Kup</p>";
								echo "<img src='images/results/" . $grade_to . "kup.png'/>";
							}
							else
							{
								echo "<p>" . $grade_from . $ordinals[$grade_from] . " Kup to " . $grade_to . $ordinals[$grade_to] . " Kup</p>";
								echo "<img src='images/results/" . $grade_from . "kup.png'/> <img src='images/results/" . $grade_to . "kup.png'/>";
							}
						}
					
					echo "</div>";
				
				echo "</div>";
			}
			
		}
?>

<?php
		// ====================================================================================================
		//  Sparring
		// ====================================================================================================
		
		$sparrings_sql = "SELECT * FROM results_sparring WHERE event_id = :event_id ORDER BY grade_to ASC,
						CASE
							WHEN age = 'Veteran' THEN 0
							WHEN age = 'Adult' THEN 1
							WHEN age = '1617' THEN 2
						END,
						CASE
							WHEN gender = 'Male' THEN 0
							WHEN gender = 'Female' THEN 1
						END,
						CASE
							WHEN type = 'Continuous' THEN 0
							WHEN type = 'Point Stop' THEN 1
						END,
						CASE
							WHEN weight = 'all' THEN 0
							WHEN weight = 'heavyweight' THEN 1
							WHEN weight = 'middleweight' THEN 2
							WHEN weight = 'lightweight' THEN 3
							WHEN weight = '85' THEN 4
							WHEN weight = '-85' THEN 5
							WHEN weight = '-78' THEN 6
							WHEN weight = '75' THEN 7
							WHEN weight = '-75' THEN 8
							WHEN weight = '-71' THEN 9
							WHEN weight = '-69' THEN 10
							WHEN weight = '65' THEN 11
							WHEN weight = '-65' THEN 12
							WHEN weight = '-64' THEN 13
							WHEN weight = '-63' THEN 14
							WHEN weight = '-57' THEN 15
							WHEN weight = '-55' THEN 16
							WHEN weight = '-51' THEN 17
							WHEN weight = '-50' THEN 18
							WHEN weight = '-45' THEN 19
						END,
						CASE
							WHEN medal = 'Gold' THEN 0
							WHEN medal = 'Silver' THEN 1
							WHEN medal = 'Bronze' THEN 2
						END";
		$sparrings = $db->prepare($sparrings_sql);
		$sparrings->bindValue("event_id", $event_id, PDO::PARAM_STR);
		$sparrings->execute();
		
		if ($sparrings->rowCount() > 0)
		{
			echo "<h2>Sparring</h2>";
			
			while($sparring = $sparrings->fetchObject())
			{
				echo "<div class='medal'>";
				
					echo "<div class='medalImage Sparring'><img src='images/results/" . $sparring->medal . ".png'/></div>";
					
					echo "<span class='medalInformation'>";
					
						echo "<h3>" . $sparring->name . "</h3>";
						
						if ($sparring->age == "1617")
							echo "<p>16-17</p>";
						else
							echo "<p>" . $sparring->age . "</p>";
							
						echo "<p>" . $sparring->gender . "</p>";
						
						echo "<p>" . $sparring->type . " Sparring</p>";
						
						if (is_numeric($sparring->weight))
						{
							if ($sparring->weight > 0)
							{
								echo "<p>" . $sparring->weight . "+ kg</p>";
							}
							else
							{
								echo "<p>" . $sparring->weight . " kg</p>";
							}
						}
						else
						{
							if ($sparring->weight == "all")
							{
								echo "<p>All Weights</p>";
							}
							else
							{
								echo "<p>" . ucfirst($sparring->weight) . "</p>";
							}
						}
						
						$grade_from = $sparring->grade_from;
						$grade_to = $sparring->grade_to;
						
						if (($grade_from != 0) && ($grade_to == 0))
						{
							$grade_to = $grade_from;
						}
						elseif (($grade_to != 0) && ($grade_from == 0))
						{
							$grade_from = $grade_to;
						}
						
						if (($grade_from < 0) && ($grade_to < 0))
						{
							$grade_from *= -1;
							$grade_to *= -1;
							
							if ($grade_from == $grade_to)
							{
								if ($grade_from == 100)
								{
									echo "<p>Black Belts</p>";
									echo "<img src='images/results/" . $grade_to . "dan.png'/>";
								}
								else
								{
									echo "<p>" . $grade_to . $ordinals[$grade_to] . " Dan</p>";
									echo "<img src='images/results/" . $grade_to . "dan.png'/>";
								}
							}
							else
							{
								echo "<p>" . $grade_from . $ordinals[$grade_from] . " Dan to " . $grade_to . $ordinals[$grade_to] . " Dan</p>";
								echo "<img src='images/results/" . $grade_from . "dan.png'/> <img src='images/results/" . $grade_to . "dan.png'/>";
							}
						}
						else
						{
							if ($grade_from == $grade_to)
							{
								echo "<p>" . $grade_to . $ordinals[$grade_to] . " Kup</p>";
								echo "<img src='images/results/" . $grade_to . "kup.png'/>";
							}
							else
							{
								echo "<p>" . $grade_from . $ordinals[$grade_from] . " Kup to " . $grade_to . $ordinals[$grade_to] . " Kup</p>";
								echo "<img src='images/results/" . $grade_from . "kup.png'/> <img src='images/results/" . $grade_to . "kup.png'/>";
							}
						}
					
					echo "</div>";
				
				echo "</div>";
			}
		}
?>

<?php
		// ====================================================================================================
		//  Power
		// ====================================================================================================
		
		$powers_sql = "SELECT * FROM results_power WHERE event_id = :event_id ORDER BY grade_to ASC,
						CASE
							WHEN age = 'Veteran' THEN 0
							WHEN age = 'Adult' THEN 1
							WHEN age = '1617' THEN 2
						END,
						CASE
							WHEN gender = 'Male' THEN 0
							WHEN gender = 'Female' THEN 1
						END,
						CASE
							WHEN medal = 'Gold' THEN 0
							WHEN medal = 'Silver' THEN 1
							WHEN medal = 'Bronze' THEN 2
						END";
		$powers = $db->prepare($powers_sql);
		$powers->bindValue("event_id", $event_id, PDO::PARAM_STR);
		$powers->execute();
		
		if ($powers->rowCount() > 0)
		{
			echo "<h2>Power</h2>";
			
			while($power = $powers->fetchObject())
			{
				echo "<div class='medal'>";
				
					echo "<div class='medalImage'><img src='images/results/" . $power->medal . ".png'/></div>";
					
					echo "<span class='medalInformation'>";
					
						echo "<h3>" . $power->name . "</h3>";
						
						if ($power->age == "1617")
							echo "<p>16-17</p>";
						else
							echo "<p>" . $power->age . "</p>";
							
						echo "<p>" . $power->gender . "</p>";
						
						
						$grade_from = $power->grade_from;
						$grade_to = $power->grade_to;
						
						if (($grade_from != 0) && ($grade_to == 0))
						{
							$grade_to = $grade_from;
						}
						elseif (($grade_to != 0) && ($grade_from == 0))
						{
							$grade_from = $grade_to;
						}
						
						if (($grade_from < 0) && ($grade_to < 0))
						{
							$grade_from *= -1;
							$grade_to *= -1;
							
							if ($grade_from == $grade_to)
							{
								if ($grade_from == 100)
								{
									echo "<p>Black Belts</p>";
									echo "<img src='images/results/" . $grade_to . "dan.png'/>";
								}
								else
								{
									echo "<p>" . $grade_to . $ordinals[$grade_to] . " Dan</p>";
									echo "<img src='images/results/" . $grade_to . "dan.png'/>";
								}
							}
							else
							{
								echo "<p>" . $grade_from . $ordinals[$grade_from] . " Dan to " . $grade_to . $ordinals[$grade_to] . " Dan</p>";
								echo "<img src='images/results/" . $grade_from . "dan.png'/> <img src='images/results/" . $grade_to . "dan.png'/>";
							}
						}
						else
						{
							if ($grade_from == $grade_to)
							{
								echo "<p>" . $grade_to . $ordinals[$grade_to] . " Kup</p>";
								echo "<img src='images/results/" . $grade_to . "kup.png'/>";
							}
							else
							{
								echo "<p>" . $grade_from . $ordinals[$grade_from] . " Kup to " . $grade_to . $ordinals[$grade_to] . " Kup</p>";
								echo "<img src='images/results/" . $grade_from . "kup.png'/> <img src='images/results/" . $grade_to . "kup.png'/>";
							}
						}
						
					
					echo "</div>";
				
				echo "</div>";
			}
		}
?>

<?php		
	}
	else
	{
		echo "No such event.  Please make sure you click on the correct button.";
	}
?>

</body>

</html>