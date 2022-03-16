<?php include("includes/header.php"); ?>
<?php include("includes/db.php"); ?>

<script type="text/javascript">document.title = "Cardiff University Taekwon-Do | Results | Hall of Fame"</script>

	<h1>Hall of Fame</h1>
	
	<div id="halloffame">
<?php
	$hof_sql = "SELECT name, SUM(gold) as Gold, SUM(silver) as Silver, SUM(bronze) as Bronze, SUM((gold * 3) + (silver * 2) + bronze) as Points, SUM(gold + silver + bronze) as MedalCount
				FROM (
						SELECT name,
								IF (medal='Gold', 1,0) as gold,
								IF (medal='Silver', 1,0) as silver,
								IF (medal='Bronze', 1,0) as bronze
						FROM results_patterns
						UNION ALL
						SELECT name,
								IF (medal='Gold', 1,0) as gold,
								IF (medal='Silver', 1,0) as silver,
								IF (medal='Bronze', 1,0) as bronze
						FROM results_sparring
						UNION ALL
						SELECT name,
								IF (medal='Gold', 1,0) as gold,
								IF (medal='Silver', 1,0) as silver,
								IF (medal='Bronze', 1,0) as bronze
						FROM results_power
						) as medals
				GROUP BY name
				ORDER BY Points DESC, Gold DESC, Silver DESC, Bronze DESC, MedalCount DESC, name ASC";
	
	$hof_result = $db->prepare($hof_sql);
	$hof_result->execute();
?>
	
		<div class="hof" style="border: none;">
			<div class="name">&nbsp;</div>		
			<div class="medal"><img src='images/results/Gold.png'/></div>
			<div class="medal"><img src='images/results/Silver.png'/></div>
			<div class="medal"><img src='images/results/Bronze.png'/></div>
			<div class="medal">Total<br/>Points<br/></div>
			<div class="medal">Medal<br/>Count<br/></div>
		</div>
<?php
		if ($hof_result->rowCount() > 1)
		{
			$currentRow = 0;
			while($hof = $hof_result->fetchObject())
			{
?>
				<div class="hof<?php if ($currentRow % 2 == 0) echo ' altRow'; ?>">
					<div class="name"><a href="individual_results.php?name=<?php echo urlencode($hof->name); ?>"><?php echo $hof->name; ?></a></div>
					<div class="medal Gold"><?php echo $hof->Gold; ?></div>
					<div class="medal Silver"><?php echo $hof->Silver; ?></div>
					<div class="medal Bronze"><?php echo $hof->Bronze; ?></div>
					<div class="medal Points"><?php echo $hof->Points; ?></div>
					<div class="medal MedalCount"><?php echo $hof->MedalCount; ?></div>
				</div>
<?php
				$currentRow++;
			}
		}
		else
		{
			echo "There are no medals.";
		}
?>
	</div>

<?php include("includes/footer.php"); ?>