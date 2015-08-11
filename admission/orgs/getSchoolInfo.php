<?php
define( "HOST", "localhost");
define( "USER", "webuser");
define( "PASSWORD", "bab020211f");
define( "DATABASE","forms");

include "DB.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$schoolName = urldecode($_REQUEST['schoolName']);

$sql = "SELECT * FROM orgs WHERE name = '$schoolName'" ;
$db->do_query($sql);

while( $row = $db->fetchObject() ){
	$ceeb		= $row->ceeb;
	$city		= $row->city;
	$state		= $row->state;
	$country	= $row->country;
	$zip		= $row->zip;
	$recruiter	= $row->recruiter;
}
$schoolInfo = "CEEB=$ceeb*CITY=$city*STATE=$state*COUNTRY=$country*ZIP=$zip*RECRUITER=$recruiter";
	
echo $schoolInfo;