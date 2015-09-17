<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$formId = 2;
// 685000007028041, 64
$formid = '685000007028041';
$seed = 64; // get from z value in IW form code

$postArray['email'] = $_REQUEST['email'];
$postArray['three_words'] = $_REQUEST['question'];


include $_SERVER['DOCUMENT_ROOT']."/includes/iw-curl.php";

?>