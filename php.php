<?php 
ini_set("display_errors","On");
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

// grab db class and connect
if(isset($_POST['submit'])) {
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/defines.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/postgredb.php";
	$port = 5432;
	$persistent = 0;
	$db = new PostgreDB (FORMS_DATABASE, FORMS_HOST, $port, FORMS_USERNAME, FORMS_PASSWORD, $persistent);
	$db->Connect();
	
	$firstname	= addslashes($_POST['firstname']);
	$lastname	= addslashes($_POST['lastname']);
	$email		= addslashes($_POST['email']);
	
	$sql = "INSERT INTO contacts (firstname,lastname,email) VALUES ('$firstname','$lastname','$email')";
	$db->ExecQuery($sql);
	$db->DBClose();
}


?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Request Information</title>
<style>
body{
font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}
/* ----------- My Form ----------- */
.myform{
margin:0 auto;
width:400px;
padding:14px;
}

/* ----------- stylized ----------- */
#stylized{
border:solid 2px #b7ddf2;
background:#ebf4fb;
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
font-weight:bold;
text-align:right;
width:140px;
float:left;
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
font-size:12px;
padding:4px 2px;
border:solid 1px #aacfe4;
width:200px;
margin:2px 0 20px 10px;
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
</style>
</head>

<body>
<?php

if(isSet($_POST['name']) && $_POST['name'] != ""){
	echo "Your name is: ";
	echo $_POST['name'];
}

?>

<div id="stylized" class="myform">
<form id="form" name="form" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
<h1>Sign-up form</h1>
<p>This is the basic look of my form without table</p>

<label>First Name
<!-- <span class="small">Add your name</span> -->
</label>
<input type="text" name="firstname" id="firstname" />

<label>Last Name
<!-- <span class="small">Add a valid address</span> -->
</label>
<input type="text" name="lastname" id="lastname" />

<label>E-mail
<span class="small">Min. size 6 chars</span>
</label>
<input type="email" name="email" id="email" />

<button type="submit" name="submit" id="submit">Sign-up</button>
<div class="spacer"></div>

</form>
</div>

</body>
</html>