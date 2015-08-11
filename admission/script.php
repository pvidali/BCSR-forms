<?php
	ini_set("display_errors","On");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

function get_recruiter($zip, $state, $country, $db) {
	// JOIN 
	if ($zip != ""){
		$sql = "SELECT 
					a.territory_id, a.pcode, a.state, 
					b.id, b.admission_territories_zone, b.admission_territories, 
					c.admission_recruiter, c.admission_territory_zone, 
					d.fname, d.lname, d.email, d.phone, d.redir, d.fields_recruiter, d.image, d.gender, d.id 
				FROM admission_territories_pcode a, admission_territory_zones b, admission_recruiter_territory c, admission_recruiter d 
				WHERE a.pcode = '$zip' AND a.territory_id = b.admission_territories AND c.admission_territory_zone = b.admission_territories_zone AND c.admission_recruiter = d.id";
	}
	elseif($state != "") {
		$state = strtoupper($state);

		// NEED A NON-ZIP HAVE FOR NY AND PA
		if ($state == "NY"){
			// set to Joel
			 $state = "NYO";
		}
		if($state == "PA"){
			 $state = "PAW";
		}

		$sql = "SELECT 
					a.territory_id, a.pcode, a.state, 
					b.id, b.admission_territories_zone, b.admission_territories, 
					c.admission_recruiter, c.admission_territory_zone, 
					d.fname, d.lname, d.email, d.phone, d.redir, d.fields_recruiter, d.image, d.gender, d.id 
				FROM admission_territories_pcode a, admission_territory_zones b, admission_recruiter_territory c, admission_recruiter d 
				WHERE a.state = '$state' AND a.territory_id = b.admission_territories AND c.admission_territory_zone = b.admission_territories_zone AND c.admission_recruiter = d.id";
	}
	elseif($country != "") {
		// SEMI-HACK TO SET ALL NON-US TO ZONE 5
		$zone = '5';
		$sql = "SELECT 
					a.admission_recruiter, a.admission_territory_zone, 
					b.fname, b.lname, b.email, b.phone, b.redir, b.fields_recruiter, b.image, b.gender, b.id 
				FROM admission_recruiter_territory a, admission_recruiter b 
				WHERE a.admission_territory_zone = '$zone' AND a.admission_recruiter = b.id";
	}
	$db->do_query($sql);
	if($db->numRows()!=0){
		$result = $db->fetchObject();
	
		$counsInfo['fname'] 			= $result->fname;
		$counsInfo['lname'] 			= $result->lname;
		$counsInfo['email'] 			= $result->email;
		$counsInfo['phone'] 			= $result->phone;
		$counsInfo['redir']	 			= $result->redir;
		$counsInfo['image'] 			= $result->image;
		$counsInfo['fields_recruiter'] 	= $result->fields_recruiter;
		$counsInfo['doRedir'] = true;
		$counsInfo['recruiter_email_handle'] = $counsInfo['email']."@simons-rock.edu";
	
		$redirStr  = "http://www.simons-rock.edu/admission/";
		$redirStr .= $counsInfo['redir'];
		$redirStr .= "/";
		$counsInfo['redirStr'] = $redirStr;
		return $counsInfo;
	}
	else {
		return false;
	}
}

$zip = "";
$state = "";
$country = "";
if(isset($_REQUEST['zip']) && $_REQUEST['zip'] != ""){
	$zip = $_REQUEST['zip'];
}
if(isset($_REQUEST['state']) && $_REQUEST['state'] != ""){
	$state = $_REQUEST['state'];
}
if(isset($_REQUEST['country']) && $_REQUEST['country'] != ""){
	$country = $_REQUEST['country'];
}
if(!($zip=="" && $state=="" && $country == "")){
	if($country == ""){
		// THIS HACK IS UNTIL NON-US COUNTRIES ARE DIVIDED INTO MORE THAN ONE RECRUITER, FOR NOW THEY ARE ALL ONE, SO JUST PASS SOMETHING IN
		$country = 1;
	}

	$cinfo = get_recruiter($zip,$state,$country,$db);
	if(!$cinfo){
		echo "No location.";
	}
	else {
		print_r($cinfo);
	}
}

?>