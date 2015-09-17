<?php
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";

// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$state = $_REQUEST['state'];
$country = $_REQUEST['country'];

//getTerritoryInfoDB($state,$country,$db);
/*
	$counsInfo['fname'] 			= $result->fname;
	$counsInfo['lname'] 			= $result->lname;
	$counsInfo['email'] 			= $result->email;
	$counsInfo['phone'] 			= $result->phone;
	$counsInfo['redir']	 			= $result->redir;
	$counsInfo['image'] 			= $result->image;
	$counsInfo['fields_recruiter'] 	= $result->fields_recruiter;
*/

$territoryInfo = getTerritoryInfoDB($state,$country,$db);
$image = $territoryInfo['image'];
$fname = $territoryInfo['fname'];
$lname = $territoryInfo['lname'];
echo "$fname&$lname&$image";
?>
