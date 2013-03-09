<?php

//
// Database schema:
//  Table: gps
//   id
//   phone_id
//   loc
//   altitude
//	 accuracy
//   altitudeAccuracy
//   heading
//   speed
//   location_time
//   time
//
//  Table: phones
//   phone_id
//   email
//   time
//    

include_once('auth.php');

function dbConnect()
{
	$db = mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASSWORD);
	mysql_select_db($MYSQL_DATABASE, $db);

	return $db;	
}

function noCache()
{
	// Do not cache
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
}

?>