<?php

require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();
$db2 = new DB(HOST,USER,PASSWORD,DATABASE);
$db2->connect();
$db3 = new DB(HOST,USER,PASSWORD,DATABASE);
$db3->connect();


$payer_id = 37;

$cids = array();
$classids = array();
$studentClassRows = "";
$sql = "SELECT * FROM forms.summer_program_class_registration WHERE payer_id=$payer_id";
$db->do_query($sql);
while($row = $db->fetchObject()){
	$cid = $row->contact_id;
	$classid = $row->class_id;
	$sql2 = "SELECT * FROM forms.summer_program_class WHERE id=$classid";
	$db2->do_query($sql2);
	while($row2 = $db2->fetchObject()){
		$thisTitle = $row2->title;
	}
	$sql2 = "SELECT * FROM forms.summer_program_contact WHERE id=$cid";
	echo ("$sql2<br />");
	$db3->do_query($sql2);
	while($row3 = $db3->fetchObject()){
		$applicant = $row3->applicant_name;
		echo("NAME: $applicant<br />");
	}
	$studentClassRows .= "$applicant: $thisTitle\n";
}

// mail to jenny
$sql = "SELECT * FROM forms.summer_program_contact WHERE id='$cid' LIMIT 1";
$db->do_query($sql);
$row = $db->fetchObject();
$permaddress_street	= $row->permaddress_street;
$permaddress_city	= $row->permaddress_city;
$permaddress_state	= $row->permaddress_state;
$permaddress_zip	= $row->permaddress_zip;
$permaddress_phone	= $row->permaddress_phone;
$guardian_name		= $row->guardian_name;
$guardian_phone_day = $row->guardian_phone_day;
$student_email		= $row->student_email;
$parent_email		= $row->parent_email;
$gradelevel_2012	= $row->gradelevel_2012;

$msg = "";
$msg .= "SUMMER PROGRAM REGISTRATION -- SUCCESSFUL PAYPAL PAYMENT\n\n";
$msg .= "        Guardian Name: $guardian_name\n";
$msg .= "       Guardian Phone: $guardian_phone_day\n\n";
$msg .= "       -----ADDRESS INFO-----\n\n";
$msg .= "               Street: $permaddress_street\n";
$msg .= "                 City: $permaddress_city\n";
$msg .= "                State: $permaddress_state\n";
$msg .= "                  Zip: $permaddress_zip\n";
$msg .= "                Phone: $permaddress_phone\n\n";
$msg .= "        Student Email: $student_email\n";
$msg .= "         Parent Email: $parent_email\n\n";
$msg .= "       -----CLASS INFO-----\n\n";
$msg .= $studentClassRows;	

//		mail("jbrowdy@simons-rock.edu","SUMMER PROGRAM REGISTRATION--PAYPAL",$msg);
echo "MSG:";
echo($msg);

//mail("dscheff@simons-rock.edu","SUMMER PROGRAM REGISTRATION--PAYPAL",$msg);
		
?>