<?php 
(isset($_REQUEST['test']) && $_REQUEST['test'] == 0) ? $is_test = true : $is_test = false;
if($is_test) {
	ini_set("display_errors","On");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
}
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db2 = new DB(HOST,USER,PASSWORD,DATABASE);
$db3 = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();
$db2->connect();
$db3->connect();

function safe($value){ 
   return mysql_real_escape_string($value); 
} 

$checkPaypal = " ";
$checkCheck = " ";

if(isset($_POST['submit'])) {

	$post_msg = "";
	if($_POST['applicant_name'] == ""){
		$post_msg .= "Applicant Name";
	}
	else{

		// clean the contact info for mysql and simplify the vars from the POST array
		$applicant_name			= safe($_POST["applicant_name"]); 
		$permaddress_street		= safe($_POST["permaddress_street"]); 
		$permaddress_street2	= safe($_POST["permaddress_street2"]); 
		$permaddress_city		= safe($_POST["permaddress_city"]); 
		$permaddress_state		= safe($_POST["permaddress_state"]); 
		$permaddress_state		= safe($_POST["permaddress_state"]); 
		$permaddress_zip		= safe($_POST["permaddress_zip"]); 
		$permaddress_country	= "";
		$permaddress_phone		= safe($_POST["permaddress_phone"]); 
		$living_arrangement		= safe($_POST["living_arrangement"]); 
		$cell_phone				= safe($_POST["cell_phone"]); 
		$email					= safe($_POST["email"]); 
		$hopes_info				= safe($_POST["hopes_info"]); 
		$workshop				= safe($_POST["workshop"]); 
		$mop					= safe($_POST["mop"]); 
		$newOrReturning			= safe($_POST["newOrReturning"]); 
		$referral				= safe($_POST["referral"]); 

		$g_names = explode(" ",$applicant_name);
		$gf_name = $g_names[0];
		$gl_name = $g_names[1];

		if($living_arrangement == "livingOffCampus"){
			$totalTuition = "975";
		}
		else {
			$totalTuition = "1375";
		}

		$discount = 80;
		$doDiscount = false;

		$exp_date = "2013-03-15";
		$todays_date = date("Y-m-d");
		
		$expiration_date = strtotime($exp_date);
		$today = strtotime($todays_date);

		if($newOrReturning == "returningBWW" || ($expiration_date > $today)){
			$doDiscount = true;
		}

		if($doDiscount){
			$totalTuition = $totalTuition - $discount;
		}


		// echo "TOTAL: ".$totalTuition;
		// exit();
		
		// create the contact in the db
		$sql = "INSERT INTO forms.bww_program_contact (id, date_submitted, applicant_name, permaddress_street, permaddress_street2, permaddress_city, permaddress_state, permaddress_zip,permaddress_country,permaddress_phone,cell_phone,email,hopes_info,vegetarian,living_arrangement,workshop,referral)  
		 		VALUES (NULL, now(), '$applicant_name', '$permaddress_street', '$permaddress_street2', '$permaddress_city', '$permaddress_state', '$permaddress_zip', '$permaddress_country', '$permaddress_phone', '$cell_phone', '$email', '$hopes_info', '', '$living_arrangement', '$workshop','$referral')";
		$db->do_query($sql);

		$sql = "SELECT id from forms.bww_program_contact ORDER BY id DESC LIMIT 1";
		$db->do_query($sql);
		$result = $db->fetchObject();
		$thisContactId = $result->id;
		$thisPayerId = $thisContactId;

		$paidfor = '0';
		if($mop == 'check'){
			$paidfor = '1';
		}
		$sql = "INSERT INTO forms.bww_program_class_registration (contact_id, class, payer_id, paid_for)
				VALUES ($thisContactId,'$workshop', $thisPayerId, '$paidfor')";
		$db->do_query($sql);
	
		$sql = "INSERT INTO forms.bww_program_registration (contact_id,tuition) 
				VALUE ($thisContactId,$totalTuition)";
		$db->do_query($sql);

		$post_success = true;


		// now we decide where to send them, and what emails to send to whom...
		if($mop == "paypal"){
			$paybuttons = '
				<form name="paypalform" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_parent">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="3X4KTT5ATNBNA">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="first_name" value="'.$gf_name.'">
				<input type="hidden" name="last_name" value="'.$gl_name.'">
				<input type="hidden" name="address1" value="'.$permaddress_street.'">
				<input type="hidden" name="address2" value="'.$permaddress_street2.'">
				<input type="hidden" name="city" value="'.$permaddress_city.'">
				<input type="hidden" name="state" value="'.$permaddress_state.'">
				<input type="hidden" name="zip" value="'.$permaddress_zip.'">
				<input type="hidden" name="email" value="'.$email.'">
				<input type="hidden" name="item_name" value="Berkshire Writing Workshop 2013">
				<input type="hidden" name="button_subtype" value="services">
				<input type="hidden" name="no_note" value="0">
				<input type="hidden" name="cn" value="Add special instructions to the seller">
				<input type="hidden" name="no_shipping" value="0">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
				<input type="hidden" name="payer_id" value="'.$thisPayerId.'">
				<input type="hidden" name="custom" value="'.$thisPayerId.'">
				<input type="hidden" name="return" value="http://www.simons-rock.edu/berkshire-writing-workshop/thank-you" />
				<input type="hidden" name="notify_url" value="http://forms.simons-rock.edu/berkshire-writing-workshop/listener.php" />
 				<input type="hidden" name="amount" value="'.$totalTuition.'">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				<script>document.paypalform.submit()</script>';
				$contents = "<p>Redirecting to Paypal... please wait moment. If after 10 seconds the page has not taken you to Paypal, <a href=\"javascript:document.paypalform.submit()\">click here</a>.</p>";
				$contents .= $paybuttons;
			echo ($contents);
		}
		else { // must be a check
		
			$tuitionShow = number_format($totalTuition, 2, '.', '');
			$content = "
				<div style=\"margin-top: 50px; height: 20px;\" id=\"innertop\"></div>
				<p style=\"padding-bottom: 12px;\">Thank you for registering for the Berkshire Writing Workshop at Simon's Rock! Payment (\$$tuitionShow)  is due in full at the time of registration. If, after registering, you discover you are unable to attend, refunds (less $50 administrative fee) will be issued for cancellations received in writing prior to September 11. After the first class meeting, students may receive a 75 percent refund if requested the next day. No refunds will be issued after September 12, 2012.</p>
				<p style=\"padding-bottom: 12px;\">If you did not print the registration form with your information on it, please print this page and include with your check payment so we may assign your payment to your registration.</p>
				<p style=\"padding-bottom: 12px;\">The total tuition due is <strong>\$$tuitionShow</strong></p>
				<p style=\"padding-bottom: 12px;\">Your Name: $applicant_name</p>
				<p style=\"padding-bottom: 12px;\">Street Address: $permaddress_street</p>
				<p style=\"padding-bottom: 12px;\">City: $permaddress_city</p>
				<p style=\"padding-bottom: 12px;\">State: $permaddress_state</p>
				<p style=\"padding-bottom: 12px;\">Zip: $permaddress_zip</p>
				<p style=\"padding-bottom: 12px;\">Phone: $permaddress_phone</p>
				<p style=\"padding-bottom: 12px;\">Cell Phone: $cell_phone</p>
				<p style=\"padding-bottom: 12px;\">Email: $email</p>
				<p style=\"padding-bottom: 12px;\">Workshop chosen: $workshop</p>
				<p></p>
				<p style=\"padding-bottom: 12px;\">Please make checks payable to: <strong>Bard College at Simon's Rock</strong></div>
				<p style=\"padding-bottom: 12px;\">Mail/Deliver to:<br />
				Bard College at Simon’s Rock<br />
				Attn: Alison Lobron<br />
				84 Alford Rd.<br />
				Great Barrington, MA 01230</p>
				<p style=\"padding-bottom: 12px;\">Please email us (<a href=\"mailto:alobron@simons-rock.edu\">alobron@simons-rock.edu</a>) with any questions.</p>
				<script>
				  document.getElementById('innertop').scrollIntoView();
				</script>
				</body></html>";

			// mail to admins
//			$sql = "SELECT * FROM forms.bww_program_contact WHERE id='$thisContactId' LIMIT 1";
//			$db->do_query($sql);
//			$row = $db->fetchObject();
//			$permaddress_street	= $row->permaddress_street;
//			$permaddress_city	= $row->permaddress_city;
//			$permaddress_state	= $row->permaddress_state;
//			$permaddress_zip	= $row->permaddress_zip;
//			$permaddress_phone	= $row->permaddress_phone;
//			$cell_phone			= $row->cell_phone;
//			$email				= $row->email;
//			$workshop			= $row->workshop;
			
			$type="CHECK PAYMENT IS DUE";
			$subj = "BERKSHIRE WRITING WORKSHOP REGISTRATION--PAYING BY CHECK";
	
			$msg = "";
			$msg .= "Berkshire Writing Workshop Registration -- $type\n\n";
			$msg .= "               Tuition: \$$tuitionShow\n\n";
			$msg .= "     Workshop selected: $workshop\n\n";
			$msg .= "        Applicant Name: $applicant_name\n";
			$msg .= "                Street: $permaddress_street\n";
			$msg .= "                  City: $permaddress_city\n";
			$msg .= "                 State: $permaddress_state\n";
			$msg .= "                   Zip: $permaddress_zip\n";
			$msg .= "                 Phone: $permaddress_phone\n";
			$msg .= "            Cell Phone: $cell_phone\n\n";
			$msg .= "                 Email: $email\n\n";
			$msg .= "            New to BWW: $newOrReturning\n\n";
			$msg .= "    Living Arrangement: $living_arrangement\n\n";
			$msg .= "Hopes for the workshop: \n  $hopes_info\n\n";
			$msg .= "How did you hear of us: \n  $referral\n\n";
			
			mail("alobron@simons-rock.edu",$subj,$msg, "From: alobron@simons-rock.edu");
			mail("dscheff@simons-rock.edu",$subj,$msg, "From: alobron@simons-rock.edu");

			// now to customer
			$msg = "";
			$msg .= "Thank you for registering for the Berkshire Writing Workshop at Simon's Rock! Payment (\$$tuitionShow) is due in full at the time of registration. If, after registering, you discover you are unable to attend, refunds (less \$50 administrative fee) will be issued for cancellations received in writing prior to June 1. On or after June 1, we cannot offer refunds unless your spot is filled by another student. Please consider investigating trip insurance if your plans are at all tentative.\n\n";
			$msg .= "If you did not print the registration form with your information on it, please print this email and include with your check payment so we may assign your payment to your registration.\n\n";
			$msg .= "Your Name: $applicant_name\n";
			$msg .= "Street Address: $permaddress_street\n";
			$msg .= "City: $permaddress_city\n";
			$msg .= "State: $permaddress_state\n";
			$msg .= "Zip: $permaddress_zip\n";
			$msg .= "Phone: $permaddress_phone\n\n";
			$msg .= "Cell Phone: $cell_phone\n\n";
			$msg .= "Email: $email\n\n";
			$msg .= "Workshop chosen: $workshop\n\n";
			$msg .= "TUITION DUE: \$ $tuitionShow\n\n";
			$msg .= "Please make checks payable to: Bard College at Simon's Rock\n\n";
			$msg .= "Mail/deliver to:\n";
			$msg .= "Bard College at Simon's Rock\n";
			$msg .= "Attn: Alison Lobron\n";
			$msg .= "84 Alford Rd.\n";
			$msg .= "Great Barrington, MA 01230\n\n";
			$msg .= "Please email us (alobron@simons-rock.edu) with any questions.\n\n";
			$to   = $email;
			
			mail($to,"Berkshire Writing Workshop at Simon's Rock",$msg, "From: alobron@simons-rock.edu");
			mail("dscheff@simons-rock.edu","COPY (orig: $to): Berkshire Writing Workshop at Simon's Rock",$msg, "From: alobron@simons-rock.edu");
		}
	}
}



?>

<!DOCTYPE HTML>
<html><head>
<meta charset="utf-8">
<title>Berkshire Writing Workshop <?php echo(date('Y'));?> at Simon's Rock Registration</title>

<script type="text/javascript">
<!--

function toggleDiv(theDiv){
	if(document.getElementById(theDiv).style.display == 'none'){
		document.getElementById(theDiv).style.display = '';
	}
	else{
		document.getElementById(theDiv).style.display = 'none';
	}
}

function calculateRegistration(num){
	document.getElementById('registrationTotal').value = num;
}

function CountWords (this_field, show_word_count, show_char_count, doAlert) {
	if (show_word_count == null) {
		show_word_count = true;
	}
	if (show_char_count == null) {
		show_char_count = false;
	}
	var char_count = this_field.value.length;
	var fullStr = this_field.value + " ";
	var initial_whitespace_rExp = /^[^A-Za-z0-9]+/gi;
	var left_trimmedStr = fullStr.replace(initial_whitespace_rExp, "");
	var non_alphanumerics_rExp = rExp = /[^A-Za-z0-9]+/gi;
	var cleanedStr = left_trimmedStr.replace(non_alphanumerics_rExp, " ");
	var splitString = cleanedStr.split(" ");
	var word_count = splitString.length -1;

	if (fullStr.length <2) {
		word_count = 0;
	}
	if (word_count > 200) {
		if(doAlert == true){
			alert ("Please limit the number of words to 200 or fewer. \n\nYour current word count is: " + word_count);
		}
		else{
			return true;
		}
	}
	return word_count;
}
// -->

</script>
<style>
body{
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	background:#fff;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}
/* ----------- My Form ----------- */
.myform{
	margin:0 auto;
	width:530px;
	padding:6px;
}
/* ----------- stylized ----------- */
#stylized{
	border:solid 1px #b7ddf2;
	/*          background:#ebf4fb; */
}
#stylized h1 {
	font-size:14px;
	font-weight:bold;
	margin-bottom:8px;
}
#stylized p{
	font-size:11px;
	color:#666666;
	margin-bottom:20px;
	border-bottom:solid 1px #b7ddf2;
	padding-bottom:10px;
}
#stylized label{
	display:block;
	text-align:right;
	width:250px;
	padding-top: 5px;
	float:left;
}
#stylized label.labelwide{
	width: 340px;
	text-align:left;
	padding: 0;
	margin: 0;
}
#stylized label.labelmed{
	text-align: left;
	width: 350px;
	padding: 0 0 0 5px;
	margin: 0;
}
#stylized label.labelsmall{
	text-align:left; 
	width: 20px;
	padding: 0 15px 0 0;
	margin: 0;
	float: right;
}
#stylized label.radiolabel{
	float: none;
	display: inline;
}
#stylized .small{
	color:#666666;
	display:block;
	font-size:11px;
	font-weight:normal;
	text-align:right;
	width:140px;
}
#stylized input{
	float:left;
	font-size:11px;
	padding:4px 2px;
	border:solid 1px #aacfe4;
	width:200px;
	margin:2px 0 10px 10px;
}
#stylized input.nofloatInput{
	float: none;
	width: 16px; 
	margin-right: 5px;
}

#stylized select{
	float:left;
	font-size:12px;
	padding:4px 2px;
	border:solid 1px #aacfe4;
	width:206px;
	margin:2px 0 20px 10px;
}
#stylized input.radio{
	width: 10px;
	border: 0;
	margin-left: 5px;
	margin-right: 5px;
	padding:0;
}
#stylized button{
	clear:both;
	margin-left:150px;
	width:125px;
	height:31px;
	background:#666666 url(img/button.png) no-repeat;
	text-align:center;
	line-height:31px;
	color:#FFFFFF;
	font-size:11px;
	font-weight:bold;
}
.required {
	color:#FF0000;
	font-size:14px;
	padding: 0 5px;
}
.msg {
	padding: 15px;
	font-size: 12px;
	font-weight: bold;
}
.classDivs{
	clear: both;
	height: 15px;
}
.classDivs input{
	width: 15px !important;
	margin-left: 95px!important;
}
.div_par{
	margin: 20px;	
}
#tt {
	position:absolute;
	display:block;
	background:url(images/tt_left.gif) top left no-repeat;
}
#tttop {
	display:block;
	height:5px;
	margin-left:5px;
	background:url(images/tt_top.gif) top right no-repeat;
	overflow:hidden;
}
#ttcont {
	display:block;
	padding:2px 12px 3px 7px;
	margin-left:5px;
	background:#666;
	color:#fff;
}
#ttbot {
	display:block;
	height:5px;
	margin-left:5px;
	background:url(images/tt_bottom.gif) top right no-repeat;
	overflow:hidden;
}
.times{
	font-size: 9px;
	padding-right: 7px;
}
</style>
</head>
<body onLoad="parent.scrollTo(0,0)" onUnload="parent.scrollTo(0,0)">
<?php
if((isset($content)) && $content!=""){
	echo ($content);
	exit();
}
?>
<div id="stylized" class="myform">
<div id="innertop"></div>
	<p style="margin: 15px; font-size:16px"><strong>The Berkshire Writing Workshop</strong></p>
	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" style="padding-left: 20px;">
    <div class="spacer" style="clear:both"></div>
	<div style="clear:both;" id="student1Div">
    	<div style="clear:both" id="applicant_nameDiv">
          <label for="applicant_name">Full Name</label>
          <input type="text" name="applicant_name" id="applicant_name" /><span class="required">*</span>
        </div>
        <div style="clear:both" id="permaddress_streetDiv">
          <label for="permaddress_street">Street</label>
          <input type="text" name="permaddress_street" id="permaddress_street"
		  <?php
		  	if(isset($permaddress_street)){
				echo (" value=\"$permaddress_street\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="permaddress_street2Div">
          <label for="permaddress_street2">Street Address 2</label>
          <input type="text" name="permaddress_street2" id="permaddress_street2" 
		  <?php
		  	if(isset($permaddress_street2)){
				echo (" value=\"$permaddress_street2\" ");
			}
		  ?>		  
		  />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="permaddress_cityDiv">
          <label for="permaddress_city">City</label>
          <input type="text" name="permaddress_city" id="permaddress_city" 
		  <?php
		  	if(isset($permaddress_city)){
				echo (" value=\"$permaddress_city\" ");
			}
		  ?>		  
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="permaddress_stateDiv">
          <label for="permaddress_state">State</label>
		  <select name="permaddress_state" id="permaddress_state" />
 		  <?php
		  	if(isset($permaddress_state)){
				echo ("<option value=\"$permaddress_state\" selected>$permaddress_state</option>");
			}else{
				echo ("<option>---Please Select---</option>");
			}
		  ?>	
			  <option>AA</option>
              <option>AE</option>
              <option>AL</option>
              <option>AK</option>
              <option>AP</option>
              <option>AR</option>
              <option>AS</option>
              <option>AZ</option>
              <option>CA</option>
              <option>CO</option>
              <option>CT</option>
              <option>DC</option>
              <option>DE</option>
              <option>FL</option>
              <option>FM</option>
              <option>GA</option>
              <option>GU</option>
              <option>HI</option>
              <option>ID</option>
              <option>IL</option>
              <option>IN</option>
              <option>IA</option>
              <option>KS</option>
              <option>KY</option>
              <option>LA</option>
              <option>ME</option>
              <option>MD</option>
              <option>MA</option>
              <option>MH</option>
              <option>MI</option>
              <option>MN</option>
              <option>MP</option>
              <option>MS</option>
              <option>MO</option>
              <option>MT</option>
              <option>NE</option>
              <option>NV</option>
              <option>NH</option>
              <option>NJ</option>
              <option>NM</option>
              <option>NY</option>
              <option>NC</option>
              <option>ND</option>
              <option>OH</option>
              <option>OK</option>
              <option>OR</option>
              <option>PA</option>
              <option>PR</option>
              <option>PW</option>
              <option>RI</option>
              <option>SC</option>
              <option>SD</option>
              <option>TN</option>
              <option>TX</option>
              <option>UT</option>
              <option>VI</option>
              <option>VT</option>
              <option>VA</option>
              <option>WA</option>
              <option>WV</option>
              <option>WI</option>
              <option>WY</option>
              <option>AB</option>
              <option>BC</option>
              <option>MB</option>
              <option>NB</option>
              <option>NL</option>
              <option>NT</option>
              <option>NS</option>
              <option>NU</option>
              <option>ON</option>
              <option>PE</option>
              <option>QC</option>
              <option>SK</option>
              <option>YT</option>
              <option>not applicable</option>
          </select><span class="required">*</span>

        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="permaddress_zipDiv">
          <label for="permaddress_zip">Postal Code</label>
          <input type="text" name="permaddress_zip" id="permaddress_zip" 
		  <?php
		  	if(isset($permaddress_zip)){
				echo (" value=\"$permaddress_zip\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="permaddress_phoneDiv">
          <label for="permaddress_phone">Phone (at permanent address)</label>
          <input type="text" name="permaddress_phone" id="permaddress_phone" 
		  <?php
		  	if(isset($permaddress_phone)){
				echo (" value=\"$permaddress_phone\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>

        <div class="spacer"></div>
        <div style="clear:both" id="cell_phoneDiv">
          <label for="cell_phone">Cell Phone</label>
          <input type="text" name="cell_phone" id="cell_phone" 
		  <?php
		  	if(isset($cell_phone)){
				echo (" value=\"$cell_phone\" ");
			}
		  ?>
		   />
        </div>

        <div class="spacer"></div>
        <div style="clear:both" id="emailDiv">
          <label for="email">E-mail</label>
          <input type="email" name="email" id="email"
		  <?php
		  	if(isset($email)){
				echo (" value=\"$email\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>

		<div class="spacer" style="height: 20px;"><strong>Are you: </strong></div>
		
		<div id="newOrReturningDiv" style="height: 50px; margin: 10px 15px 10px 15px;">
			<div>
				<div style="float:left"><input type="radio" name="newOrReturning" value="returningBWW" id="returningBWW" class="nofloatInput" style="width:15px"></div>
				<div><label style="padding-top: 1px; width: auto" for="returningBWW">A returning BWW student</label></div>
			</div>
			<div class="spacer"></div>
			<div>
				<div style="float:left"><input type="radio" name="newOrReturning" value="newBWW" id="newBWW" class="nofloatInput" style="width:15px"></div>
				<div><label style="padding-top: 1px; width: auto" for="newBWW">A new BWW student</label></div>
			</div>
		</div>
		
		<div class="spacer" style="height: 15px;"></div>

        <div class="spacer"></div>
		<div><strong>Please choose your workshop:</strong></div>
		<div style="margin: 10px 15px 10px 15px;" id="workshopDiv">
<!--			<input class="nofloatInput" type="radio" name="workshop" id="workshopEssay" value="The Personal Essay"> 
			<label class="radiolabel" for="workshopEssay">The Personal Essay</label><br />
-->
			<input class="nofloatInput" type="radio" name="workshop" id="workshopStory" value="Finding the Story"> 
			<label class="radiolabel" for="workshopStory">Finding the Story</label><br />
			<input class="nofloatInput" type="radio" name="workshop" id="workshopFiction" value="Fact into Fiction"> 
			<label class="radiolabel" for="workshopFiction">Fact into Fiction</label><br />
		</div>


		<div class="spacer" style="height: 20px;"><strong>Living Arangements: </strong></div>
		<div>Please choose a living arrangement (total cost in parentheses):</div>
		<div style="margin: 5px 15px 0 15px;" id="living_arrangementDiv">
			<input class="nofloatInput" type="radio" name="living_arrangement" id="livingOnCampus" value="livingOnCampus"> 
			<label class="radiolabel" for="livingOnCampus">Residential: $1375 ($1295, returning students/early registrants)</label><br />
			<input class="nofloatInput" type="radio" name="living_arrangement" id="livingOffCampus" value="livingOffCampus"> 
			<label class="radiolabel" for="livingOffCampus">Non-residential: $975 ($895, returning students/ early registrants) </label><br />
		</div>
		
        <div class="spacer"></div>
		<div style="margin-right: 14px; padding: 10px; -moz-border-radius: 10px 10px 10px; border-radius: 10px 10px 10px; border: 1px solid red; margin-bottom: 17px; background: lightgray;"><strong>Note:</strong> Discounts will be calculated automatically. New students must register by March 15 to receive the early-registration discount.</div>


        <div class="spacer"></div>
		<div><strong>Please use this space to tell us your hopes for the workshop, and any additional information you'd like us to know</strong> (in 200 words or fewer please.)</div>
		<div>
			<textarea name="hopes_info" id="hopes_info" onBlur="CountWords(this.form.hopes_info, true, true, true);" style="width: 450px; height: 105px; "></textarea>
		</div>
		<div class="spacer" style="height: 15px;"></div>
		<div><strong>How did you hear about the Berkshire Writing Workshop?</strong></div>
		<div>
			<textarea name="referral" id="referral" style="width: 450px; height: 105px; "></textarea>
		</div>
        <div class="spacer" style="height: 15px;"></div>		
		
	</div>
	<div class="spacer" style="height: 15px;"></div>

	<div class="spacer" style="height: 5px;"></div>
	<div class="spacer" style="height: 20px;"><strong>Method of payment: </strong></div>
	<div style="padding-left: 15px" id="mopDiv">
		<input class="nofloatInput" type="radio" value="paypal" name="mop" id="mop_paypal"> 
		<label class="radiolabel" for="mop_paypal">Credit Card</label><br />
		<input class="nofloatInput" type="radio" value="check" name="mop" id="mop_check"> 
		<label class="radiolabel" for="mop_check">Check</label> <br />(NOTE: If paying by check, please print this form, then mail along with check as instructed on page following form submission)
	</div>
	<div class="spacer" style="height: 15px;"></div>
	<div class="spacer" style="height: 20px;"><strong>Payment Terms: </strong></div>
	<div style="padding: 5px 10px 10px 10px;">Payment is due in full at the time of registration. If, after registering, you discover you are unable to attend, refunds (less $50 administrative fee) will be issued for cancellations received in writing prior to June 1. On or after June 1, we cannot offer refunds unless your spot is filled by another student. Please consider investigating trip insurance if your plans are at all tentative.</div>
<!-- 	<div style="padding: 5px 10px 10px 10px;">After June 1, we will issue refunds (lest $100 fee) <em>only if your spot is filled by another student</em>. If your spot is <em>not</em> filled, we regret that we will not be able to refund your tuition. If your plans are at all tentative, you may wish to investigate travel insurance.</div> -->
	<div id="consentDiv" style="height: 30px;">
		<div style="float:left"><input type="checkbox" name="consent" value="on" id="consent" class="nofloatInput" style="width:15px"> </div>
		<div><label style="padding-top: 0; width: auto" for="consent"><strong>I have read, understand and agree to the terms above.</strong></label></div>
	</div>
	<div class="spacer" style="height: 20px;"></div>
	<div>
		<button type="submit" name="submit" id="submit">Register Now</button>
	</div>
	<div class="spacer"></div>
	</form>
  </div>
  
<script>
<!--
function checkForm() {
    var bgcolor
    var normal
    var rval
    var tuitionval 
    var consentval
    highlight = "#ffcccc"
    normal = "#ffffff"
    rval = true
    tuitionval = true 
    consentval = true
	fieldFocus = "";

	if (document.layers||document.getElementById||document.all) {
        if (document.request.applicant_name.value.length == 0) {
            document.request.applicant_name.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "applicant_name";
			}
		} 
		else {
            document.request.applicant_name.style.backgroundColor = normal
		}
        if (document.request.permaddress_street.value.length == 0) {
            document.request.permaddress_street.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "permaddress_street";
			}
		} 
		else {
            document.request.permaddress_street.style.backgroundColor = normal
		}
        if (document.request.permaddress_city.value.length == 0) {
            document.request.permaddress_city.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "permaddress_city";
			}
		} 
		else {
            document.request.permaddress_city.style.backgroundColor = normal
		}
		if (document.getElementById('permaddress_state').options[document.getElementById('permaddress_state').selectedIndex].value == '---Please Select---') {
            document.request.permaddress_state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "permaddress_state";
			}
		} 
		else{
            document.request.permaddress_state.style.backgroundColor = normal
		}
        if (document.request.permaddress_zip.value.length == 0) {
            document.request.permaddress_zip.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "permaddress_zip";
			}
		} 
		else {
            document.request.permaddress_zip.style.backgroundColor = normal
		}
        if (document.request.permaddress_phone.value.length == 0) {
            document.request.permaddress_phone.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "permaddress_phone";
			}
		} 
		else {
            document.request.permaddress_phone.style.backgroundColor = normal
		}
	
        if (document.request.email.value.length == 0) {
            document.request.email.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "email";
			}
		} 
		else {
            document.request.email.style.backgroundColor = normal
		}

		if(!getCheckedValue(document.request.workshop)){
            rval = false
			fieldFocus = "workshopDiv";
//			alert ("Please select a workshop");
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).style.backgroundColor = highlight
			}
		}	
		else {
			fieldFocus = "workshopDiv";
            document.getElementById(fieldFocus).style.backgroundColor = normal
		}
		
		if(!getCheckedValue(document.request.newOrReturning)){
            rval = false
			fieldFocus = "newOrReturningDiv";
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).style.backgroundColor = highlight
			}
		}	
		else {
			fieldFocus = "newOrReturningDiv";
            document.getElementById(fieldFocus).style.backgroundColor = normal
		}		

		if(!getCheckedValue(document.request.mop)){
            rval = false
			fieldFocus = "mopDiv";
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).style.backgroundColor = highlight
			}
		}	
		else {
			fieldFocus = "mopDiv";
            document.getElementById(fieldFocus).style.backgroundColor = normal
		}				

        if (!document.request.consent.checked) {
            document.getElementById('consentDiv').style.backgroundColor = highlight
            consentval = false
			if(fieldFocus == ""){
				fieldFocus = "consent";
			}
		}		
		else {
			if(fieldFocus == ""){
				fieldFocus = "consent";
			}
            document.getElementById('consentDiv').style.backgroundColor = normal
		}

        if (!rval) {
			alert ("Please complete all required (highlighted) fields prior to submitting your form.");
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).focus();
			}
		}
		else if(!consentval){
            rval = false
			fieldFocus = "consent";
			alert ("You must agree to the payment terms by checking the box below them.");
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).focus();
			}
		}
		return rval
    } 
	else {
        return  true; 
	}
}
function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}
// document.getElementById('innertop').scrollIntoView();
// -->
</script>
</body>
</html>
