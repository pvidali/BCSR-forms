<?php 
echo "hello";
exit();
$is_intl = 0;
if(isset($_REQUEST['test']) && $_REQUEST['test'] == "1"){
	$test_env = true;
}
else{
	$test_env = false;
}
if($test_env){
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/errors.php";
}
$test_env = true;

require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();


/*
	@dscheff #20140710 - this form is now being used not only for google ads but for the search campaign
*/
if(isset($_REQUEST['source']) && $_REQUEST['source'] == "SGN"){
	$this_source = setSource('SGN');
	$lead_source = "";
	$specify_source = "";
	$formid = "685000018320186";
	$seed = "103";
}
else{
	$this_source = setSource('ADG');
	$lead_source = "Online...";
	$specify_source = "Google Adwords";
	$formid = "685000016000434";
	$seed = "89";

	// grab and parse google ad params
	if(isset($_REQUEST['m']) && $_REQUEST['m'] != ""){ // matchtype
		switch ($_REQUEST['m']){
			case 'e':
				$ADGmatchtype = "exact";
				break;	
			case 'p':
				$ADGmatchtype = "phrase";
				break;	
			case 'b':
				$ADGmatchtype = "broad";
				break;	
			default:
				$ADGmatchtype = $_REQUEST['m'];
		}
	}
	if(isset($_REQUEST['n']) && $_REQUEST['n'] != ""){ // network
		switch ($_REQUEST['n']){
			case 'g':
				$ADGnetwork = "google search";
				break;	
			case 's':
				$ADGnetwork = "search partner";
				break;	
			case 'd':
				$ADGnetwork = "display network";
				break;	
			default:
				$ADGnetwork = $_REQUEST['n'];
		}
	}
	if(isset($_REQUEST['d']) && $_REQUEST['d'] != ""){ // device
		switch ($_REQUEST['d']){
			case 'm':
				$ADGdevice = "mobile ";
				break;	
			case 't':
				$ADGdevice = "tablet";
				break;	
			case 'c':
				$ADGdevice = "desktop or laptop";
				break;	
			default:
				$ADGdevice = $_REQUEST['d'];
		}
	}
	if(isset($_REQUEST['dm']) && $_REQUEST['dm'] != ""){ //devicemodel
		$ADGdevicemodel = $_REQUEST['dm'];
	}
	if(isset($_REQUEST['c']) && $_REQUEST['c'] != ""){ // creative
		$ADGcreative = $_REQUEST['c'];
	}
	if(isset($_REQUEST['k']) && $_REQUEST['k'] != ""){ // keyword
		$ADGkeyword = $_REQUEST['k'];
	}
	if(isset($_REQUEST['p']) && $_REQUEST['p'] != ""){ // content network 'placement'
		$ADGplacement = $_REQUEST['p'];
	}

}
// check URL to see if the student is from outside the US
if(isset($_REQUEST['intl'])){
	$is_intl = true;
}

$thankyou = false;
// $thankyou = true; // for testing

// added this 2014 07 09
$state = $_REQUEST['stateval'];
$country = "UNITED STATES";

$territory = $state;
if($territory == "NY") {
	$territory = "NYC";
}
if($territory == "PA") {
	$territory = "PAW";
}

$territoryInfo = getTerritoryInfoDB($state,$country,$db);
$redir = $territoryInfo['redir'];
$fields_recruiter = $territoryInfo['fields_recruiter'];
$redirStr = $territoryInfo['redirStr'];
$doRedir = $territoryInfo['doRedir'];
$recruiter_email_handle = $territoryInfo['recruiter_email_handle'];

if($state=="not applicable"){
	$state = "";
}
else {
//	$state = $postArray['state'];
}
	


if(isset($_POST['submit'])) {
	$postArray = $_POST;
	$post_msg = "";
	
	fixFormatting($postArray);

	foreach($postArray as $k => $v){
		$$k = $v;
	}
        
 	// include $_SERVER['DOCUMENT_ROOT']."/includes/iw-curl2.php";
        
        
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $comment = $_POST['comment'];
        $url = $_POST['URL'];

        $msg = "";
        $msg .= "First name: $fname\n";
        $msg .= "Last name: $lname\n";
        $msg .= "Email: $email\n";
        $msg .= "Comment: $comment\n";
        $msg .= "URL: $url\n";

        mail('admit@simons-rock.edu',"Sept 12/13 2014 Admission Form",$msg);
        mail('dscheff@simons-rock.edu',"Sept 12/13 2014 Admission Form",$msg);
        
        
	$thankyou = true;



}

/* REMOVE BEFORE LIVE
if(isset($_REQUEST['email'])){
	$email = $_REQUEST['email'];
}
if(isset($_REQUEST['state'])){
	$state = $_REQUEST['state'];
}
if(isset($_REQUEST['couns'])){
	$couns = $_REQUEST['couns'];
}
if(isset($_REQUEST['lname'])){
	$lname = $_REQUEST['lname'];
}
*/

?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>The Early College Checklist: 5 Signs You're Ready for College Now</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="stylesheets/base.css">
	<link rel="stylesheet" href="stylesheets/skeleton.css">
	<link rel="stylesheet" href="stylesheets/layout.css">

	<style>
		ul.bullets{
			list-style: outside !important;
		}
		.bullets li{
			margin: 15px;
			font-size: 1.3em;
		}
		.bullets li a{
			color: #990020;
		}

    </style>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="icon" type="image/png" href="images/favicon.png">
	<script type="text/javascript" src="/js/form-funcs.js"></script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/google-analytics.php";

if($thankyou){
?>

	<script>
<?php
if( isset($_POST['source']) && strpos($_POST['source'],"ADG") ){
?>
		ga('send', 'event', 'Form', 'Submit', '5 Reasons Fall 2014 Search');
<?php
}
else {
?>
		ga('send', 'event', 'Form', 'Submit', '5 Reasons Early College NON-Hubspot');
<?php
} 
?>

    </script>
<?php
}
?>

</head>
<body>
	<div class="container">
		<div class="sixteen columns utility">
            <?php
            if($thankyou){
			?>
        	<a href="https://lock.simons-rock.edu/fsdir" target="_blank">Directory</a> | 
            <a href="http://simons-rock.edu/about/directions/directions-maps/directions/" target="_blank">Directions</a> | 
            <a href="http://simons-rock.edu/about/contact-information" target="_blank">Contact</a> | 
            <a href="https://my.simons-rock.edu/" target="_blank">Login</a>
            <div class="sixteen columns">
                <ul id="menu">
                    <li><a href="http://simons-rock.edu/about">About</a>
                    </li>
                    <li class=""><a href="http://simons-rock.edu/admission">Admission</a>
                    </li>
                    <li class=""><a href="http://simons-rock.edu/academics">Academics</a>
                    </li>
                    <li class=""><a href="http://simons-rock.edu/campus-life">Campus Life</a>
                    </li>
                    <li class=""><a href="http://simons-rock.edu/campus-resources">Resources</a>
                    </li>
                    <li class=""><a href="http://simons-rock.edu/events">Events</a>
                    </li>
                    <li class=""><a href="http://simons-rock.edu/newsroom">News</a>
                    </li>
                    <li class=""><a href="http://simons-rock.edu/alumni">Alumni</a>
                    </li>
                </ul>
            </div>
            <?php
			}
			?>

        </div>




		<div class="sixteen columns">
        	<img src="images/logo.png">
            <?php
            if(!$thankyou){
			?>
				<h1>Early College Checklist: 5 Signs You're Ready for College Now</h1>
           	<?php
			} else {
			?>
				<h1>Thank you for requesting the Checklist</h1>
           	<?php
			}
			?>

		</div>
		<div class="eight columns">
            <?php
            if(!$thankyou){
			?>
			<h4><strong>Skip high school. Go directly to college.</strong></h4>
            <p>Did you know you can start college now, without a high school diploma, without taking the SATs?</p>
			<p><strong>Download the Early College Checklist to find out:</strong></p>
			<ul class="square">
				<li>Five telltale signs you're ready for a greater challenge</li>
				<li>What you could be learning in college classes</li>
				<li>A few of the things you could do at The Early College</li>
			</ul>
            <p>At Simon's Rock you'll find professors who are interested in helping you pursue your interests and expand your knowledge. </p>
           	<?php
			} else {
			?>
				<h4><strong>5 Signs You're Ready for College Now</strong></h4>
                <p>Some students are ready for college earlier than their peers. Click the button below to discover the signs that you might be ready now.</p>
                <p><a href="check_list.pdf" target="_blank"><button class="download">View the Checklist</button></a></p>
				<h4><strong>Why Simon's Rock</strong></h4>
                <p>We bring you face to face with top professors, with advanced research, essential texts and an astonishing range of opportunities, in early college. If you’re ready to leave high school before graduation and want to be part of an unabashedly intellectual, proudly independent, fiercely creative college community, Bard College at Simon’s Rock is exactly what you’ve been seeking. 
                </p>
                
           	<?php
			}
			?>

		</div>
		<div class="eight columns">
 <?php
            if(!$thankyou){
			?>
			<h4><strong>5 Signs You're Ready for College Now</strong></h4>
			<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
                	<fieldset>
                    	<legend>Request Info</legend>
                        <label for="fname">* First name:</label><input type="text" name="fname" id="fname" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['fname']); ?>">
                        <label for="lname">* Last name:</label><input type="text" name="lname" id="lname" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['lname']); ?>">
                        <label for="email">* Email:</label><input type="text" name="email" id="email" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['email']); ?>">
                        <textarea name="comment" id="comment"></textarea>
                        <button type="submit" name="submit" id="submit">Get the Checklist</button>
			</fieldset>
                </form>
           	<?php
			} else {
			?>
				<h4><strong>Next Steps</strong></h4>
                
                <ul class="bullets">
                	<li><a href="mailto:askastudent@simons-rock.edu">Email a student</a></li>
                	<li>Contact Admission: <a href="mailto:admit@simons-rock.edu">Email</a> or Call: 800.235.7186</li>
                    <li><a href="http://www.simons-rock.edu/about/our-students">Read about Simon's Rock students</a></li>
                	<li><a href="http://simons-rock.edu/admission/apply/apply-online">Apply</a></li>
                </ul>
                
		</div>
		<div class="sixteen columns" id="footer">
        Bard College at Simon's Rock  //  84 Alford Rd.  //  Simon's Rock  //  Great Barrington, MA 01230  //  413 644 4400  //  fax 413 528 7365  //  © Bard College at Simon's Rock / All Rights Reserved
        </div>
	</div><!-- container -->


<script type="text/javascript">
<!--

function fieldStyleReset(field){
	var val = field.value;
	if(val !== ""){
	   field.style.background = "#fff";
	}
}


function checkForm() {

    var bgcolor
    var normal
    var rval
    highlight = "#990020"
    normal = "#fff"
    rval = true
	fieldFocus = "";
	if (document.layers||document.getElementById||document.all) {
        if (document.request.fname.value.length == 0) {
            document.request.fname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "fname";
			}
		} 
		else {
            document.request.fname.style.backgroundColor = normal
		}

		if (document.request.lname.value.length == 0) {
            document.request.lname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "lname";
			}
		} 
		else {
            document.request.lname.style.backgroundColor = normal
		}
		
		if (document.request.email.value.length == 0) {
            document.request.email.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "email";
			}
		} 
		else {
            document.request.email.style.backgroundColor = normal
		}		


        if (!rval) {
			alert ("Please complete all required (highlighted) fields prior to submitting your form.");
			document.getElementById(fieldFocus).focus();
			document.getElementById(fieldFocus).style.display='';
		}
		return rval
    } 
	else {
		return true
	}
}
// -->
			
</script>
</body>
</html>
