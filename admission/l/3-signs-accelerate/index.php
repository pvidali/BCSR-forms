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
 	include $_SERVER['DOCUMENT_ROOT']."/includes/iw-curl3.php";
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
	<title>Bard Academy Checklist: 3 Signs You're Ready for the 2-Year High School</title>
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
		h1, h2, h3, h4, h5, h6 {
			color: #be1d23 !important;
		}
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
		#bottomimages{
			font-size: 26px;
			line-height:28px;
			
		}
		#bottomimages img{
			float: left;
			max-width: 180px;
			max-height: 132px;
			margin:3px;
		}
		.note{
			font-size: 11px;
			line-height: 14px;
		}
		input {
			padding: 3px 2px !important;
			font-size: 12px !important;
			width: auto !important;
		}
		select{
			width: 220px !important;
		}
		select.dob {
			float: left;
			width: 55px !important;
			margin: 2px 0 5px 3px;
		}
		select.doby {
			float: left;
			width: 75px !important;
			margin: 2px 0 5px 10px;
		}
		
	/* All Mobile Sizes (devices and browser) */
	@media only screen and (max-width: 767px) {
		#logo{
			width: 350px;
			height: 75px;
		}
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
		ga('send', 'event', 'Form', 'Submit', 'Bard Academy Checklist: 3 Signs You’re Ready for the 2-Year High School');
<?php
}
else {
?>
		ga('send', 'event', 'Form', 'Submit', 'Bard Academy Checklist: 3 Signs You’re Ready for the 2-Year High School NON-Hubspot');
<?php
} 
?>

    </script>
<?php
}
?>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/jquery/plugins/jquery.json.min.js" type="text/javascript"></script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/iw.js" type="text/javascript"></script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/IWFormValidator.js" type="text/javascript"></script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/uitypes.js" type="text/javascript"></script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/html.js" type="text/javascript"></script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/countrystate.js" type="text/javascript"></script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/fielddep.js" type="text/javascript"></script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/inlinelookup.js" type="text/javascript"></script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/formsruntime.js?v=2_11_4_108" type="text/javascript"></script>
		<script type="text/javascript">
// <![CDATA[
var serverURL = "https://bardsimonsrock.hobsonsradius.com";
// ]]>
</script>
		<script type="text/javascript">
// <![CDATA[

			var _each = function(array, fn, scope)
			{
			for (var i = 0; i
			< array.length; i++)
			{
			if (fn.call(scope || array[i], array[i], i, array) === false)
			return i;
			}
			}
			var addConditionalDisplay = function(sectionId, logic)
			{    // Make sure we're 'ready' before continuing..
			var args = arguments;
			jQuery(function() {
			_addConditionalDisplay.apply(this, args);
			});
			}
			var _addConditionalDisplay = function(sectionId, logic)
			{
			// For each field that controls this section, add a callback
			var crit = logic.criteria;
			if (!crit)
			return;
			_each(crit, function(oneCrit)
			{
			if (oneCrit.htmlid)
			{
			if (_IW.UITypes.isGPMultiSelect(oneCrit.htmlid))
			{
			_IW.UITypes.groupMultiSelectOnChange(oneCrit.htmlid, function()
			{
			_doConditionalDisplay(sectionId, logic);
			});
			}
			else
			{
			jQuery(document.getElementById(oneCrit.htmlid)).change(function()
			{
			_doConditionalDisplay(sectionId, logic);
			});
			}
			}
			});
			// Fire it right away to set the initial state
			_doConditionalDisplay(sectionId, logic);
			}
			var _doConditionalDisplay = function(sectionId, logic)
			{
			if (_evalConditions(logic))
			{        jQuery(document.getElementById(sectionId)).removeClass('conditionallyHidden');
			}
			else
			{        jQuery(document.getElementById(sectionId)).addClass('conditionallyHidden');
			}
			}
			var _evalConditions = function(logic)
			{
			for (var i = 0; i
			< logic.criteria.length; i++)
			{
			var oneCrit = logic.criteria[i];
			// If we don't have an htmlid, then that means the field
			// is missing and we'll treat the condition as 'FALSE'.
			// Note that this may not be technically correct for
			// check-box fields.
			if (!oneCrit.htmlid)
			var pass = false;
			else
			var pass = _checkFieldValue(oneCrit.htmlid, oneCrit.values);
			if (pass)
			{
			if (logic.match == 'any')
			return true;
			}
			else
			{
			if (logic.match == 'all')
			return false;
			}
			}
			return logic.match == 'all';
			}
			var _checkFieldValue = function(field, values)
			{
			if (_IW.UITypes.isGPMultiSelect(field))
			{
			var val = _IW.UITypes.getGroupMultiSelectValues(field);
			for (var prop in values)
			{
			if (values.hasOwnProperty(prop))
			{
			var haystack = val[prop];
			var needles = values[prop];
			if (haystack)
			{
			for (var i = 0; i
			< haystack.length; i++)
			{
			for (var j = 0; j
			< needles.length; j++)
			{
			if (haystack[i] == needles[j])
			return true;
			}
			}
			}
			}
			}
			}
			else
			{
			var val = _IW.FormsRuntime.getElementValue(document.getElementById(field));
			if (! jQuery.isArray(values))
			values = [ values ];
			if (! jQuery.isArray(val))
			val = [ val ];
			for (var i = 0; i
			< val.length; i++)
			{
			for (var j = 0; j
			< values.length; j++)
			{
			if (val[i] == values[j])
			return true;
			}
			}
			}
			return false;
			}
		
// ]]>
</script>
		<script src="https://bardsimonsrock.hobsonsradius.com/crm/javascript/inquiryformruntime.js" type="text/javascript"></script>

</head>
<body>
	<div class="container">
		<div class="sixteen columns utility">
            <?php
            if($thankyou){
			?>
<!--
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
                    <li class=""><a href="http://simons-rock.edu/bard-academy-at-simons-rock/">Bard Academy</a>
                    </li>
                </ul>
            </div>
-->
            <?php
			}
			?>

        </div>




		<div class="sixteen columns">


        	<img src="images/banner.png" id="logo" width="500" height="107">
            <?php
            if(!$thankyou){
			?>
				<h1>Bard Academy Checklist: 3 Signs You're Ready for the 2-Year High School</h1>
           	<?php
			} else {
			?>
				<h1>3 Signs You're Ready for Bard Academy</h1>
           	<?php
			}
			?>

		</div>
		<?php
        if($thankyou){
        ?>
            <div class="four columns" id="bottomimages">
	            High School. <br>
				Reimagined. <br>
                <img src="images/profs.png">
                <img src="images/campus.png">
                <img src="images/class.png">
                <img src="images/dac.png">
                <img src="images/kac.png">
            </div>
		<div class="six columns">
       	<?php } 
	   	else{ ?>
			<div class="five columns">
		<?php }?>
            <?php
            if(!$thankyou){
			?>
			<h4><strong>Finish high school in two years. Then start college early.</strong></h4>
            <p>The traditional American high school isn't for everyone. Find out if this challenging educational experience might be right for you.</p>
            <h4><strong>View the Bard Academy Checklist to find out:</strong></h4>
            <ul class="square">
            	<li>Three telltale signs you're ready for the Academy's advanced academic challenge and intensive critical inquiry</li>
				<li>What <strong>high school, reimagined,</strong> might look like for you</li>
            </ul>



<!--			<ul class="square">
				<li>Three telltale signs you’re ready for college preparatory study at Bard Academy at Simon’s Rock</li>
				<li>What you could experience in and out of class at the Academy</li>
			</ul>
            <p>At Bard Academy, you’ll be taught by the faculty of Bard College at Simon’s Rock, who are also your future professors!</p>
-->


           	<?php
			} else {
			?>
            	<p>At Bard Academy at Simon's Rock, we believe that traditional American high school isn't for everyone. For too many students, junior and senior years end up less about learning and more about preparing for standardized tests and filling out college applications.</p>
                <p>The nation's only independent school for 9th and 10th grade boarding and day students, Bard Academy prepares students to enter college after just two years of high school.</p>
				  <h4><strong>You may be ready for an accelerated high school program if:</strong></h4>
				<ul class="square">
					<li><strong>You question everything.</strong> You're searching for teachers and peers who want to help you find the answers&ndash;and maybe ask even deeper questions.</li>
					<li><strong>You find yourself thinking and talking about books and ideas outside the classroom.</strong> You're seeking a community of equally curious, passionate and creative peers who would love to continue discussions into the dining hall, dorms and beyond.</li>
					<li><strong>You can envision yourself starting college after 10th grade.</strong> You know there's a whole world out there waiting for you, and you’re ready now to start focusing on your area(s) of interest and explore subjects and ways of thinking not accessible in a traditional high school.</li>
				</ul>
                <p>If you see yourself in any of the above, contact us to find out more or to schedule a <a href="http://www.simons-rock.edu/bard-academy-at-simons-rock/visit-basr">campus visit</a>.</p>
                <p><a href="check_list.pdf" target="_blank"><strong>Download PDF</strong></a></p>

                
<!--
				<h4><strong>Why Bard Academy?</strong></h4>
                <p>For students who love to learn and don’t want to wait for intensive critical inquiry and advanced academic challenge, Bard Academy may be the right answer. Modeled by Bard College at Simon’s Rock after successful day programs at the Bard High School Early Colleges in New York, Newark and Cleveland, Bard Academy provides an enriching high school experience while creating a seamless transition into college life and work, right when you are most ready for it.
                </p>
   -->             
           	<?php
			}
			?>

		</div>
		 <?php
            if(!$thankyou){
			?>
		<div class="eleven columns">
			<h4 style="margin-left:20px"><strong>View the Checklist<br>
Request Information</strong></h4>


<iframe src="https://bardsimonsrock.hobsonsradius.com/crm/forms/Gax827G0kA70x6708Nq" class="eleven columns" style="margin-left:0 !important" height="500"></iframe>


           	<?php
			} else {
			?>
            <div class="six columns">
				<h4><strong>Next Steps</strong></h4>
                
                <ul class="bullets">
                    <li><a href="http://simons-rock.edu/bard-academy-at-simons-rock/visit-basr"><strong>Schedule a Visit</strong></a></li>
                	<li><strong>Learn More:</strong><br />
                    	&nbsp;&nbsp;&nbsp;Web <a href="http://www.simons-rock.edu/academy">simons-rock.edu/academy</a><br>
                    	&nbsp;&nbsp;&nbsp;Email <a href="mailto:bardacademy@simons-rock.edu">bardacademy@simons-rock.edu</a><br>
						&nbsp;&nbsp;&nbsp;Call: 800.235.7186</li>
                	<!-- <li><a href="http://simons-rock.edu/bard-academy-at-simons-rock/apply-basr"><strong>Apply</strong></a></li> -->
                </ul>
                
                <?php 
					// add counselor thank you
					/* hide the video from the thank you page we are pulling in
					$hideVideo = true;
					
					// make sure we know who the recruiter is... dont show this otherwise
					if($fields_recruiter != ""){
						$counselor = "http://forms.simons-rock.edu/admission/thankyou-iframe.php?email=$email&lname=$lname&couns=$fields_recruiter&showBanner=0&hideVideo=true";
	//					echo $counselor;
						include($counselor);
					}
					*/
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
		
		if (document.request.parent1_email.value.length == 0) {
            document.request.parent1_email.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "parent1_email";
			}
		} 
		else {
            document.request.parent1_email.style.backgroundColor = normal
		}		


		if (document.request.current_grade.value.length == 0) {
            document.request.current_grade.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "current_grade";
			}
		} 
		else {
            document.request.current_grade.style.backgroundColor = normal
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
<script type="text/javascript">
// <![CDATA[

			var processConditionalSection = function(obj)
			{
			if (obj == null || obj.id == null)
			{
			return;
			}
			var id = obj.id;
			var ruleArray = new Array(0);
			for (var i = 0; i
			< ruleArray.length; i++)
			{
			var sectionId = ruleArray[i][0];
			var rule = JSON.parse(ruleArray[i][1]);
			for (var j = 0; j
			< rule.criteria.length; j++)
			{
			var htmlid = rule.criteria[j].htmlid;
			if (id == htmlid)
			{
			addConditionalDisplay(sectionId, rule);
			}
			}
			}
			}
		
// ]]>
</script>
</body>
</html>
