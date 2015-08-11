<?php
ini_set("display_errors","On");
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

/*** begin our session ***/
session_start();

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
<p>You must be logged in to view the reports.</p>	
<p><a href="/summer/reports/login.php">Login Here</a></p>
</body>
</html>

<?php 
}
else {
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
	$db = new DB(HOST,USER,PASSWORD,DATABASE);
	$db2 = new DB(HOST,USER,PASSWORD,DATABASE);
	$db3 = new DB(HOST,USER,PASSWORD,DATABASE);
	$db->connect();
	$db2->connect();
	$db3->connect();

	$sql = "SELECT * FROM summer_program_class";
	$db->do_query($sql);
	$classes = array();
	while($row = $db->fetchObject()) {
		$this_id = $row->id;
		$classes[$this_id]["week"]	= $row->week;
		$classes[$this_id]["title"]	= $row->title;
	}
	

	$cids = array();
	$classids = array();
	$studentClassRows = "";
	$sql = "SELECT * FROM forms.summer_program_class_registration WHERE paid_for='1'";
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


	$sql = "SELECT * FROM summer_program_class_registration WHERE paid_for = '1'";
	$db->do_query($sql);
	$regs = array();
	$x = 1;
	$tableRows = array();
	while($row = $db->fetchObject()) {
//		$regs[$x]["contact_id"]	= $row->contact_id;
//		$regs[$x]["class_id"]		= $row->class_id;
//		$x++;
		$contact_id = $row->contact_id;
		$class_id = $row->class_id;
		$class_title = $classes[$class_id]["title"];
		$class_week = $classes[$class_id]["week"];
		$sql = "SELECT * FROM summer_program_contact WHERE id = '$contact_id'";
		$rowNum = "1";
		while($inner_row = $db2->fetchObject()) {
			$date = $inner_row->date;
			$applicant_name = $inner_row->applicant_name;
			$permaddress_street = $inner_row->permaddress_street;
			$permaddress_street2 = $inner_row->permaddress_street2;
			$permaddress_city = $inner_row->permaddress_city;
			$permaddress_state = $inner_row->permaddress_state;
			$permaddress_zip = $inner_row->permaddress_zip;
			$permaddress_phone = $inner_row->permaddress_phone;
			$summeraddress_street = $inner_row->summeraddress_street;
			$summeraddress_street2 = $inner_row->summeraddress_street2;
			$summeraddress_city = $inner_row->summeraddress_city;
			$summeraddress_state = $inner_row->summeraddress_state;
			$summeraddress_city = $inner_row->summeraddress_city;
			$summeraddress_zip = $inner_row->summeraddress_zip;
			$student_phone = $inner_row->student_phone;
			$guardian_phone_day = $inner_row->guardian_phone_day;
			$emergency_name = $inner_row->emergency_name;
			$emergency_phone = $inner_row->emergency_phone;
			$student_email = $inner_row->student_email;
			$parent_email = $inner_row->parent_email;
			$student_school = $inner_row->student_school;
			$schooladdress_street = $inner_row->schooladdress_street;
			$schooladdress_street2 = $inner_row->schooladdress_street2;
			$schooladdress_city = $inner_row->schooladdress_city;
			$schooladdress_state = $inner_row->schooladdress_state;
			$schooladdress_zip = $inner_row->schooladdress_zip;
			$gradelevel_2012 = $inner_row->gradelevel_2012;
			$acad_interests = $inner_row->acad_interests;
			$extra_interests = $inner_row->extra_interests;
			$is_faculty = $inner_row->is_faculty;
		
			$tableRows[] = "
				<tr class=\"$rowClass\">
					<td>$rowNum</td>
					<td>$applicant_name</td>
					<td>$permaddress_phone</td>
					<td>$student_phone</td>
					<td>$guardian_phone_day</td>
					<td>$emergency_name</td>
					<td>$emergency_phone</td>
					<td>$student_email</td>
					<td>$parent_email</td>
					<td>$class_title</td>
					<td>$date</td>
				</tr>";
			$rowNum++;
		}
	}

?>

<html>
<head> 
<title>Summer Program 2012 Registration Reports</title>
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


</style>
</head>
<body>
<div style="float:right"><a href="/summer/reports/login.php?logout=true">Log Out</a> </div>
<h1>Summer Program 2012</h1>

<h2>Class Registrations</h2>

<table cellpadding="2" cellspacing="0">
	<tr>
		<td width="10">&nbsp;</td>
		<td width="185"><strong>Student</strong></td>
		<td width="185"><strong>Family Member</strong></td>
		<td width="175"><strong>Relationship</strong></td>
		<td width="150"><strong>City</strong></td>
		<td width="150"><strong>State</strong></td>
		<td width="185"><strong>Reg. Date</strong></td>
	</tr>
<?php 
echo ($studentClassRowsHtml);
echo ($tablerows);
?>
</table>



</body>
</html>
<?php
}
?>