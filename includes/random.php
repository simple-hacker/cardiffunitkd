<?php

$intPics = 6; // Number of pics to choose from.

// Generate Random number between 0 and intPics
srand((double)microtime()*1000000); 
$pic = rand(1,$intPics); 

// Get the file name
$cache_file = "../images/banner".$pic.".jpg";   

// Change header information
header("Content-Type: image/jpeg");
header("Content-Length: ".filesize($cache_file));

// Stream File
$cache = fopen($cache_file,"r");
fpassthru($cache);
fclose($cache);

exit;
?>
