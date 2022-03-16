<?php include("includes/header.php"); ?>
<?php include("includes/db.php"); ?>

<script type="text/javascript">document.title = "Cardiff University Taekwon-Do | Results"</script>

<h1>Individual Results<?php if ($_GET['name'] != null) echo " - " . $_GET['name']; ?></h1>

<div id="results">

<?php 	
	if ($_GET['name'] != null)
	{
		$total_sql = "	SELECT SUM(gold) as Gold, SUM(silver) as Silver, SUM(bronze) as Bronze
								FROM (
										SELECT name,
												IF (medal='Gold', 1,0) as gold,
												IF (medal='Silver', 1,0) as silver,
												IF (medal='Bronze', 1,0) as bronze
										FROM results_patterns
										WHERE name=:name
										UNION ALL
										SELECT name,
												IF (medal='Gold', 1,0) as gold,
												IF (medal='Silver', 1,0) as silver,
												IF (medal='Bronze', 1,0) as bronze
										FROM results_sparring
										WHERE name=:name
										UNION ALL
										SELECT name,
												IF (medal='Gold', 1,0) as gold,
												IF (medal='Silver', 1,0) as silver,
												IF (medal='Bronze', 1,0) as bronze
										FROM results_power
										WHERE name=:name
										) as medals";
		
		$total_medals_exec = $db->prepare($total_sql);
		//$total_medals_exec->bindValue("event_date_from", $dateFrom, PDO::PARAM_STR);
		//$total_medals_exec->bindValue("event_date_to", $dateTo, PDO::PARAM_STR);
		$total_medals_exec->bindValue("name", urldecode($_GET['name']), PDO::PARAM_STR);
		$total_medals_exec->execute();
		$total_medals = $total_medals_exec->fetchObject();
?>
		<div class="slider">
			<h1>Total</h1>
		</div>
		<div class='totalMedal Gold'><img src='images/results/Gold.png'/><?php echo $total_medals->Gold; ?></div>
		<div class='totalMedal Silver'><img src='images/results/Silver.png'/><?php echo $total_medals->Silver; ?></div>
		<div class='totalMedal Bronze'><img src='images/results/Bronze.png'/><?php echo $total_medals->Bronze; ?></div>
<?php

		$yearStart = 2009;
		for ($year = date("Y"); $year >= $yearStart; $year--)
		{			
			$dateFrom = date("Y-m-d", mktime(0,0,0,9,1,$year));
			$dateTo = date("Y-m-d", mktime(0,0,0,8,31,($year+1)));
			
			$query = "	SELECT	events.id, events.startdate, events.title, medals.name
						FROM 	(
								SELECT event_id, name FROM results_patterns WHERE name=:name AND event_date >= :dateFrom AND event_date <= :dateTo
								UNION
								SELECT event_id, name FROM results_sparring WHERE name=:name AND event_date >= :dateFrom AND event_date <= :dateTo
								UNION
								SELECT event_id, name FROM results_power WHERE name=:name AND event_date >= :dateFrom AND event_date <= :dateTo
								) as medals, events
						WHERE	medals.event_id = events.id
						ORDER BY events.startdate DESC";

			$results = $db->prepare($query);
			$results->bindValue("name", urldecode($_GET['name']), PDO::PARAM_STR);
			$results->bindValue("dateFrom", $dateFrom, PDO::PARAM_STR);
			$results->bindValue("dateTo", $dateTo, PDO::PARAM_STR);
			$results->execute();
			
			if ($results->rowCount() != 0)
			{
				$total_sql = "	SELECT SUM(gold) as Gold, SUM(silver) as Silver, SUM(bronze) as Bronze
								FROM (
										SELECT name,
												IF (medal='Gold', 1,0) as gold,
												IF (medal='Silver', 1,0) as silver,
												IF (medal='Bronze', 1,0) as bronze
										FROM results_patterns
										WHERE event_date >= :event_date_from AND event_date <= :event_date_to AND name=:name
										UNION ALL
										SELECT name,
												IF (medal='Gold', 1,0) as gold,
												IF (medal='Silver', 1,0) as silver,
												IF (medal='Bronze', 1,0) as bronze
										FROM results_sparring
										WHERE event_date >= :event_date_from AND event_date <= :event_date_to AND name=:name
										UNION ALL
										SELECT name,
												IF (medal='Gold', 1,0) as gold,
												IF (medal='Silver', 1,0) as silver,
												IF (medal='Bronze', 1,0) as bronze
										FROM results_power
										WHERE event_date >= :event_date_from AND event_date <= :event_date_to AND name=:name
										) as medals";
		
				$total_medals_exec = $db->prepare($total_sql);
				$total_medals_exec->bindValue("event_date_from", $dateFrom, PDO::PARAM_STR);
				$total_medals_exec->bindValue("event_date_to", $dateTo, PDO::PARAM_STR);
				$total_medals_exec->bindValue("name", urldecode($_GET['name']), PDO::PARAM_STR);
				$total_medals_exec->execute();
				$total_medals = $total_medals_exec->fetchObject();
				
				$currentRow = 0;
?>
				<div class="slider">
					<h1><?php echo $year . "/" . ($year + 1); ?></h1>

					<div class="sliderContent">
			
						<div class='totalMedal Gold'><img src='images/results/Gold.png'/><?php echo $total_medals->Gold; ?></div>
						<div class='totalMedal Silver'><img src='images/results/Silver.png'/><?php echo $total_medals->Silver; ?></div>
						<div class='totalMedal Bronze'><img src='images/results/Bronze.png'/><?php echo $total_medals->Bronze; ?></div>
<?php						
					while($result = $results->fetchObject())
					{
						$currentRow++;
?>
						<div class="result <?php if ($currentRow % 2 == 1) { echo 'altRow'; } ?>">
							<div class="resultDate"><?php echo date("d/m/Y", strtotime($result->startdate)); ?></div>
							<div class="resultCategory">
								&nbsp;
							</div>
							<a href="individual_result.php?id=<?php echo $result->id; ?>&name=<?php echo urlencode($_GET['name']); ?>" class="fb-result"><?php echo $result->title; ?></a>
						</div>
<?php
					}
?>
					</div>
				</div>
<?php
			}
		}
	}
	else
	{
		echo "Please provide a name by clicking on a name from the Hall of Fame";
	}
?>
	
</div>

<?php include("includes/footer.php"); ?>