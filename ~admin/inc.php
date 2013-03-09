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
	return new mysqli($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASSWORD, $MYSQL_DATABASE);
}

function noCache()
{
	// Do not cache
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
}

function base64url_encode($data)
{
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
}

function base64url_decode($data)
{
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
}

?>