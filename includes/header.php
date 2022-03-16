<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
        <!-- 
			Cardiff University Taekwon-Do
        -->
<head>       
        <!-- Meta Tags -->
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
	
        <!-- CSS -->
        <link rel="stylesheet" href="./style/style.css" type="text/css" media="screen" />
		
		<!-- jQuery -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		
		
        <!-- Shortcut Icon -->
        <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon" />

		<!-- Title -->
		<title>Cardiff University Taekwon-Do</title>
		
		
		<!-- Twitter -->
		<link rel="stylesheet" href="code/twitter/jquery.twitter.css" type="text/css" />
		<script src="code/twitter/jquery.twitter.js" type="text/javascript"></script>
		
		<!-- fancyBox -->
		<script type="text/javascript" src="code/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script> <!-- Add mousewheel plugin (this is optional) -->
		<link rel="stylesheet" href="code/fancybox/source/jquery.fancybox.css?v=2.0.4" type="text/css" media="screen" />
		<script type="text/javascript" src="code/fancybox/source/jquery.fancybox.pack.js?v=2.0.4"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			$(".fancybox").fancybox({
				loop 			: false,
				nextEffect	: 'fade',
				prevEffect	: 'fade'
			});
		});
		
		//Properties for a various fancyBox
			$(document).ready(function() {
			$(".various").fancybox({
				type 			: 'iframe',
				maxWidth	: 800,
				maxHeight	: 600,
				fitToView	: true,
				width		: '70%',
				height		: '70%',
				autoSize	: true,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
		
		//Use variousSmall for events and forms
		$(document).ready(function() {
			$(".fb-small").fancybox({
				type 		: 'iframe',
				fitToView	: false,
				width		: 700,
				height		: 500,
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
		
		$(document).ready(function() {
			$(".fb-result").fancybox({
				type 		: 'iframe',
				fitToView	: false,
				width		: 700,
				height		: 600,
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
		
		$(document).ready(function() {
			$(".youtube").fancybox({
				type 		: 'iframe',
				maxWidth	: 800,
				maxHeight	: 600,
				fitToView	: true,
				width		: '70%',
				height		: '70%',
				autoSize	: true,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
		
		$(document).ready(function() {
			$(".slider h1").click(function(){
			$(this).next('.sliderContent').slideToggle("medium");
			});
		});
		
		$(document).ready(function() {
			$(".slider .resultTitle").click(function(){
			$(this).next('.sliderContent').slideToggle("medium");
			});
		});
		</script>

		
		

</head>

<body>


<div id="pageContainer">

	<div id="banner"></div>
	<!-- CHANGE STYLE SHEET RANDOM2.PHP TO RANDOM.PHP -->


	<div id="navigation">
		<ul>
			<li><a href="./">I. News</a></li>
			<li><a href="./training">II. Training</a></li>
			<li><a href="./events">III. Events</a></li>
			<li><a href="./results">IV. Results</a></li>
			<!--<li><a href="./theory.php">V. Theory</a></li>-->
			<!-- MAKE SURE ROMAN NUMERALS LINE UP IN UNCOMMENT -->
			<li><a href="./gallery">V. Gallery</a></li>
			<li><a class="small" href="http://www.facebook.com/groups/26237096291/"><img src="./images/fb.jpg" alt="Facebook Group"/></a></li>
			<li><a class="small" href="https://twitter.com/#!/CardiffUniTKD"><img src="./images/twitter.png" alt="Twitter"/></a></li>
		</ul>
	</div>

	
	<div id="pageContent">
