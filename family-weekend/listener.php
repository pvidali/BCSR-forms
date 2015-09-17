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
	mail("dscheff@simons-rock.edu","POST",$emlstr);

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
	$sql = "INSERT INTO forms.fw_meal_payments_2014 VALUES (NULL, '$txn_id', '$payer_email', '$mc_gross')";
	$db->do_query($sql);

	$payer_id = mysql_real_escape_string($_POST['custom']);
	$sql = "UPDATE fw_program_meal_registration_2014 SET paid_for='1' WHERE payer_id='$payer_id' AND mop='paypal'";
	$db->do_query($sql);

	$sql = "SELECT * FROM forms.fw_program_meal_registration_2014 WHERE payer_id=$payer_id AND mop='paypal' LIMIT 1";
	$db->do_query($sql);
	if($db->numRows() > 0){
		$success = true;
	}
	else{
		$success = false;
	}
	
	
	if($success) {
		// mail to Admin
		$sql = "SELECT * FROM forms.family_weekend_2014 WHERE id='$payer_id' LIMIT 1";
		$db->do_query($sql);
		$row = $db->fetchObject();
		$relative1Fname		= stripslashes($row->relative1Fname);
		$relative1Lname		= stripslashes($row->relative1Lname);
		$email				= $row->relative1Email;

		// meal info
		$meals  = "";
		$meals .= "Friday lunch: ";
		$meals .= $row->fridayLunchAdults . "@ \$8: \$" .($row->fridayLunchAdults*8);
		$meals .= "\n";
		$meals .= "Friday dinner: ";
		$meals .= $row->fridayDinnerAdults . "@ \$9: \$" .($row->fridayDinnerAdults*9);
		$meals .= "\n";
		$meals .= "Saturday breakfast: ";
		$meals .= $row->saturdayBrunchAdults . "@ \$9: \$" .($row->saturdayBrunchAdults*5);
		$meals .= "\n";
		$meals .= "Saturday Harvest Fest Lunch: ";
		$meals .= $row->saturdayBrunchAdults . "@ \$9: \$" .($row->saturdayLunchAdults*9);
		$meals .= "\n";
		$meals .= "Saturday dinner: ";
		$meals .= $row->saturdayDinnerAdults . "at \$9: \$" .($row->saturdayDinnerAdults*9);
		$meals .= "\n";
		$meals .= "Sunday brunch: ";
		$meals .= $row->sundayBrunchAdults . "at \$9: \$" .($row->sundayBrunchAdults*9);

		
		$msg = "";
		$msg .= "FAMILY WEEKEND MEAL PURCHASE -- SUCCESSFUL PAYPAL PAYMENT\n\n";
		$msg .= "Registrant Name: $relative1Fname $relative1Lname\n";
		$msg .= "Email: $email\n\n";
		$msg .= "== MEALS/QUANTITIES PURCHASED ==\n\n";
		$msg .= $meals."\n\n";
		$msg .= "Total paid: \$ $mc_gross\n";
	//		$msg .= "Hopes for the workshop: \n  $hopes_info\n\n";
	//		$msg .= "How did you hear of us: \n  $referral\n\n";
					
	//		mail("cingram@simons-rock.edu","FAMILY WEEKEND MEAL PURCHASE--PAYPAL",$msg, "From: cingram@simons-rock.edu");
	//	mail("cingram@simons-rock.edu","FAMILY WEEKEND --SUCCESSFUL PAYPAL TRANSACTION",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");
		mail("dscheff@simons-rock.edu","FAMILY WEEKEND --SUCCESSFUL PAYPAL TRANSACTION",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");

		// now to customer
		$msg = "";
		$msg .= "Dear $relative1Fname,\n\n";
		$msg .= "Thank you for pre-purchasing your Family Weekend meals!\n\n";
		$msg .= "PLEASE PRINT THIS EMAIL, AND PRESENT IT AT ALL MEALS FOR FASTER SERVICE. Thank you!\n\n";
		$msg .= "TOTAL PAID: \$ $mc_gross\n\n";
		$msg .= "MEALS PURCHASED: \n";
		$msg .= "$meals \n\n";
		$msg .= "Please email me (cingram@simons-rock.edu) or call me at (413) 528-7266 with any questions.\n\n";
		$msg .= "Sincerely,\n\n";
		$msg .= "Cathy Ingram\n";
		$msg .= "Alumni and Parent Relations Officer\n";
		$msg .= "Family Weekend Coordinator\n";
		$msg .= "(413) 528-7266\n";
			
		$to = $email;
		mail($to,"Simon's Rock Family Weekend Payment Confirmation",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");
		mail("cingram@simons-rock.edu","COPY (sent to $to) Simon's Rock Family Weekend Payment Confirmation--SUCCESSFUL PAYPAL",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");
		mail("dscheff@simons-rock.edu","COPY (sent to $to) Simon's Rock Family Weekend Payment Confirmation--SUCCESSFUL PAYPAL",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");
	}
	else {
		//SELECT * FROM forms.fw_program_meal_registration WHERE payer_id='$payer_id' AND mop='paypal' LIMIT 1
		mail ("dscheff@simons-rock.edu","ODD TRANSACTION","CHECK ON PROBLEM $payer_id");
	}
} else {
    // IPN response was "INVALID"
	// mail("dscheff@simons-rock.edu","NOPE","not so verified");
    mail('dscheff@simons-rock.edu', 'Invalid IPN', $listener->getTextReport());
}

?>