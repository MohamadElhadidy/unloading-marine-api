<?php
date_default_timezone_set("Africa/Cairo");

$con = mysqli_connect("localhost","user","password","unloading");

if (!$con) {die("Connection failed: " . mysqli_connect_error());}

?>