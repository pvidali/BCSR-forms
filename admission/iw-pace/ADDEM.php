<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$addCountries = array(
"AA",
"AE",
"AP",
"AB",
"AS",
"CNMI",
"GU",
"MB",
"MH",
"PR",
"VI",
"NB",
"NF",
"NT",
"NS",
"ON",
"PE",
"QB",
"SK",
"YT");

//$addZones = 251;

foreach ($addCountries as $country){
	$sql = "INSERT INTO admission_territories (territory) VALUES (\"$country\")";
	$db->do_query($sql);
}