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
	if($_POST['student1Fname'] == ""){
		$post_msg .= "First name";
	}
	else{
		foreach($_POST as $textKey => $textValue){
			$textValue = str_replace( "(", " - ", $textValue);
			$textValue = str_replace( ")", " - ", $textValue);
			$$textKey = addslashes($textValue);
			if(stristr($$textKey, "please select")){
				$$textKey = "N/A";
			}
			if(stristr($textKey, "Adult") && $textValue==""){
				$$textKey = "0";
			}
			if(stristr($textKey, "Child") && $textValue==""){
				$$textKey = "0";
			}
			if(stristr($textKey, "Brunch") && $textValue==""){
				$$textKey = "0";
			}
			if(stristr($textKey, "Breakfast") && $textValue==""){
				$$textKey = "0";
			}
			if(stristr($textKey, "Dinner") && $textValue==""){
				$$textKey = "0";
			}
			if(stristr($textKey, "Lunch") && $textValue==""){
				$$textKey = "0";
			}
		}

		$sql = "INSERT INTO forms.family_weekend (
				student1Fname, student1Lname, student1Class, student1Meeting, student2Fname, student2Lname, student2Class, student2Meeting, accessibilityNeeds, 
				relative1Fname, relative1Lname, relative1Hometown, relative1Homestate, relative1Country, relative1Class, 
				relative2Fname, relative2Lname, relative2Hometown, relative2Homestate, relative2Country, relative2Class, 
				relative3Fname, relative3Lname, relative3Hometown, relative3Homestate, relative3Country, relative3Class, 
				relative4Fname, relative4Lname, relative4Hometown, relative4Homestate, relative4Country, relative4Class, 
				relative5Fname, relative5Lname, relative5Hometown, relative5Homestate, relative5Country, relative5Class, 
				honorsConvocationAdults, honorsConvocationChild, 
				welcomeReceptionAdults, welcomeReceptionChild,
				jazzEnsembleConcertAdults, jazzEnsembleConcertChild,
				FYAdjustmentAdults, FYAdjustmentChild, 
				alumniPanelAdults, alumniPanelChild, 
				studyAbroadPanelAdults, studyAbroadPanelChild, 
				internationalFairAdults, internationalFairChild, 
				seniorThesisPanelAdults, seniorThesisPanelChild, 
				studentShowcaseAdults, studentShowcaseChild, 
				provostsReceptionAdults, 
				hikeUpMountainAdults, hikeUpMountainChild, 
				fridayLunchAdults, fridayDinnerAdults, 
				saturdayBrunchAdults, saturdayDinnerAdults, 
				sundayBrunchAdults, 
				totalFamilyMembersAttending, date_submitted, student1MeetingSpecifyWhich, student2MeetingSpecifyWhich, relative1Email,
				academicAdvisorMeeting1,academicAdvisorMeeting2,sophomoreFacultyMeeting1,sophomoreFacultyMeeting2,SMLateArrival1, 
				arrivaldetails1,SMLateArrival2, arrivaldetails2, seniorThesisAdvisorMeeting1, seniorThesisAdvisorMeeting2)  
 		VALUES ('$student1Fname', '$student1Lname', '$student1Class', '$student1Meeting', '$student2Fname', '$student2Lname', '$student2Class', '$student2Meeting', '$accessibilityNeeds', 
				'$relative1Fname', '$relative1Lname', '$relative1Hometown', '$relative1Homestate', '$relative1Country', '$relative1Class', 
				'$relative2Fname', '$relative2Lname', '$relative2Hometown', '$relative2Homestate', '$relative2Country', '$relative2Class', 
				'$relative3Fname', '$relative3Lname', '$relative3Hometown', '$relative3Homestate', '$relative3Country', '$relative3Class', 
				'$relative4Fname', '$relative4Lname', '$relative4Hometown', '$relative4Homestate', '$relative4Country', '$relative4Class', 
				'$relative5Fname', '$relative5Lname', '$relative5Hometown', '$relative5Homestate', '$relative5Country', '$relative5Class', 
				$honorsConvocationAdults, $honorsConvocationChild, 
				$welcomeReceptionAdults, $welcomeReceptionChild,
				$jazzEnsembleConcertAdults, $jazzEnsembleConcertChild,
				$FYAdjustmentAdults, $FYAdjustmentChild, 
				$alumniPanelAdults, $alumniPanelChild, 
				$studyAbroadPanelAdults, $studyAbroadPanelChild, 
				$internationalFairAdults, $internationalFairChild, 
				$seniorThesisPanelAdults, $seniorThesisPanelChild, 
				$studentShowcaseAdults, $studentShowcaseChild, 
				$provostsReceptionAdults, 
				$hikeUpMountainAdults, $hikeUpMountainChild, 
				$fridayLunch, $fridayDinner, 
				$saturdayBrunch, $saturdayDinner, 
				$sundayBrunch, 
				$totalFamilyMembersAttending, NOW(), '$student1MeetingSpecifyWhich', '$student2MeetingSpecifyWhich', '$relative1Email', 
				'$academicAdvisorMeeting1', '$academicAdvisorMeeting2', '$sophomoreFacultyMeeting1', '$sophomoreFacultyMeeting2','$SMLateArrival1',
				'$arrivaldetails1','$SMLateArrival2','$arrivaldetails2','$seniorThesisAdvisorMeeting1','$seniorThesisAdvisorMeeting2')";
		$db->do_query($sql);
//echo ($sql);
//exit();	
/* --------------ADDED PAYAL ------------ 
	#20130910 @dscheff
----------------------------------------- */

		$sql = "SELECT id from forms.family_weekend ORDER BY id DESC LIMIT 1";
		$db->do_query($sql);
		$result = $db->fetchObject();
		$thisContactId = $result->id;
		$thisPayerId = $thisContactId;

		$paidfor = '0';
/*
		if($mop == 'check'){
			$paidfor = '1';
		}
*/
		// build the list of meals purchased (meal1:quantity|meal2:quantity|)
		$post_success = true;

		$mealsArray = array('fridayLunch','fridayDinner','saturdayBrunch','saturdayDinner','sundayBrunch');
		$meals = "";
		foreach ($mealsArray as $meal){
			$meals .= $meal.":".$$meal."|";
			/* add a record to the meal table... maybe
			$sql = "INSERT INTO forms.fw_meals (meal, contact_id, qunatity)
					VALUES ('$meal', $thisPayerId, '$paidfor', $$meal)";
			$db->do_query($sql);
			*/
		}
		$meals = substr($meals,0,(strlen($meals)-1));

		$sql = "INSERT INTO forms.fw_program_meal_registration (contact_id, meals, payer_id, paid_for, date_submitted, mop)
				VALUES ($thisContactId,'$meals', $thisPayerId, '$paidfor', NOW(), '$mop')";
		$db->do_query($sql);
	
		$sql = "INSERT INTO forms.fw_meal_registration (contact_id,total) 
				VALUE ($thisContactId,$total)";
		$db->do_query($sql);

		// now we decide where to send them, and what emails to send to whom...
		if($mop == "paypal"){


			$paybuttons = '
				<form name="paypalform" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_parent">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="3X4KTT5ATNBNA">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="first_name" value="'.$relative1Fname.'">
				<input type="hidden" name="last_name" value="'.$relative1Lname.'">
<!--
				<input type="hidden" name="address1" value="'.$permaddress_street.'">
				<input type="hidden" name="zip" value="'.$permaddress_zip.'">
				<input type="hidden" name="address2" value="'.$permaddress_street2.'"> 
-->
				<input type="hidden" name="city" value="'.$relative1Hometown.'">
				<input type="hidden" name="state" value="'.$relative1Homestate.'">
				<input type="hidden" name="email" value="'.$relative1Email.'">
				<input type="hidden" name="item_name" value="Family Weekend Meal Pre-purchase">
				<input type="hidden" name="button_subtype" value="service">
				<input type="hidden" name="no_note" value="0">
				<input type="hidden" name="cn" value="Add special instructions to the seller">
				<input type="hidden" name="no_shipping" value="0">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
				<input type="hidden" name="payer_id" value="'.$thisPayerId.'">
				<input type="hidden" name="custom" value="'.$thisPayerId.'">
				<input type="hidden" name="return" value="http://www.simons-rock.edu/parents-families/family-weekend/family-weekend-registration-confirmation" />
				<input type="hidden" name="notify_url" value="http://forms.simons-rock.edu/family-weekend/listener.php" />
 				<input type="hidden" name="amount" value="'.$total.'">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				<script>document.paypalform.submit()</script>';
				$contents = "<div style='width:100%;'><div style='width:250px;margin:auto;margin-top:100px;text-align:center'>Redirecting to Paypal... please wait a few moments.<br /><br /><img src='icon-loading-animated.gif' style='width:35px' /><br /><br />If after 10 seconds the page has not taken you to Paypal, <a href=\"javascript:document.paypalform.submit()\">click here</a>.<br /><br />";
				$contents .= $paybuttons.'</div></div>';
			echo ($contents);
			$post_success = false;

		}

		// #20130912 @dscheff - added per K Advokaat email confirmation to registrant 
		$msg  = "";
		$msg .= "Dear $relative1Fname,\n\n";
		$msg .= "Thank you for registering for Family Weekend! We look forward to seeing you.\n\n";
		$msg .= "To confirm, you have registered for:\n\n";
		$msg .= "== MEETINGS REQUESTED ==\n\n";
		// student 1
		$msg .= "  For $student1Fname $student1Lname:\n";
		$prepend = "";
		if($academicAdvisorMeeting1 != "1"){
			$prepend = "    - No meeting";
		}
		else {
			$prepend = "    - Meeting";
		}
		$msg .= "$prepend with the academic advisor.\n";
		if($student1Meeting == "none") {
			$msg .= "    - No meetings with faculty.\n";
		}
		else if($student1Meeting == "some"){
			$msg .= "    - Meetings with faculty (Specifically $student1MeetingSpecifyWhich\n";
		}
		else{
			$msg .= "    - Meetings with faculty\n";
		}
		if($student1Class == "Sophomore"){
			$prepend = "";
			if($sophomoreFacultyMeeting1 != "1"){
				$msg .= "    - No sophomore meeting\n";
			}
			else {
				$msg .= "    - Sophomore planning meeting\n";
			}
			if($SMLateArrival1 == "on"){
				$msg .= "    (You requested this for Saturday morning b/w 10am and 12pm instead of Friday afternoon.)\n";
				if($arrivaldetails1 != ""){
					$msg .= "    You noted: $arrivaldetails1\n";
				}
			}
		}

		if($student1Class == "Senior"){
			$prepend = "";
			if($seniorThesisAdvisorMeeting1 != "1"){
				$msg .= "    - No Senior Thesis Advisor meeting\n";
			}
			else {
				$msg .= "    - Senior Thesis Advisor meeting\n";
			}
		}

		
		// student 2
		if($student2Fname != "") {
			$msg .= "\n  For $student2Fname $student2Lname:\n";
			$prepend = "";
			if($academicAdvisorMeeting2 != "1"){
				$prepend = "    - No meeting";
			}
			else {
				$prepend = "    - Meeting";
			}
			$msg .= "$prepend with the academic advisor.\n";
			if($student2Meeting == "none") {
				$msg .= "    - No meetings with faculty.\n";
			}
			else if($student2Meeting == "some"){
				$msg .= "    - Meetings with some faculty ($student2MeetingSpecifyWhich)\n";
			}
			else{
				$msg .= "    - Meetings with all faculty\n";
			}
			if($student2Class == "Sophomore"){
				$prepend = "";
				if($sophomoreFacultyMeeting2 != "1"){
					$msg .= "    - No sophomore meeting\n";
				}
				else {
					$msg .= "    - Sophomore planning meeting\n";
				}
				if($SMLateArrival2 == "on"){
					$msg .= "   (You requested this for Saturday morning instead of Friday afternoon.)\n";
					if($arrivaldetails2 != ""){
						$msg .= "   You noted: $arrivaldetails2\n";
					}
				}
			}
			if($student2Class == "Senior"){
				$prepend = "";
				if($seniorThesisAdvisorMeeting2 != "1"){
					$msg .= "    - No Senior Thesis Advisor meeting\n";
				}
				else {
					$msg .= "    - Senior Thesis Advisor meeting\n";
				}
			}
		}
		$msg .= "\n\nIf you have registered for meetings with your student's faculty and academic advisor, please note that your schedule of actual meeting times between 9am and noon on Saturday, November 1, will be emailed to you on or before October 27th.\n\n";
		$msg .= "== ACTIVITIES ==\n\n";
		$msg .= " - Honors Convocation: $honorsConvocationAdults Adult(s), $honorsConvocationChild Child(ren)\n";
		$msg .= " - Welcome Reception: $welcomeReceptionAdults Adult(s), $welcomeReceptionChild Child(ren)\n";
		$msg .= " - Jazz Ensemble Concert: $jazzEnsembleConcertAdults Adult(s), $jazzEnsembleConcertChild Child(ren)\n";
		$msg .= " - First-year Adjustment Panel: $FYAdjustmentAdults Adult(s), $FYAdjustmentChild Child(ren)\n";
		$msg .= " - Alumni Panel: $alumniPanelAdults Adult(s), $alumniPanelChild Child(ren)\n";
		$msg .= " - Study Abroad Panel: $studyAbroadPanelAdults Adult(s), $studyAbroadPanelChild Child(ren)\n";
		$msg .= " - Senior Thesis Panel: $seniorThesisPanelAdults Adult(s), $seniorThesisPanelChild Child(ren)\n";
		$msg .= " - Student Showcase: $studentShowcaseAdults Adult(s), $studentShowcaseChild Child(ren)\n\n";
//		$msg .= " - Provost's reception: $honorsConvocationAdults (Adults only)\n\n";
//		if($total != "" && $total != 0 && $total != "0"){
//			$msg .= "== PURCHASED MEALS ==\n\n";
//		}
		$msg .= "== MEALS ATTENDANCE SPECIFIED ==\n\n";
		if($mop == "paypal"){
			$msg .= "You specified that you would pay in advance with a credit card or Paypal.  (NOTE: Meal information below indicates only what you specified on the registration form, but does not itself indicate a successful payment. Successful payment confirmation will be emailed separately.)\n\n";
		}
		elseif ($mop == "cashAtDoor"){
			$msg .= "You specified that you will pay cash at the door.  (NOTE: Please remember to have cash with you. The Dining Hall can only accept cash.)\n\n";
		}
		
		if($total == "" || $total == 0 || $total == "0"){
			$msg .= "  You did not indicate that you will be attending any meals.\n\n";
		}
		else {
			$msg .= " - Friday Lunch (\$8 per person): $fridayLunch\n";
			$msg .= " - Friday Dinner (\$9 per person): $fridayDinner\n";
			$msg .= " - Saturday Brunch & Harvest Fest Lunch (\$9 per person): $saturdayBrunch\n";
			$msg .= " - Saturday Dinner (\$9 per person): $saturdayDinner\n";
			$msg .= " - Sunday Brunch (\$9 per person): $sundayBrunch\n\n";
		}
		$msg .= "TOTAL COST FOR MEALS SPECIFIED: \$$total.\n\n";
		$msg .= "== OTHER ATTENDEES ==\n\n";
		if(
		 ($relative2Fname != "") ||
		 ($relative3Fname != "") ||
		 ($relative4Fname != "") ||
		 ($relative5Fname != "")) {
			if($relative2Fname != ""){
				$msg .= "  - $relative2Fname $relative2Lname\n";
			}
			if($relative3Fname != ""){
				$msg .= "  - $relative3Fname $relative3Lname\n";
			}
			if($relative4Fname != ""){
				$msg .= "  - $relative4Fname $relative4Lname\n";
			}
			if($relative5Fname != ""){
				$msg .= "  - $relative5Fname $relative5Lname\n";
			}
		}
		else {
			$msg .= "  - No other attendees specified.\n\n";
		}
		if($accessibilityNeeds != ""){
			$msg .= "\n== ACCESSIBILITY NEEDS ==\n\n";
			$msg .= "  - $accessibilityNeeds\n";
		}
		
		$msg .= "\nThanks, again for registering for Family Weekend at Simon's Rock!  If you have any questions, please feel free to contact me via email at cingram@simons-rock.edu or by phone at (413) 528-7266. \n\n";
		$msg .= "We look forward to seeing you soon!\n\n";
		$msg .= "Sincerely,\n\n";
		$msg .= "Cathy Ingram\n";
		$msg .= "Alumni and Parent Relations Officer\n";
		$msg .= "Family Weekend Coordinator\n";
		$msg .= "(413) 528-7266\n";	
		// send email
		$to = $relative1Email;
		mail($to,"Family Weekend Registration Confirmation",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");
		$to = "cingram@simons-rock.edu";
		mail($to,"COPY: Family Weekend Registration Confirmation",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");
		$to = "dscheff@simons-rock.edu";
		mail($to,"COPY: Family Weekend Registration Confirmation",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");
		
	}
}
$relativesTotal = 5;

$firstYearNote = "We recommend that family members of first-semester students meet with as many of their student's faculty as possible—it is a nice opportunity to put faces and names together. We prioritize scheduling parents to meet with their student's academic advisor.";
$seniorNote = "Please specify if you wish to meet with your student's academic advisor or thesis advisor, as well as any subject faculty.";
// $FMNote = "Advanced registration for meetings with faculty and advisors has ended. If you would like to meet your student&#39;s faculty members, their meeting schedules will be posted on their office doors and when you arrive on campus, you can sign yourself up in an open time slot. If you have any questions, please email Karen Advokaat (<a href=\"mailto:kadvokaat@simons-rock.edu\">kadvokaat@simons-rock.edu</a>). Thank you.";
// $FMNote = "<strong>FACULTY AND ADVISOR MEETINGS TAKE PLACE ONLY ON SATURDAY, OCTOBER 12, FROM 10:00 am to 1:00 pm</strong>. Meetings take place in faculty offices and are scheduled on 15-minute intervals.";
$FMNote = "Faculty meetings are 10-minute one-on-one appointments with your student&#39;s faculty and academic advisor. The meetings will be scheduled on Saturday, November 1 between 9 am and noon and will take place in faculty offices. Since families will be moving between buildings, the schedule of meetings will allow time as needed for going between buildings.<br><br><strong>The deadline for requesting these meetings is Wednesday, October 29</strong> however many faculty schedules fill up before this date so don&#39;t wait to request them.";


// $sophomoreNote = "Liz Lierman's schedule for sophomore planning meetings is full on Friday afternoon and Saturday morning. If you would like to make arrangements to speak with Liz about your sophomore's plans, please email her at <a href=\"mailto:llierman@simons-rock.edu\">llierman@simons-rock.edu</a>.";
$sophomoreNote = "The sophomore planning meetings are 10-minute one-on-one appointments with James Jeffries, Director of Career Development.<br><br>These meetings are intended for families and their student to discuss the moderation and transfer process, as well as plans for post-graduation.<br><br>All sophomore planning meetings will be scheduled on Friday, October 31, from 1:00 pm to 4:00 pm. If you will not be arriving until Friday evening, a few appointments will be available on Saturday morning.<br><br><strong>The deadline for requesting a Sophomore Planning Meeting is Wednesday, October 29.</strong>";
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Family Weekend Registration</title>
<?php 
if(isset($post_success) && $post_success == true){
	echo "<script>
			window.top.location.href = \"http://www.simons-rock.edu/parents-families/family-weekend/family-weekend-registration-confirmation\";
		</script>
		<noscript>
			Registration successful.  <a href=\"/parents-families/family-weekend/family-weekend-registration-confirmation\">Click here to continue</a>.
		</noscript>";
}
?>
<script type="text/javascript">
<!--

function setMeetingTimeMsg(level,student) {
	stud = 'meetingTimeMsg';
	stud += student;
	FM = 'nonSophomoreFM';
	FM += student;
	FMS = 'sophomoreFM';
	FMS += student;
	if(level == "---Please Select---"){
		document.getElementById(FM).style.display = 'none';
		document.getElementById(FMS).style.display = 'none';
		if(document.getElementById('accessibilityNeeds').value.length==0){
			if(student==1){
				document.getElementById('accessibilityDiv').style.display = 'none';
			}
		}
	}
	else if(level != "Sophomore"){
		msg = 'PLEASE NOTE: All Faculty Meetings for ';
		msg += level;
		msg += ' Students take place Saturday, between 10 a.m. and 1 p.m.<br /><br /><p>Please let us know if you will be arriving late Saturday. We will schedule accordingly.</p>';

		msg = '<p style="font-weight: normal"><?php echo ($FMNote)?></p>';

		document.getElementById(stud).innerHTML = msg;
		document.getElementById(FM).style.display = '';
		document.getElementById(FMS).style.display = 'none';
		document.getElementById('accessibilityDiv').style.display = '';
	}
	else{
		document.getElementById(FMS).style.display = '';
//		document.getElementById(FM).style.display = 'none';
		if(document.getElementById('accessibilityNeeds').value.length==0){
			if(student==1){
	//			document.getElementById('accessibilityDiv').style.display = 'none';
			}
		}
	}

	if(level == "First-year"){
		if(student==1){
			document.getElementById('fynote1').style.display = '';
		}
		else {
			document.getElementById('fynote2').style.display = '';
		}
	}
	else{
		if(student==1){
			document.getElementById('fynote1').style.display = 'none';
		}
		else {
			document.getElementById('fynote2').style.display = 'none';
		}
	}

 
	if(level == "Senior"){
		if(student==1){
			document.getElementById('seniorThesisAdvisorMeeting1HeaderDiv').style.display = '';
			document.getElementById('seniorThesisAdvisorMeeting1QuestionDiv').style.display = 'inline-block';
		}
		else {
			document.getElementById('seniorThesisAdvisorMeeting2HeaderDiv').style.display = '';
			document.getElementById('seniorThesisAdvisorMeeting2QuestionDiv').style.display = 'inline-block';
		}
	}
	else{
		if(student==1){
			document.getElementById('seniorThesisAdvisorMeeting1HeaderDiv').style.display = 'none';
			document.getElementById('seniorThesisAdvisorMeeting1QuestionDiv').style.display = 'none';
		}
		else {
			document.getElementById('seniorThesisAdvisorMeeting2HeaderDiv').style.display = 'none';
			document.getElementById('seniorThesisAdvisorMeeting2QuestionDiv').style.display = 'none';
		}
	}

}
function specifyWhich(val,studNum){
	stud = 'student';
	stud += studNum;
	stud += 'MeetingSpecifyWhichDiv';
	if(val == "some"){
		document.getElementById(stud).style.display = '';
	}
	else {
		document.getElementById(stud).style.display = 'none';
	}
}
function toggleDiv(id,div){
	if(document.getElementById(id).checked){
		document.getElementById(div).style.display='';
	}
	else{
		document.getElementById(div).style.display='none';
	}
}
function showAnother(id,type){
	if(document.getElementById(id).style.display == ''){
		document.getElementById(id).style.display = 'none';
		moreOrLess = 'less';
	}
	else{
		document.getElementById(id).style.display = '';
		moreOrLess = 'more';
	}
	if(type == 'family'){
		if(moreOrLess == 'more'){
			document.getElementById('totalFamilyMembersAttending').value++;
		}
		else{
			document.getElementById('totalFamilyMembersAttending').value--;
		}
		document.getElementById('totalFamilyMembersAttendingShow').innerHTML = document.getElementById('totalFamilyMembersAttending').value;
	}
}
var tooltip=function(){
 var id = 'tt';
 var top = 3;
 var left = 3;
 var maxw = 300;
 var speed = 10;
 var timer = 20;
 var endalpha = 95;
 var alpha = 0;
 var tt,t,c,b,h;
 var ie = document.all ? true : false;
 return{
  show:function(v,w){
   if(tt == null){
    tt = document.createElement('div');
    tt.setAttribute('id',id);
    t = document.createElement('div');
    t.setAttribute('id',id + 'top');
    c = document.createElement('div');
    c.setAttribute('id',id + 'cont');
    b = document.createElement('div');
    b.setAttribute('id',id + 'bot');
    tt.appendChild(t);
    tt.appendChild(c);
    tt.appendChild(b);
    document.body.appendChild(tt);
    tt.style.opacity = 0;
    tt.style.filter = 'alpha(opacity=0)';
    document.onmousemove = this.pos;
   }
   tt.style.display = 'block';
   c.innerHTML = v;
   tt.style.width = w ? w + 'px' : 'auto';
   if(!w && ie){
    t.style.display = 'none';
    b.style.display = 'none';
    tt.style.width = tt.offsetWidth;
    t.style.display = 'block';
    b.style.display = 'block';
   }
  if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
  h = parseInt(tt.offsetHeight) + top;
  clearInterval(tt.timer);
  tt.timer = setInterval(function(){tooltip.fade(1)},timer);
  },
  pos:function(e){
   var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
   var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
   tt.style.top = (u - h) + 'px';
   tt.style.left = (l + left) + 'px';
  },
  fade:function(d){
   var a = alpha;
   if((a != endalpha && d == 1) || (a != 0 && d == -1)){
    var i = speed;
   if(endalpha - a < speed && d == 1){
    i = endalpha - a;
   }else if(alpha < speed && d == -1){
     i = a;
   }
   alpha = a + (i * d);
   tt.style.opacity = alpha * .01;
   tt.style.filter = 'alpha(opacity=' + alpha + ')';
  }else{
    clearInterval(tt.timer);
     if(d == -1){tt.style.display = 'none'}
  }
 },
 hide:function(){
  clearInterval(tt.timer);
   tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
  }
 };
}();
 
//-->
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
	width:140px;
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
text-align:right; 
width: 180px;
padding: 0;
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
cursor: pointer;
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
.price{
	width: 150px; 
	float: left; 
	text-align: right; 
	height: 20px; 
	padding-top: 5px;
}
#stylized input.total{
	width: 50px;
	border: none;
	font-size: 16px;
	font-weight: bold;
	text-align: left;
	padding: 2px !important;
	margin-left: 0px;
	font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
}
<?php
if(isset($contents) && $contents != ""){
?>
.myform	{
	display: none;
}
<?php
}
?>

</style>
</head>
<body>
  <div id="stylized" class="myform">
  
<?php
if(isset($post_success) & $post_success == true)  {
	echo "<p>Thank you! We look forward to seeing you at Family Weekend.</p>";
	echo "</div></body></html>";
}
else {
?>
  
  
	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()">

    <div class="spacer" style="clear:both"></div>
	<div style="margin: 15px; font-size:16px"><strong>About Your Student(s)</strong></div>
	<div style="clear:both; border: 1px solid #000; background:#F8F8F8; " id="student1Div">
		<div style="float:right; font-size: 14px">Student #1</div>
    	<div style="clear:both" id="student1FnameDiv">
          <label for="student1Fname">Student First Name
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="student1Fname" id="student1Fname" /><span class="required">*</span>
        </div>
        <div style="clear:both" id="student1LnameDiv">
          <label for="student1Lname">Student Last Name
          </label>
          <input type="text" name="student1Lname" id="student1Lname" /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both">
          <label for="student1Class">Currently a:</label>
          <select name="student1Class" id="student1Class" onChange="setMeetingTimeMsg(this.value,'1')" />
          	<option>---Please Select---</option>
          	<option value="First-year">First-year</option>
          	<option value="Sophomore">Sophomore</option>
          	<option value="Junior">Junior</option>
          	<option value="Senior">Senior</option>
          </select>
        </div>

        <div style="clear: both; display: ''" id="nonSophomoreFM1">
            <div style="font-weight: normal; display: none; padding: 0 20px 20px;" id="fynote1"><?php echo($firstYearNote); ?></div>
            <div style="font-weight: normal; display: none; padding: 0 20px 20px;" id="seniornote1"><?php echo($seniorNote); ?></div>
        	<div style="padding: 0 0 0 20px; font-weight: bold">
            	<span style="font-size:16px">Faculty Meetings</span>
                	<div class="msg" id="meetingTimeMsg1">
						<p style="font-weight: normal"><?php echo ($FMNote)?><br> 
							<!--
								<br>
								<strong>NOTE: </strong>Many faculty schedules are full or almost full for Saturday morning meetings. Please indicate with whom you would like to meet and we will let you know which faculty members still have available meeting times. We will continue scheduling meetings for families through Thursday morning. Thank you. 
							-->
						</p>
						<p style="font-weight: normal; display: none">We do not schedule meetings for any of the ensemble classes (Chorus, Jazz, Madrigal Group, Chamber Orchestra, and Collegium). Generally, faculty members with "adjunct" status are not available for meetings on Family Weekend, nor are private music instructors.</p></div>
            </div>
       	<div onKeyUp="" style="padding: 0 0 0 70px;"><strong>Meetings Requests</strong></div>
         	<div style="padding: 0 0 0 70px;">I would like to meet with:</div>
            <div style="margin: 0 0 0 150px; display:inline-block;">
            	<div style="float:left; ">
              	<input class="radio" type="radio" name="student1Meeting" id="student1MeetingAll" value="all"  onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display='none'"  /><label class="labelwide" for="student1MeetingAll">All of the Student's Available Faculty</label></div>
            	<div style="float:left; ">
              	<input class="radio" type="radio" name="student1Meeting" id="student1MeetingNone" value="none" onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display='none'" /><label class="labelwide" for="student1MeetingNone" >No Meetings with Faculty</label></div>
                <div style="float:left; ">
              	<input class="radio" type="radio" name="student1Meeting" id="student1MeetingSpecify" value="some"   onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display=''" /><label class="labelwide" for="student1MeetingSpecify">Specify Certain Faculty</label>
                
                	<div id="student1MeetingSpecifyWhichDiv" style="display:none" >Please specify the Faculty (or the course subject matter) with which you wish to meet:<br />
<input type="text" name="student1MeetingSpecifyWhich" style="width:300px; padding: 4px" id="student1MeetingSpecifyWhich">
                    </div>
                </div>
            </div>
			<div style="padding: 0 0 0 70px; ">I would like to meet with my student's Academic Advisor:</div>
			<div style="width:150px; padding-left:125px; display:inline-block;">
				<div style="float:left; " ><input type="radio" class="radio" name="academicAdvisorMeeting1" id="academicAdvisorMeeting1Yes" value="1">
					<label for="academicAdvisorMeeting1Yes" class="labelsmall">Yes</label></div>
				<div style="float:left; " ><input type="radio" class="radio" name="academicAdvisorMeeting1" id="academicAdvisorMeeting1No" value="0">
					<label for="academicAdvisorMeeting1No" class="labelsmall">No</label></div>
			</div>
			<div style="padding: 0 0 0 70px; display:none; " id="seniorThesisAdvisorMeeting1HeaderDiv">I would like to meet with my student's Thesis Advisor:</div>
			<div style="width:150px; padding-left:125px; display:none;" id="seniorThesisAdvisorMeeting1QuestionDiv">
				<div style="float:left; " ><input type="radio" class="radio" name="seniorThesisAdvisorMeeting1" id="seniorThesisAdvisorMeeting1Yes" value="1">
					<label for="seniorThesisAdvisorMeeting1Yes" class="labelsmall">Yes</label></div>
				<div style="float:left; " ><input type="radio" class="radio" name="seniorThesisAdvisorMeeting1" id="seniorThesisAdvisorMeeting1No" value="0">
					<label for="seniorThesisAdvisorMeeting1No" class="labelsmall">No</label></div>
			</div>            
	    </div>

        <div style="clear: both; display: none" id="sophomoreFM1">
        	<div style="padding: 0 0 0 20px; font-weight: bold">
            	Sophomore Planning Meetings 
                	<div class="msg">
					<p style="font-weight: normal"><?php echo($sophomoreNote);?></span></p>
					</div>
            </div>

        	<div style="padding: 0 0 0 70px; ">I would like to request a Sophomore Planning Meeting:</div>
			<div style="width:150px; padding-left:125px;">
				<div style="float:left; "><input type="radio" class="radio" name="sophomoreFacultyMeeting1" id="sophomoreFacultyMeeting1Yes" value="1" onClick="document.getElementById('lateArrive1_div').style.display=''">
					<label for="sophomoreFacultyMeeting1Yes" class="labelsmall" >Yes</label></div>
				<div style="float:left; "><input type="radio" class="radio" name="sophomoreFacultyMeeting1" id="sophomoreFacultyMeeting1No" value="0" onClick="document.getElementById('lateArrive1_div').style.display='none'">
					<label for="sophomoreFacultyMeeting1No" class="labelsmall">No</label></div>
			</div>
			<div id="lateArrive1_div" style="clear:both; padding: 0 0 0 70px; display: inline-block; display: none ">
				<div >
					<input type="checkbox" name="SMLateArrival1" id="SMLateArrival1" class="radio" onClick="toggleDiv('SMLateArrival1','arrivaldetails_div')">
						<label for="SMLateArrival1" class="labelwide">Yes, I will be arriving late, and am unable to meet between 1pm and 4pm on Friday, and wish to on Saturday morning.</label></div>
				<div style="display:none; clear:both" id="arrivaldetails_div">Please provide specifics about your estimated arrival time so that we may schedule on that basis.<br>
					<textarea name="arrivaldetails1" id="arrivaldetails1" style="width:300px; height: 80px; margin: 8px" ></textarea>
				</div>
			</div>

		</div>

		<div style="clear:both;">
			<div><a href="javascript: showAnother('student2Div','student')" style="text-decoration: none; font-size:14px;"><img src="userblue_add.png" style="padding: 0 10px; border: 0" />I have more than one student at Simon's Rock</a></div>		
			<div class="spacer"></div>	
		</div>
	</div>
	<div class="spacer"></div>
	<div style="clear:both; border: 1px solid #000; background:#F8F8F8; display: none" id="student2Div">
		<div style="float:right; font-size: 14px">Student #2</div>
    	<div style="clear:both" id="student2FnameDiv">
          <label for="student2Fname">Student First Name
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="student2Fname" id="student2Fname" /><span class="required">*</span>
        </div>
        <div style="clear:both" id="student2LnameDiv">
          <label for="student2Lname">Student Last Name
          </label>
          <input type="text" name="student2Lname" id="student2Lname" /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both; display:inline-block">
          <label for="student2Class">Currently a:</label>
          <select name="student2Class" id="student2Class" onChange="setMeetingTimeMsg(this.value,'2')" />
          	<option>---Please Select---</option>
          	<option value="First-year">First-year</option>
          	<option value="Sophomore">Sophomore</option>
          	<option value="Junior">Junior</option>
          	<option value="Senior">Senior</option>
          </select>
        </div>        
        <div style="clear: both; display:''" id="nonSophomoreFM2">
        	<div style="padding: 0 0 0 20px; font-weight: bold">
                <div style="font-weight:normal; display:none; padding: 0 20px 20px 0" id="fynote2"><?php echo($firstYearNote); ?></div>
	            <div style="font-weight: normal; display: none; padding: 0 20px 20px 0;" id="seniornote2"><?php echo($seniorNote); ?></div>
	        	<div><strong><span style="font-size:16px">Faculty Meetings</span></strong></div>
            	<div class="msg" id="meetingTimeMsg2"><p style="font-weight: normal"><?php echo ($FMNote)?><br /><br />
                <!-- <strong>NOTE:</strong> Many faculty schedules are full or almost full for Saturday morning meetings. Please indicate with whom you would like to meet and we will let you know which faculty members still have available meeting times. We will continue scheduling meetings for families through Thursday morning. Thank you.</p> -->
                    <p style="font-weight: normal; display: none">We do not schedule meetings for any of the ensemble classes (Chorus, Jazz, Madrigal Group, Chamber Orchestra, and Collegium). Generally, faculty members with "adjunct" status are not available for meetings on Family Weekend, nor are private music instructors.</p>
				</div> 
            </div>

        	<div style="padding: 0 0 0 70px; "><strong>Meetings Requests</strong></div>
        	<div style="padding: 0 0 0 70px; ">I would like to meet with:</div>
            <div style="margin: 0 0 0 150px; display: inline-block;">
            	<div style="float:left; ">
              	<input class="radio" type="radio" name="student2Meeting" id="student2MeetingAll" value="all" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display='none'" /><label class="labelwide" for="student2MeetingAll">All of the Student's Available Faculty</label></div>
            	<div style="float:left; ">
              	<input class="radio" type="radio" name="student2Meeting" id="student2MeetingNone" value="none" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display='none'" /><label class="labelwide" for="student2MeetingNone" >No Meetings with Faculty</label></div>
                <div style="float:left; ">
              	<input class="radio" type="radio" name="student2Meeting" id="student2MeetingSpecify" value="some" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display=''"  /><label class="labelwide" for="student2MeetingSpecify">Specify Certain Faculty</label>
                
                	<div id="student2MeetingSpecifyWhichDiv" style="display:none" >Please specify the Faculty (or the course subject matter) with which you wish to meet:<br />
						<input type="text" name="student2MeetingSpecifyWhich" style="width:300px; padding: 4px" id="student2MeetingSpecifyWhich">
                    </div>
                </div>
            </div>
			<div style="padding: 0 0 0 70px; ">I would like to meet with my student's Academic Advisor:</div>
			<div style="width:150px; padding-left:125px; display:inline-block;">
				<div style="float:left; " ><input type="radio" class="radio" name="academicAdvisorMeeting2" id="academicAdvisorMeeting2Yes" value="1">
					<label for="academicAdvisorMeeting2Yes" class="labelsmall">Yes</label></div>
				<div style="float:left; " ><input type="radio" class="radio" name="academicAdvisorMeeting2" id="academicAdvisorMeeting2No" value="0">
					<label for="academicAdvisorMeeting2No" class="labelsmall">No</label></div>
			</div>
			<div style="padding: 0 0 0 70px; display: none;" id="seniorThesisAdvisorMeeting2HeaderDiv">I would like to meet with my student's Thesis Advisor:</div>
			<div style="width:150px; padding-left:125px; display:none;" id="seniorThesisAdvisorMeeting2QuestionDiv">
				<div style="float:left" ><input type="radio" class="radio" name="seniorThesisAdvisorMeeting2" id="seniorThesisAdvisorMeeting2Yes" value="1">
					<label for="seniorThesisAdvisorMeeting2Yes" class="labelsmall">Yes</label></div>
				<div style="float:left" ><input type="radio" class="radio" name="seniorThesisAdvisorMeeting2" id="seniorThesisAdvisorMeeting2No" value="0">
					<label for="seniorThesisAdvisorMeeting2No" class="labelsmall">No</label></div>
			</div>

        </div>
		
        <div style="clear: both; display: none" id="sophomoreFM2">
        	<div style="padding: 0 0 0 20px; font-weight: bold">
            	Sophomore Planning Meetings 
                	<div class="msg"><p style="font-weight: normal"><?php echo($sophomoreNote);?></span></p></div>
            </div>

        	<div style="padding: 0 0 0 70px; ">I would like to request a Sophomore Planning Meeting:</div>
			<div style="width:150px; padding-left:125px; display:inline-block;">
				<div style="float:left; " ><input type="radio" class="radio" name="sophomoreFacultyMeeting2" id="sophomoreFacultyMeeting2Yes" value="1" onClick="document.getElementById('lateArrive2_div').style.display='inline-block'">
					<label for="sophomoreFacultyMeeting2Yes" class="labelsmall">Yes</label></div>
				<div style="float:left; " ><input type="radio" class="radio" name="sophomoreFacultyMeeting2" id="sophomoreFacultyMeeting2No" value="0" onClick="document.getElementById('lateArrive2_div').style.display='none'">
					<label for="sophomoreFacultyMeeting2No" class="labelsmall">No</label></div>
			</div>
			<div id="lateArrive2_div" style="clear:both; padding: 0 0 0 70px;display: inline-block; display: none">
				<div>
					<input type="checkbox" name="SMLateArrival2" id="SMLateArrival2" class="radio" onClick="toggleDiv('SMLateArrival2','arrivaldetails2_div')">
						<label for="SMLateArrival2" class="labelwide">Yes, I will be arriving late, and am unable to meet between 1pm  and 4pm on Friday, and wish to meet on Saturday morning.</label></div>
				<div style="display:none; clear:both " id="arrivaldetails2_div">Please provide specifics about your estimated arrival time so that we can schedule on that basis.<br>
					<textarea name="arrivaldetails2" id="arrivaldetails2" style="width:300px; height: 80px; margin: 8px" ></textarea>
				</div>
			</div>				

		</div>
		
	</div>
	
	<div class="spacer"></div>
    <div style="clear:both; padding:5px; margin:5px; " id="accessibilityDiv">
		<div style="margin: 15px; font-size:16px"><strong>Accessibility</strong></div>
		<div style="margin: 15px; font-size:13px">Meetings take place in faculty offices located around campus in 4 different academic buildings. Some buildings have elevators and some have only stairs, so <strong>please let us know if you would like to meet in an accessible meeting location</strong> by providing a brief description of your accessibility needs.</div>
		<textarea name="accessibilityNeeds" id="accessibilityNeeds" style="width:500px; height: 80px; margin: 8px" ></textarea>	
	</div>
    <div class="spacer" style="clear:both"></div>
	<div style="margin: 15px; font-size:16px"><strong>Family Members Attending</strong></div>
	
<?php 
for($relativeCount=1; $relativeCount <= $relativesTotal; $relativeCount++){
	if($relativeCount==1){
		$display = '';
	}
	else{
		$display = 'none';
	}

	echo '<div style="clear:both; border: 1px solid #000; background:#F8F8F8; display:'.$display.'" id="relative'.$relativeCount.'Div">';
	if($relativeCount==1){
		echo '<div style="font-size:14px; font-weight: bold; text-indent: 20px;">Your Information</div>';
	}
	else{
		echo '<div style="font-size:14px; font-weight: bold; text-indent: 15px;">Family Member '.($relativeCount).'</div>';
	}
	echo '
		<div style="clear:both" id="student'.$relativeCount.'FnameDiv">
          <label for="relative'.$relativeCount.'Fname">First Name
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="relative'.$relativeCount.'Fname" id="relative'.$relativeCount.'Fname" /><span class="required">*</span>
        </div>
        <div style="clear:both" id="relative'.$relativeCount.'LnameDiv">
          <label for="relative'.$relativeCount.'Lname">Last Name
          </label>
          <input type="text" name="relative'.$relativeCount.'Lname" id="relative'.$relativeCount.'Lname" /><span class="required">*</span>
        </div>';
		if($relativeCount==1){
			echo '
        <div style="clear:both" id="relative'.$relativeCount.'EmailDiv">
          <label for="relative'.$relativeCount.'Email">Email
          </label>
          <input type="text" name="relative'.$relativeCount.'Email" id="relative'.$relativeCount.'Email" /><span class="required">*</span>
        </div>			
			';
		}
		echo '
        <div style="clear:both" id="relative'.$relativeCount.'HometownDiv">
          <label for="relative'.$relativeCount.'Hometown">City
          </label>
          <input type="text" name="relative'.$relativeCount.'Hometown" id="relative'.$relativeCount.'Hometown" />
        </div>
        <div style="clear:both" id="relative'.$relativeCount.'HomestateDiv">
          <label for="relative'.$relativeCount.'Homestate">State/Province
          </label>
          <input type="text" name="relative'.$relativeCount.'Homestate" id="relative'.$relativeCount.'Homestate" />
        </div>
        <div style="clear:both" id="relative'.$relativeCount.'CountryDiv">
          <label for="relative'.$relativeCount.'Country">Country
          </label>
          <input type="text" name="relative'.$relativeCount.'Country" id="relative'.$relativeCount.'Country" />
        </div>
        <div style="clear:both">
          <label for="relative'.$relativeCount.'Class">Relationship:</label>
          <select name="relative'.$relativeCount.'Class" id="relative'.$relativeCount.'Class" style="float:none" />
          	<option>---Please Select---</option>
          	<option>Parent/Guardian</option>
          	<option>Other Adult Family Member</option>
          	<option>Child under 12</option>
          </select>
        </div>        

';
		if($relativeCount<$relativesTotal){
			echo '
	<div style="clear:both; ">
				  <div><a href="javascript: showAnother(\'relative'.($relativeCount+1).'Div\',\'family\')" style="text-decoration: none; font-size:14px;"><img src="userblue_add.png" style="padding: 0 10px; border: 0" /> Add additional Family Members Attending</a></div>
				<div class="spacer"></div>	
			</div>
			';
		}
	echo '
	</div>	
	<div class="spacer"></div>';
}
?>
    <div class="spacer" style="clear:both"></div>
	<div style="margin: 15px; font-size:14px; text-align:right">
		<div style="float: right; "><input type="hidden" name="totalFamilyMembersAttending" id="totalFamilyMembersAttending" value="1" /></div>
		<div style="float: right; margin-bottom: 0"><strong>Total Family Members Attending: <span id="totalFamilyMembersAttendingShow">1</span></strong></div>
	</div>
	
	
	<div style="clear:both; padding:5px; margin:5px; ">
		<p style="margin: 15px; font-size:16px"><strong>Events</strong></p>
		<div>
			<div style="margin: 15px; font-size:13px">Please indicate which of the events listed below you plan to attend, and the number of attendees.</div>
		</div>
		<div style="margin: 15px; font-size:15px"><strong>Friday, October 11th</strong></div>
		<div>
			<div style="float:left; text-indent: 10px; text-align: center; width:180px;"><strong>Event</strong></div>
			<div style="width:160px; float: left"><strong>Number Attending:</strong></div>
		</div>
		<div>
			<div style="padding-left: 190px; width:53px; margin-right: 12px; float: left">Adults</div>
			<div style="width:50px; float: left">Children</div>
		</div>
    	<div style="clear:both; display:none;" id="attendClassesDiv">
          <label for="attendClasses" class="labelmed">Attend Classes
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" style="width: 50px" name="attendClassesAdults" id="attendClassesAdults" />
		  <input type="text" style="width: 50px" name="attendClassesChild" id="attendClassesChild" />
        </div>
		<div style="clear:both; display:none;" id="labOpenHouseDiv">
          <label for="labOpenHouse" class="labelmed">Lab Open House
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" style="width: 50px" name="labOpenHouseAdults" id="labOpenHouseAdults" />
		  <input type="text" style="width: 50px" name="labOpenHouseChild" id="labOpenHouseChild" />
        </div>
		<div style="clear:both; display:none; " id="familyRecreationTimeDiv">
          <label for="familyRecreationTime" class="labelmed">Family Recreation Time
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" style="width: 50px" name="familyRecreationTimeAdults" id="familyRecreationTimeAdults" />
		  <input type="text" style="width: 50px" name="familyRecreationTimeChild" id="familyRecreationTimeChild" />
        </div>
		<div style="clear:both; display:none;" id="winStudentResourceCommonsDiv">
          <label for="winStudentResourceCommons" class="labelmed">Win Student Resource Commons: Support Services for Students</label>
          <input type="text" style="width: 50px" name="winStudentResourceCommonsAdults" id="winStudentResourceCommonsAdults" />
		  <input type="text" style="width: 50px" name="winStudentResourceCommonsChild" id="winStudentResourceCommonsChild" />
        </div>
		<div style="clear:both; " id="honorsConvocationDiv">
          <label for="honorsConvocationCommons" class="labelmed">Honors Convocation</label>
          <input type="text" style="width: 50px" name="honorsConvocationAdults" id="honorsConvocationAdults" />
		  <input type="text" style="width: 50px" name="honorsConvocationChild" id="honorsConvocationChild" />
<!-- 		  <img src="info.png" onMouseOver="tooltip.show('Join Provost Peter Laipson and the faculty and student speakers on this special evening when the College celebrates this year\'s recipients of named scholarships', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
		<div style="clear:both;" id="welcomeReceptionDiv">
          <label for="welcomeReception" class="labelmed">Welcome Reception</label>
          <input type="text" style="width: 50px" name="welcomeReceptionAdults" id="welcomeReceptionAdults" />
		  <input type="text" style="width: 50px" name="welcomeReceptionChild" id="welcomeReceptionChild" />
        </div>
    	<div style="clear:both;" id="jazzEnsembleConcertDiv">
          <label for="jazzEnsembleConcert" class="labelmed">Jazz Ensemble Concert</label>
          <input type="text" style="width: 50px" name="jazzEnsembleConcertAdults" id="jazzEnsembleConcertAdults" />
		  <input type="text" style="width: 50px" name="jazzEnsembleConcertChild" id="jazzEnsembleConcertChild" />
        </div>

		<div class="spacer"></div>
		
		<div style="margin: 15px; font-size:15px; clear:both"><strong>Saturday, October 12th</strong></div>
		
    	<div style="clear:both; display:none;" id="studAffairsOHDiv">
          <label for="studAffairsOH" class="labelmed">Student Affairs Open House</label>
          <input type="text" style="width: 50px" name="studAffairsOHAdults" id="studAffairsOHAdults" />
		  <input type="text" style="width: 50px" name="studAffairsOHChild" id="studAffairsOHChild" />
        </div>
    	<div style="clear:both" id="FYAdjustmentDiv">
          <label for="FYAdjustment" class="labelmed">First-Year Adjustment Panel</label>
          <input type="text" style="width: 50px" name="FYAdjustmentAdults" id="FYAdjustmentAdults" />
		  <input type="text" style="width: 50px" name="FYAdjustmentChild" id="FYAdjustmentChild" />
<!--		  <img src="info.png" onMouseOver="tooltip.show('How does a student settle into the Simon\'s Rock routine? Attend this panel presentation to find out!', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div style="clear:both" id="alumniPanelDiv">
          <label for="alumniPanel" class="labelmed">Alumni Panel</label>
          <input type="text" style="width: 50px" name="alumniPanelAdults" id="alumniPanelAdults" />
		  <input type="text" style="width: 50px" name="alumniPanelChild" id="alumniPanelChild" />
<!--		  <img src="info.png" onMouseOver="tooltip.show('Alumni share their academic/career paths since leaving Simon\'s Rock.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div style="clear:both" id="studyAbroadPanelDiv">
          <label for="studyAbroadPanel" class="labelmed">Study Abroad Panel</label>
          <input type="text" style="width: 50px" name="studyAbroadPanelAdults" id="studyAbroadPanelAdults" />
		  <input type="text" style="width: 50px" name="studyAbroadPanelChild" id="studyAbroadPanelChild" />
<!--		  <img src="info.png" onMouseOver="tooltip.show('Five seniors will share their experiences during their study away program.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div style="clear:both; display: none" id="internationalFairDiv">
          <label for="internationalFair" class="labelmed">International Fair</label>
          <input type="text" style="width: 50px" name="internationalFairAdults" id="internationalFairAdults" />
		  <input type="text" style="width: 50px" name="internationalFairChild" id="internationalFairChild" />
<!--		  <img src="info.png" onMouseOver="tooltip.show('Students invite you to learn about their area of the world in a variety of ways:  through photographs, videos, dress, cuisine, and language, among others.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div style="clear:both;display: none" id="seniorThesisPanelDiv">
          <label for="seniorThesisPanel" class="labelmed">Senior Thesis Panel</label>
          <input type="text" style="width: 50px" name="seniorThesisPanelAdults" id="seniorThesisPanelAdults" />
		  <input type="text" style="width: 50px" name="seniorThesisPanelChild" id="seniorThesisPanelChild" />
		  <!-- <img src="info.png" onMouseOver="tooltip.show('', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div style="clear:both" id="studentShowcaseDiv">
          <label for="studentShowcase" class="labelmed">Student Showcase</label>
          <input type="text" style="width: 50px" name="studentShowcaseAdults" id="studentShowcaseAdults" />
		  <input type="text" style="width: 50px" name="studentShowcaseChild" id="studentShowcaseChild" />
<!-- 		  <img src="info.png" onMouseOver="tooltip.show('', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div style="clear:both; display:none" id="provostsReceptionDiv">
          <label for="provostsReception" class="labelmed">Provost's Reception</label>
          <input type="text" style="width: 50px" name="provostsReceptionAdults" id="provostsReceptionAdults" />
		  <input type="text" style="width: 50px; display: none" value="0" name="provostsReceptionChild" id="provostsReceptionChild" />
<!--		  <img src="info.png" onMouseOver="tooltip.show('Provost Peter Laipson invites parents (only, please) to join him and members of the faculty and staff for a reception.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
		<div class="spacer"></div>
		
		
		<div style="margin: 15px; font-size:15px; clear:both; display: none"><strong>Sunday, October 30th</strong></div>
		
    	<div style="clear:both; display: none" id="hikeUpMountainDiv">
          <label for="hikeUpMountain" class="labelmed">Hike Up Mountain</label>
          <input type="text" style="width: 50px" name="hikeUpMountainAdults" id="hikeUpMountainAdults" />
		  <input type="text" style="width: 50px" name="hikeUpMountainChild" id="hikeUpMountainChild" />
<!--		  <img src="info.png" onMouseOver="tooltip.show('Join us for a hike in one of our local parks.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
	</div>
	<div class="spacer"></div>

	<div style="clear:both; padding:5px; margin:5px; ">
		<p style="margin: 15px; font-size:16px"><strong>Meals</strong></p>
		<div>
			<div style="margin: 15px; font-size:13px">
            	Please indicate below which meals you plan to attend. <br />(Note: Students currently on the meal plan are already covered for the meals below.)</div>
		</div>
		<div>
			<div style="float:left; text-indent: 10px; text-align: right; width:180px;padding-right: 10px;"><strong>Meal</strong></div>
			<div style="width:160px; float: left"><strong># Attending</strong></div>
		</div>
    	<div style="clear:both; " id="fridayLunchDiv">
          <label for="fridayLunch" class="labelmed" style="margin-top: 5px;">Friday Lunch</label>
          <input type="text" style="width: 50px" name="fridayLunch" id="fridayLunch" onKeyUp="calculateMeals(); setTemps(this.id)" /><div class="price">@ $8</div>
          <input type="hidden" name="fridayLunchTemp" id="fridayLunchTemp">
        </div>
    	<div style="clear:both" id="fridayDinnerDiv">
          <label for="fridayDinner" class="labelmed" style="margin-top: 5px;">Friday Dinner</label>
          <input type="text" style="width: 50px" name="fridayDinner" id="fridayDinner" onKeyUp="calculateMeals(); setTemps(this.id)" /><div class="price">@ $9</div>
          <input type="hidden" name="fridayDinnerTemp" id="fridayDinnerTemp">
        </div>
    	<div style="clear:both;" id="saturdayBrunchDiv">
          <label for="saturdayBrunch" class="labelmed">Saturday Brunch &amp;<br />Harvest Fest Lunch</label>
          <input type="text" style="width: 50px" name="saturdayBrunch" id="saturdayBrunch" onKeyUp="calculateMeals(); setTemps(this.id)" /><div class="price">@ $9</div>
          <input type="hidden" name="saturdayBrunchTemp" id="saturdayBrunchTemp">
        </div>
    	<div style="clear:both; display:none" id="saturdayLunchDiv">
          <label for="saturdayLunch" class="labelmed">Saturday Lunch</label>
          <input type="text" style="width: 50px" name="saturdayLunch" id="saturdayLunch" onKeyUp="calculateMeals(); setTemps(this.id)" /><div class="price">@ $9</div>
          <input type="hidden" name="saturdayLunchTemp" id="saturdayLunchTemp">
        </div>
    	<div style="clear:both" id="saturdayDinnerDiv">
          <label for="saturdayDinner" class="labelmed" style="margin-top: 5px;">Saturday Dinner</label>
          <input type="text" style="width: 50px" name="saturdayDinner" id="saturdayDinner" onKeyUp="calculateMeals(); setTemps(this.id)" /><div class="price">@ $9</div>
          <input type="hidden" name="saturdayDinnerTemp" id="saturdayDinnerTemp">
        </div>
    	<div style="clear:both" id="sundayBrunchDiv">
          <label for="sundayBrunch" class="labelmed" style="margin-top: 5px;">Sunday Brunch</label>
          <input type="text" style="width: 50px" name="sundayBrunch" id="sundayBrunch" onKeyUp="calculateMeals(); setTemps(this.id)" /><div class="price">@ $9</div>
          <input type="hidden" name="sundayBrunchTemp" id="sundayBrunchTemp">
        </div>
		<div style="clear:both" id="totalDiv">
          <div class="price" style="width: 350px; font-size: 15px"><strong>TOTAL: $</strong></div><input type="text" class="total" onFocus="this.blur()" name="total" id="total" readonly />
        </div>
    	<div style="clear:both; height: 35px;" id="paypalDiv">
<!--           <input style="margin-left: 150px;" type="checkbox" class="radio" name="cashAtDoor" id="cashAtDoor" onClick="doCashAtDoor(this.checked)"  /> -->
		  <input style="margin-left: 150px;" type="radio" class="radio" name="mop" id="paypal" value="paypal"  /> 
          <label style="text-align:left" for="paypal" class="labelmed">I will pay by credit card now.</label>
        </div>
    	<div style="clear:both; height: 35px;" id="cashAtDoorDiv">
<!--           <input style="margin-left: 150px;" type="checkbox" class="radio" name="cashAtDoor" id="cashAtDoor" onClick="doCashAtDoor(this.checked)"  /> -->
		  <input style="margin-left: 150px;" type="radio" class="radio" name="mop" id="cashAtDoor" value="cashAtDoor"  /> 
          <label style="text-align:left; width: 250px;" for="cashAtDoor" class="labelmed">I will pay cash at the door.<br />(Dining Services only accepts cash)</label>
        </div>
	</div>
	<div class="spacer" style="height: 20px;"></div>
	<button type="submit" name="submit" id="submit">Register Now</button>
	<div class="spacer"></div>
	</form>
  </div>
<script>
<!--


function checkForm(){
    var bgcolor
    var normal
    var rval
    highlight = "#ffcccc"
    normal = "#ffffff"
    rval = true
	fieldFocus = "";
	if (document.layers||document.getElementById||document.all) {
        if (document.request.student1Fname.value.length == 0) {
            document.request.student1Fname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "student1Fname";
			}
		} 
		else {
            document.request.student1Fname.style.backgroundColor = normal
		}
        if (document.request.student1Lname.value.length == 0) {
            document.request.student1Lname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "student1Lname";
			}
		} 
		else {
            document.request.student1Lname.style.backgroundColor = normal
		}
	
		if (document.getElementById('student1Class').options[document.getElementById('student1Class').selectedIndex].value == '---Please Select---') {
            document.request.student1Class.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "student1Class";
			}
		} 
		else {
            document.request.student1Class.style.backgroundColor = normal
			//if(document.getElementById('student1Class').options[document.getElementById('student1Class').selectedIndex].value != "Sophomore"){
			if(1){
				if (getCheckedValue(document.request.elements['student1Meeting']) == undefined || getCheckedValue(document.request.elements['student1Meeting']) == "") {
					document.getElementById('nonSophomoreFM1').style.display = '';
					document.getElementById('nonSophomoreFM1').style.backgroundColor = highlight
					rval = false
				} 
				else {
					document.getElementById('nonSophomoreFM1').style.backgroundColor = normal
				} 
			}
			if(document.getElementById('student1Class').options[document.getElementById('student1Class').selectedIndex].value == "Sophomore"){
//			else {
				if (getCheckedValue(document.request.elements['sophomoreFacultyMeeting1']) == undefined || getCheckedValue(document.request.elements['sophomoreFacultyMeeting1']) == "") {
					document.getElementById('sophomoreFM1').style.display = '';
					document.getElementById('sophomoreFM1').style.backgroundColor = highlight
					rval = false
				} 
				else {
					document.getElementById('sophomoreFM1').style.backgroundColor = normal
				} 				
			}
		}
        if (document.request.relative1Fname.value.length == 0) {
            document.request.relative1Fname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "relative1Fname";
			}
		} 
		else {
            document.request.relative1Lname.style.backgroundColor = normal
		}		
        if (document.request.relative1Lname.value.length == 0) {
            document.request.relative1Lname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "relative1Lname";
			}
		} 
		else {
            document.request.relative1Lname.style.backgroundColor = normal
		}
        if (document.request.relative1Email.value.length == 0) {
            document.request.relative1Email.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "relative1Email";
			}
		} 
		else {
            document.request.relative1Email.style.backgroundColor = normal
		}


        if (!rval) {
			alert ("Please complete all required (highlighted) fields prior to submitting your form.");
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).focus();
			}
		}
        return rval
    } 
	else {
        return true
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
function setTemps(fld){
	var str = new String(fld+'Temp');
	document.getElementById(str).value = document.getElementById(fld).value;
}
function doCashAtDoor(val){
	var resetTemp = false;
	var mealsArray = new Array(
		"fridayLunch",
		"fridayDinner",
		"saturdayBreakfast",
		"saturdayLunch",
		"saturdayDinner",
		"sundayBrunch"
	);
	if(val){
		theVal = 0;
		theBg = "#666";
		theReadOnly = true;
	}
	else{
		theVal = '';
		theBg = "#fff";
		theReadOnly = false;
		resetTemp = true
	}
	for(x=0;x<mealsArray.length;x++){
		document.getElementById(mealsArray[x]).value = theVal;
		document.getElementById(mealsArray[x]).style.background = theBg;
		document.getElementById(mealsArray[x]).readOnly  = theReadOnly;
		if(resetTemp){
			var str = new String(mealsArray[x]+'Temp');
//			alert(str);
			// alert(document.getElementById(mealsArray[str]).value);
			document.getElementById(mealsArray[x]).value = document.getElementById(str).value;
		}
	}

	calculateMeals();
}

function isNum(num){
    return !isNaN(num)
}

function calculateMeals(){
	var mealsArray = new Array(
		"fridayLunch",
		"fridayDinner",
		"saturdayBreakfast",
		"saturdayLunch",
		"saturdayDinner",
		"sundayBrunch"
	);
	var total=0;
	var alertMsg = 0;
	if(document.request.fridayLunch.value != 0 && document.request.fridayLunch.value != ""){
		if(!isNum(document.request.fridayLunch.value)){
			alertMsg += 1;
			document.request.fridayLunch.value = "";
		}
		else {
			total += parseInt(document.request.fridayLunch.value)*8;
		}
	}
	if(document.request.fridayDinner.value != 0 && document.request.fridayDinner.value != ""){
		if(!isNum(document.request.fridayDinner.value)){
			alertMsg += 1;
			document.request.fridayDinner.value = "";
		}
		else {
			total += parseInt(document.request.fridayDinner.value)*9;
		}
	}
	if(document.request.saturdayBrunch.value != 0 && document.request.saturdayBrunch.value != ""){
		if(!isNum(document.request.saturdayBrunch.value)){
			alertMsg += 1;
			document.request.saturdayBrunch.value = "";
		}
		else {
			total += parseInt(document.request.saturdayBrunch.value)*9;
		}
	}
	if(document.request.saturdayDinner.value != 0 && document.request.saturdayDinner.value != ""){
		if(!isNum(document.request.saturdayDinner.value)){
			alertMsg += 1;
			document.request.saturdayDinner.value = "";
		}
		else {
			total += parseInt(document.request.saturdayDinner.value)*9;
		}
	}
	if(document.request.sundayBrunch.value != 0 && document.request.sundayBrunch.value != ""){
		if(!isNum(document.request.sundayBrunch.value)){
			alertMsg += 1;
			document.request.sundayBrunch.value = "";
		}
		else {
			total += parseInt(document.request.sundayBrunch.value)*9;
		}
	}
	if (alertMsg != 0){
		alert ("Please specify numbers only.");
	}
	else{
		document.getElementById('total').value = total;
	}
}
// alert(document.request.elements['student1Meeting']);
// -->
</script>
</body>
</html>
<?php 
}
?>
