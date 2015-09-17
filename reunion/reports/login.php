<?php 
/*** begin our session ***/
session_start();
if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'true'){
	$_SESSION['user_id'] = "";
	unset($_SESSION['user_id']);
	$pre_msg = "You have been logged out. You can login below.";
}
?>

<html>
<head>
<title>Family Weekend Reports Login</title>
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
	width:420px;
	padding:6px;
}
/* ----------- stylized ----------- */
#stylized{
	/* border:solid 1px #b7ddf2; */
	border: 0;
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



</style>
</head>
<body>
<div id="stylized" class="myform">

<?php 
if(isset($pre_msg) && $pre_msg != ""){
	echo "<div>$pre_msg</div>";
}
?>

<h2 style="text-align:center">Family Weekend Reports Login</h2>
<form action="login_submit.php" method="post">
	<fieldset>
		<div style="clear:both">
			<label for="phpro_username">Username</label>
			<input type="text" id="phpro_username" name="phpro_username" value="" maxlength="20" />
		</div>
		<div style="clear:both">
			<label for="phpro_password">Password</label>
			<input type="password" id="phpro_password" name="phpro_password" value="" maxlength="20" />
		</div>
		<div style="clear:both; padding-left: 190px">
			<input style="width:90px" type="submit" value="Login" />
		</div>
	</fieldset>
</form>
</div>
</body>
</html>
