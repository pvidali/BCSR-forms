<?php 
(isset($_REQUEST['test']) && $_REQUEST['test'] == 0) ? $is_test = true : $is_test = false;
if($is_test) {
	ini_set("display_errors","On");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
	echo "IS TEST<br>";
}
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db2 = new DB(HOST,USER,PASSWORD,DATABASE);
$db3 = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();
$db2->connect();
$db3->connect();

// grab the list of classes
$sql = "SELECT * FROM summer_program_class";
$db->do_query($sql);
$classes = array();
$numOfClasses = 12;
$maxStudentsPerClass = 12;
for($x=1; $x <= $numOfClasses; $x++){
	$classes[$x]['count'] = 0;
	$classes[$x]['status'] = 'enabled';
}

$week1 = "";
$week2 = "";
$week3 = "";
$week4 = "";

$times = array("none","9:30-12:30","1:30-4:30","1:30-4:30","9:30-12:30","1:30-4:30","1:30-4:30","9:30-12:30","1:30-4:30","1:30-4:30","9:30-12:30","1:30-4:30","1:30-4:30");
$toggles = array("0","0","3","2","0","6","5","0","9","8","0","12","11");

$sql = "SELECT * FROM forms.summer_program_class";
$db->do_query($sql);
while($row = $db->fetchObject()){
	
	// count how many are already in this class, disable it if it's 12 or more
	$thisClassId = $row->id;
	$sql2 = "SELECT * FROM forms.summer_program_class_registration WHERE class_id = $thisClassId and paid_for = '1'";
	$db2->do_query($sql2);
	$registeredCount = $db2->numRows();
	if($registeredCount >= $maxStudentsPerClass){
		$thisStatus = 'disabled';
		$thisClosedMessage = "<span>(Class is filled)</span>";
	}
	else{	
		$thisStatus	= "";
		$thisClosedMessage = "";
	}
	
	if($classes[$row->id]['count'] >= $maxStudentsPerClass){
		$classes[$row->id]['status'] = 'disabled';
	}
	$week = $row->week;
	$thisCount = $classes[$row->id]['count'];
	$thisTitle = $row->title;
	$thisClassIdName = "class".$row->id;
	if($row->id == '6'){
		$otherFeeText = "<span>($50 additional studio fee)</span>";
	}
	else if($row->id == '7'){
		$otherFeeText = "<span>($50 additional lab fee)</span>";
	}
	else{
		$otherFeeText = "";
	}
	$time = $times[$thisClassId];
	$toggle = $toggles[$thisClassId];
	$class = "class" . $week;
	if($week == 1){
		$week1 .= "<div class=\"classDivs\" id=\"" . $thisClassIdName . "Div\">";
		$week1 .= "<input onChange=\"calculate(); toggleClasses(this,'$toggle')\" type=\"checkbox\" value=\"on\" name=\"".$thisClassIdName."\" id=\"".$thisClassIdName."\" $thisStatus />";
		$week1 .= "<label for=\"".$thisClassIdName."\" class=\"labelmed\"><span class=\"times\">$time</span>$thisTitle $thisClosedMessage $otherFeeText</label>";
		$week1 .= "</div>";
	}
	if($week == 2){
		$week2 .= "<div class=\"classDivs\" id=\"" . $thisClassIdName . "Div\">";
		$week2 .= "<input onChange=\"calculate(); toggleClasses(this,'$toggle')\" type=\"checkbox\" value=\"on\" name=\"".$thisClassIdName."\" id=\"".$thisClassIdName."\" $thisStatus />";
		$week2 .= "<label for=\"".$thisClassIdName."\" class=\"labelmed\"><span class=\"times\">$time</span>$thisTitle $thisClosedMessage $otherFeeText</label>";
		$week2 .= "</div>";
	}
	if($week == 3){
		$week3 .= "<div class=\"classDivs\" id=\"" . $thisClassIdName . "Div\">";
		$week3 .= "<input onChange=\"calculate(); toggleClasses(this,'$toggle')\" type=\"checkbox\" value=\"on\" name=\"".$thisClassIdName."\" id=\"".$thisClassIdName."\" $thisStatus />";
		$week3 .= "<label for=\"".$thisClassIdName."\" class=\"labelmed\"><span class=\"times\">$time</span>$thisTitle $thisClosedMessage $otherFeeText</label>";
		$week3 .= "</div>";
	}
	if($week == 4){
		$week4 .= "<div class=\"classDivs\" id=\"" . $thisClassIdName . "Div\">";
		$week4 .= "<input onChange=\"calculate(); toggleClasses(this,'$toggle')\" type=\"checkbox\" value=\"on\" name=\"".$thisClassIdName."\" id=\"".$thisClassIdName."\" $thisStatus />";
		$week4 .= "<label for=\"".$thisClassIdName."\" class=\"labelmed\"><span class=\"times\">$time</span>$thisTitle $thisClosedMessage $otherFeeText</label> ";
		$week4 .= "</div>";
	}
}


function safe($value){ 
   return mysql_real_escape_string($value); 
} 



$addPayerIdField = " ";
$multiChildNote = "If you will be registering an additional student check this box:";
$multiChildHeader = "";
$checkFaculty = " ";
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
		$permaddress_zip		= safe($_POST["permaddress_zip"]); 
		$permaddress_country	= "";
		$permaddress_phone		= safe($_POST["permaddress_phone"]); 
		$summeraddress_street	= safe($_POST["summeraddress_street"]); 
		$summeraddress_street2	= safe($_POST["summeraddress_street2"]); 
		$summeraddress_city		= safe($_POST["summeraddress_city"]); 
		$summeraddress_state	= safe($_POST["summeraddress_state"]); 
		$summeraddress_zip		= safe($_POST["summeraddress_zip"]); 
		$summeraddress_country	= "";
		$student_phone			= safe($_POST["student_phone"]); 
		$guardian_name			= safe($_POST["guardian_name"]); 
		$guardian_phone_day		= safe($_POST["guardian_phone_day"]); 
		$guardian2_name			= safe($_POST["guardian2_name"]); 
		$guardian2_phone_day	= safe($_POST["guardian2_phone_day"]); 
		$emergency_name			= safe($_POST["emergency_name"]); 
		$emergency_phone		= safe($_POST["emergency_phone"]); 
		$student_email			= safe($_POST["student_email"]); 
		$parent_email			= safe($_POST["parent_email"]); 
		$student_school			= safe($_POST["student_school"]); 
		$schooladdress_street	= safe($_POST["schooladdress_street"]); 
		$schooladdress_street2	= safe($_POST["schooladdress_street2"]); 
		$schooladdress_city		= safe($_POST["schooladdress_city"]); 
		$schooladdress_state	= safe($_POST["schooladdress_state"]); 
		$schooladdress_zip		= safe($_POST["schooladdress_zip"]); 
		$schooladdress_country	= "";
		$gradelevel_2012		= safe($_POST["gradelevel_2012"]); 
		$acad_interests			= safe($_POST["acad_interests"]); 
		$extra_interests		= safe($_POST["extra_interests"]); 
		$is_faculty				= safe($_POST["is_faculty"]); 
		$mop					= $_POST["mop"]; 
		
		$g_names = explode(" ",$guardian_name);
		$gf_name = $g_names[0];
		$gl_name = $g_names[1];
		
		// create the contact in the db
		$sql = "INSERT INTO forms.summer_program_contact (id, date_submitted, applicant_name, permaddress_street, permaddress_street2, permaddress_city, permaddress_state, permaddress_zip,permaddress_country,permaddress_phone,summeraddress_street,summeraddress_street2, summeraddress_city,summeraddress_state,summeraddress_zip,summeraddress_country, student_phone,guardian_name,guardian_phone_day,guardian2_name,guardian2_phone_day,emergency_name,emergency_phone,student_email,parent_email,student_school, schooladdress_street,schooladdress_street2,schooladdress_city,schooladdress_state,schooladdress_zip, schooladdress_country,gradelevel_2012,acad_interests,extra_interests,is_faculty)  
		 		VALUES (NULL, now(), '$applicant_name', '$permaddress_street', '$permaddress_street2', '$permaddress_city', '$permaddress_state', '$permaddress_zip', '$permaddress_country', '$permaddress_phone', '$summeraddress_street', '$summeraddress_street2', '$summeraddress_city', '$summeraddress_state', '$summeraddress_zip', '$summeraddress_country', '$student_phone', '$guardian_name', '$guardian_phone_day', '$guardian2_name', '$guardian2_phone_day', '$emergency_name', '$emergency_phone', '$student_email', '$parent_email', '$student_school', '$schooladdress_street', '$schooladdress_street2', '$schooladdress_city', '$schooladdress_state', '$schooladdress_zip', '$schooladdress_country', '$gradelevel_2012', '$acad_interests', '$extra_interests', '$is_faculty')";
		$db->do_query($sql);

		$sql = "SELECT id from forms.summer_program_contact ORDER BY id DESC LIMIT 1";
		$db->do_query($sql);
		$result = $db->fetchObject();
		$thisContactId = $result->id;
		if(isset($_POST['payer_id']) && $_POST['payer_id'] != ""){
			$thisPayerId = $_POST['payer_id'];
		}
		else {
			$thisPayerId = $thisContactId;
		}
		// determine if we need to add another student
		//	if( ! (isset($_POST['payer_id'])) ){
		if( $_POST['multi_student'] == "on"){
			$addPayerIdField = "<input type=\"hidden\" name=\"payer_id\" value=\"$thisPayerId\">";
			// change the note text...
			$multiChildNote = "</div><div class=\"div_par\">
			THE DISCOUNT FOR REGISTERING MULTIPLE STUDENTS IS ALREADY APPLIED. PLEASE ONLY CHECK THIS BOX IF YOU ARE GOING TO REGISTER ANOTHER FAMILY MEMBER IN ADDITION TO THE ONE YOU ARE CURRENTLY REGISTERING. CHECKING THIS BOX WILL PROMPT YOU TO FILL OUT THE FORM AGAIN.";
			$multiChildHeader = "<h2 style=\"color: red\">Information for your next student:</h2>";

			if($is_faculty == "on"){
				$checkFaculty = " checked";
			}
			if($mop == "paypal"){
				$checkPaypal = " checked";
			}
			else{
				 $checkCheck = " checked";
			}


		}

		// assign the classes
		$postedClassArray = array("class1","class2","class3","class4","class5","class6","class7","class8","class9","class10","class11","class12");
		foreach($postedClassArray as $postedClass){
			if( array_key_exists("$postedClass",$_POST)){
				$thisClassId = substr($postedClass, 5);
				if($is_faculty == 'on' && $mop != "paypal"){
					$paidfor = '1';
				}
				else {
					$paidfor = '0';
				}
				
				$sql = "INSERT INTO forms.summer_program_class_registration (contact_id, class_id, payer_id, paid_for)
						VALUES ($thisContactId,$thisClassId, $thisPayerId, '$paidfor')";
				$db->do_query($sql);
			}
		}

		$class1 = $_POST["class1"];
		$class2 = $_POST["class2"];
		$class3 = $_POST["class3"];
		$class4 = $_POST["class4"];
		$class5 = $_POST["class5"];
		$class6 = $_POST["class6"];
		$class7 = $_POST["class7"];
		$class8 = $_POST["class8"];
		$class9 = $_POST["class9"];
		$class10 = $_POST["class10"];
		$class11 = $_POST["class11"];
		$class12 = $_POST["class12"];
	
		$totalTuition = $_POST["totalTuition"];
		$totalTuitionFaculty = $_POST["totalTuitionFaculty"];
		if($is_faculty == 'on'){
			$totalTuition = $totalTuitionFaculty;
		}
		
		$sql = "INSERT INTO forms.summer_program_registration (contact_id,tuition) 
				VALUE ($thisContactId,$totalTuition)";
		$db->do_query($sql);
		$post_success = true;


		$cids = array();
		$classids = array();
		$studentClassRows = "";
		$sql = "SELECT * FROM forms.summer_program_class_registration WHERE payer_id=$thisPayerId";
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
			$studentClassRowsHtml .= "$applicant: <br />";
			$studentClassRowsHtml .= " WEEK $thisWeek: \"$thisTitle\"<br /><br />";
		}

		
		// now we decide where to send them, and what emails to send to whom...
		if($addPayerIdField == " "){
//			if($is_faculty != "on" && $mop == "paypal"){
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
					<input type="hidden" name="email" value="'.$parent_email.'">
					<input type="hidden" name="item_name" value="Summer Program 2012">
					<input type="hidden" name="button_subtype" value="services">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="cn" value="Add special instructions to the seller">
					<input type="hidden" name="no_shipping" value="0">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
					<input type="hidden" name="payer_id" value="'.$thisPayerId.'">
					<input type="hidden" name="custom" value="'.$thisPayerId.'">
					<input type="hidden" name="return" value="http://www.simons-rock.edu/summer/thank-you" />
					<input type="hidden" name="notify_url" value="http://forms.simons-rock.edu/summer/listener.php" />
					<input type="hidden" name="amount" value="'.$totalTuition.'">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					<script>document.paypalform.submit()</script>';
					$contents = "<p>Redirecting to Paypal... please wait...</p>";
					$contents .= "<div>";
					$contents .= $paybuttons;
					$contents .= "</div>";
				echo ($contents);
			}
			elseif($is_faculty != "on" && $mop == "check"){
				$content = "
					<div>Thank you for registering for the Summer Program at Simon's Rock! Please keep in mind that we cannot reserve seats in the class until payment is received.</div>
					<div>The total tuition due is: \$ $totalTuition</div>
					<div>Please make checks payable to: <strong>Bard College at Simon’s Rock Summer Program</strong></div>
					<div>Deliver to:<br />
					Bard College at Simon’s Rock<br />
					Attn: Jennifer Browdy de Hernandez<br />
					84 Alford Rd.<br />
					Great Barrington, MA 01230</div>
					<div>Registration summary:</div>
					<div>$studentClassRowsHtml</div>
					</body></html>";
			}
			else{
				$totalTuitionFaculty = $_POST['totalTuitionFaculty'];
				$content = "
					<div>Thank you for registering for the Summer Program at Simon's Rock! Please keep in mind that we cannot reserve seats in the class until payment is received.</div>
					<div>&nbsp;</div>
					<div>Total of class registrations, plus studio fees: \$ $totalTuitionFaculty</div>
					<div>&nbsp;</div>
					<div>Please make checks payable to: <strong>Bard College at Simon’s Rock Summer Program</strong>, and deliver them to Jennifer Browdy de Hernandez, program director, through campus mail or in person.</div>
					<div>&nbsp;</div>
					<div>If you will be mailing it, send to:<br /><br />
					Bard College at Simon’s Rock<br />
					Attn: Jennifer Browdy de Hernandez<br />
					84 Alford Rd.<br />
					Great Barrington, MA 01230</div>
					<div>&nbsp;</div>
					<div>Registration summary:</div>
					<div style=\"padding: 10px;\">$studentClassRowsHtml</div>
					<div>&nbsp;</div>
					<div>We look forward to welcoming your children this summer!  Any questions, please email <a href=\"mailto:EngageSummer@simons-rock.edu\">EngageSummer@simons-rock.edu</a>.</div>
					</body></html>";
			}
			
			if($mop != "paypal"){
				// mail to jenny
				$sql = "SELECT * FROM forms.summer_program_contact WHERE id='$thisContactId' LIMIT 1";
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
				
				if($is_faculty == 'on'){
					$type="FACULTY";
					$subj = "SUMMER PROGRAM REGISTRATION--FACULTY, PAYING BY CHECK";
				}
				else{
					$type="NON-FACULTY, CHECK PAYMENT IS DUE (seats not reserved)";
					$subj = "SUMMER PROGRAM REGISTRATION--PAYING BY CHECK";
				}
				$msg = "";
				$msg .= "SUMMER PROGRAM REGISTRATION -- $type\n\n";
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
				
				if(!$is_test) {
					mail("Browdy@simons-rock.edu",$subj,$msg, "From: EngageSummer@simons-rock.edu");
				}
				mail("dscheff@simons-rock.edu",$subj,$msg, "From: EngageSummer@simons-rock.edu");

				// now to customer
				$msg = "";
				$msg .= "Thank you for registering for the Summer Program at Simon's Rock! Please keep in mind that we cannot reserve seats in the class until payment is received.\n\n";
				$msg .= "Please email us (EngageSummer@simons-rock.edu) with any questions.\n\n";
				$msg .= "TUITION DUE: \$ $totalTuition\n\n";
				$msg .= "Please make checks payable to: Bard College at Simon's Rock Summer Program\n\n";
				$msg .= "Mail/deliver to:\n";
				$msg .= "Bard College at Simon's Rock\n";
				$msg .= "Attn: Jennifer Browdy de Hernandez\n";
				$msg .= "84 Alford Rd.\n";
				$msg .= "Great Barrington, MA 01230\n\n";
				$msg .= "Class Registration summary:\n";
				$msg .= $studentClassRows;		
				$to = $parent_email;
				
				mail($to,"Simon's Rock Summer Program Registration",$msg, "From: EngageSummer@simons-rock.edu");
				mail("dscheff@simons-rock.edu","COPY (parent email): Simon's Rock Summer Program Registration",$msg, "From: EngageSummer@simons-rock.edu");
			}
		}
		else{
			//do the form again, prepopulate the fields 
			
		}
	}
}



?>

<!DOCTYPE HTML>
<html><head>
<meta charset="utf-8">
<title>Summer Program Registration</title>

<script type="text/javascript">
<!--
function toggleClasses(clickedClass,changeClass){
	var classToChange = "class";
	classToChange += changeClass;
	var divToChange = classToChange;
	divToChange += "Div";

	if(changeClass != "0"){
		if(clickedClass.checked){
			document.getElementById(classToChange).disabled = true;
			document.getElementById(divToChange).style.color = 'gray';
		}
		else{
			document.getElementById(classToChange).disabled = false;
			document.getElementById(divToChange).style.color = '#000';
		}
	}
}

function toggleSummer(it){
	if(it.checked){
		document.request.summeraddress_street.value = document.request.permaddress_street.value;
		document.request.summeraddress_street2.value = document.request.permaddress_street2.value;
		document.request.summeraddress_city.value = document.request.permaddress_city.value;
		document.request.summeraddress_state.value = document.request.permaddress_state.value;
		document.request.summeraddress_zip.value = document.request.permaddress_zip.value;
	}	
	else {
		document.request.summeraddress_street.value = "";
		document.request.summeraddress_street2.value = "";
		document.request.summeraddress_city.value = "";
		document.request.summeraddress_state.value = "---Please Select---";
		document.request.summeraddress_zip.value = "";
	}
}


function calculate(){

<?php if(isset($_POST['totalTuition']) && $_POST['totalTuition'] != ""){ ?>
	var startingTotal = <?php echo($_POST['totalTuition']) ?>;
<?php } else {?>
	var startingTotal = 0;
<?php } ?>
<?php if($addPayerIdField == " "){ ?>
	var dayVal = 60;
<?php } else { ?>
	var dayVal = 50;
<?php } ?>
	var dayValDiscount = 50; 
	var otherFees = 50; 
	var classCount = 0;
	var week1Sum = 0;
	var week2Sum = 0;
	var week3Sum = 0;
	var week4Sum = 0;
	var theSum = 0;

	var classArray = new Array(
		"document.request.class1.checked",
		"document.request.class2.checked",
		"document.request.class3.checked",
		"document.request.class4.checked",
		"document.request.class5.checked",
		"document.request.class6.checked",
		"document.request.class7.checked",
		"document.request.class8.checked",
		"document.request.class9.checked",
		"document.request.class10.checked",
		"document.request.class11.checked",
		"document.request.class12.checked");
	var week1Array = new Array(
		"document.request.class1.checked",
		"document.request.class2.checked",
		"document.request.class3.checked");
	var week2Array = new Array(
		"document.request.class4.checked",
		"document.request.class5.checked",
		"document.request.class6.checked");
	var week3Array = new Array(
		"document.request.class7.checked",
		"document.request.class8.checked",
		"document.request.class9.checked")
	var week4Array = new Array(
		"document.request.class10.checked",
		"document.request.class11.checked",
		"document.request.class12.checked")		

	for (x=0;x<classArray.length;x++){
		if(eval(classArray[x])){
			classCount++;
		}	
	}
	if(classCount > 1 || document.request.multi_student.checked){
		dayVal = dayValDiscount;
	}
	
	for (x=0;x<week1Array.length;x++){
		if(eval(week1Array[x])){
			week1Sum += dayVal;
		}	
	}
	for (x=0;x<week2Array.length;x++){
		if(eval(week2Array[x])){
			week2Sum += dayVal;
		}	
	}
	for (x=0;x<week3Array.length;x++){
		if(eval(week3Array[x])){
			week3Sum += dayVal;
		}	
	}
	for (x=0;x<week4Array.length;x++){
		if(eval(week4Array[x])){
			week4Sum += dayVal;
		}	
	}
	week1Sum = week1Sum*4;
	week2Sum = week2Sum*5;
	week3Sum = week3Sum*5;
	week4Sum = week4Sum*5;
	
	if(document.request.class6.checked){
		week2Sum += otherFees;
	}
	if(document.request.class7.checked){
		week3Sum += otherFees;
	}
	document.request.week1Total.value = week1Sum;
	document.request.week2Total.value = week2Sum;
	document.request.week3Total.value = week3Sum;
	document.request.week4Total.value = week4Sum;
	theSum = week1Sum + week2Sum + week3Sum + week4Sum;

	document.getElementById('totalTuitionSpan').innerHTML = theSum;
	document.request.totalTuition.value = theSum + startingTotal;
<?php if(isset($_POST['totalTuition']) && $_POST['totalTuition'] != ""){ ?>
	document.getElementById('grandTotalTuitionSpan').innerHTML = theSum + startingTotal;
<?php } ?>
	if(theSum != '0' && theSum != '' && theSum != 0) {
	    document.getElementById('totalTuitionSpan').style.backgroundColor = '#fff';
	}
	else{
	    document.getElementById('totalTuitionSpan').style.backgroundColor = '#ffcccc';
	}
	calculateFaculty();
}
function calculateFaculty(){
<?php if(isset($_POST['totalTuitionFaculty']) && $_POST['totalTuitionFaculty'] != ""){ ?>
	var startingTotal = <?php echo($_POST['totalTuitionFaculty']) ?>;
<?php } else {?>
	var startingTotal = 0;
<?php } ?>
<?php if($addPayerIdField == " "){ ?>
	var dayVal = 50;
<?php } else { ?>
	var dayVal = 40;
<?php } ?>
	var dayValDiscount = 40; 
	var otherFees = 50; 
	var classCount = 0;
	var week1Sum = 0;
	var week2Sum = 0;
	var week3Sum = 0;
	var week4Sum = 0;
	var theSum = 0;

	
	var classArray = new Array(
		"document.request.class1.checked",
		"document.request.class2.checked",
		"document.request.class3.checked",
		"document.request.class4.checked",
		"document.request.class5.checked",
		"document.request.class6.checked",
		"document.request.class7.checked",
		"document.request.class8.checked",
		"document.request.class9.checked",
		"document.request.class10.checked",
		"document.request.class11.checked",
		"document.request.class12.checked");
	var week1Array = new Array(
		"document.request.class1.checked",
		"document.request.class2.checked",
		"document.request.class3.checked");
	var week2Array = new Array(
		"document.request.class4.checked",
		"document.request.class5.checked",
		"document.request.class6.checked");
	var week3Array = new Array(
		"document.request.class7.checked",
		"document.request.class8.checked",
		"document.request.class9.checked")
	var week4Array = new Array(
		"document.request.class10.checked",
		"document.request.class11.checked",
		"document.request.class12.checked")		

	for (x=0;x<classArray.length;x++){
		if(eval(classArray[x])){
			classCount++;
		}	
	}
	if(classCount > 1){
		dayVal = dayValDiscount;
	}
	
	for (x=0;x<week1Array.length;x++){
		if(eval(week1Array[x])){
			week1Sum += dayVal;
		}	
	}
	for (x=0;x<week2Array.length;x++){
		if(eval(week2Array[x])){
			week2Sum += dayVal;
		}	
	}
	for (x=0;x<week3Array.length;x++){
		if(eval(week3Array[x])){
			week3Sum += dayVal;
		}	
	}
	for (x=0;x<week4Array.length;x++){
		if(eval(week4Array[x])){
			week4Sum += dayVal;
		}	
	}
	week1Sum = week1Sum*4;
	week2Sum = week2Sum*5;
	week3Sum = week3Sum*5;
	week4Sum = week4Sum*5;
	
	// what about 'otherFees' for class 6 & 7
	if(document.request.class6.checked){
		week2Sum += otherFees;
	}
	if(document.request.class7.checked){
		week3Sum += otherFees;
	}

	theSum = week1Sum + week2Sum + week3Sum + week4Sum;
	document.request.totalTuitionFaculty.value = theSum + startingTotal;
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
	width: 50px; 
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
  <div id="stylized" class="myform">
  
    
<?php
if((isset($content)) && $content!=""){
	echo ($content);
	exit();
}
?>
<div id="innertop"></div>
	<p style="margin: 15px; font-size:16px"><strong>Bard College at Simon’s Rock Summer Program<br>2012 Registration Form</strong></p>
	<?php
		echo($multiChildHeader);
	?>
	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()">
<?php

echo($addPayerIdField);

?>
    <div class="spacer" style="clear:both"></div>
	<div style="clear:both;" id="student1Div">
    	<div style="clear:both" id="student1FnameDiv">
          <label for="date">Date: </label>
		  <input type="text" value="<?php echo(date('m/d/Y')); ?>" readonly disabled>
        </div>
    	<div style="clear:both" id="applicant_nameDiv">
          <label for="applicant_name">Applicant Name
          </label>
          <input type="text" name="applicant_name" id="applicant_name" /><span class="required">*</span>
        </div>
        <div style="clear:both; margin-left: 15px;"><strong>Permanent Address</strong></div>
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

        <div style="clear:both; margin-left: 15px;">
			<div style="float: left">
				<strong>Summer Address</strong> 
			</div>
			<div>
				<input style="width: 20px" type="checkbox" name="summerSame" id="summerSame" onClick="toggleSummer(this)"><label for="summerSame" style="padding-top: 0px; width: auto">(Check box if same as permanent)</label>
			</div>
		</div>
        <div style="clear:both" id="summeraddress_streetDiv">
          <label for="summeraddress_street">Street</label>
          <input type="text" name="summeraddress_street" id="summeraddress_street" 
		  <?php
		  	if(isset($summeraddress_street)){
				echo (" value=\"$summeraddress_street\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="summeraddress_street2Div">
          <label for="summeraddress_street2">Street Address 2</label>
          <input type="text" name="summeraddress_street2" id="summeraddress_street2"
		  <?php
		  	if(isset($summeraddress_street2)){
				echo (" value=\"$summeraddress_street2\" ");
			}
		  ?>
		   />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="summeraddress_cityDiv">
          <label for="summeraddress_city">City</label>
          <input type="text" name="summeraddress_city" id="summeraddress_city" 
		  <?php
		  	if(isset($summeraddress_city)){
				echo (" value=\"$summeraddress_city\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="summeraddress_stateDiv">
          <label for="summeraddress_state">State</label>
		 <select name="summeraddress_state" id="summeraddress_state" />
 		  <?php
		  	if(isset($summeraddress_state)){
				echo ("<option value=\"$summeraddress_state\" selected>$summeraddress_state</option>");
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
        <div style="clear:both" id="summeraddress_zipDiv">
          <label for="summeraddress_zip">Postal Code</label>
          <input type="text" name="summeraddress_zip" id="summeraddress_zip" 
		  <?php
		  	if(isset($summeraddress_zip)){
				echo (" value=\"$summeraddress_zip\" ");
			}
		  ?>		  
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="student_phoneDiv">
          <label for="student_phone">Student's Phone (during the summer)</label>
          <input type="text" name="student_phone" id="student_phone"
		  <?php
		  	if(isset($student_phone)){
				echo (" value=\"$student_phone\" ");
			}
		  ?>				  
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="guardian_nameDiv">
          <label for="guardian_name">Parent/guardian name</label>
          <input type="text" name="guardian_name" id="guardian_name" 
		  <?php
		  	if(isset($guardian_name)){
				echo (" value=\"$guardian_name\" ");
			}
		  ?>	
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="guardian_phone_dayDiv">
          <label for="guardian_phone_day">Parent/guardian daytime or cell phone</label>
          <input type="text" name="guardian_phone_day" id="guardian_phone_day"
		  <?php
		  	if(isset($guardian_phone_day)){
				echo (" value=\"$guardian_phone_day\" ");
			}
		  ?>	
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="guardian2_nameDiv">
          <label for="guardian2_name">Parent/guardian #2 name</label>
          <input type="text" name="guardian2_name" id="guardian2_name"
		  <?php
		  	if(isset($guardian2_name)){
				echo (" value=\"$guardian2_name\" ");
			}
		  ?>	
		  />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="guardian2_phone_dayDiv">
          <label for="guardian2_phone_day">Parent/guardian #2 daytime or cell phone</label>
          <input type="text" name="guardian2_phone_day" id="guardian2_phone_day"
		  <?php
		  	if(isset($guardian2_phone_day)){
				echo (" value=\"$guardian2_phone_day\" ");
			}
		  ?>
		   />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="emergency_nameDiv">
          <label for="emergency_name">Emergency contact name</label>
          <input type="text" name="emergency_name" id="emergency_name"
		  <?php
		  	if(isset($emergency_name)){
				echo (" value=\"$emergency_name\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="emergency_phoneDiv">
          <label for="emergency_phone">Emergency contact phone</label>
          <input type="text" name="emergency_phone" id="emergency_phone"
		  <?php
		  	if(isset($emergency_phone)){
				echo (" value=\"$emergency_phone\" ");
			}
		  ?>
		  /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="student_emailDiv">
          <label for="student_email">Student's E-mail</label>
          <input type="email" name="student_email" id="student_email" />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="parent_emailDiv">
          <label for="parent_email">Parent's E-mail</label>
          <input type="email" name="parent_email" id="parent_email"
		  <?php
		  	if(isset($parent_email)){
				echo (" value=\"$parent_email\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>

        <div class="spacer"></div>
        <div style="clear:both; margin-left: 15px;"><strong>Student's School</strong></div>
        <div class="spacer"></div>
        <div style="clear:both" id="student_schoolDiv">
          <label for="student_school">School Name</label>
          <input type="text" name="student_school" id="student_school"
		  <?php
		  	if(isset($student_school)){
				echo (" value=\"$student_school\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="schooladdress_streetDiv">
          <label for="schooladdress_street">Street</label>
          <input type="text" name="schooladdress_street" id="schooladdress_street" 
		  <?php
		  	if(isset($schooladdress_street)){
				echo (" value=\"$schooladdress_street\" ");
			}
		  ?>		  
		  />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="schooladdress_street2Div">
          <label for="schooladdress_street2">Street Address 2</label>
          <input type="text" name="schooladdress_street2" id="schooladdress_street2"
		  <?php
		  	if(isset($schooladdress_street2)){
				echo (" value=\"$schooladdress_street2\" ");
			}
		  ?>
		   />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="schooladdress_cityDiv">
          <label for="schooladdress_city">City</label>
          <input type="text" name="schooladdress_city" id="schooladdress_city"
		  <?php
		  	if(isset($schooladdress_city)){
				echo (" value=\"$schooladdress_city\" ");
			}
		  ?>
		   /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="schooladdress_stateDiv">
          <label for="schooladdress_state">State</label>
          <select name="schooladdress_state" id="schooladdress_state" />
 		  <?php
		  	if(isset($schooladdress_state)){
				echo ("<option value=\"$schooladdress_state\" selected>$schooladdress_state</option>");
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
        <div style="clear:both" id="schooladdress_zipDiv">
          <label for="schooladdress_zip">Zip</label>
          <input type="text" name="schooladdress_zip" id="schooladdress_zip"
		  <?php
		  	if(isset($schooladdress_zip)){
				echo (" value=\"$schooladdress_zip\" ");
			}
		  ?>
		   />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="gradelevel_2012Div">
          <label for="gradelevel_2012">Student’s grade level in Fall 2012</label>
          <input type="text" name="gradelevel_2012" id="gradelevel_2012" /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="acad_interestsDiv">
          <label for="acad_interests">Academic Interests</label>
          <input type="text" name="acad_interests" id="acad_interests" />
        </div>
        <div class="spacer"></div>
        <div style="clear:both" id="extra_interestsDiv">
          <label for="extra_interests">Extracurricular Interests</label>
          <input type="text" name="extra_interests" id="extra_interests" />
        </div>
        <div class="spacer"></div>
		<p style="margin: 15px; font-size:16px"><strong>Tuition and Payment Information</strong></p>
		<div class="div_par">Tuition for each class is $300, or $250/class for two or more classes, with the exception of Week One, which has only 4 days of classes (July 2-6 excluding July 4). Tuition for each Week One class is $240, or $200/class for two or more classes within that week. Some classes require an additional materials fee, as noted in the class description.</div>
		<div class="div_par"><strong>NOTE: </strong>The multi-class discount is applicable per family, not per child. If you are enrolling more than one child, the multi-class discount applies even if each child only takes one class. 
		<?php
		echo ($multiChildNote);
		?>
		 <input type="checkbox" name="multi_student" id="multi_student" value="on" onChange="calculate()" style="width: 20px; float: none;" /> </div>
		
		
		<div class="div_par">Tuition is due in full at the time of registration. Refunds of all but a 10% processing fee will be made if written cancellation notice is postmarked or received in person at least two weeks prior to the start of the class. Refunds will not be given for late arrivals, early departures, missed days or dismissals due to disciplinary issues.</div>
		<div style="margin: 15px 15px 0 15px;">
			$<input class="nofloatInput" type="text" name="week1Total" id="week1Total" readonly value="0"> 
			Week 1, July 2-6 ($240 for one class, $400 for two)
		</div>
		<?php
			echo ($week1); 
		?>
        <div class="spacer"></div>
		<div style="margin: 15px 15px 0 15px;">
			$<input class="nofloatInput" type="text" name="week2Total" id="week2Total" readonly value="0"> 
			Week 2, July 9-13 ($300 for one class, $500 for two)
		</div>
        <div class="spacer"></div>
		<?php
			echo ($week2); 
		?>
        <div class="spacer"></div>
		<div style="margin: 15px 15px 0 15px;">
			$<input class="nofloatInput" type="text" name="week3Total" id="week3Total" readonly value="0"> 
			Week 3, July 16-20 ($300 for one class, $500 for two)
		</div>
		<?php
			echo ($week3); 
		?>
        <div class="spacer"></div>
		<div style="margin: 15px 15px 0 15px;">
			$<input class="nofloatInput" type="text" name="week4Total" id="week4Total" readonly value="0"> 
			Week 4, July 23-27 ($300 for one class, $500 for two)
		</div>
		<?php
			echo ($week4); 
		?>
		
		
	</div>
	<div class="spacer" style="height: 20px;"></div>
	<div style="margin-left:15px;"><strong>$</strong><span id="totalTuitionSpan" style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		<input type="hidden" name="totalTuition" id="totalTuition" value="0">
		<strong> TOTAL TUITION FOR THIS STUDENT </strong>
		<input type="hidden" name="totalTuitionFaculty" id="totalTuitionFaculty" value="" />
	</div>
	<?php if(isset($_POST['totalTuition']) && $_POST['totalTuition'] != "") {?>
	<div class="spacer" style="height: 10px;"></div>
	<div style="margin-left:15px;"><strong>$</strong><span id="grandTotalTuitionSpan" style="font-weight: bold"><?php echo($_POST['totalTuition']);?></span> <strong> RUNNING TOTAL TUITION (includes all prior students) </strong>
	<?php } ?>
	<div class="spacer" style="height: 20px;"></div>


	<div><strong>Parent/Guardian Release</strong></div>
	<div>Please read carefully.  You must check the box below to signify that you have read, understand and agree to the following:<br>

		<textarea readonly style="width:500px; height: 100px;">The Bard College at Simon’s Rock Summer Program strives to be an academic community in which students are active and engaged learners, while demonstrating honesty and integrity, and taking responsibility for their actions. By signing this registration form I acknowledge that I have read the entire registration form in detail and I give my child permission to participate in all course-related summer programs, excursions and special outings as planned and supervised by Bard College at Simon’s Rock. I recognize there are risks inherent in students’ use of the facilities at Bard College at Simon’s Rock and hold harmless the related parties (faculty and administration) from and against all claims and demands whatsoever on account of or in any way from any accidental occurrence. 
			
I fully understand that Bard College at Simon’s Rock reserves the right to dismiss at its sole discretion any student whose condition, conduct, influence or behavior is deemed by the Program Director as unsatisfactory or detrimental to the best interests of the Program. No refunds are made for students dismissed for misconduct or disciplinary reasons. Misconduct and illegal acts, such as using non-prescription drugs, smoking and consuming alcoholic beverages are prohibited on the Simon’s Rock campus. Violations of these prohibitions as well as any other disruptive or illegal behavior constitute grounds for dismissal from the Summer Program.
			
I acknowledge that Bard College at Simon’s Rock does not maintain any health or medical insurance which would cover my child while attending the Summer Program. The parent or legal guardian shall be responsible for the administration and cost of any medical treatment, drugs and the like for a Summer Program student. Bard College at Simon’s Rock will not be responsible for the personal health and well-being of students whose release form has not been signed by the parent. I have read the above and understand and agree to its meaning. 
			
I agree to enroll my child in the 2012 Summer Program, subject to the terms in this contract. I agree to pay my tuition in full. I hereby give Bard College at Simon’s Rock permission to use my child’s image in their brochures, videos, Internet sites and other camp advertising.</textarea>
	</div>
	<div class="spacer" style="height: 20px;"></div>
	<div>
		<div style="float:left"><input type="checkbox" name="consent" value="on" id="consent" class="nofloatInput" style="width:15px"> </div>
		<div><label style="padding-top: 0; width: auto" for="consent">I have read, understand and agree to the terms above.</label></div>
	</div>
	<div class="spacer" style="height: 5px;"></div>
	<div>
		<div style="float:left"><input type="checkbox" name="is_faculty" id="is_faculty" value="on" class="nofloatInput" style="width:15px" <?php echo($checkFaculty); ?>  ></div>
		<div><label style="padding-top: 0; width: auto" for="is_faculty">I am an active employee of Bard College at Simon's Rock.</label>
	</div>
	<div class="spacer" style="height: 5px;"></div>
	<div style="padding-left: 15px" id="mop">
        Method of payment: <br>
(Note that class seats paid by check cannot be guaranteed until payment is received)<br>
		<div style="padding-top:5px; height: 30px; width: 250px; "><input style="width:15px; height:10px; vertical-align:texttop" type="radio" value="paypal" name="mop" id="mop_paypal" <?php echo($checkPaypal); ?> > <label for="mop_paypal" style="width:90px; text-align:left; line-height:12px">Credit Card</label></div>
		<div style="padding-top:5px; height: 25px; width: 250px"><input style="width:15px; height:10px"  type="radio" name="mop" value="check" id="mop_check" <?php echo($checkCheck); ?> > <label for="mop_check" style="width:90px; text-align:left; line-height:12px">Check</label></div>
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
function classCount(){
	var classCount = 0;
	var classArray = new Array(
		"document.request.class1.checked",
		"document.request.class2.checked",
		"document.request.class3.checked",
		"document.request.class4.checked",
		"document.request.class5.checked",
		"document.request.class6.checked",
		"document.request.class7.checked",
		"document.request.class8.checked",
		"document.request.class9.checked",
		"document.request.class10.checked",
		"document.request.class11.checked",
		"document.request.class12.checked");
	var week1Array = new Array(
		"document.request.class1.checked",
		"document.request.class2.checked",
		"document.request.class3.checked");
	var week2Array = new Array(
		"document.request.class4.checked",
		"document.request.class5.checked",
		"document.request.class6.checked");
	var week3Array = new Array(
		"document.request.class7.checked",
		"document.request.class8.checked",
		"document.request.class9.checked")
	var week4Array = new Array(
		"document.request.class10.checked",
		"document.request.class11.checked",
		"document.request.class12.checked")		

	for (x=0;x<classArray.length;x++){
		if(eval(classArray[x])){
			classCount++;
		}	
	}
	return classCount
}

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
        if (document.request.summeraddress_street.value.length == 0) {
            document.request.summeraddress_street.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "summeraddress_street";
			}
		} 
		else {
            document.request.summeraddress_street.style.backgroundColor = normal
		}
        if (document.request.summeraddress_city.value.length == 0) {
            document.request.summeraddress_city.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "summeraddress_city";
			}
		} 
		else {
            document.request.summeraddress_city.style.backgroundColor = normal
		}
		if (document.getElementById('summeraddress_state').options[document.getElementById('summeraddress_state').selectedIndex].value == '---Please Select---') {
            document.request.summeraddress_state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "summeraddress_state";
			}
		} 
		else{
            document.request.summeraddress_state.style.backgroundColor = normal
		}		
        if (document.request.summeraddress_zip.value.length == 0) {
            document.request.summeraddress_zip.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "summeraddress_zip";
			}
		} 
		else {
            document.request.summeraddress_zip.style.backgroundColor = normal
		}
	
        if (document.request.student_phone.value.length == 0) {
            document.request.student_phone.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "student_phone";
			}
		} 
		else {
            document.request.student_phone.style.backgroundColor = normal
		}
	
        if (document.request.guardian_name.value.length == 0) {
            document.request.guardian_name.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "guardian_name";
			}
		} 
		else {
            document.request.guardian_phone_day.style.backgroundColor = normal
		}
	
        if (document.request.guardian_phone_day.value.length == 0) {
            document.request.guardian_phone_day.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "guardian_phone_day";
			}
		} 
		else {
            document.request.guardian_phone_day.style.backgroundColor = normal
		}
	
        if (document.request.emergency_name.value.length == 0) {
            document.request.emergency_name.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "emergency_name";
			}
		} 
		else {
            document.request.emergency_name.style.backgroundColor = normal
		}
	
        if (document.request.emergency_phone.value.length == 0) {
            document.request.emergency_phone.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "emergency_phone";
			}
		} 
		else {
            document.request.emergency_phone.style.backgroundColor = normal
		}
	
        if (document.request.parent_email.value.length == 0) {
            document.request.parent_email.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "parent_email";
			}
		} 
		else {
            document.request.parent_email.style.backgroundColor = normal
		}
	
        if (document.request.student_school.value.length == 0) {
            document.request.student_school.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "student_school";
			}
		} 
		else {
            document.request.student_school.style.backgroundColor = normal
		}

        if (document.request.schooladdress_city.value.length == 0) {
            document.request.schooladdress_city.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "schooladdress_city";
			}
		} 
		else {
            document.request.schooladdress_city.style.backgroundColor = normal
		}
		if (document.getElementById('schooladdress_state').options[document.getElementById('schooladdress_state').selectedIndex].value == '---Please Select---') {
            document.request.schooladdress_state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "schooladdress_state";
			}
		} 
		else{
            document.request.schooladdress_state.style.backgroundColor = normal
		}	
        if (document.request.gradelevel_2012.value.length == 0) {
            document.request.gradelevel_2012.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "gradelevel_2012";
			}
		} 
		else {
            document.request.gradelevel_2012.style.backgroundColor = normal
		}
        if (document.request.totalTuition.value == '0') {
            document.getElementById('totalTuitionSpan').style.backgroundColor = highlight
            tuitionval = false
			if(fieldFocus == ""){
				fieldFocus = "totalTuition";
			}
		} 
		else {
            document.getElementById('totalTuitionSpan').style.backgroundColor = normal
		}
		
        if (!document.request.consent.checked) {
            document.request.consent.style.backgroundColor = highlight
            consentval = false
			if(fieldFocus == ""){
				fieldFocus = "consent";
			}
		} 
		else {
            document.request.consent.style.backgroundColor = normal
		}

        if (!rval) {
			alert ("Please complete all required (highlighted) fields prior to submitting your form.");
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).focus();
			}
		}
		else if(!classCount()){
            rval = false
			fieldFocus = "totalTuition";
			alert ("You must select at least one class.");
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).focus();
			}
		}
		else if(!consentval){
            rval = false
			fieldFocus = "consent";
			alert ("You must agree to the terms of the Parent/Guradian Release by checking the box below them.");
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).focus();
			}
		}
		else if(!getCheckedValue(document.request.mop)){
            rval = false
			fieldFocus = "mop";
			alert ("Please select a method of payment");
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

document.getElementById('innertop').scrollIntoView();
// -->
</script>
</body>
</html>
