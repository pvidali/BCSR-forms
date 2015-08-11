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
				<h1>What if high school only lasted two years?</h1>
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
                <img src="images/profs.png">
                <img src="images/campus.png">
                <img src="images/class.png">
                <img src="images/dac.png">
                <img src="images/kac.png">
            </div>
		<div class="six columns">
       	<?php } 
	   	else{ ?>
			<div class="ten columns">
		<?php }?>
            <?php
            if(!$thankyou){
			?>
			<h4><strong>Why Bard Academy</strong></h4>
            <p>At Bard Academy, we believe the traditional American high school isn't for everyone. For students who love to learn and don't want to wait for intensive critical inquiry and advanced academic challenge, Bard Academy may be the right answer. 
            Modeled after successful day programs at the Bard High School Early Colleges in New York, Newark and Cleveland, Bard Academy provides an enriching high school 
            experience while creating a seamless transition into college life and work, right when you are most ready for it.</p>
            <p>Fill out the information to the right to discover three signs that you might be better served by a challenging high school experience condensed into two years.</p>



<!--			<ul class="square">
				<li>Three telltale signs you’re ready for college preparatory study at Bard Academy at Simon’s Rock</li>
				<li>What you could experience in and out of class at the Academy</li>
			</ul>
            <p>At Bard Academy, you’ll be taught by the faculty of Bard College at Simon’s Rock, who are also your future professors!</p>
-->


           	<?php
			} else {
			?>
				  <h4><strong>You may be ready for an accelerated high school program if:</strong></h4>
				<ul class="square">
					<li><strong>You question everything.</strong> You're searching for teachers and peers who want to help you find the answers&ndash;and maybe ask even deeper questions.</li>
					<li><strong>You find yourself thinking and talking about books and ideas outside the classroom.</strong> You're seeking a community of equally curious, passionate and creative peers who would love to continue discussions into the dining hall, dorms and beyond.</li>
					<li><strong>You can envision yourself starting college after 10th grade.</strong> You know there's a whole world out there waiting for you, and you’re ready now to start focusing on your area(s) of interest and explore subjects and ways of thinking not accessible in a traditional high school.</li>
				</ul>
                <p>If you see yourself in any of the above, contact us to find out more or to schedule a <a href="http://www.simons-rock.edu/bard-academy-at-simons-rock/visit-basr">campus visit</a>.</p>
                
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
		<div class="six columns">
			<h4><strong>Find out now!</strong></h4>
			<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
                	<fieldset>
                    	<legend>Request Info</legend>
                        <p class="note">Note: You must be age thirteen or older to submit this form. If you are under thirteen, please have your parent or guardian complete it on your behalf.</p>
                        <label for="fname">* First name:</label><input type="text" name="fname" id="fname" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['fname']); ?>">
                        <label for="lname">* Last name:</label><input type="text" name="lname" id="lname" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['lname']); ?>">
                        <label for="email">* Email:</label><input type="text" name="email" id="email" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['email']); ?>">


						<label for="dob_m">* Date of Birth</label>
						<!-- <input id="dob_m.dob_d.dob_y" name="dob_m.dob_d.dob_y" value="" type="text" style="margin-bottom: 0px;" /><div style="color: #333; margin-bottom:10px">&nbsp;&nbsp;[mm/dd/yyyy]</div> -->
														<select name="dob_m" class="dob" id="dob_m">
															<option value="">month</option>
															<option value="01">Jan</option>
															<option value="02">Feb</option>
															<option value="03">Mar</option>
															<option value="04">Apr</option>
															<option value="05">May</option>
															<option value="06">Jun</option>
															<option value="07">Jul</option>
															<option value="08">Aug</option>
															<option value="09">Sep</option>
															<option value="10">Oct</option>
															<option value="11">Nov</option>
															<option value="12">Dec</option>
														</select>
														<select name="dob_d" class="dob" id="dob_d">
															<option value="">day</option>
															<option value="01">01</option>
															<option value="02">02</option>
															<option value="03">03</option>
															<option value="04">04</option>
															<option value="05">05</option>
															<option value="06">06</option>
															<option value="07">07</option>
															<option value="08">08</option>
															<option value="09">09</option>
															<option value="10">10</option>
															<option value="11">11</option>
															<option value="12">12</option>
															<option value="13">13</option>
															<option value="14">14</option>
															<option value="15">15</option>
															<option value="16">16</option>
															<option value="17">17</option>
															<option value="18">18</option>
															<option value="19">19</option>
															<option value="20">20</option>
															<option value="21">21</option>
															<option value="22">22</option>
															<option value="23">23</option>
															<option value="24">24</option>
															<option value="25">25</option>
															<option value="26">26</option>
															<option value="27">27</option>
															<option value="28">28</option>
															<option value="29">29</option>
															<option value="30">30</option>
															<option value="31">31</option>
														</select>
														<select name="dob_y" class="doby" id="dob_y">
															<option value="">year</option>
															<option value="1985">1985</option>
															<option value="1986">1986</option>
															<option value="1987">1987</option>
															<option value="1988">1988</option>
															<option value="1989">1989</option>
															<option value="1990">1990</option>
															<option value="1991">1991</option>
															<option value="1992">1992</option>
															<option value="1993">1993</option>
															<option value="1994">1994</option>
															<option value="1995">1995</option>
															<option value="1996">1996</option>
															<option value="1997">1997</option>
															<option value="1998">1998</option>
															<option value="1999">1999</option>
															<option value="2000">2000</option>
															<option value="2001">2001</option>
															<option value="2002">2002</option>
															<option value="2003">2003</option>
															<option value="2004">2004</option>
															<option value="2005">2005</option>
															<option value="2006">2006</option>
															<option value="2007">2007</option>
														</select>

						<div class="clearfix" style="height: 10px; clear:both"></div>
                        <label for="parent1_email">* Parent Email:</label><input type="text" name="parent1_email" id="parent1_email" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['parent1_email']); ?>">
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
						<label id="stateLabel" for="stateval">* State/Province (US/Canada only):</label>
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

						<label id="country" for="country">Country (if other than US):</label>
						<select id="country" style="width:14em;" name="country" onChange="fieldStyleReset(this)">
                            <option selected="selected" value=""></option>
                            <option value="AFGHANISTAN">AFGHANISTAN</option>
                            <option value="ALBANIA">ALBANIA</option>
                            <option value="ALGERIA">ALGERIA</option>
                            <option value="ANDORRA">ANDORRA</option>
                            <option value="ANGOLA">ANGOLA</option>
                            <option value="ANGUILLA">ANGUILLA</option>
                            <option value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>
                            <option value="ARGENTINA">ARGENTINA</option>
                            <option value="ARMENIA">ARMENIA</option>
                            <option value="ARUBA">ARUBA</option>
                            <option value="AUSTRALIA">AUSTRALIA</option>
                            <option value="AUSTRIA">AUSTRIA</option>
                            <option value="AZERBAIJAN">AZERBAIJAN</option>
                            <option value="BAHAMAS, THE">BAHAMAS, THE</option>
                            <option value="BAHRAIN">BAHRAIN</option>
                            <option value="BANGLADESH">BANGLADESH</option>
                            <option value="BARBADOS">BARBADOS</option>
                            <option value="BELARUS">BELARUS</option>
                            <option value="BELGIUM">BELGIUM</option>
                            <option value="BELIZE">BELIZE</option>
                            <option value="BENIN">BENIN</option>
                            <option value="BERMUDA">BERMUDA</option>
                            <option value="BHUTAN">BHUTAN</option>
                            <option value="BOLIVIA">BOLIVIA</option>
                            <option value="BOSNIA AND HERZEGOVINA">BOSNIA AND HERZEGOVINA</option>
                            <option value="BOTSWANA">BOTSWANA</option>
                            <option value="BRAZIL">BRAZIL</option>
                            <option value="BRUNEI">BRUNEI</option>
                            <option value="BULGARIA">BULGARIA</option>
                            <option value="BURKINA FASO">BURKINA FASO</option>
                            <option value="BURMA">BURMA</option>
                            <option value="BURUNDI">BURUNDI</option>
                            <option value="CAMBODIA">CAMBODIA</option>
                            <option value="CAMEROON">CAMEROON</option>
                            <option value="CANADA">CANADA</option>
                            <option value="CAPE VERDE">CAPE VERDE</option>
                            <option value="CAYMAN ISLANDS">CAYMAN ISLANDS</option>
                            <option value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>
                            <option value="CHAD">CHAD</option>
                            <option value="CHILE">CHILE</option>
                            <option value="CHINA">CHINA</option>
                            <option value="COLOMBIA">COLOMBIA</option>
                            <option value="COMOROS">COMOROS</option>
                            <option value="CONGO (BRAZZAVILLE)">CONGO (BRAZZAVILLE)</option>
                            <option value="CONGO (KINSHASA)">CONGO (KINSHASA)</option>
                            <option value="COSTA RICA">COSTA RICA</option>
                            <option value="CROATIA">CROATIA</option>
                            <option value="CUBA">CUBA</option>
                            <option value="CURACAO">CURACAO</option>
                            <option value="CYPRUS">CYPRUS</option>
                            <option value="CZECH REPUBLIC">CZECH REPUBLIC</option>
                            <option value="CÔTE D&#39;IVOIRE">CÔTE D&#39;IVOIRE</option>
                            <option value="DENMARK">DENMARK</option>
                            <option value="DJIBOUTI">DJIBOUTI</option>
                            <option value="DOMINICA">DOMINICA</option>
                            <option value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
                            <option value="ECUADOR">ECUADOR</option>
                            <option value="EGYPT">EGYPT</option>
                            <option value="EL SALVADOR">EL SALVADOR</option>
                            <option value="ENGLAND">ENGLAND</option>
                            <option value="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>
                            <option value="ERITREA">ERITREA</option>
                            <option value="ESTONIA">ESTONIA</option>
                            <option value="ETHIOPIA">ETHIOPIA</option>
                            <option value="FIJI">FIJI</option>
                            <option value="FINLAND">FINLAND</option>
                            <option value="FRANCE">FRANCE</option>
                            <option value="GABON">GABON</option>
                            <option value="GAMBIA, THE">GAMBIA, THE</option>
                            <option value="GEORGIA">GEORGIA</option>
                            <option value="GERMANY">GERMANY</option>
                            <option value="GHANA">GHANA</option>
                            <option value="GREECE">GREECE</option>
                            <option value="GRENADA">GRENADA</option>
                            <option value="GUATEMALA">GUATEMALA</option>
                            <option value="GUINEA">GUINEA</option>
                            <option value="GUINEA-BISSAU">GUINEA-BISSAU</option>
                            <option value="GUYANA">GUYANA</option>
                            <option value="HAITI">HAITI</option>
                            <option value="HOLY SEE">HOLY SEE</option>
                            <option value="HONDURAS">HONDURAS</option>
                            <option value="HONG KONG">HONG KONG</option>
                            <option value="HUNGARY">HUNGARY</option>
                            <option value="ICELAND">ICELAND</option>
                            <option value="INDIA">INDIA</option>
                            <option value="INDONESIA">INDONESIA</option>
                            <option value="IRAN">IRAN</option>
                            <option value="IRAQ">IRAQ</option>
                            <option value="IRELAND">IRELAND</option>
                            <option value="ISRAEL">ISRAEL</option>
                            <option value="ITALY">ITALY</option>
                            <option value="JAMAICA">JAMAICA</option>
                            <option value="JAPAN">JAPAN</option>
                            <option value="JORDAN">JORDAN</option>
                            <option value="KAZAKHSTAN">KAZAKHSTAN</option>
                            <option value="KENYA">KENYA</option>
                            <option value="KIRIBATI">KIRIBATI</option>
                            <option value="KOREA, NORTH">KOREA, NORTH</option>
                            <option value="KOREA, SOUTH">KOREA, SOUTH</option>
                            <option value="KOSOVO">KOSOVO</option>
                            <option value="KUWAIT">KUWAIT</option>
                            <option value="KYRGYZSTAN">KYRGYZSTAN</option>
                            <option value="LAOS">LAOS</option>
                            <option value="LATVIA">LATVIA</option>
                            <option value="LEBANON">LEBANON</option>
                            <option value="LESOTHO">LESOTHO</option>
                            <option value="LIBERIA">LIBERIA</option>
                            <option value="LIBYA">LIBYA</option>
                            <option value="LIECHTENSTEIN">LIECHTENSTEIN</option>
                            <option value="LITHUANIA">LITHUANIA</option>
                            <option value="LUXEMBOURG">LUXEMBOURG</option>
                            <option value="MACAU">MACAU</option>
                            <option value="MACEDONIA">MACEDONIA</option>
                            <option value="MADAGASCAR">MADAGASCAR</option>
                            <option value="MALAWI">MALAWI</option>
                            <option value="MALAYSIA">MALAYSIA</option>
                            <option value="MALDIVES">MALDIVES</option>
                            <option value="MALI">MALI</option>
                            <option value="MALTA">MALTA</option>
                            <option value="MARSHALL ISLANDS">MARSHALL ISLANDS</option>
                            <option value="MAURITANIA">MAURITANIA</option>
                            <option value="MAURITIUS">MAURITIUS</option>
                            <option value="MEXICO">MEXICO</option>
                            <option value="MICRONESIA">MICRONESIA</option>
                            <option value="MOLDOVA">MOLDOVA</option>
                            <option value="MONACO">MONACO</option>
                            <option value="MONGOLIA">MONGOLIA</option>
                            <option value="MONTENEGRO">MONTENEGRO</option>
                            <option value="MONTSERRAT">MONTSERRAT</option>
                            <option value="MOROCCO">MOROCCO</option>
                            <option value="MOZAMBIQUE">MOZAMBIQUE</option>
                            <option value="NAMIBIA">NAMIBIA</option>
                            <option value="NAURU">NAURU</option>
                            <option value="NEPAL">NEPAL</option>
                            <option value="NETHERLANDS">NETHERLANDS</option>
                            <option value="NEW ZEALAND">NEW ZEALAND</option>
                            <option value="NICARAGUA">NICARAGUA</option>
                            <option value="NIGER">NIGER</option>
                            <option value="NIGERIA">NIGERIA</option>
                            <option value="NORTHERN IRELAND">NORTHERN IRELAND</option>
                            <option value="NORWAY">NORWAY</option>
                            <option value="OMAN">OMAN</option>
                            <option value="PAKISTAN">PAKISTAN</option>
                            <option value="PALAU">PALAU</option>
                            <option value="PALESTINE">PALESTINE</option>
                            <option value="PANAMA">PANAMA</option>
                            <option value="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>
                            <option value="PARAGUAY">PARAGUAY</option>
                            <option value="PERU">PERU</option>
                            <option value="PHILIPPINES">PHILIPPINES</option>
                            <option value="POLAND">POLAND</option>
                            <option value="PORTUGAL">PORTUGAL</option>
                            <option value="QATAR">QATAR</option>
                            <option value="ROMANIA">ROMANIA</option>
                            <option value="RUSSIA">RUSSIA</option>
                            <option value="RWANDA">RWANDA</option>
                            <option value="SAINT KITTS AND NEVIS">SAINT KITTS AND NEVIS</option>
                            <option value="SAINT LUCIA">SAINT LUCIA</option>
                            <option value="SAINT VINCENT AND THE GRENADINES">SAINT VINCENT AND THE GRENADINES</option>
                            <option value="SAMOA">SAMOA</option>
                            <option value="SAN MARINO">SAN MARINO</option>
                            <option value="SAO TOME AND PRINCIPE">SAO TOME AND PRINCIPE</option>
                            <option value="SAUDI ARABIA">SAUDI ARABIA</option>
                            <option value="SCOTLAND">SCOTLAND</option>
                            <option value="SENEGAL">SENEGAL</option>
                            <option value="SERBIA">SERBIA</option>
                            <option value="SEYCHELLES">SEYCHELLES</option>
                            <option value="SIERRA LEONE">SIERRA LEONE</option>
                            <option value="SINGAPORE">SINGAPORE</option>
                            <option value="SINT MAARTEN">SINT MAARTEN</option>
                            <option value="SLOVAKIA">SLOVAKIA</option>
                            <option value="SLOVENIA">SLOVENIA</option>
                            <option value="SOLOMON ISLANDS">SOLOMON ISLANDS</option>
                            <option value="SOMALIA">SOMALIA</option>
                            <option value="SOUTH AFRICA">SOUTH AFRICA</option>
                            <option value="SOUTH SUDAN">SOUTH SUDAN</option>
                            <option value="SPAIN">SPAIN</option>
                            <option value="SRI LANKA">SRI LANKA</option>
                            <option value="SUDAN">SUDAN</option>
                            <option value="SURINAME">SURINAME</option>
                            <option value="SWAZILAND">SWAZILAND</option>
                            <option value="SWEDEN">SWEDEN</option>
                            <option value="SWITZERLAND">SWITZERLAND</option>
                            <option value="SYRIA">SYRIA</option>
                            <option value="TAHITI">TAHITI</option>
                            <option value="TAIWAN">TAIWAN</option>
                            <option value="TAJIKISTAN">TAJIKISTAN</option>
                            <option value="TANZANIA">TANZANIA</option>
                            <option value="THAILAND">THAILAND</option>
                            <option value="TIMOR-LESTE">TIMOR-LESTE</option>
                            <option value="TOGO">TOGO</option>
                            <option value="TONGA">TONGA</option>
                            <option value="TRINIDAD AND TOBAGO">TRINIDAD AND TOBAGO</option>
                            <option value="TUNISIA">TUNISIA</option>
                            <option value="TURKEY">TURKEY</option>
                            <option value="TURKMENISTAN">TURKMENISTAN</option>
                            <option value="TUVALU">TUVALU</option>
                            <option value="UGANDA">UGANDA</option>
                            <option value="UKRAINE">UKRAINE</option>
                            <option value="UNITED ARAB EMIRATES">UNITED ARAB EMIRATES</option>
                            <option value="UNITED KINGDOM">UNITED KINGDOM</option>
                            <option value="URUGUAY">URUGUAY</option>
                            <option value="UZBEKISTAN">UZBEKISTAN</option>
                            <option value="VANUATU">VANUATU</option>
                            <option value="VENEZUELA">VENEZUELA</option>
                            <option value="VIETNAM">VIETNAM</option>
                            <option value="WALES">WALES</option>
                            <option value="YEMEN">YEMEN</option>
                            <option value="ZAMBIA">ZAMBIA</option>
                            <option value="ZIMBABWE">ZIMBABWE</option>
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
                    	<button type="submit" name="submit" id="submit">Submit</button>
					</fieldset>
                </form>
           	<?php
			} else {
			?>
            <div class="six columns">
				<h4><strong>Next Steps</strong></h4>
                
                <ul class="bullets">
                	<li><a href="check_list.pdf" target="_blank"><strong>Download the 3 Signs (PDF)</strong></a></li>
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
</body>
</html>
