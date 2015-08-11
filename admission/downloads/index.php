<?php

/*** begin our session ***/
session_start();

function is_odd( $int ) {
  return( $int & 1 );
}

/*** check if the users is already logged in ***/
if(!isset( $_SESSION['user_id'] ))
{
	
?>	
<html>
<head>
<title>Summer Program 2012 Reports</title>
<style>
.rowOther {
	background-color: #CCC;
}
</style>
</head>
<body>	
<p>You must be logged in to perform this action.</p>	
<p><a href="login.php">Login Here</a></p>
<?php } 
else {
	$list = array();
	$list[] = array('id','form_id','firstname','middlename','lastname','nickname','email','role','gender','street_address','street_address_2','city','state','country','postal_code','phone','dob','high_school','high_school_city','high_school_state','high_school_country','anticipated_grad_year','academic_interests','extra_curricular','three_words','ethnicity','reference','mail_list','`call`','comment','date_submitted','vr_email','vr_campaign','vr_term','hash_id','parent1_fname','parent1_lname','parent1_relationship','parent1_email','parent1_phone','parent1_phonetype','parent2_fname','parent2_lname','parent2_relationship','parent2_email','parent2_phone','parent2_phonetype','dup_flag','typage_wedcall','typage_thcall','typage_question','counselor');
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
	$db = new DB(HOST,USER,PASSWORD,DATABASE);
	$db->connect();
	$sql = "SELECT * FROM forms.admission_form_submission ORDER BY id DESC";
	$db->do_query($sql);
	$thisRow = array();
	while($row = $db->fetchArray()){
		$counter = 0;
		unset($thisRow);
		foreach($row as $item){
			if(is_odd($counter)){
				$item = preg_replace( '/\r\n/', ' ', trim($item) );
				$thisRow[] = $item;
			}
			$counter++;
		}
		$list[] = $thisRow;
	}
	$fp = fopen('export.csv', 'w+');
	foreach ($list as $fields) {
		fputcsv($fp, $fields);
	}
	fclose($fp);
?>
<html>
<head>
<title>Info Requests</title>
<style>
.rowOther {
	background-color: #CCC;
}
</style>
</head>
<body>
<p>

<p>You are now logged in.</p>
<p><a href="export.csv" target="_blank">Download</a></p>
<? } ?>
</body>
</html>
