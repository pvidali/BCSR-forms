<?php
if(isset($_REQUEST['test']) && $_REQUEST['test'] == "1"){
	ini_set("display_errors","On");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
}
/*** begin our session ***/
session_start();

/*** check if the users is already logged in ***/
if(!isset( $_SESSION['user_id'] ))
{
	
?>	
<html>
<head>
<title>Family Weekend Meal Reports</title>
<style>
.rowOther {
	background-color: #CCC;
}
</style>
</head>
<body>	
<p>You must be logged in to view the reports.</p>	
<p><a href="/family-weekend/reports/login.php">Login Here</a></p>
</body>
</html>

<?php 
}
else if($_SESSION['user_id']->phpro_username == 'fwstats'){
?>	
<html>
<head>
<title>Family Weekend Reports</title>
<style>
.rowOther {
	background-color: #CCC;
}

</style>
</head>
<body>	
<p>You do not have permission to view this information.</p>	
<p><a href="/family-weekend/reports/overall/index.php">View the overall stats here</a></p>
</body>
</html>

<?php 		
}
else {
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
	$db = new DB(HOST,USER,PASSWORD,DATABASE);
	$db->connect();
	
	$pend = "-09-01 00:00:00";
	$startyear = date('Y');
	if(
		 (isset($_REQUEST['year']) && $_REQUEST['year'] != "all")  
		 	||
		 (!isset($_REQUEST['year']))
	   ){
		if(isset($_REQUEST['year'])){
			$startyear = $_REQUEST['year'];
		}
		$endyear = $startyear+1;
		$rangestart =  $startyear.$pend;
		$rangeend = $endyear.$pend;
	}
	else if(isset($_REQUEST['year']) && $_REQUEST['year'] == "all"){
		$rangestart =  "2000".$pend;
		$rangeend = "2500".$pend;
	}

	$FRL = array();
	$FRD = array();
	$STB = array();
//	$STL = array();
	$STD = array();
	$SNB = array();
	$PMT_STATUS = array();
	$MOP = array();

	$sql = "SELECT * FROM fw_program_meal_registration WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend' ORDER BY date_submitted";
	$db->do_query($sql);
	while($row = $db->fetchObject()) {
		$contact_id			= $row->contact_id;
		$meals				= $row->meals;
		$payer_id			= $row->payer_id;
		$paid_for			= $row->paid_for;
		$mop				= $row->mop;
		
		/* 	This is ugly... but since we know the order they are coming in because we pushed them in., we'll blindly rely on that. Sorry! They meals should for sure have been placed into their own table linked on the payer_id
			Anyway, first we break the entire string of a given registration's 'meals' on each pipe (|) into an array, so that each spoecific meal is its own array element
			Then each array element we've created is further exploeded on the colon (:), so it's now a array of arrays, each one representing a meal, and a number of meal eaters
			We'll also create a payment status array based on the payer id as index, as a method of payment (mop) on the same basis
		*/ 
		$mealsArray = explode("|",$meals);  
		$FRLArray = explode(":",$mealsArray[0]);
		$FRL[$payer_id] = $FRLArray[1];
		$FRDArray = explode(":",$mealsArray[1]);
		$FRD[$payer_id] = $FRDArray[1];
		$STBArray = explode(":",$mealsArray[2]);
		$STB[$payer_id] = $STBArray[1];
//		$STLArray = explode(":",$mealsArray[3]);
//		$STL[$payer_id] = $STLArray[1];
		$STDArray = explode(":",$mealsArray[4]);
		$STD[$payer_id] = $STDArray[1];
		$SNBArray = explode(":",$mealsArray[5]);
		$SNB[$payer_id] = $SNBArray[1];

		$PMT_STATUS[$payer_id] = $row->paid_for;
		$MOP[$payer_id] = $row->mop;
	}
//	$allMeals = array('FRL' => $FRL,'FRD' => $FRD,'STB' => $STB,'STL' => $STL,'STD' => $STD,'SNB' => $SNB);
//	$allMealsNames = array('FRL' => "Friday Lunch",'FRD' => "Friday Dinner",'STB' => "Saturday Breakfast",'STL' => "Saturday Lunch",'STD' => "Saturday Dinner",'SNB' => "Sunday Brunch");
	$allMeals = array('FRL' => $FRL,'FRD' => $FRD,'STB' => $STB,'STD' => $STD,'SNB' => $SNB);
	$allMealsNames = array('FRL' => "Friday Lunch",'FRD' => "Friday Dinner",'STB' => "Saturday Brunch/Harvest Lunch",'STD' => "Saturday Dinner",'SNB' => "Sunday Brunch");

	$FRLTable = "";
	foreach($allMeals as $mealKey => $mealValue){
		$FRLTableKeys = array();
		$mealName = $allMealsNames[$mealKey];
		$FRLTable .= "<table id=\"$mealKey\" style='display: none'>";
		$FRLTable .= "<tr><td colspan=2 class='mealName'>$mealName</td></tr>";
		if(count($mealValue)){
			$FRLTable .= "<tr class=columnheader><td style='min-width: 250px; white-space: nowrap'>Registrant</td><td>Meal Count Indicated</td><td>M.O.P.</td><td>Pmt Status</td></tr>";
		}
		else {
			$FRLTable .= "<tr class=columnheader><td style='min-width: 250px; white-space: nowrap' colspan=2>No meals purchased for $mealName.</td></tr>";
		}
		foreach($mealValue as $k => $v){
			$sql = "SELECT * FROM family_weekend WHERE id = $k";
			$db->do_query($sql);
			$res = $db->fetchObject();
			$lname = $res->relative1Lname;
			$fname = $res->relative1Fname;
	//		$FRLTable = "PAYER ID: $k, NUMER RESERVED: $v";
			$FRLTableRow  = "<tr><td class=person>";
			$FRLTableRow .= $lname . ", " . $fname;
			$FRLTableRow .= "</td><td class=quantity>";
			$FRLTableRow .= $v;
			$FRLTableRow .= "</td><td class=mop>";
			$FRLTableRow .= $MOP[$k];
			$FRLTableRow .= "</td><td class=pmt_status>";
			$FRLTableRow .= $PMT_STATUS[$k];
			$FRLTableRow .= "</td></tr>";
			$thiskey = $lname.$fname;
			$x = 0;
			// MAKE A RECURSIVE FUNCTION
			if(array_key_exists($thiskey,$FRLTableKeys)){
				$thiskey = $thiskey.$x;
				$x++;
			}
			$FRLTableKeys[$thiskey] = $FRLTableRow;
	
		}
		$trows = "";
		natcasesort($FRLTableKeys);
		$rowColor = "even";
		foreach($FRLTableKeys as $trow){
			if($rowColor == "even"){
				$rowColor = "odd";
			}
			else {
				$rowColor = "even";	
			}
			$rowtagstyled  = "<tr class=";
			$rowtagstyled .= $rowColor;
			$rowtagstyled .= ">";
			$trow = str_replace("<tr>",$rowtagstyled,$trow);
			$trows .= $trow;
		}
		$FRLTable .= $trows;
		$FRLTable .= "</table>";
	}
/*
	$db->do_query($sql);
	$tablerows = "";
	$rowStyle = 0;
	$rowCount = 1;
	while($row = $db->fetchObject()) {
		$studentFname			= $row->student1Fname;
		$studentLname			= $row->student1Lname;
		$studentClass			= $row->student1Class;
		$studentMtg				= $row->student1Meeting;
		$academicAdvisorMtg		= $row->academicAdvisorMeeting1;
		$whichStaff				= $row->student1MeetingSpecifyWhich;
		if($academicAdvisorMtg == "1"){
			$academicAdvisorMtg = "Y";
		}
		else {
			$academicAdvisorMtg = "N";
		}
		$accessibilityNeeds		= $row->accessibilityNeeds;
		$sophomoreFacultyMtg	= $row->sophomoreFacultyMeeting1;
		if($sophomoreFacultyMtg == "1"){
			$sophomoreFacultyMtg = "Y";
		}
		else {
			$sophomoreFacultyMtg = "N";
		}
		$relativeFname			= $row->relative1Fname;
		$relativeLname			= $row->relative1Lname;
		$relativeEmail			= $row->relative1Email;
		$SMLateArrival			= $row->SMLateArrival1;
		$date					= $row->date_submitted;
		$arrivaldetails			= $row->arrivaldetails1;

		if($rowStyle == 0){
			$rowClass = "rowOther";
			$rowStyle++;
		}
		else{
			$rowClass = "";
			$rowStyle--;
		}
		$tablerows .= "
			<tr class=\"$rowClass\">
				<td>$rowCount</td>
				<td>$studentLname</td>
				<td>$studentFname</td>
				<td>$studentClass</td>
				<td>$relativeLname</td>
				<td>$relativeFname</td>
				<td><a href=\"mailto:$relativeEmail\">$relativeEmail</a></td>
				<td>$date</td>
				<td align=center>$studentMtg</td>
				<td align=center>$academicAdvisorMtg</td>
				<td align=center>$sophomoreFacultyMtg</td>
				<td>$arrivaldetails</td>
				<td>$accessibilityNeeds</td>
				<td>$whichStaff</td>
			</tr>
		";
		$rowCount++;

		if($row->student2Fname != ""){
			$studentFname			= $row->student2Fname;
			$studentLname			= $row->student2Lname;
			$studentClass			= $row->student2Class;
			$studentMtg				= $row->student2Meeting;
			$academicAdvisorMtg		= $row->academicAdvisorMeeting2;
			$whichStaff				= $row->student2MeetingSpecifyWhich;
			if($academicAdvisorMtg == "1"){
				$academicAdvisorMtg = "Y";
			}
			else {
				$academicAdvisorMtg = "N";
			}
			$accessibilityNeeds		= $row->accessibilityNeeds;
			$sophomoreFacultyMtg	= $row->sophomoreFacultyMeeting2;
			if($sophomoreFacultyMtg == "1"){
				$sophomoreFacultyMtg = "Y";
			}
			else {
				$sophomoreFacultyMtg = "N";
			}
			$relativeFname			= $row->relative1Fname;
			$relativeLname			= $row->relative1Lname;
			$relativeEmail			= $row->relative1Email;
			$SMLateArrival			= $row->SMLateArrival2;
			$date					= $row->date_submitted;
			$arrivaldetails			= $row->arrivaldetails2;
	
			if($rowStyle == 0){
				$rowClass = "rowOther";
				$rowStyle++;
			}
			else{
				$rowClass = "";
				$rowStyle--;
			}
			$tablerows .= "
				<tr class=\"$rowClass\">
					<td>$rowCount</td>
					<td>$studentLname</td>
					<td>$studentFname</td>
					<td>$studentClass</td>
					<td>$relativeLname</td>
					<td>$relativeFname</td>
					<td><a href=\"mailto:$relativeEmail\">$relativeEmail</a></td>
					<td>$date</td>
					<td align=center>$studentMtg</td>
					<td align=center>$academicAdvisorMtg</td>
					<td align=center>$sophomoreFacultyMtg</td>
					<td>$arrivaldetails</td>
					<td>$accessibilityNeeds</td>
					<td>$whichStaff</td>
				</tr>
			";
			$rowCount++;
		}
	}
*/

?>

<html>
<head>
<title>Family Weekend Meal Reports</title>
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
.rowOther {
	background-color: #CCC;
}
TD{
	font-size: 11px;
}

.mealName{
	font-weight: bold;
	font-size: 1.3em;
}
.person{
	width: 250px;
	white-space: nowrap;
}
.quantity{
}
.columnheader{
	font-weight:bold;
	font-size:1em;
}
.odd{background: #ccc}
.even{background: #fff}
</style>
</head>
<body>
<div style="float:right"><a href="/family-weekend/reports/login.php?logout=true">Log Out</a> </div>
<h1>Family Weekend Reports</h1>

<h2><?php echo($startyear);?> Meal Info</h2>

<?php
include_once "../date.php";
?>

<p>Choose the report you wish to view:</p>
<ul>
	<li><a href="javascript: showTable('FRL')">Friday Lunch</a></li>
	<li><a href="javascript: showTable('FRD')">Friday Dinner</a></li>
	<li><a href="javascript: showTable('STB')">Saturday Brunch/Harvest Lunch</a></li>
	<li><a href="javascript: showTable('STD')">Saturday Dinner</a></li>
	<li><a href="javascript: showTable('SNB')">Sunday Brunch</a></li>
</ul>

<?php
echo $FRLTable;
?>
<!--
<table cellpadding="3" cellspacing="0">
	<tr>
		<td width="10">&nbsp;</td>
		<td width="70"><strong>Student Last</strong></td>
		<td width="70"><strong>First</strong></td>
		<td width="60"><strong>Class</strong></td>
		<td width="90"><strong>Prnt/Grdn Last</strong></td>
		<td width="90"><strong>First</strong></td>
		<td width="90"><strong>email</strong></td>
		<td width="140"><strong>Date</strong></td>
		<td width="50" align="center"><strong>Faculty<br>Meeting?</strong></td>
		<td width="60" align="center"><strong>Advisor<br>Meeting?</strong></td>
		<td width="60" align="center"><strong>Sophomore<br>Planning</strong></td>
		<td width="100" align="center"><strong>Late Arrival Info</strong></td>
		<td width="100" align="center"><strong>Accessibility Needs</strong></td>
		<td width="100" align="center"><strong>Specific Faculty</strong></td>
	</tr>
<?php 
// echo ($tablerows);
?>
</table>
-->

<script>
function showTable(meal){
	var meals = new Array();
	meals[meals.length] = 'FRL';
	meals[meals.length] = 'FRD';
	meals[meals.length] = 'STB';
	meals[meals.length] = 'STD';
	meals[meals.length] = 'SNB';
	for(x = 0; x < meals.length; x++){
		if(meal == meals[x]){
			document.getElementById(meals[x]).style.display = '';
		}
		else{
			document.getElementById(meals[x]).style.display = 'none';
		}
	}
}
</script>
</body>
</html>
<?php
}
?>