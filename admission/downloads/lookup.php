<?php

require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$sql = "SELECT * FROM forms.summer_program_class_registration ORDER BY id DESC";
$db->do_query($sql);
$x = 1;
while($row = $db->fetchObject()){
	$contact_id = $row->contact_id;
	$class_id = $row->class_id;
	$payer_id = $row->payer_id;
	$paid_for = $row->paid_for;
	
	echo("$x: contact_id: $contact_id, class_id: $class_id, payer_id: $payer_id, paid_for: $paid_for<br />");
	$x++;
}
?>