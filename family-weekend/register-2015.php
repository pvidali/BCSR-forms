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




		$sql = "INSERT INTO forms.family_weekend_2015 (
				student1Fname, student1Lname, student1Class, student1Meeting, 
				student2Fname, student2Lname, student2Class, student2Meeting, accessibilityNeeds, 
				relative1Fname, relative1Lname, relative1Hometown, relative1Homestate, relative1Country, relative1Class, 
				relative2Fname, relative2Lname, relative2Hometown, relative2Homestate, relative2Country, relative2Class, 
				relative3Fname, relative3Lname, relative3Hometown, relative3Homestate, relative3Country, relative3Class, 
				relative4Fname, relative4Lname, relative4Hometown, relative4Homestate, relative4Country, relative4Class, 
				relative5Fname, relative5Lname, relative5Hometown, relative5Homestate, relative5Country, relative5Class, 
				honorsConvocationAdults, honorsConvocationChild, 
				welcomeReceptionAdults, welcomeReceptionChild,
				
				FYAdjustmentAdults, FYAdjustmentChild, 
				alumniPanelAdults, alumniPanelChild, 
				studyAbroadPanelAdults, studyAbroadPanelChild, 
				internationalFairAdults, internationalFairChild, 
				seniorThesisPanelAdults, seniorThesisPanelChild, 
				studentShowcaseAdults, studentShowcaseChild, 
				provostsReceptionAdults, 
				hikeUpMountainAdults, hikeUpMountainChild, 
				fridayLunchAdults, fridayDinnerAdults, 
				saturdayBrunchAdults, saturdayLunch, saturdayDinnerAdults, 
				sundayBrunchAdults, 
				totalFamilyMembersAttending, date_submitted, student1MeetingSpecifyWhich, student2MeetingSpecifyWhich, relative1Email,
				academicAdvisorMeeting1,academicAdvisorMeeting2,sophomoreFacultyMeeting1,sophomoreFacultyMeeting2,SMLateArrival1, 
				arrivaldetails1,SMLateArrival2, arrivaldetails2, seniorThesisAdvisorMeeting1, seniorThesisAdvisorMeeting2, whenPlanArrive,
				 
				murderMysteryChallengeAdults, murderMysteryChallengeChild, 
				frightFilmFestAdults, frightFilmFestChild, 
				pianoRecitalAdults, pianoRecitalChild, 
				
				
				halloweenDanceAdults, halloweenDanceChild)  
 		VALUES ('$student1Fname', '$student1Lname', '$student1Class', '$student1Meeting', '$student2Fname', '$student2Lname', '$student2Class', '$student2Meeting', '$accessibilityNeeds', 
				'$relative1Fname', '$relative1Lname', '$relative1Hometown', '$relative1Homestate', '$relative1Country', '$relative1Class', 
				'$relative2Fname', '$relative2Lname', '$relative2Hometown', '$relative2Homestate', '$relative2Country', '$relative2Class', 
				'$relative3Fname', '$relative3Lname', '$relative3Hometown', '$relative3Homestate', '$relative3Country', '$relative3Class', 
				'$relative4Fname', '$relative4Lname', '$relative4Hometown', '$relative4Homestate', '$relative4Country', '$relative4Class', 
				'$relative5Fname', '$relative5Lname', '$relative5Hometown', '$relative5Homestate', '$relative5Country', '$relative5Class', 
				$honorsConvocationAdults, $honorsConvocationChild, 
				$welcomeReceptionAdults, $welcomeReceptionChild,
				
				$FYAdjustmentAdults, $FYAdjustmentChild, 
				$alumniPanelAdults, $alumniPanelChild, 
				$studyAbroadPanelAdults, $studyAbroadPanelChild, 
				$internationalFairAdults, $internationalFairChild, 
				$seniorThesisPanelAdults, $seniorThesisPanelChild, 
				$studentShowcaseAdults, $studentShowcaseChild, 
				$provostsReceptionAdults, 
				$hikeUpMountainAdults, $hikeUpMountainChild, 
				$fridayLunch, $fridayDinner, 
				$saturdayBrunch, $saturdayLunch, $saturdayDinner, 
				$sundayBrunch, 
				$totalFamilyMembersAttending, NOW(), '$student1MeetingSpecifyWhich', '$student2MeetingSpecifyWhich', '$relative1Email', 
				'$academicAdvisorMeeting1', '$academicAdvisorMeeting2', '$sophomoreFacultyMeeting1', '$sophomoreFacultyMeeting2','$SMLateArrival1',
				'$arrivaldetails1','$SMLateArrival2','$arrivaldetails2','$seniorThesisAdvisorMeeting1','$seniorThesisAdvisorMeeting2',
				'$whenPlanArrive',
				
				$murderMysteryChallengeAdults, $murderMysteryChallengeChild, 
				$frightFilmFestAdults, $frightFilmFestChild, 
				$pianoRecitalAdults, $pianoRecitalChild, 
				
				$halloweenDanceAdults, $halloweenDanceChild)";
		$db->do_query($sql);
//echo ($sql);
//exit();	
/* --------------ADDED PAYAL ------------ 
	#20130910 @dscheff
----------------------------------------- */

		$sql = "SELECT id from forms.family_weekend_2015 ORDER BY id DESC LIMIT 1";
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

		$mealsArray = array('fridayLunch','fridayDinner','saturdayBrunch','saturdayLunch','saturdayDinner','sundayBrunch');
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

		$sql = "INSERT INTO forms.fw_program_meal_registration_2015 (contact_id, meals, payer_id, paid_for, date_submitted, mop)
				VALUES ($thisContactId,'$meals', $thisPayerId, '$paidfor', NOW(), '$mop')";
		$db->do_query($sql);
	
		$sql = "INSERT INTO forms.fw_meal_registration_2015 (contact_id,total) 
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
				<input type="hidden" name="return" value="https://simons-rock.edu/current-students-and-families/family-weekend/family-weekend-registration-complete.php" />
				<input type="hidden" name="notify_url" value="https://forms.simons-rock.edu/family-weekend/listener.php" />
  				<input type="hidden" name="amount" value="'.$total.'">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				<script>document.paypalform.submit()</script>';
				$contents = "<div style='width:100%;'><div style='width:250px;margin:auto;margin-top:100px;text-align:center'>Redirecting to Paypal... please wait a few moments.<br /><br /><img src='icon-loading-animated.gif' style='width:35px' /><br /><br />If after 10 seconds the page has not taken you to Paypal, <a href=\"javascript:document.paypalform.submit()\">click here</a>.<br /><br />";
				$contents .= $paybuttons.'</div></div>';
			echo ($contents);
			echo ("<!-- ");
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
		$msg .= "\n\nIf you have registered for meetings with your student's faculty and academic advisor, please note that your schedule of actual meeting times between 9am and noon on Saturday, October 31st, will be emailed to you on or before October 28th.\n\n";
		$msg .= "== ACTIVITIES ==\n\n";
		//$msg .= " - Trick or Treating: $trickOrTreatingAdults Adult(s), $trickOrTreatingChild Child(ren)\n";
		$msg .= " - First-year Adjustment Panel: $FYAdjustmentAdults Adult(s), $FYAdjustmentChild Child(ren)\n";
		$msg .= " - Welcome Reception and Senior Thesis Poster Display: $welcomeReceptionAdults Adult(s), $welcomeReceptionChild Child(ren)\n";
		$msg .= " - Murder Mystery Challenge: $murderMysteryChallengeAdults Adult(s), $murderMysteryChallengeChild Child(ren)\n";
		$msg .= " - Scary Movie: $frightFilmFestAdults Adult(s), $frightFilmFestChild Child(ren)\n";

		$msg .= " - Honors Convocation: $honorsConvocationAdults Adult(s), $honorsConvocationChild Child(ren)\n";
		$msg .= " - Alumni Career Panel: $alumniPanelAdults Adult(s), $alumniPanelChild Child(ren)\n";
		$msg .= " - Study Abroad Panel: $studyAbroadPanelAdults Adult(s), $studyAbroadPanelChild Child(ren)\n";
		$msg .= " - Halloween Dance: $halloweenDanceAdults Adult(s), $halloweenDanceChild Child(ren)\n";
		//$msg .= " - Jazz Ensemble Concert: $jazzEnsembleConcertAdults Adult(s), $jazzEnsembleConcertChild Child(ren)\n";

		$msg .= " - Interpretative Trail Guided Walk: $hikeUpMountainAdults Adult(s), $hikeUpMountainChild Child(ren)\n";
		$msg .= " - Faculty Concert - Allan Dean & Friends: $pianoRecitalAdults Adult(s), $pianoRecitalChild Child(ren)\n";

		/*
		if($normanRockwellMuseumTransportationAdults == 1){
			$normanRockwellMuseumTransportationAdultsShow = 'yes';
		}
		else{
			$normanRockwellMuseumTransportationAdultsShow = 'no';
		}
		$msg .= " - Norman Rockwell Museum & Stockbridge: $normanRockwellMuseumAdults Adult(s), $normanRockwellMuseumChild Child(ren)\n";
		$msg .= "   - Norman Rockwell Museum & Stockbridge Transportation: $normanRockwellMuseumTransportationAdultsShow\n";

		if($walkingTourTransportationAdults == 1){
			$walkingTourTransportationAdultsShow = 'yes';
		}
		else{
			$walkingTourTransportationAdultsShow = 'no';
		}
		$msg .= " - Great Barrington Historical walking tour indicated for: $walkingTourAdults Adult(s), $walkingTourChild Child(ren)\n";
		$msg .= "   - Transportation to walking tour: $walkingTourTransportationAdultsShow\n";
		*/
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
			$msg .= " - Saturday Breakfast (\$5 per person): $saturdayBrunch\n";
			$msg .= " - Saturday Harvest Fest Lunch (\$9 per person): $saturdayLunch\n";
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
		$msg .= "Director of Alumni and Parent Engagement\n";
		$msg .= "Family Weekend Coordinator\n";
		$msg .= "(413) 528-7266\n";	
		// send email
		$to = $relative1Email;
		mail($to,"Family Weekend Registration Confirmation",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");

		$to = "cingram@simons-rock.edu";
		mail($to,"COPY: Family Weekend Registration Confirmation",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");

		$to = "mchameides@simons-rock.edu";
		mail($to,"COPY: Family Weekend Registration Confirmation",$msg, "From: Cathy Ingram <cingram@simons-rock.edu>");
		
	}
}
$relativesTotal = 5;

//$firstYearNote = "We recommend that family members of first-semester students meet with as many of their student's faculty as possible—it is a nice opportunity to put faces and names together. We prioritize scheduling parents to meet with their student's academic advisor.";
$seniorNote = "Please specify if you wish to meet with your student's academic advisor or thesis advisor, as well as any subject faculty.";

//Academic Meeting note. 
//swap notes after meeting deadline

$FMNote = "Advanced registration for meetings with faculty and advisors has ended. If you would like to meet your student&#39;s faculty members, their meeting schedules will be posted on their office doors and when you arrive on campus, you can sign yourself up in an open time slot. If you have any questions, please email Karen Advokaat (<a href=\"mailto:kadvokaat@simons-rock.edu\">kadvokaat@simons-rock.edu</a>). Thank you.";

//$FMNote = "Faculty meetings are 10-minute one-on-one appointments with your student’s faculty and academic advisor. The meetings will be scheduled on Saturday, October 31 between 9 am and noon and will take place in faculty offices. Since families will be moving between buildings, the schedule of meetings will allow time as needed for going between buildings.</p><p>Please note that meetings are not scheduled with: theater production and music ensemble faculty, as well as private music instructors. We generally also don’t schedule meetings for modular “half-semester” courses.</p><p>The deadline for requesting these meetings is Wednesday, October 28 and many faculty schedules fill up before this date.</p>";


//$sophomoreNote = "James Jeffries' schedule for sophomore planning meetings is full on Friday afternoon. If you would like to make arrangements to speak with Liz about your sophomore's plans, please email her at <a href=\"mailto:jjeffries@simons-rock.edu\">jjeffries@simons-rock.edu</a>.";
$sophomoreNote = "<p>The sophomore planning meetings are 10-minute appointments with James Jeffries, Director of Career Development. These meetings will be scheduled on Friday, October 30, from 1:00 pm to 4:00 pm.</p><p>Priority is given to families of students who are currently sophomores, and the meeting is intended for families and their student to discuss the moderation and transfer process.</p>";
?>
<!DOCTYPE HTML>

<!--[if lt IE 9 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
   <!--<![endif]-->

	<head>
		<title>Family Weekend Registration | Bard College at Simon's Rock</title>

		<!-- Bootstrap -->
		<link href="/_css/iframe-compiled.css" rel="stylesheet"/>
		<link href="https://simons-rock.edu/_resources/css/app.css" rel="stylesheet"/>
		

		
		<style>
		/* #20151006 pv */
		#stylized {
			/*max-width: 576px;*/
			margin-left: auto;
			margin-right: auto;
		}
		#submit.btn.btn-primary {
			margin-top: 50px;
		}

		/*#stylized.myform .radio {
			display: inline;
		}*/

		.labelwide {
			padding-left: 5px;
		}
		/* end pv */
		</style>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script type='text/javascript' src='//code.jquery.com/jquery-1.8.3.js'></script>
<?php 
if(isset($post_success) && $post_success == true){
	echo "<script>
			window.top.location.href = \"https://simons-rock.edu/current-students-and-families/family-weekend/family-weekend-registration-complete.php\";
		</script>
		<noscript>
			Registration successful.  <a href=\"https://simons-rock.edu/current-students-and-families/family-weekend/family-weekend-registration-complete.php\">Click here to continue</a>.
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

	/* First Year Note not active
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
	*/

 
	if(level == "Senior"){
		if(student==1){
			document.getElementById('seniorThesisAdvisorMeeting1HeaderDiv').style.display = '';
			document.getElementById('seniorThesisAdvisorMeeting1QuestionDiv').style.display = '';
		}
		else {
			document.getElementById('seniorThesisAdvisorMeeting2HeaderDiv').style.display = '';
			document.getElementById('seniorThesisAdvisorMeeting2QuestionDiv').style.display = '';
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

</head>
<body class="iframe">
  <div id="stylized" class="myform page-container">
  
<?php
if(isset($post_success) & $post_success == true)  {
	echo "<p>Thank you! We look forward to seeing you at Family Weekend.</p>";
	echo "</div></body></html>";
}
else {
?>
  

<!--
	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()">
    -->
		<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
		<h2 class="subheadline">About Your Student(s)</h2>
		<h3>Student #1</h3>
		<div id="student1Div">	
	    <div id="student1FnameDiv" class="form-group col-sm-6">
	      <label for="student1Fname">Student First Name*
	      <!-- <span class="small">Add your name</span> -->
	      </label>
	      <input type="text" name="student1Fname" id="student1Fname" class="form-control" /><span class="required"></span>
	    </div>
	    <div id="student1LnameDiv" class="form-group col-sm-6">
	      <label for="student1Lname">Student Last Name*</label>
	        <input type="text" name="student1Lname" id="student1Lname" class="form-control" /><span class="required"></span>
	    </div>
	  </div><!-- end student1div -->
	  <div class="spacer"></div>
	        
	  

	  <!--student current year -->
    <div class="form-group col-sm-12">
      <label for="student1Class">Student Current Year</label>
      <select name="student1Class" id="student1Class" class="form-control" onChange="setMeetingTimeMsg(this.value,'1')" />
      	<option>---Please Select---</option>
      	<option value="First-year">First-year</option>
      	<option value="Sophomore">Sophomore</option>
      	<option value="Junior">Junior</option>
      	<option value="Senior">Senior</option>
      </select>
    </div>

    <div style="clear: both; display: none;" id="nonSophomoreFM1">
      <!-- <div id="fynote1" style="display: none;"><?php echo($firstYearNote); ?></div>-->
      <div id="seniornote1" style="display: none;"><?php echo($seniorNote); ?></div>
    </div>
     
    <h3 class="subheadline">Faculty Meetings</h3>
    <div class="msg" id="meetingTimeMsg1">
			<p><?php echo ($FMNote)?></p>
				<!--<p style="display: none">We do not schedule meetings for any of the ensemble classes (Chorus, Jazz, Madrigal Group, Chamber Orchestra, and Collegium). Generally, faculty members with "adjunct" status are not available for meetings on Family Weekend, nor are private music instructors.</p>-->
		</div> 
	</div><!-- seems like an extra div -->


  <!-- comment out meetings requests after deadline -->
 	<!--
 	<div onKeyUp=""><h3 class="subheadline">Meeting Requests</h3>
   	<h4>I would like to meet with</h4>
    <div class="form-group col-md-12">
    	<div class="radio">
      	<label class="labelwide" for="student1MeetingAll"> <input class="radio" type="radio" name="student1Meeting" id="student1MeetingAll" value="all"  onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display='none'"  />All of the Student's Available Faculty</label>
      </div>
    	<div class="radio">
      	<label class="labelwide" for="student1MeetingNone" > <input class="radio" type="radio" name="student1Meeting" id="student1MeetingNone" value="none" onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display='none'" />No Meetings with Faculty</label>
      </div>
      <div class="radio">
      	<label class="labelwide" for="student1MeetingSpecify"> <input class="radio" type="radio" name="student1Meeting" id="student1MeetingSpecify" value="some"   onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display=''" />Certain faculty</label>
      </div>  
      <div id="student1MeetingSpecifyWhichDiv" style="display:none" >
      	Please specify the faculty by name or class
      		<input type="text" name="student1MeetingSpecifyWhich" id="student1MeetingSpecifyWhich" class="col-sm-12">
      </div>
    </div>		
	</div> -->
	<!-- end meeting requests -->

	<!-- comment out meetings requests after deadline -->	
	<!--
	<h4>I would like to meet with my student's Academic Advisor</h4>
	<div class="form-group col-md-12">
		<div class="radio">
			<label for="academicAdvisorMeeting1Yes" class="labelsmall"><input type="radio" class="radio" name="academicAdvisorMeeting1" id="academicAdvisorMeeting1Yes" value="1">
			Yes</label>
		</div>
		<div class="radio">
			<label for="academicAdvisorMeeting1No" class="labelsmall"><input type="radio" class="radio" name="academicAdvisorMeeting1" id="academicAdvisorMeeting1No" value="0">
			No</label>
		</div>
	</div>          
</div> -->   <!-- seems like an extra div -->

<!-- comment out meetings requests after deadline -->	
<!--
<div style="display:none; " id="seniorThesisAdvisorMeeting1HeaderDiv">
	<h4>I would like to meet with my student's Thesis Advisor</h4>
</div>
<div style="display:none;" id="seniorThesisAdvisorMeeting1QuestionDiv" class="form-group col-md-12">
	<div class="radio">
		<label for="seniorThesisAdvisorMeeting1Yes" class="labelsmall"><input type="radio" class="radio" name="seniorThesisAdvisorMeeting1" id="seniorThesisAdvisorMeeting1Yes" value="1">
		Yes</label>
	</div>
	<div class="radio">
		<label for="seniorThesisAdvisorMeeting1No" class="labelsmall"><input type="radio" class="radio" name="seniorThesisAdvisorMeeting1" id="seniorThesisAdvisorMeeting1No" value="0">
		No</label>
	</div>
</div>
<div style="clear: both; display: none" id="sophomoreFM1">
 	<h4>Sophomore Planning Meetings</h4> 
	<div class="msg">
		<p><?php echo($sophomoreNote);?></span></p>
	</div>
	<h5>I would like to request a Sophomore Planning Meeting</h5>
	<div class="form-group col-md-12">
		<div class="radio">
			<label for="sophomoreFacultyMeeting1Yes" class="labelsmall" ><input type="radio" class="radio" name="sophomoreFacultyMeeting1" id="sophomoreFacultyMeeting1Yes" value="1" onClick="document.getElementById('lateArrive1_div').style.display=''">
			Yes</label>
		</div>
		<div class="radio">
			<label for="sophomoreFacultyMeeting1No" class="labelsmall"><input type="radio" class="radio" name="sophomoreFacultyMeeting1" id="sophomoreFacultyMeeting1No" value="0" onClick="document.getElementById('lateArrive1_div').style.display='none'">
			No</label>
		</div>
	</div>
</div> -->  <!-- end sophomore fm1 -->

        	
<!--			<div id="lateArrive1_div" style="clear:both; display: inline-block; display: none ">
				<div >
					<input type="checkbox" name="SMLateArrival1" id="SMLateArrival1" class="radio" onClick="toggleDiv('SMLateArrival1','arrivaldetails_div')">
						<label for="SMLateArrival1" class="labelwide">Yes, I will be arriving late, and am unable to meet between 1pm and 4pm on Friday, and wish to on Saturday morning.</label></div>
				<div style="display:none; clear:both" id="arrivaldetails_div">Please provide specifics about your estimated arrival time so that we may schedule on that basis.<br>
					<textarea name="arrivaldetails1" id="arrivaldetails1"></textarea>
				</div>
			</div>
-->

</div><!-- seems like an extra div -->

<div style="clear:both;">
	<div>
		<a href="javascript: showAnother('student2Div','student')" style="text-decoration: none; font-size:14px;">+ I have more than one student at Simon's Rock</a>
	</div>		
	<div class="spacer"></div>	
</div>

</div><!-- seems like an extra div -->

<div class="spacer"></div>
<div style="clear:both; display: none" id="student2Div" class="form-group col-md-12">
	<h2>Student #2</h2>
	<div id="student2FnameDiv" class="form-group col-sm-6">
    <label for="student2Fname">Student First Name*
      <!-- <span class="small">Add your name</span> -->
      </label>
      <input type="text" name="student2Fname" id="student2Fname" class="form-control"/><span class="required"></span>
  </div>
  <div id="student2LnameDiv" class="form-group col-sm-6">
      <label for="student2Lname">Student Last Name*
      </label>
      <input type="text" name="student2Lname" id="student2Lname" class="form-control"/><span class="required"></span>
  </div>
  <div class="spacer"></div>
  
  <!--student 2 class year -->
  <div class="margin-bottom col-sm-12">
      <label for="student2Class">Currently a:</label>
      <select name="student2Class" id="student2Class" class="form-control" onChange="setMeetingTimeMsg(this.value,'2')" />
      	<option>---Please Select---</option>
      	<option value="First-year">First-year</option>
      	<option value="Sophomore">Sophomore</option>
      	<option value="Junior">Junior</option>
      	<option value="Senior">Senior</option>
      </select>
    </div>

    <!-- comment out meetings requests after deadline -->	
    <!--        
    <div style="clear: both; display:''" id="nonSophomoreFM2">
    	<div> -->
        <!--<div id="fynote2" style="display: none;"><?php echo($firstYearNote); ?></div>-->
     <!-- 	<div id="seniornote2" style="display: none;"><?php echo($seniorNote); ?></div>
      	<div><h3 class="subheadline">Faculty Meetings</h3></div>
        <div class="msg" id="meetingTimeMsg2"><p><?php echo ($FMNote)?><br /><br />
      -->     
            <!-- <strong>NOTE:</strong> Many faculty schedules are full or almost full for Saturday morning meetings. Please indicate with whom you would like to meet and we will let you know which faculty members still have available meeting times. We will continue scheduling meetings for families through Thursday morning. Thank you.</p> -->
      <!--          <p style="display: none">We do not schedule meetings for any of the ensemble classes (Chorus, Jazz, Madrigal Group, Chamber Orchestra, and Collegium). Generally, faculty members with "adjunct" status are not available for meetings on Family Weekend, nor are private music instructors.</p>
				</div> 
      </div><!--end nonSophomoreFM2 -->
			
      <!-- comment out meetings requests after deadline -->	     
			<!--
			<div>
      	<h3 class="subheadline">Meeting Requests</h3>
      </div>
			-->
      <!-- comment out meetings requests after deadline -->
      <!--
      <h4>I would like to meet with</h4>
      <div class="form-group col-md-12">
      	<div class="radio">
        	<label class="labelwide" for="student2MeetingAll"><input class="radio" type="radio" name="student2Meeting" id="student2MeetingAll" value="all" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display='none'" />All of the Student's Available Faculty</label>
        </div>
      	<div class="radio">
        	<label class="labelwide" for="student2MeetingNone" ><input class="radio" type="radio" name="student2Meeting" id="student2MeetingNone" value="none" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display='none'" />No Meetings with Faculty</label>
        </div>
        <div class="radio">
        	<label class="labelwide" for="student2MeetingSpecify"><input class="radio" type="radio" name="student2Meeting" id="student2MeetingSpecify" value="some" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display=''"  />Certain Faculty</label>
        </div>
        <div id="student2MeetingSpecifyWhichDiv" style="display:none" >
        	Please specify the faculty by name or class
					<input type="text" name="student2MeetingSpecifyWhich" id="student2MeetingSpecifyWhich" class="col-sm-12">
        </div>
      </div>  --> <!-- end facultuy meeting form group -->
    </div>
		
   	<!-- comment out meetings requests after deadline -->
		<!--
		<div class="form-group col-md-12">
			<h4>I would like to meet with my student's Academic Advisor</h4>
			<div class="radio">
				<label for="academicAdvisorMeeting2Yes" class="labelsmall"><input type="radio" class="radio" name="academicAdvisorMeeting2" id="academicAdvisorMeeting2Yes" value="1">
				Yes</label>
			</div>
			<div class="radio">
				<label for="academicAdvisorMeeting2No" class="labelsmall"><input type="radio" class="radio" name="academicAdvisorMeeting2" id="academicAdvisorMeeting2No" value="0">
				No</label>
			</div>
		</div>
		<div style="display: none;" id="seniorThesisAdvisorMeeting2HeaderDiv">
			<h4>I would like to meet with my student's Thesis Advisor</h4>
		</div>
		<div style="display:none;" id="seniorThesisAdvisorMeeting2QuestionDiv" class="form-group col-md-12">
			<div class="radio">
				<label for="seniorThesisAdvisorMeeting2Yes" class="labelsmall">
				<input type="radio" class="radio" name="seniorThesisAdvisorMeeting2" id="seniorThesisAdvisorMeeting2Yes" value="1">
				Yes</label></div>
			<div class="radio">
				<label for="seniorThesisAdvisorMeeting2No" class="labelsmall"><input type="radio" class="radio" name="seniorThesisAdvisorMeeting2" id="seniorThesisAdvisorMeeting2No" value="0">
				No</label>
			</div>
		</div>  --><!-- end advisor form groups -->
	</div>

	<!-- comment out meetings requests after deadline -->
  <!--<div style="clear: both; display: none" id="sophomoreFM2">
  	<div>
    	<h4>Sophomore Planning Meetings</h4>
    	<div class="msg">
     		<p><?php echo($sophomoreNote);?></span></p>
    	</div>
    </div>
  	<h5>I would like to request a Sophomore Planning Meeting</h5>
		<div class="form-group col-md-12">
  		<div class="radio">
  			<label for="sophomoreFacultyMeeting2Yes" class="labelsmall"><input type="radio" class="radio" name="sophomoreFacultyMeeting2" id="sophomoreFacultyMeeting2Yes" value="1" onClick="document.getElementById('lateArrive2_div').style.display='inline-block'">
				Yes</label>
			</div>
		<div class="radio">
			<label for="sophomoreFacultyMeeting2No" class="labelsmall"><input type="radio" class="radio" name="sophomoreFacultyMeeting2" id="sophomoreFacultyMeeting2No" value="0" onClick="document.getElementById('lateArrive2_div').style.display='none'">
			No</label>
		</div>
	</div>  -->    <!-- end sophomore planning meetings for student 2-->
	<!--
			<div id="lateArrive2_div" style="clear:both; padding: 0 0 0 70px;display: inline-block; display: none">
				<div>
					<input type="checkbox" name="SMLateArrival2" id="SMLateArrival2" class="radio" onClick="toggleDiv('SMLateArrival2','arrivaldetails2_div')">
						<label for="SMLateArrival2" class="labelwide">Yes, I will be arriving late, and am unable to meet between 1pm  and 4pm on Friday, and wish to meet on Saturday morning.</label></div>
				<div style="display:none; clear:both " id="arrivaldetails2_div">Please provide specifics about your estimated arrival time so that we can schedule on that basis.<br>
					<textarea name="arrivaldetails2" id="arrivaldetails2" style="width:300px; height: 80px; margin: 8px" ></textarea>
				</div>
			</div>				
	-->
</div>
</div> <!-- seems like an extra closing div -->

						<script type='text/javascript'>//<![CDATA[
			$(window).load(function(){
			$(document).ready(function(){
			    $('#student1Class').on('change', function() {
			      if ( this.value == 'Senior')
			      {
			        $("#seniorThesisAdvisorMeeting1HeaderDiv").show();
					$("#seniorThesisAdvisorMeeting1QuestionDiv").show();
			      }
			      else
			      {
			        $("#seniorThesisAdvisorMeeting1HeaderDiv").hide();
					$("#seniorThesisAdvisorMeeting1QuestionDiv").hide();
			      }
			    });
				$('#student2Class').on('change', function() {
			      if ( this.value == 'Senior')
			      {
			        $("#seniorThesisAdvisorMeeting2HeaderDiv").show();
					$("#seniorThesisAdvisorMeeting2QuestionDiv").show();
			      }
			      else
			      {
			        $("#seniorThesisAdvisorMeeting2HeaderDiv").hide();
					$("#seniorThesisAdvisorMeeting2QuestionDiv").hide();
			      }
			    });
			});
			});//]]> 

			</script>	
<!--
	<div class="spacer"></div>
    <div style="clear:both; padding:5px; margin:5px; " id="accessibilityDiv">
		<div style="margin: 15px; font-size:16px"><strong>Accessibility</strong></div>
		<div style="margin: 15px; font-size:13px">Meetings take place in faculty offices located around campus in 4 different academic buildings. Some buildings have elevators and some have only stairs, so <strong>please let us know if you would like to meet in an accessible meeting location</strong> by providing a brief description of your accessibility needs.</div>
		<textarea name="accessibilityNeeds" id="accessibilityNeeds" style="width:500px; height: 80px; margin: 8px" ></textarea>	
	</div>
-->
    <div class="margin-bottom"></div>
	<h2>Family Members Attending</h2>
	
<?php 
for($relativeCount=1; $relativeCount <= $relativesTotal; $relativeCount++){
	if($relativeCount==1){
		$display = '';
	}
	else{
		$display = 'none';
	}

	echo '<div style="display:'.$display.'" id="relative'.$relativeCount.'Div" class="form-group col-md-12">';
	if($relativeCount==1){
		echo '<h3>Your Information</h3>';
	}
	else{
		echo '<h3>Family Member '.($relativeCount).'</h3>';
	}
	echo '
		<div id="student'.$relativeCount.'FnameDiv" class="form-group col-sm-6">
      <label for="relative'.$relativeCount.'Fname">First Name*
      <!-- <span class="small">Add your name</span> -->
      </label>
      <input type="text" name="relative'.$relativeCount.'Fname" id="relative'.$relativeCount.'Fname" class="form-control"/><span class="required"></span>
    </div>
    <div id="relative'.$relativeCount.'LnameDiv" class="form-group col-sm-6">
      <label for="relative'.$relativeCount.'Lname">Last Name*
      </label>
      <input type="text" name="relative'.$relativeCount.'Lname" id="relative'.$relativeCount.'Lname" class="form-control"/><span class="required"></span>
    </div>';
		if($relativeCount==1){
			echo '
				<div>
	        <div class="form-group col-sm-12" id="relative'.$relativeCount.'EmailDiv">
	          <label for="relative'.$relativeCount.'Email">Email*
	          </label>
	          <input type="text" class="form-control" name="relative'.$relativeCount.'Email" id="relative'.$relativeCount.'Email" /><span class="required"></span>
	        </div>
					
        </div>			
			';
		}
		echo '
        <div id="relative'.$relativeCount.'HometownDiv" class="form-group col-sm-6">
          <label for="relative'.$relativeCount.'Hometown">City
          </label>
          <input type="text" name="relative'.$relativeCount.'Hometown" id="relative'.$relativeCount.'Hometown" class="form-control"/>
        </div>
        <div id="relative'.$relativeCount.'HomestateDiv" class="form-group col-sm-6">
          <label for="relative'.$relativeCount.'Homestate">State/Province
          </label>
          <input type="text" name="relative'.$relativeCount.'Homestate" id="relative'.$relativeCount.'Homestate" class="form-control"/>
        </div>
        <div class="form-group col-sm-12" id="relative'.$relativeCount.'CountryDiv">
          <label for="relative'.$relativeCount.'Country">Country
          </label>
          <input type="text" name="relative'.$relativeCount.'Country" id="relative'.$relativeCount.'Country" class="form-control" />
        </div>
        <div class="form-group col-sm-12">
          <label for="relative'.$relativeCount.'Class">Relationship:</label>
          <select name="relative'.$relativeCount.'Class" id="relative'.$relativeCount.'Class" class="form-control" />
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
				  <div><a href="javascript: showAnother(\'relative'.($relativeCount+1).'Div\',\'family\')" style="text-decoration: none; font-size:14px;">+ Add additional Family Members Attending</a></div>
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
	<div>
		<div><input type="hidden" name="totalFamilyMembersAttending" id="totalFamilyMembersAttending" value="1" /></div>
		<div class="margin-bottom"><strong>Total Family Members Attending: <span id="totalFamilyMembersAttendingShow">1</span></strong></div>
	</div>
	
	
	<h2>Events</h2>
		
	<div class="form-group col-md-12" id="whenPlanArrive">
    <label for="whenPlanArrive" class="labelmed">When do you plan to arrive on campus</label>
    <input type="text" name="whenPlanArrive" id="whenPlanArrive" class="form-control" />
  </div>
  <p>Please indicate which of the events listed below you plan to attend, and the number of attendees.</p>
		<h3>Friday, October 30</h3>
		<div>
			
    	<div style="clear:both; display:none;" id="attendClassesDiv">
          <label for="attendClasses" class="labelmed">Attend Classes
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="attendClassesAdults" id="attendClassesAdults" />
		  <input type="text" name="attendClassesChild" id="attendClassesChild" />
        </div>
		<div style="clear:both; display:none;" id="labOpenHouseDiv">
          <label for="labOpenHouse" class="labelmed">Lab Open House
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="labOpenHouseAdults" id="labOpenHouseAdults" />
		  <input type="text" name="labOpenHouseChild" id="labOpenHouseChild" />
        </div>
		<div style="clear:both; display:none; " id="familyRecreationTimeDiv">
          <label for="familyRecreationTime" class="labelmed">Family Recreation Time
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="familyRecreationTimeAdults" id="familyRecreationTimeAdults" />
		  <input type="text" name="familyRecreationTimeChild" id="familyRecreationTimeChild" />
        </div>
		<div style="clear:both; display:none;" id="winStudentResourceCommonsDiv">
          <label for="winStudentResourceCommons" class="labelmed">Win Student Resource Commons: Support Services for Students</label>
          <input type="text" name="winStudentResourceCommonsAdults" id="winStudentResourceCommonsAdults" />
		  <input type="text" name="winStudentResourceCommonsChild" id="winStudentResourceCommonsChild" />
        </div>
    <!--    
		<div class="form-group col-md-12" id="trickOrTreatingDiv">
			<h4>Trick or Treating</h4>
      <label for="trickOrTreatingAdults" class="labelmed">Adults</label>
      <input type="text" name="trickOrTreatingAdults" id="trickOrTreatingAdults" size="5"/><br />
      <label for="trickOrTreatingChild" class="labelmed">Children</label>
  		<input type="text" name="trickOrTreatingChild" id="trickOrTreatingChild" size="5"/>
    </div>
    -->

    	<div class="form-group col-md-12" id="FYAdjustmentDiv">
    		<h4>First-Year Adjustment Panel</h4>
          <label for="FYAdjustmentAdults" class="labelmed">Adults</label>
          <input type="text" name="FYAdjustmentAdults" id="FYAdjustmentAdults" size="5"/><br />
          <label for="FYAdjustmentChild" class="labelmed">Children</label>
		  		<input type="text" name="FYAdjustmentChild" id="FYAdjustmentChild" size="5"/>
<!--		  <img src="info.png" onMouseOver="tooltip.show('How does a student settle into the Simon\'s Rock routine? Attend this panel presentation to find out!', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>

		<div class="form-group col-md-12" id="welcomeReceptionDiv">
			<h4>Welcome Reception and Senior Thesis Poster Display</h4>
      <label for="welcomeReceptionAdults" class="labelmed">Adults</label>
      <input type="text" name="welcomeReceptionAdults" id="welcomeReceptionAdults" size="5"/><br />
      <label for="welcomeReceptionChild" class="labelmed">Children</label>
		  <input type="text" name="welcomeReceptionChild" id="welcomeReceptionChild" size="5"/>
        </div>

		<div class="form-group col-md-12" id="murderMysteryChallengeDiv">
			<h4>Murder Mystery Challenge</h4>
      <label for="murderMysteryChallengeAdults" class="labelmed">Adults</label>
      <input type="text" name="murderMysteryChallengeAdults" id="murderMysteryChallengeAdults" size="5"/><br />
      <label for="murderMysteryChallengeChild" class="labelmed">Children</label>
		  <input type="text" name="murderMysteryChallengeChild" id="murderMysteryChallengeChild" size="5"/>
    </div>

    	<div class="form-group col-md-12" id="frightFilmFestDiv">
    		<h4>Scary Movie</h4>
          <label for="frightFilmFestAdults" class="labelmed">Adults</label>
          <input type="text" name="frightFilmFestAdults" id="frightFilmFestAdults" size="5"/><br />
		 			<label for="frightFilmFestChild" class="labelmed">Children</label>
		 			<input type="text" name="frightFilmFestChild" id="frightFilmFestChild" size="5"/>
        </div>
		<h3>Saturday, October 31</h3>
		
		<div class="form-group col-md-12" id="honorsConvocationDiv">
			<h4>Honors Convocation</h4>
          <label for="honorsConvocationCommons" class="labelmed">Adults</label>
          <input type="text" name="honorsConvocationAdults" id="honorsConvocationAdults" size="5"/><br />
          <label for="honorsConvocationCommonsChild" class="labelmed">Children</label>
		  <input type="text" name="honorsConvocationChild" id="honorsConvocationChild" size="5"/>
<!-- 		  <img src="info.png" onMouseOver="tooltip.show('Join Provost Peter Laipson and the faculty and student speakers on this special evening when the College celebrates this year\'s recipients of named scholarships', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>

    	<div style="clear:both; display:none;" id="studAffairsOHDiv">
    		<h4>Student Affairs Open House</h4>
        <label for="studAffairsOH" class="labelmed">Adults</label>
        <input type="text" name="studAffairsOHAdults" id="studAffairsOHAdults" size="5"/><br />
        <label for="studAffairsOHChild" class="labelmed">Children</label>
		  	<input type="text" name="studAffairsOHChild" id="studAffairsOHChild" size="5"/>
      </div>
    	<div class="form-group col-md-12" id="alumniPanelDiv">
        <h4>Alumni Career Panel</h4>
          <label for="alumniPanel" class="labelmed">Adults</label>
          <input type="text" name="alumniPanelAdults" id="alumniPanelAdults" size="5"/><br />
          <label for="alumniPanelChild" class="labelmed">Children</label>
		  		<input type="text" name="alumniPanelChild" id="alumniPanelChild" size="5"/>
<!--		  <img src="info.png" onMouseOver="tooltip.show('Alumni share their academic/career paths since leaving Simon\'s Rock.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
      </div>
    	<div class="form-group col-md-12" id="studyAbroadPanelDiv">
    		<h4>Study Abroad Panel</h4>
          <label for="studyAbroadPanel" class="labelmed">Adults</label>
          <input type="text" name="studyAbroadPanelAdults" id="studyAbroadPanelAdults" size="5"/><br />
          <label for="studyAbroadPanelChild" class="labelmed">Children</label>
		  		<input type="text" name="studyAbroadPanelChild" id="studyAbroadPanelChild" size="5"/>
<!--		  <img src="info.png" onMouseOver="tooltip.show('Five seniors will share their experiences during their study away program.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div style="clear:both; display: none" id="internationalFairDiv">
    		<h4>International Fair</h4>
        <label for="internationalFair" class="labelmed">Adults</label>
        <input type="text" name="internationalFairAdults" id="internationalFairAdults" size="5"/><br />
        <label for="internationalFairChild" class="labelmed">Children</label>
		  	<input type="text" name="internationalFairChild" id="internationalFairChild" size="5"/>
<!--		  <img src="info.png" onMouseOver="tooltip.show('Students invite you to learn about their area of the world in a variety of ways:  through photographs, videos, dress, cuisine, and language, among others.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div style="clear:both;display: none" id="seniorThesisPanelDiv">
    		<h4>Senior Thesis Panel</h4>
        <label for="seniorThesisPanel" class="labelmed">Adults</label>
        <input type="text" name="seniorThesisPanelAdults" id="seniorThesisPanelAdults" size="5"/><br />
        <label for="seniorThesisPanelChild" class="labelmed">Children</label>
		  	<input type="text" name="seniorThesisPanelChild" id="seniorThesisPanelChild" size="5"/>
		  <!-- <img src="info.png" onMouseOver="tooltip.show('', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
      </div>
    	<div style="clear:both; display: none" id="studentShowcaseDiv">
        <h4>Student Showcase</h4>
        <label for="studentShowcase" class="labelmed">Adults</label>
        <input type="text" name="studentShowcaseAdults" id="studentShowcaseAdults" size="5"/><br />
		  	<label for="studentShowcaseChild" class="labelmed">Children</label>
		  	<input type="text" name="studentShowcaseChild" id="studentShowcaseChild" size="5"/>
<!-- 		  <img src="info.png" onMouseOver="tooltip.show('', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
      </div>
    	<div style="clear:both; display:none" id="provostsReceptionDiv">
        <h4>Provost's Reception</h4>  
        <label for="provostsReception" class="labelmed">Adults</label>
        <input type="text" name="provostsReceptionAdults" id="provostsReceptionAdults" size="5"/><br />
        <label for="provostsReceptionChild" class="labelmed">Children</label>
		  	<input type="text" style="display: none" value="0" name="provostsReceptionChild" id="provostsReceptionChild" size="5"/>
<!--		  <img src="info.png" onMouseOver="tooltip.show('Provost Peter Laipson invites parents (only, please) to join him and members of the faculty and staff for a reception.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>


    	<!--
    	<div class="form-group col-md-12" id="jazzEnsembleConcertDiv">
          <h4>Jazz Ensemble Concert</h4>
          <label for="jazzEnsembleConcert" class="labelmed">Adults</label>
          <input type="text" name="jazzEnsembleConcertAdults" id="jazzEnsembleConcertAdults" size="5"/><br />
          <label for="jazzEnsembleConcertChild" class="labelmed">Child</label>
		  		<input type="text" name="jazzEnsembleConcertChild" id="jazzEnsembleConcertChild" size="5"/>
      </div>
      -->
      <div class="form-group col-md-12" id="halloweenDanceDiv">
	    	<h4>Halloween Dance</h4>
	      <label for="halloweenDanceAdults" class="labelmed">Adults</label>
	      <input type="text" name="halloweenDanceAdults" id="halloweenDanceAdults" size="5"/><br />
	      <label for="halloweenDanceAdults" class="labelmed">Children</label>
			  <input type="text" name="halloweenDanceChild" id="halloweenDanceChild" size="5"/>
	    </div>
        
		
		<h3>Sunday, November 1</h3>
		
    	<div class="form-group col-md-12" id="hikeUpMountainDiv">
    		<h4>Interpretative Trail Guided Walk</h4>
        <label for="hikeUpMountain" class="labelmed">Adults</label>
        <input type="text" name="hikeUpMountainAdults" id="hikeUpMountainAdults" size="5"/><br />
		  	<label for="hikeUpMountainChild" class="labelmed">Children</label>
		  	<input type="text" name="hikeUpMountainChild" id="hikeUpMountainChild" size="5"/>
<!--		  <img src="info.png" onMouseOver="tooltip.show('Join us for a hike in one of our local parks.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" /> -->
        </div>
    	<div class="form-group col-md-12" id="pianoRecitalDiv">
    		<h4>Faculty Concert: Allan Dean & Friends</h4>
        <label for="pianoRecitalAdults" class="labelmed">Adults</label>
        <input type="text" name="pianoRecitalAdults" id="pianoRecitalAdults" size="5"/><br />
        <label for="pianoRecitalChild" class="labelmed">Children</label>
		  	<input type="text" name="pianoRecitalChild" id="pianoRecitalChild" size="5"/>
      </div>
      <!--
    	<div class="form-group col-md-12" id="normanRockwellMuseumDiv">
          <h4>Norman Rockwell Museum &amp; Stockbridge</h4>
          <p>Admission fee to museum to be paid upon arrival by each guest.</p>
          <label for="normanRockwellMuseumTransportationAdults" class="labelmed">Adults</label>
          <input type="text" name="normanRockwellMuseumAdults" id="normanRockwellMuseumAdults" size="5"/><br />
          <label for="normanRockwellMuseumTransportationChild" class="labelmed">Child</label>
		  		<input type="text" name="normanRockwellMuseumChild" id="normanRockwellMuseumChild" size="5"/>
          <div class="form-group col-md-12">
            <input value="1" type="checkbox" name="normanRockwellMuseumTransportationAdults" id="normanRockwellMuseumTransportationAdults">
            <label for="normanRockwellMuseumTransportationAdults" class="labelmed">I will need transportation</label>
		  		</div>
        </div>
      -->
      <!--
    	<div class="form-group col-md-12" id="walkingTourDiv">
      	<h4>Great Barrington Historical Walking Tour</h4>
    	  <label for="walkingTourAdults" class="labelmed">Adults</label>
        <input type="text" name="walkingTourAdults" id="walkingTourAdults" size="5"/><br />
        <label for="walkingTourChild" class="labelmed">Adults</label>
	  		<input type="text" name="walkingTourChild" id="walkingTourChild" size="5"/>
        <div class="form-group col-md-12">
          <input value="1" type="checkbox" name="walkingTourTransportationAdults" id="walkingTourTransportationAdults">
          <label for="walkingTourTransportationAdults" class="labelmed">I will need transportation</label>
	  		</div>
      </div>
      -->

	<div style="clear:both;">
		<h2>Meals</h2>
			<p>Please indicate below which meals you plan to attend. Students currently on the meal plan are already covered for the meals below.</p>
    	<div class="form-group col-md-12" id="fridayLunchDiv">
          <label for="fridayLunch" class="labelmed">Friday Lunch: $8 &times; </label>
          <input type="text" name="fridayLunch" id="fridayLunch" onKeyUp="calculateMeals(); setTemps(this.id)" size="3"/> 
          <input type="hidden" name="fridayLunchTemp" id="fridayLunchTemp">
        </div>
    	<div class="form-group col-md-12" id="fridayDinnerDiv">
          <label for="fridayDinner" class="labelmed">Friday Dinner: $9 &times; </label>
          <input type="text" name="fridayDinner" id="fridayDinner" onKeyUp="calculateMeals(); setTemps(this.id)" size="3"/>
          <input type="hidden" name="fridayDinnerTemp" id="fridayDinnerTemp">
        </div>
    	<div class="form-group col-md-12" id="saturdayBrunchDiv">
          <label for="saturdayBrunch" class="labelmed">Saturday Breakfast: $5 &times; </label>
          <input type="text" name="saturdayBrunch" id="saturdayBrunch" onKeyUp="calculateMeals(); setTemps(this.id)" size="3"/> 
          <input type="hidden" name="saturdayBrunchTemp" id="saturdayBrunchTemp">
        </div>
    	<div class="form-group col-md-12" id="saturdayLunchDiv">
          <label for="saturdayLunch" class="labelmed">Harvest Fest Lunch: $9 &times; </label>
          <input type="text" name="saturdayLunch" id="saturdayLunch" onKeyUp="calculateMeals(); setTemps(this.id)" size="3"/>
          <input type="hidden" name="saturdayLunchTemp" id="saturdayLunchTemp">
        </div>
    	<div class="form-group col-md-12" id="saturdayDinnerDiv">
          <label for="saturdayDinner" class="labelmed">Saturday Dinner: $9 &times; </label>
          <input type="text" name="saturdayDinner" id="saturdayDinner" onKeyUp="calculateMeals(); setTemps(this.id)" size="3"/>
          <input type="hidden" name="saturdayDinnerTemp" id="saturdayDinnerTemp">
        </div>
    	<div class="form-group col-md-12" id="sundayBrunchDiv">
          <label for="sundayBrunch" class="labelmed">Sunday Brunch: $9 &times; </label>
          <input type="text" name="sundayBrunch" id="sundayBrunch" onKeyUp="calculateMeals(); setTemps(this.id)" size="3"/>
          <input type="hidden" name="sundayBrunchTemp" id="sundayBrunchTemp">
      </div>
			<div style="clear:both" id="totalDiv">
	          <strong>TOTAL: $</strong><input type="text" class="total" onFocus="this.blur()" name="total" id="total" readonly style="border: none;"/>
	    </div>
	   	<h3>Payment</h3>
		  <div class="form-group col-md-12">
	   		<div id="paypalDiv" class="radio">
<!--           <input style="margin-left: 150px;" type="checkbox" class="radio" name="cashAtDoor" id="cashAtDoor" onClick="doCashAtDoor(this.checked)"  /> -->
		  		<label for="paypal" class="labelmed"><input type="radio" class="radio" name="mop" id="paypal" value="paypal"  /> I will pay by credit card now.</label>
        </div>
    		<div id="cashAtDoorDiv" class="radio">
<!--           <input style="margin-left: 150px;" type="checkbox" class="radio" name="cashAtDoor" id="cashAtDoor" onClick="doCashAtDoor(this.checked)"  /> -->
		  		<label for="cashAtDoor" class="labelmed"><input type="radio" class="radio" name="mop" id="cashAtDoor" value="cashAtDoor"  /> 
          I will pay cash at the door.(Dining Services only accepts cash.)</label>
        </div>
      </div>
	</div>
	<div class="spacer"></div>
	<button type="submit" name="submit" id="submit" class="btn btn-primary">Register Now</button>
	<div class="margin-bottom"></div>
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
			alert ("Please complete all required (starred) fields prior to submitting your form.");
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
		"saturdayBrunch",
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
			total += parseInt(document.request.saturdayBrunch.value)*5;
		}
	}
	if(document.request.saturdayLunch.value != 0 && document.request.saturdayLunch.value != ""){
		if(!isNum(document.request.saturdayLunch.value)){
			alertMsg += 1;
			document.request.saturdayLunch.value = "";
		}
		else {
			total += parseInt(document.request.saturdayLunch.value)*9;
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
