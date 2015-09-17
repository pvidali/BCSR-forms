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
    
    if (!empty($errmsg)) {
  
        // manually investigate errors from the fraud checking
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();
        mail('dscheff@simons-rock.edu', 'IPN Fraud Warning', $body);
        
    }
	// else {

		if(isset($_POST['mc_gross'])){
			$mc_gross = $_POST['mc_gross'];
		}
		else{
			$mc_gross = $_POST['mc_gross_1'];
		}

		$payer_email = mysql_real_escape_string($_POST['payer_email']);
		// $mc_gross = mysql_real_escape_string($_POST['mc_gross_1']);
		$sql = "INSERT INTO forms.bww_program_payments VALUES (NULL, '$txn_id', '$payer_email', '$mc_gross')";
		$db->do_query($sql);

		$payer_id = mysql_real_escape_string($_POST['custom']);
		$sql = "UPDATE bww_program_class_registration SET paid_for='1' WHERE payer_id='$payer_id'";
		$db->do_query($sql);
		
		// mail to Alison
		$sql = "SELECT * FROM forms.bww_program_contact WHERE id='$payer_id' LIMIT 1";
		$db->do_query($sql);
		$row = $db->fetchObject();
		$applicant_name		= stripslashes($row->applicant_name);
		$permaddress_street	= $row->permaddress_street;
		$permaddress_city	= $row->permaddress_city;
		$permaddress_state	= $row->permaddress_state;
		$permaddress_zip	= $row->permaddress_zip;
		$permaddress_phone	= $row->permaddress_phone;
		$email				= $row->email;
		$vegetarian			= $row->vegetarian;
		$living_arrangement	= $row->living_arrangement;
		$workshop			= $row->workshop;
		$hopes_info			= stripslashes($row->hopes_info);
		$referral			= stripslashes($row->referral);
		
		$msg = "";
		$msg .= "BERKSHIRE WRITING WORKSHOP REGISTRATION -- SUCCESSFUL PAYPAL PAYMENT\n\n";
		$msg .= "                  Name: $applicant_name\n";
		$msg .= "                Street: $permaddress_street\n";
		$msg .= "                  City: $permaddress_city\n";
		$msg .= "                 State: $permaddress_state\n";
		$msg .= "                   Zip: $permaddress_zip\n";
		$msg .= "                 Phone: $permaddress_phone\n\n";
		$msg .= "            Cell Phone: $cell_phone\n\n";
		$msg .= "            Vegetarian? $vegetarian\n\n";
		$msg .= "                 Email: $email\n\n";
		$msg .= "              Workshop: $workshop\n\n";
		$msg .= "          Tuition paid: $mc_gross\n\n";
		$msg .= "    Living Arrangement: $living_arrangement\n\n";
		$msg .= "Hopes for the workshop: \n  $hopes_info\n\n";
		$msg .= "How did you hear of us: \n  $referral\n\n";
					
		mail("alobron@simons-rock.edu","BERKSHIRE WRITING WORKSHOP REGISTRATION--PAYPAL",$msg, "From: alobron@simons-rock.edu");
		mail("dscheff@simons-rock.edu","BERKSHIRE WRITING WORKSHOP REGISTRATION--PAYPAL",$msg, "From: alobron@simons-rock.edu");

		// now to customer
		$msg = "";
		$msg .= "Thank you for registering for the Berkshire Writing Workshop at Simon's Rock! Your class seats have been reserved.\n\n";
		$msg .= "Please email us (alobron@simons-rock.edu) with any questions.\n\n";
		$msg .= "TUITION PAID: \$ $mc_gross\n\n";
		$msg .= "CLASS REGISTRATION INFORMATION: $workshop\n";
			
		$to = $email;
		mail($to,"Simon's Rock Berkshire Writing Workshop Registration Confirmation",$msg, "From: alobron@simons-rock.edu");
		mail("dscheff@simons-rock.edu","COPY ($to) Simon's Rock Berkshire Writing Workshop--SUCCESSFUL PAYPAL",$msg, "From: alobron@simons-rock.edu");

		
} else {
    // IPN response was "INVALID"
	// mail("dscheff@simons-rock.edu","NOPE","not so verified");
    mail('dscheff@simons-rock.edu', 'Invalid IPN', $listener->getTextReport());
}

?>