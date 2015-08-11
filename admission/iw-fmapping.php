<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
require_once($_SERVER['DOCUMENT_ROOT']."/admission/includes/iw-fields/functions.php");

$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$fetchFields = array('fname','lname');
$fields = array();
$fname = "Testname";
$lname = "TestLast";

foreach($fetchFields as $field){
//		$fields[$field]['iw_formfield_name'] = $k;
//		$fields[$field]['iw_post_varname'] = $v;
	$iw_formfield_name = iw_fieldmap_name($db,$field);
	$thisfieldvalue = $$field;
	echo "<input type=\"text\" name=\"$iw_formfield_name\" value=\"$thisfieldvalue\" />";
}

