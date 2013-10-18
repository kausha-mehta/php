<?php

@error_reporting(0);

$ARR_CFGS["db_host"] = 'localhost';
$ARR_CFGS["db_name"] = 'php_pagination';
$ARR_CFGS["db_user"] = 'root';
$ARR_CFGS["db_pass"] = '';

define('DEF_PAGE_SIZE', 10);
@extract($_POST);
@extract($_GET);
ob_start();
@session_start();

require_once("function.php");


// magic_quotes_gpc needs to be "on"
if(!get_magic_quotes_gpc()) {
	$_GET		= ms_addslashes($_GET);
	$_POST		= ms_addslashes($_POST);
	$_COOKIE	= ms_addslashes($_COOKIE);
} else {
	$_GET		= ms_trim($_GET);
	$_POST		= ms_trim($_POST);
	$_COOKIE	= ms_trim($_COOKIE);
}


connect_db(); //	Connect To Data Base



// Create Database IF Not Exist
mysql_query("CREATE DATABASE IF NOT EXISTS `php_pagination`");


//	Create table If Not Exist
mysql_query("CREATE TABLE IF NOT EXISTS `php_pagination`.`user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `add_date` date NOT NULL,
  `mod_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = INNODB");



?>