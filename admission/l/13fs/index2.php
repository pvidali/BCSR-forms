<?php 
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

// check URL to see if the student is from outside the US
if(isset($_REQUEST['intl'])){
	$is_intl = true;
}

$thankyouDisplay = 'none';

if(isset($_POST['submit'])) {
	$thankyouDisplay = '';
	$postArray = $_POST;
	$postArray['ethnicities'] = $ethnicities;
	$post_msg = "";
	
	fixFormatting($postArray);

	foreach($postArray as $k => $v){
		$$k = $v;
	}

	if(isset($_REQUEST['country']) && $_REQUEST['country'] != ""){
		$country = $_REQUEST['country'];
	}
	else {
		// THIS HACK IS UNTIL NON-US COUNTRIES ARE DIVIDED INTO MORE THAN ONE RECRUITER, FOR NOW THEY ARE ALL ONE, SO JUST PASS SOMETHING IN
			$country = "OUTSIDE_US";
	}

	if (isset($stateval) && $stateval!=""){
		$state = $stateval;	
	}
	if(!($zip=="" && $state=="" && $country == "" )){
		$cinfo = get_recruiter($zip,$state,$country,$db);
		if(!$cinfo){
			echo "No location.";
		}
		else {
			$territoryInfo = $cinfo;
		}
	}

	$redir = $territoryInfo['redir'];
	$fields_recruiter = $territoryInfo['fields_recruiter'];
//	$redirStr = $territoryInfo['redirStr'];
	$doRedir = $territoryInfo['doRedir'];
	$recruiter_email_handle = $territoryInfo['recruiter_email_handle'];

	$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter";

	$dup_flag = dupCheck($db,$email,$fname,$lname,$zip);
		

//	}
 	include $_SERVER['DOCUMENT_ROOT']."/includes/iw-curl.php";
	include $redirStr;	
	?>
	<script>
        _gaq.push(['_trackEvent', 'Form', 'Submit', '2013 FS - Over HS Animated LP']);
    </script>
	<?php
}
else {
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
	<title>Over High School | Bard College at Simon's Rock</title>
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

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== 
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/google-analytics.php";
?>
</head>
<body>
<div class="container">
    <div class="two columns"></div>
    <div class="eleven columns" id="inner-container">
	    <div class="row"></div>
        <img src="images/banner.gif" class="scale-with-grid" id="banner">
        <div class="row">
            <h1 class="remove-bottom" style="margin-top: 40px">
            Start college next fall, without earning your 
            high school diploma or taking the SAT&hellip;</h1>
        </div>
        <div class="row">  

            <div class="six columns">
                <h2>What is Early College?</h2>
                <ul class="list">
                	<li>400 Students</li>
                    <li>More than 40 areas of study</li>
                    <li>Average class size: 12</li>
                    <li>Weekly meetings with faculty advisors</li>
                    <li>85% of students receive financial aid</li>
                </ul>
                <h3>Fill out this form to receive a map of what your early college experience might look like.</h3>
            </div>
            <div class="four columns">
                <form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
                	<fieldset>
                    	<legend>Request Info</legend>
                        <label for="fname">* First name:</label><input type="text" name="fname" id="fname" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['fname']); ?>">
                        <label for="lname">* Last name:</label><input type="text" name="lname" id="lname" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['lname']); ?>">
                        <label for="email">* Email:</label><input type="text" name="email" id="email" onBlur="fieldStyleReset(this)" value="<?php echo($_REQUEST['email']); ?>">
<?php
if(!$is_intl){
?>
						<label id="stateLabel" for="stateval">* State/Province:</label>
						<select id="stateval" style="width:14em;" name="stateval">
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
<?php
}
?>

                        <label for="phone">Phone:</label><input type="text" name="phone" id="phone" value="<?php echo($_REQUEST['phone']); ?>">

                        <label for="phonetype" style="">Phone type:</label>
                        <select id="phonetype" style="" name="phonetype">
                            <option></option>
                            <option value="Home">Home</option>
                            <option value="Cell">Cell</option>
                        </select>
                        
                        <input id="texting_ok" name="texting_ok" type="checkbox" class="cb_left">
                        <label style="float: right; margin-left:  20px !important " for="texting_ok" class="cb_label">May we contact you via texts? </label>

						<label for="hs_gradyear">* HS class of:</label>
                        <select id="hs_gradyear" name="hs_gradyear" onChange="fieldStyleReset(this)">
                            <option selected="selected" value=""></option>
                            <option value="2013">2013</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                        <label for="desc" class="ta_label">What about early college most interests you?</label>
                        <textarea name="desc" id="desc"></textarea>
                        <div class="field-container">
<!--
                    	<input name="zip" id="zip" value="<?php echo($_REQUEST['zip']); ?>" type="hidden" />
                    	<input name="state" id="state" value="<?php echo($_REQUEST['state']); ?>" type="hidden" />
                    	<input name="country" id="country" value="<?php echo($_REQUEST['country']); ?>" type="hidden" />
                     	<input name="desc"  id="desc"  value="<?php echo($_REQUEST['desc']); ?>" type="hidden" /> 
                        
-->

                        <input type="hidden" name="formid" id="formid" value="685000007216264">
                        <input type="hidden" name="seed" id="seed" value="23">
                    	<button type="submit" name="submit" id="submit" ></button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="row">
        	<div class="center"><img src="images/logo.png" class="scale-with-grid"></div>
        </div>


    </div>
    <div class="two columns"></div>
</div>
<script type="text/javascript">
<!--

function fieldStyleReset(field){
	var val = field.value;
	if(val !== ""){
	   field.style.background = "#16BDDE";
	}
}


function checkForm() {

    var bgcolor
    var normal
    var rval
    highlight = "#990020"
    normal = "#16BDDE"
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

		if (document.request.phone.value.length != 0 && document.request.phonetype.value.length == 0) {
            document.request.phonetype.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "phonetype";
			}
		} 
		else {
            document.request.phonetype.style.backgroundColor = normal
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
<?php 
}
?>