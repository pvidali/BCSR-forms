<?php 
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
//$test_env = true;

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
	$formid = "685000021579065";
	$seed = "25";

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
 	include $_SERVER['DOCUMENT_ROOT']."/includes/iw-curl2.php";
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
	<title>Top 3 Signs You May be Ready to Accelerate through High School</title>
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
		#footer {
			text-align: center;
			line-height:22px;	
		}
		li {
			font-size: 14px;
			line-height: 22px;
			margin-bottom: 10px;
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
        	<img src="images/banner.png" width="500" height="107">
            <?php
            if(!$thankyou){
			?>
				<h1>Top 3 Signs You May be Ready to Accelerate through High School</h1>
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
			<h4><strong>Two years of high school that lead directly to college.</strong></h4>
            <p>Are you ready for a program of concentrated high-school studies that will propel you to college in just two years?</p>
			<p><strong>Download the checklist of the top 3 signs and discover if Bard Academy at Simon’s Rock is right for you:</strong></p>
			<ul class="square">
				<li>Three telltale signs you’re ready for college preparatory study at Bard Academy at Simon’s Rock</li>
				<li>What you could experience in and out of class at the Academy</li>
			</ul>
            <p>At Bard Academy, you’ll be taught by the faculty of Bard College at Simon’s Rock, who are also your future professors!</p>
           	<?php
			} else {
			?>
				<h4><strong>3 Signs Bard Academy is Right for You</strong></h4>
                <p>At Bard Academy, we believe the traditional American high school isn’t for everyone. Click the button below to discover the signs that you might be better served by an intensive, challenging high school experience condensed into two years.</p>
                <p><a href="check_list.pdf" target="_blank"><button class="download">View the Checklist</button></a></p>
				<h4><strong>Why Bard Academy?</strong></h4>
                <p>For students who love to learn and don’t want to wait for intensive critical inquiry and advanced academic challenge, Bard Academy may be the right answer. Modeled by Bard College at Simon’s Rock after successful day programs at the Bard High School Early Colleges in New York, Newark and Cleveland, Bard Academy provides an enriching high school experience while creating a seamless transition into college life and work, right when you are most ready for it.
                </p>
                
           	<?php
			}
			?>

		</div>
		<div class="eight columns">
 <?php
            if(!$thankyou){
			?>
			<h4><strong>Find out now!</strong></h4>
			<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
                	<fieldset>
                    	<legend>Request Info</legend>
                        <label for="fname">* First name:</label><input type="text" name="fname" id="fname" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['fname']); ?>">
                        <label for="lname">* Last name:</label><input type="text" name="lname" id="lname" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['lname']); ?>">
                        <label for="email">* Email:</label><input type="text" name="email" id="email" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['email']); ?>">

						<label for="hs_gradyear">* HS class of:</label>
                        <select id="hs_gradyear" name="hs_gradyear" onChange="fieldStyleReset(this)">
                            <option selected="selected" value="">- Please Select -</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
						<label id="stateLabel" for="stateval">* State/Province:</label>
						<select id="stateval" style="width:14em;" name="stateval" onChange="fieldStyleReset(this)">
                          <option selected="selected" value=""></option>
                          <option>not applicable</option>
                          <option value="AA">APO, AA</option>
                          <option value="AE">APO, AE</option>
                          <option value="AP">APO, AP</option>
                          <option value="AB">Alberta</option>
                          <option value="AL">Alabama</option>
                          <option value="AK">Alaska</option>
                          <option value="AR">Arkansas</option>
                          <option value="AS">American Samoa</option>
                          <option value="AZ">Arizona</option>
                          <option value="CA">California</option>
                          <option value="CO">Colorado</option>
                          <option value="CNMI">Commonwealth of the Northern Mariana Islands</option>
                          <option value="CT">Connecticut</option>
                          <option value="DC">District of Columbia</option>
                          <option value="DE">Delaware</option>
                          <option value="FL">Florida</option>
                          <option value="GA">Georgia</option>
                          <option value="GU">Guam</option>
                          <option value="HI">Hawaii</option>
                          <option value="ID">Idaho</option>
                          <option value="IL">Illinois</option>
                          <option value="IN">Indiana</option>
                          <option value="IA">Iowa</option>
                          <option value="KS">Kansas</option>
                          <option value="KY">Kentucky</option>
                          <option value="LA">Louisiana</option>
                          <option value="MA">Massachusetts</option>
                          <option value="ME">Maine</option>
                          <option value="MB">Manitoba</option>
                          <option value="MD">Maryland</option>
                          <option value="MH">Marshall Islands</option>
                          <option value="MI">Michigan</option>
                          <option value="MN">Minnesota</option>
                          <option value="MS">Mississippi</option>
                          <option value="MO">Missouri</option>
                          <option value="MT">Montana</option>
                          <option value="NE">Nebraska</option>
                          <option value="NV">Nevada</option>
                          <option value="NH">New Hampshire</option>
                          <option value="NJ">New Jersey</option>
                          <option value="NM">New Mexico</option>
                          <option value="NY">New York</option>
                          <option value="NC">North Carolina</option>
                          <option value="ND">North Dakota</option>
                          <option value="OH">Ohio</option>
                          <option value="OK">Oklahoma</option>
                          <option value="OR">Oregon</option>
                          <option value="PA">Pennsylvania</option>
                          <option value="PR">Puerto Rico</option>
                          <option value="RI">Rhode Island</option>
                          <option value="SC">South Carolina</option>
                          <option value="SD">South Dakota</option>
                          <option value="TN">Tennessee</option>
                          <option value="TX">Texas</option>
                          <option value="UT">Utah</option>
                          <option value="VI">US Virgin Islands</option>
                          <option value="VT">Vermont</option>
                          <option value="VA">Virginia</option>
                          <option value="WA">Washington</option>
                          <option value="WV">West Virginia</option>
                          <option value="WI">Wisconsin</option>
                          <option value="WY">Wyoming</option>
                          <option value="AB">Alberta</option>
                          <option value="BC">British Columbia</option>
                          <option value="MB">Manitoba</option>
                          <option value="NB">New Brunswick</option>
                          <option value="NF">Newfoundland</option>
                          <option value="NT">Northwest Territories</option>
                          <option value="NS">Nova Scotia</option>
                          <option value="ON">Ontario</option>
                          <option value="PE">Prince Edward Island</option>
                          <option value="QB">Quebec</option>
                          <option value="SK">Saskatchewan</option>
                          <option value="YT">Yukon Territory</option>
                          <option>not applicable</option>
                        </select>
                        <input name="date_source" value="<?php echo($this_source); ?>" type="hidden" />
                        <input name="lead_source" value="<?php echo($lead_source); ?>" type="hidden" />
                        <input name="specify_source" value="<?php echo($specify_source); ?>" type="hidden" />
                        <input name="ADGcreative" value="<?php echo($ADGcreative); ?>" type="hidden" />
                        <input name="ADGdevice" value="<?php echo($ADGdevice); ?>" type="hidden" />
                        <input name="ADGdevicemodel" value="<?php echo($ADGdevicemodel); ?>" type="hidden" />
                        <input name="ADGkeyword" value="<?php echo($ADGkeyword); ?>" type="hidden" />
                        <input name="ADGmatchtype" value="<?php echo($ADGmatchtype); ?>" type="hidden" />
                        <input name="ADGnetwork" value="<?php echo($ADGnetwork); ?>" type="hidden" />
                        <input name="ADGplacement" value="<?php echo($ADGplacement); ?>" type="hidden" />
                        
                        <input type="hidden" name="formid" id="formid" value="<?php echo $formid; ?>">
                        <input type="hidden" name="seed" id="seed" value="<?php echo $seed; ?>">
                    	<button type="submit" name="submit" id="submit">Get the Checklist</button>
					</fieldset>
                </form>
           	<?php
			} else {
			?>
				<h4><strong>Next Steps</strong></h4>
                
                <ul class="bullets">
                	<li>Contact Admission: Email <a href="mailto:bardacademy@simons-rock.edu">bardacademy@simons-rock.edu</a> or Call: 800.235.7186</li>
                    <li><a href="http://simons-rock.edu/bard-academy-at-simons-rock/visit-basr">Schedule a Visit</a></li>
                	<li><a href="http://simons-rock.edu/bard-academy-at-simons-rock/apply-basr">Apply</a></li>
                </ul>
                
                <?php 
					// add counselor thank you
					// hide the video from the thank you page we are pulling in
					$hideVideo = true;
					
					// make sure we know who the recruiter is... dont show this otherwise
					if($fields_recruiter != ""){
						$counselor = "http://forms.simons-rock.edu/admission/thankyou-iframe.php?email=$email&lname=$lname&couns=$fields_recruiter&showBanner=0&hideVideo=true";
	//					echo $counselor;
						include($counselor);
					}
				?>
           	<?php
			}
			?>
	
		</div>
		<div class="sixteen columns" id="footer">
        Accredited by the New England Association of Schools and Colleges (NEASC)<br />
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

		if (document.request.stateval.value.length == 0) {
            document.request.stateval.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "stateval";
			}
		} 
		else {
            document.request.stateval.style.backgroundColor = normal
		}


		if (document.request.hs_gradyear.value.length == 0) {
            document.request.hs_gradyear.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "hs_gradyear";
			}
		} 
		else {
            document.request.hs_gradyear.style.backgroundColor = normal
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
