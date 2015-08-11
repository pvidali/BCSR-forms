<?php

require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$state = $_REQUEST['state'];
$counsInfo = getTerritoryInfoDB($state,'',$db);
print_r ($counsInfo);
?>