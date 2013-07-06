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
//   email_time
//    

include_once('auth.php');

$BASE_URL = 'http://gps.asrc.net/';
$TIME_ZONE = 'US/Eastern';

function dbConnect()
{
	$db = new mysqli($GLOBALS['MYSQL_HOST'], $GLOBALS['MYSQL_USER'], $GLOBALS['MYSQL_PASSWORD'], $GLOBALS['MYSQL_DATABASE']);
	$db->query("SET time_zone='". $GLOBALS['TIME_ZONE'] . "'"); // Set local time zone
	return $db;
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

/*
 * Detailed Database Structure
 *

CREATE TABLE IF NOT EXISTS `gps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_id` int(11) NOT NULL,
  `loc` varchar(64) DEFAULT NULL,
  `altitude` double DEFAULT NULL,
  `accuracy` double DEFAULT NULL,
  `altitudeAccuracy` double DEFAULT NULL,
  `heading` double DEFAULT NULL,
  `speed` double DEFAULT NULL,
  `location_time` timestamp NULL DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `phones` (
  `phone_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `email_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`phone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

 */

?>