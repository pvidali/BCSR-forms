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
<title>Family Weekend Reports - Provost</title>
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
else {
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
	$db = new DB(HOST,USER,PASSWORD,DATABASE);
	$db->connect();

	require_once $_SERVER['DOCUMENT_ROOT']."/family-weekend/reports/includes/date-range.php";
	
	$sql = "SELECT * FROM family_weekend WHERE provostsReceptionAdults > 0 AND date_submitted > '$rangestart' AND date_submitted < '$rangeend' ORDER BY relative1Lname";
	$db->do_query($sql);
	$tablerows = "";
	$rowStyle = 0;
	$rowCount = 1;
	$attendeesTotal = 0;
	while($row = $db->fetchObject()) {
		$relativeFname			= $row->relative1Fname;
		$relativeLname			= $row->relative1Lname;
		$provosts				= $row->provostsReceptionAdults;
		$attendeesTotal += $provosts;
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
				<td>$relativeLname, $relativeFname</td>
				<td>$provosts</td>
			</tr>
		";
		$rowCount++;
	}

?>

<html>
<head>
<title>Family Weekend Reports</title>
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
<h1>Family Weekend Reports</h1>

<h2><?php echo($startyear);?> Provost Reception Attendees</h2>

<?php
include_once "../date.php";
?>


<table cellpadding="3" cellspacing="0">
	<tr>
		<td width="10">&nbsp;</td>
		<td width="180"><strong>Family Contact</strong></td>
		<td align="center"><strong>Number Attending</strong></td>
	</tr>
<?php 
echo ($tablerows);
?>
<tr>
	<td colspan="3" align="right">
		<?php 
			echo " TOTAL ATTENDEES: $attendeesTotal"; 
		?>
	</td>
</tr>
</table>



</body>
</html>
<?php
}
?>