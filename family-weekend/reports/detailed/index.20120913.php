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
<title>Family Weekend 2011 Registered Attendees</title>
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
/*
else if($_SESSION['user_id']->phpro_username == 'fwstats'){
?>	
<html>
<head>
<title>Family Weekend 2011 Reports</title>
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
*/
else {
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
	$db = new DB(HOST,USER,PASSWORD,DATABASE);
	$db->connect();
	
	$sql = "SELECT * FROM family_weekend_2014 ORDER BY student1Lname,student1Fname,student2Lname,student2Fname";
	$db->do_query($sql);
	$tablerows = "";
	$rowStyle = 0;
	$rowCount = 1;
	while($row = $db->fetchObject()) {
		$date_submitted		= $row->date_submitted;
		$student1Fname		= $row->student1Fname;
		$student1Lname		= $row->student1Lname;
		$relative1Fname		= $row->relative1Fname;
		$relative1Lname		= $row->relative1Lname;
		$relative1Class		= $row->relative1Class;
		$relative1Hometown	= $row->relative1Hometown;
		$relative1Homestate	= $row->relative1Homestate;

		// start this table row
		//  class="rowOther"
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
				<td>$student1Fname $student1Lname</td>
				<td>$relative1Fname $relative1Lname</td>
				<td>$relative1Class</td>
				<td>$relative1Hometown</td>
				<td>$relative1Homestate</td>
				<td>$date_submitted</td>
			</tr>
		";
		$rowCount++;

		if($row->relative2Fname != ""){
			$date_submitted		= $row->date_submitted;
			$student1Fname		= $row->student1Fname;
			$student1Lname		= $row->student1Lname;
			$relative2Fname		= $row->relative2Fname;
			$relative2Lname		= $row->relative2Lname;
			$relative2Class		= $row->relative2Class;
			$relative2Hometown	= $row->relative2Hometown;
			$relative2Homestate	= $row->relative2Homestate;
			
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
					<td>$student1Fname $student1Lname</td>
					<td>$relative2Fname $relative2Lname</td>
					<td>$relative2Class</td>
					<td>$relative2Hometown</td>
					<td>$relative2Homestate</td>
					<td>$date_submitted</td>
				</tr>
			";
			$rowCount++;
		}

		if($row->relative3Fname != ""){
			$date_submitted		= $row->date_submitted;
			$studentFname		= $row->student1Fname;
			$studentLname		= $row->student1Lname;
			$relativeFname		= $row->relative3Fname;
			$relativeLname		= $row->relative3Lname;
			$relativeClass		= $row->relative3Class;
			$relativeHometown	= $row->relative3Hometown;
			$relativeHomestate	= $row->relative3Homestate;
			
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
					<td>$studentFname $studentLname</td>
					<td>$relativeFname $relativeLname</td>
					<td>$relativeClass</td>
					<td>$relativeHometown</td>
					<td>$relativeHomestate</td>
					<td>$date_submitted</td>
				</tr>
			";
			$rowCount++;
		}
		if($row->relative4Fname != ""){
			$date_submitted		= $row->date_submitted;
			$studentFname		= $row->student1Fname;
			$studentLname		= $row->student1Lname;
			$relativeFname		= $row->relative4Fname;
			$relativeLname		= $row->relative4Lname;
			$relativeClass		= $row->relative4Class;
			$relativeHometown	= $row->relative4Hometown;
			$relativeHomestate	= $row->relative4Homestate;
			
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
					<td>$studentFname $studentLname</td>
					<td>$relativeFname $relativeLname</td>
					<td>$relativeClass</td>
					<td>$relativeHometown</td>
					<td>$relativeHomestate</td>
					<td>$date_submitted</td>
				</tr>
			";
			$rowCount++;
		}
		if($row->relative5Fname != ""){
			$date_submitted		= $row->date_submitted;
			$studentFname		= $row->student1Fname;
			$studentLname		= $row->student1Lname;
			$relativeFname		= $row->relative5Fname;
			$relativeLname		= $row->relative5Lname;
			$relativeClass		= $row->relative5Class;
			$relativeHometown	= $row->relative5Hometown;
			$relativeHomestate	= $row->relative5Homestate;
			
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
					<td>$studentFname $studentLname</td>
					<td>$relativeFname $relativeLname</td>
					<td>$relativeClass</td>
					<td>$relativeHometown</td>
					<td>$relativeHomestate</td>
					<td>$date_submitted</td>
				</tr>
			";
			$rowCount++;
		}

		if($row->student2Fname != ""){
			$date_submitted		= $row->date_submitted;
			$student2Fname		= $row->student2Fname;
			$student2Lname		= $row->student2Lname;
			$relative1Fname		= $row->relative1Fname;
			$relative1Lname		= $row->relative1Lname;
			$relative1Class		= $row->relative1Class;
			$relative1Hometown	= $row->relative1Hometown;
			$relative1Homestate	= $row->relative1Homestate;
			
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
					<td>$student2Fname $student2Lname</td>
					<td>$relative1Fname $relative1Lname</td>
					<td>$relative1Class</td>
					<td>$relative1Hometown</td>
					<td>$relative1Homestate</td>
					<td>$date_submitted</td>
				</tr>
			";
			$rowCount++;
		}

	}

?>

<html>
<head>
<title>Family Weekend 2011 Reports</title>
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
<div style="float:right"><a href="/family-weekend/reports/login.php?logout=true">Log Out</a> </div>
<h1>Family Weekend 2011 Registered Attendees </h1>

<h2>Registered Attendees </h2>

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
echo ($tablerows);
?>
</table>



</body>
</html>
<?php
}
?>