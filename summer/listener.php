<?php

require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();
$db2 = new DB(HOST,USER,PASSWORD,DATABASE);
$db2->connect();
$db3 = new DB(HOST,USER,PASSWORD,DATABASE);
$db3->connect();
include('IpnListener.php');

$listener = new IpnListener();
$listener->use_sandbox = false;

try {
    $verified = $listener->processIpn();
} catch (Exception $e) {
    // fatal error trying to process IPN.
    exit(0);
}

$emlstr = "";
foreach($_POST as $k => $v){
	$emlstr .= "$k = $v ,<br />\n";
}

if ($verified) {
//	mail("dscheff@simons-rock.edu","POST",$emlstr);

	$errmsg = '';   // stores errors from fraud checks
    
    if ($_POST['payment_status'] != 'Completed') { 
        // simply ignore any IPN that is not completed
		mail("dscheff@simons-rock.edu","payment_status","not completed");
        exit(0); 
    }

    // 2. Make sure seller email matches your primary account email.
    if ($_POST['receiver_email'] != 'register@simons-rock.edu') {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";
    }
    
    // 3. Make sure the amount(s) paid match
    // if ($_POST['mc_gross'] != '9.99') {
    //    $errmsg .= "'mc_gross' does not match: ";
    //    $errmsg .= $_POST['mc_gross']."\n";
    // }
    
    // 4. Make sure the currency code matches
    if ($_POST['mc_currency'] != 'USD') {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $_POST['mc_currency']."\n";
    }

    $txn_id = mysql_real_escape_string($_POST['txn_id']);
    /* TODO: Check for duplicate txn_id
    $txn_id = mysql_real_escape_string($_POST['txn_id']);
    $sql = "SELECT COUNT(*) FROM summer_program_payments WHERE txn_id = '$txn_id'";
    $r = $db->do_query($sql);
    
    if (!$r) {
        error_log(mysql_error());
        exit(0);
    }
    */
//    $exists = mysql_result($r, 0);
//    mysql_free_result($r);
    
//    if ($exists) {
//        $errmsg .= "'txn_id' has already been processed: ".$_POST['txn_id']."\n";
//    }
    
    if (!empty($errmsg)) {
  
        // manually investigate errors from the fraud checking
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();
        mail('dscheff@simons-rock.edu', 'IPN Fraud Warning', $body);
        
    }
	// else {

		$payer_email = mysql_real_escape_string($_POST['payer_email']);
		$mc_gross = mysql_real_escape_string($_POST['mc_gross']);
		$sql = "INSERT INTO summer_program_payments VALUES (NULL, '$txn_id', '$payer_email', '$mc_gross')";
		$db->do_query($sql);

		$payer_id = mysql_real_escape_string($_POST['custom']);
		$sql = "UPDATE summer_program_class_registration SET paid_for='1' WHERE payer_id='$payer_id'";
		$db->do_query($sql);
		
		// summer_program_class_registration (contact_id, class_id, payer_id, paid_for)
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
				$thisWeek = $row2->week;
			}
			$sql2 = "SELECT * FROM forms.summer_program_contact WHERE id=$cid";
			$db3->do_query($sql2);
			while($row3 = $db3->fetchObject()){
				$applicant = $row3->applicant_name;
			}
			$studentClassRows .= "$applicant:\n";
			$studentClassRows .= "  WEEK $thisWeek: \"$thisTitle\"\n\n";
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
		
		mail("Browdy@simons-rock.edu","SUMMER PROGRAM REGISTRATION--PAYPAL",$msg, "From: EngageSummer@simons-rock.edu");
		mail("dscheff@simons-rock.edu","SUMMER PROGRAM REGISTRATION--PAYPAL",$msg, "From: EngageSummer@simons-rock.edu");

		// now to customer
		$msg = "";
		$msg .= "Thank you for registering for the Summer Program at Simon's Rock! Your class seats have been reserved.\n\n";
		$msg .= "Please email us (EngageSummer@simons-rock.edu) with any questions.\n\n";
		$msg .= "TUITION PAID: \$ $mc_gross\n\n";
		$msg .= "CLASS REGISTRATION INFORMATION:\n";
		$msg .= $studentClassRows;
			
		$to = $parent_email;
		mail($to,"Simon's Rock Summer Program Registration Confirmation",$msg, "From: EngageSummer@simons-rock.edu");
		mail("dscheff@simons-rock.edu","SUMMER PROGRAM REGISTRATION--PAYPAL",$msg, "From: EngageSummer@simons-rock.edu");

		
} else {
    // IPN response was "INVALID"
	// mail("dscheff@simons-rock.edu","NOPE","not so verified");
    mail('dscheff@simons-rock.edu', 'Invalid IPN', $listener->getTextReport());
}

?>