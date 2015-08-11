<?php
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php";
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";

// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$email = $_REQUEST['email'];
$fields_recruiter = $_REQUEST['couns'];
$state = $_REQUEST['state'];
$country = $_REQUEST['country'];

$counsInfo = getTerritoryInfoDB($state,$country,$db);

$pic = $counsInfo['image']; //"leslie-globe.gif";
$couns_name = $counsInfo['fname'] . " ". $counsInfo['lname'];
$couns_fname = $counsInfo['fname'];
$couns_email = $counsInfo['recruiter_email_handle'];
$couns_phone = $counsInfo['phone'];
$couns_link = $counsInfo['redirStr'];// "http://www.simons-rock.edu/admission/davidson/";
$couns_pron = $counsInfo['pronoun'];

$par_one = "$couns_fname will be in touch with you very soon. If you wish to contact $couns_pron more quickly, <a href=\"mailto:$couns_email\">email</a> $couns_pron, or call $couns_pron at $couns_phone.";
$par_two = "You can learn some fun facts about $couns_fname <a href=\"$couns_link\" target=\"_top\">here</a>.";

?>

<!DOCTYPE HTML>
<html><head>
<meta charset="utf-8">
<title>Start College Now</title>
<style>
body {
	text-align: center;
	background:#FFF;
}
p{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#000;	
	padding: 10px 2px;
	font-weight:normal;
}
div#container {
	margin-left: auto;
	margin-right: auto;
	width: 700px;
	height:auto;
	text-align: left;
	display: inline-block;
}
#content{
	display:inline-block;
	height: auto;
}
#header {
	clear:both
}
#main {
	width: 700px;
	display:inline-block;
}
#main div#leadtext p{
	color: #323232;
	font-size:16px;
	font-weight:bold;
}
#slidenav {
	background-color: #949494;
	height: 37px;
	width:565px;
	margin-left:5px;
}
#video_box{
	width:425px;
	border: none;
	display:inline-block;
	height:auto;
	float:left;
	margin: 5px;
}
#left {
	width: 567px;
	float:left;
}
#left2 {
	width: 567px;
	float:left;
}
#right {
	width:457px;
	float: right;
}
#righttop {
	background:#FFF;
	width:455px;
	height: 53px; 
	text-align: center; 
	color:  #ee4236; 
	font-size: 19px; 
	font-weight: bold; 
	font-family: arial; 
	padding: 2px 0 2px 0; 
	line-height: 51px;
	text-transform: uppercase;
	border-top: 1px solid #000;
	border-left: 1px solid #000;
	border-right: 1px solid #000;
} 
.action{
	color: blue;
	text-decoration:underline;
	cursor: pointer;
}
#footer{
	font-size:10px;
	color:#999999;
	font-family: Arial, Helvetica, sans-serif;
	text-align:center;
	margin-top: 50px;
}

.curved{
	height: 65px;
	width:160px;
	-moz-border-radius: 15px;
	border-radius: 15px;
	border: 2px solid #00BCDD;
	padding:0 10px 10px 10px;
}
</style>


</head>
<body style="margin:0">
<div style="width:229px;">
	<div style="width: 229px; height: auto">
		<div style="width:231px; border: 1px solid #990020">
			<div style="height: 41px; background: #990020; padding: 3px 5px; width: 221px; color: #fff; text-decoration: none; font-weight: bold; font-family:Arial, Helvetica, sans-serif">
				Meet Your<br>Admission Counselor
			</div>
			<div id="questionDiv" style="width:215px; padding: 5px">
	
				<p style="padding: 0 5px;">
				<img src="/admission/images/<?php echo($pic);?>" style="float:left; margin: 5px">
				<strong>Your counselor is <?php echo($couns_name);?>.</strong></p>
				<div style="clear:both; height:2px"></div>
                <p><?php echo($par_one);?></p>
                <p><?php echo($par_two);?></p>
			</div>
		</div>
	</div>
</div>
</body>
</html>