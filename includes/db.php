<?php
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "cutkd";
  
	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');

	mysql_select_db($dbname);
	
	
	$host = 'localhost';
	$port = 3306; // This is the default port for MySQL
	$database = 'cutkd';
	$dsn = "mysql:host=$host;port=$port;dbname=$database";
	// Connect!
	$db = new PDO($dsn, $dbuser, $dbpass);
?>