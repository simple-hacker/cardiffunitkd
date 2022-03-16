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
	$name = urldecode($_GET['name']);
	$ordinals = array('th','st','nd','rd','th','th','th','th','th','th','th');
	
	if ($event_id != "")
	{
		$event_sql = "SELECT * FROM events WHERE id = :id";
		$event = $db->prepare($event_sql);
		$event->bindValue("id", $event_id, PDO::PARAM_STR);
		$event->execute();
		$event_result = $event->fetchObject();
?>
		<h1><?php echo $event_result->title; ?></h1>
		<h1><?php echo $name; ?></h1>
		
<?php
		// ====================================================================================================
		//  PATTERNS
		// ====================================================================================================
		
		$patterns_sql = "SELECT * FROM results_patterns WHERE event_id = :event_id AND name=:name";
		$patterns = $db->prepare($patterns_sql);
		$patterns->bindValue("event_id", $event_id, PDO::PARAM_STR);
		$patterns->bindValue("name", $name, PDO::PARAM_STR);
		$patterns->execute();
		
		if ($patterns->rowCount() > 0)
		{
			echo "<h2>Patterns</h2>";
			
			while($pattern = $patterns->fetchObject())
			{
				echo "<div class='medal'>";
				
					echo "<div class='medalImage'><img src='images/results/" . $pattern->medal . ".png'/></div>";
					
					echo "<span class='medalInformation'>";
					
						
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
		
		$sparrings_sql = "SELECT * FROM results_sparring WHERE event_id = :event_id AND name=:name";
		$sparrings = $db->prepare($sparrings_sql);
		$sparrings->bindValue("event_id", $event_id, PDO::PARAM_STR);
		$sparrings->bindValue("name", $name, PDO::PARAM_STR);
		$sparrings->execute();
		
		if ($sparrings->rowCount() > 0)
		{
			echo "<h2>Sparring</h2>";
			
			while($sparring = $sparrings->fetchObject())
			{
				echo "<div class='medal'>";
				
					echo "<div class='medalImage Sparring'><img src='images/results/" . $sparring->medal . ".png'/></div>";
					
					echo "<span class='medalInformation'>";
						
						if ($sparring->age == "1617")
							echo "<p>16-17</p>";
						else
							echo "<p>" . $sparring->age . "</p>";
							
						echo "<p>" . $sparring->gender . "</p>";
						
						echo "<p>" . $sparring->type . "</p>";
						
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
		
		$powers_sql = "SELECT * FROM results_power WHERE event_id = :event_id AND name=:name";;
		$powers = $db->prepare($powers_sql);
		$powers->bindValue("event_id", $event_id, PDO::PARAM_STR);
		$powers->bindValue("name", $name, PDO::PARAM_STR);
		$powers->execute();
		
		if ($powers->rowCount() > 0)
		{
			echo "<h2>Power</h2>";
			
			while($power = $powers->fetchObject())
			{
				echo "<div class='medal'>";
				
					echo "<div class='medalImage'><img src='images/results/" . $power->medal . ".png'/></div>";
					
					echo "<span class='medalInformation'>";
											
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