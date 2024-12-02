<?php
date_default_timezone_set("Asia/Kolkata");
echo filemtime("uploadscript.php");
echo "<br>";
echo "Content last changed: ".date("F d Y h:i A.", filemtime("uploadscript.php"));
?>