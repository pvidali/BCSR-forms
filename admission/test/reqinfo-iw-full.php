<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
require_once($_SERVER['DOCUMENT_ROOT']."/admission/includes/iw-fields/functions.php");

if(isset($_REQUEST['test'])){
	if(error_check($_REQUEST['test'])){
		require_once $_SERVER['DOCUMENT_ROOT']."/includes/errors.php";
		$test_env = true;
	}
}

$form1Display = '';
$thankyouDisplay = 'none';

if(isset($_POST['submit'])) {
	$form1Display = 'none';
	$thankyouDisplay = '';
	$postArray = $_POST;
	$postArray['ethnicities'] = $ethnicities;
	$post_msg = "";
	
	fixFormatting($postArray);

	foreach($postArray as $k => $v){
		$$k = $v;
	}
	// get their state
	// exceptions: PA (West), PA (East),  NY (except NYC, Nassau & Suffok), NY (Nassau & Suffolk), 
	$territory = $high_school_state;
	if($territory == "NY") {
		$territory = $nycounty;
	}
	if($territory == "PA") {
		$territory = $paArea;
	}
//	$territoryInfo = getTerritoryInfo($territory,$territories);
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
		$state = $postArray['state'];
	}
	$hs_name = str_replace("&","*",$postArray['hs_name']);
	

	// add auto-submit icontact submission form in hidden iframe
	if(!$test_env){
		$formStr = "";
		$formStr .= "fname=".$postArray['fname'];
		$formStr .= "&";
		$formStr .= "lname=".$postArray['lname'];
		$formStr .= "&";
		$formStr .= "nickname=".$postArray['nickname'];
		$formStr .= "&";
		$formStr .= "email=".$postArray['email'];
		$formStr .= "&";
		$formStr .= "street=".$postArray['street'];
		$formStr .= "&";
		$formStr .= "street2=".$postArray['street2'];
		$formStr .= "&";
		$formStr .= "city=".$postArray['city'];
		$formStr .= "&";
		$formStr .= "state=".$state; 
		$formStr .= "&";
		$formStr .= "zip=".$postArray['zip'];
		$formStr .= "&";
		$formStr .= "country=".$postArray['country'];
		$formStr .= "&";
		$formStr .= "dob_m=".$postArray['dob_m'];
		$formStr .= "&";
		$formStr .= "dob_d=".$postArray['dob_d'];
		$formStr .= "&";
		$formStr .= "dob_y=".$postArray['dob_y'];
		$formStr .= "&";
		$formStr .= "gender=".$postArray['gender'];
		$formStr .= "&";
		$formStr .= "grad_year=".$postArray['grad_year'];
		$formStr .= "&";
		$formStr .= "REPLACE_ethnicity=".$postArray['ethnicity'];
		$formStr .= "&";
		$formStr .= "hs_name=".$hs_name;
		$formStr .= "&";
		$formStr .= "most_recent=".$most_recent;
		$formStr .= "&";
		$formStr .= "most_recent=".$postArray['most_recent'];
		$formStr .= "&";
		$formStr .= "hs_city=".$postArray['hs_city'];
		$formStr .= "&";
		$formStr .= "hs_state=".$postArray['hs_state'];
		$formStr .= "&";
		$formStr .= "hs_country=".$postArray['hs_country'];
		$formStr .= "&";
		$formStr .= "hs_type=".$postArray['hs_type'];
		$formStr .= "&";
		$formStr .= "ceeb=".$postArray['ceeb'];
		$formStr .= "&";
		$formStr .= "ed_type=".$postArray['ed_type'];
		$formStr .= "&";
		$formStr .= "fips=".$postArray['fips'];
		$formStr .= "&";
		$formStr .= "term_code=".$postArray['term_code'];
		$formStr .= "&";
		$formStr .= "sbgi=".$postArray['sbgi'];
		$formStr .= "&";
		$formStr .= "REPLACE_eth_code=".$postArray['eth_code'];
		$formStr .= "&";
		$formStr .= "how_heard=".$postArray['how_heard'];
		$formStr .= "&";
		$formStr .= "how_heard_more=".$postArray['how_heard_more'];
		$formStr .= "&";
		$formStr .= "how_heard_other=".$postArray['how_heard_other'];
		$formStr .= "&";
		$formStr .= "comment=".$postArray['comment'];
		$formStr .= "&";
		$formStr .= "parent1_fname=".$postArray['parent1_fname'];
		$formStr .= "&";
		$formStr .= "parent1_lname=".$postArray['parent1_lname'];
		$formStr .= "&";
		$formStr .= "parent1_rel=".$postArray['parent1_rel'];
		$formStr .= "&";
		$formStr .= "parent1_reswith=".$postArray['parent1_reswith'];
		$formStr .= "&";
		$formStr .= "parent1_email=".$postArray['parent1_email'];
		$formStr .= "&";
		$formStr .= "parent1_phone=".$postArray['parent1_phone'];
		$formStr .= "&";
		$formStr .= "parent1_phonetype=".$postArray['parent1_phonetype'];
		$formStr .= "&";
		$formStr .= "parent2_fname=".$postArray['parent2_fname'];
		$formStr .= "&";
		$formStr .= "parent2_lname=".$postArray['parent2_lname'];
		$formStr .= "&";
		$formStr .= "parent2_rel=".$postArray['parent2_rel'];
		$formStr .= "&";
		$formStr .= "parent2_reswith=".$postArray['parent2_reswith'];
		$formStr .= "&";
		$formStr .= "parent2_email=".$postArray['parent2_email'];
		$formStr .= "&";
		$formStr .= "parent2_phone=".$postArray['parent2_phone'];
		$formStr .= "&";
		$formStr .= "parent2_phonetype=".$postArray['parent2_phonetype'];
//		echo $formStr."<br ><br >";
//		$formStr = urlencode($formStr);
//		echo $formStr."<br ><br >";
//		exit();
		$formFrame = "<iframe src=\"http://forms.simons-rock.edu/admission/iw-full.php?$formStr\" width=\"0\" height=\"0\" style=\"border: 0\"></iframe>";
	}
	echo $formFrame;
}

if($thankyouDisplay == ""){
//	$territoryInfo = getTerritoryInfo($_POST['state'],$territories);
	$territoryInfo = getTerritoryInfoDB($state,$country,$db);
	$fields_recruiter = $territoryInfo['fields_recruiter'];//$_POST['counselor'];
	$email = $email;
	$doRedir = $territoryInfo['doRedir'];
	// HEADS UP THIS IS A MAJOR HACK... We are giving all NY and PA to Joel for this formn, since we only get state and not the futher area breakdown
	if($_POST['state'] == "NY" || $_POST['state'] == "PA"){
		$redir = "joel-pitt";
		$fields_recruiter = "pitt";
		$recruiter_email_handle = "jpitt@simons-rock.edu";
	}
	// SIMILAR HACK... These countries are steve's, whereas the absence of a state has been defaulting to Leslie
	if($_POST['country'] == "INDIA" || $_POST['country'] == "PAKISTAN" || $_POST['country'] == "BANGLADESH"){
		$redir = "coleman";
		$fields_recruiter = "coleman";
		$recruiter_email_handle = "scoleman@simons-rock.edu";
	}

	$redirStr = "http://forms.simons-rock.edu/admission/thankyou-iframe.php?email=$email&couns=$fields_recruiter&showBanner=1";
?>

<?php
	include $redirStr;	
}
else{

if($test_env){
	echo "BLUE";	
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
		<title>Bard College Simons Rock</title>
		<meta content="text/html; charset=ISO-8859-1" http-equiv="Content-Type" />
		<style type="text/css">
/* <![CDATA[ */

			#loading-mask {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: #F5F5F5;
			z-index: 1;
			display: none;
			opacity:0.5; filter:alpha(opacity=50);
			}
			#loading-wrapper {
			position: absolute;
			width: 400px;
			height: 200px;
			margin-left: -200px;
			margin-top: -100px;
			top: 50%;
			left: 50%;
			z-index: 2;
			display: none;
			}
			#loading {
			display: block;
			height: 2em;
			top: 50%;
			margin-top: -2em;
			margin-left: auto;
			margin-right: auto;
			position: absolute;
			width: 100%;
			text-align: center;
			}
			#loading span {
			color: #000000;
			background: url(data:image/gif;base64,R0lGODlhEAAQALMMAKqooJGOhp2bk7e1rZ2bkre1rJCPhqqon8PBudDOxXd1bISCef///wAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFAAAMACwAAAAAEAAQAAAET5DJyYyhmAZ7sxQEs1nMsmACGJKmSaVEOLXnK1PuBADepCiMg/DQ+/2GRI8RKOxJfpTCIJNIYArS6aRajWYZCASDa41Ow+Fx2YMWOyfpTAQAIfkEBQAADAAsAAAAABAAEAAABE6QyckEoZgKe7MEQMUxhoEd6FFdQWlOqTq15SlT9VQM3rQsjMKO5/n9hANixgjc9SQ/CgKRUSgw0ynFapVmGYkEg3v1gsPibg8tfk7CnggAIfkEBQAADAAsAAAAABAAEAAABE2QycnOoZjaA/IsRWV1goCBoMiUJTW8A0XMBPZmM4Ug3hQEjN2uZygahDyP0RBMEpmTRCKzWGCkUkq1SsFOFQrG1tr9gsPc3jnco4A9EQAh+QQFAAAMACwAAAAAEAAQAAAETpDJyUqhmFqbJ0LMIA7McWDfF5LmAVApOLUvLFMmlSTdJAiM3a73+wl5HYKSEET2lBSFIhMIYKRSimFriGIZiwWD2/WCw+Jt7xxeU9qZCAAh+QQFAAAMACwAAAAAEAAQAAAETZDJyRCimFqbZ0rVxgwF9n3hSJbeSQ2rCWIkpSjddBzMfee7nQ/XCfJ+OQYAQFksMgQBxumkEKLSCfVpMDCugqyW2w18xZmuwZycdDsRACH5BAUAAAwALAAAAAAQABAAAARNkMnJUqKYWpunUtXGIAj2feFIlt5JrWybkdSydNNQMLaND7pC79YBFnY+HENHMRgyhwPGaQhQotGm00oQMLBSLYPQ9QIASrLAq5x0OxEAIfkEBQAADAAsAAAAABAAEAAABE2QycmUopham+da1cYkCfZ94UiW3kmtbJuRlGF0E4Iwto3rut6tA9wFAjiJjkIgZAYDTLNJgUIpgqyAcTgwCuACJssAdL3gpLmbpLAzEQA7) no-repeat left center;
			font-size: 1.2em;
			padding: 5px 21px;
			}
			#loading-wrapper.timeout #loading span {
			background: none;
			}
			#loading-mask.run, #loading-wrapper.run, #loading-mask.timeout, #loading-wrapper.timeout {
			display: block;
			}
		
/* ]]> */
</style>
		<script src="https://crm.orionondemand.com/crm/javascript/jquery/js/jquery-min.js" type="text/javascript"></script>
		<script src="https://crm.orionondemand.com/crm/javascript/jquery/js/jquery-ui-min.js" type="text/javascript"></script>
		<script type="text/javascript">
// <![CDATA[
jQuery.noConflict();
// ]]>
</script>
		<script src="https://crm.orionondemand.com/crm/javascript/jquery/plugins/jquery.json.min.js" type="text/javascript"></script>
		<script src="https://crm.orionondemand.com/crm/javascript/iw.js" type="text/javascript"></script>
 		<script src="https://crm.orionondemand.com/crm/javascript/IWFormValidator.js" type="text/javascript"></script> 
		<script src="https://crm.orionondemand.com/crm/javascript/uitypes.js" type="text/javascript"></script>
		<script src="https://crm.orionondemand.com/crm/javascript/html.js" type="text/javascript"></script>
		<script src="https://crm.orionondemand.com/crm/javascript/countrystate.js" type="text/javascript"></script>
		<script src="https://crm.orionondemand.com/crm/javascript/fielddep.js" type="text/javascript"></script>
		<script src="https://crm.orionondemand.com/crm/javascript/inlinelookup.js" type="text/javascript"></script>
		<script src="https://crm.orionondemand.com/crm/javascript/formsruntime.js" type="text/javascript"></script>
		<link rel="Stylesheet" type="text/css" href="https://crm.orionondemand.com/crm/javascript/jquery/css/smoothness/jquery-ui.css" />
		<link rel="Stylesheet" type="text/css" href="https://crm.orionondemand.com/crm/css/common.css" />
		<link rel="Stylesheet" type="text/css" href="https://crm.orionondemand.com/crm/css/formscommon.css" />
		<link rel="Stylesheet" type="text/css" href="https://crm.orionondemand.com/crm/css/formsruntime.css" />
		<script src="https://crm.orionondemand.com/crm/javascript/jquery/plugins/jquery.bjax.js" type="text/javascript"></script>
		<script type="text/javascript">
// <![CDATA[
var serverURL = "https://crm.orionondemand.com";
// ]]>
</script>
		<script src="https://crm.orionondemand.com/crm/javascript/inquiryformruntime.js" type="text/javascript"></script>

<script src="/js/jquery-1.9.1.js"></script>
<script src="/js/jquery-ui-1.10.1.custom.min.js"></script>

<link href="/css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<script>
jQuery(document).ready(function($){
	$('#EducationHistory').autocomplete({
		source:'search.php', 
		minLength:2
	});
//	$("#EducationHistory").autocomplete({
 // 		select: function( event, ui ) {}
//	});
	$( "#EducationHistory" ).on( "autocompletechange", function( event, ui ) {
		document.getElementById('hs_name').value = document.getElementById('EducationHistory').value;	
		
		var xmlhttp;
		var str = "";
		var schoolInfoArray = new Array();
		if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			
			var trip = 0;
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				schoolInfo = xmlhttp.responseText;
				schoolInfoArray = schoolInfo.split("*");
				for(x=0;x<schoolInfoArray.length;x++){
					innerArray = schoolInfoArray[x].split("=");
					if(innerArray[0] == "CITY"){
						document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002993").value=innerArray[1];
						document.getElementById("hs_city").value=innerArray[1];
						if(innerArray[1] != ""){
							trip++;
							document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002993").style.background = "#CCC";
							document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002993").disabled = true;
						}
					}
					if(innerArray[0] == "STATE"){
						document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000131537").value=innerArray[1];
						document.getElementById("hs_state").value=innerArray[1];
						if(innerArray[1] != ""){
							trip++;
							document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000131537").style.background = "#CCC";
							document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000131537").disabled = true;
						}
					}
					if(innerArray[0] == "COUNTRY"){
						document.getElementById("hs_country").value=innerArray[1];
						document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000133093").value=innerArray[1];
						if(innerArray[1] != ""){
							trip++;
							document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000133093").style.background = "#CCC";
							document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000133093").disabled = true;
						}
					}
					if(innerArray[0] == "CEEB"){
						document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002975").value=innerArray[1];
					}
				}
				if(trip == 0){
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002993").style.background = "#FFF";
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002993").disabled = false;
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000131537").style.background = "#FFF";
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000131537").disabled = false;
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000133093").style.background = "#FFF";
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000133093").disabled = false;
				}
				else {
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002993").style.background = "#CCC";
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002993").disabled = true;
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000131537").style.background = "#CCC";
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000131537").disabled = true;
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000133093").style.background = "#CCC";
					document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000133093").disabled = true;
				}
				//document.getElementById("EducationHistory.High School.records.IWDF-row-111.685000000002993").value=xmlhttp.responseText;
			}
		}
		str =  encodeURIComponent(document.getElementById('EducationHistory').value);
		xmlhttp.open("GET","getSchoolInfo.php?schoolName="+str,true);
		xmlhttp.send();
	} );
});
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/google-analytics.php";
?>
<script>
var tooltip=function(){
 var id = 'tt';
 var top = 3;
 var left = 3;
 var maxw = 300;
 var speed = 10;
 var timer = 20;
 var endalpha = 95;
 var alpha = 0;
 var tt,t,c,b,h;
 var ie = document.all ? true : false;
 return{
  show:function(v,w){
   if(tt == null){
    tt = document.createElement('div');
    tt.setAttribute('id',id);
    t = document.createElement('div');
    t.setAttribute('id',id + 'top');
    c = document.createElement('div');
    c.setAttribute('id',id + 'cont');
    b = document.createElement('div');
    b.setAttribute('id',id + 'bot');
    tt.appendChild(t);
    tt.appendChild(c);
    tt.appendChild(b);
    document.body.appendChild(tt);
    tt.style.opacity = 0;
    tt.style.filter = 'alpha(opacity=0)';
    document.onmousemove = this.pos;
   }
   tt.style.display = 'block';
   c.innerHTML = v;
   tt.style.width = w ? w + 'px' : 'auto';
   if(!w && ie){
    t.style.display = 'none';
    b.style.display = 'none';
    tt.style.width = tt.offsetWidth;
    t.style.display = 'block';
    b.style.display = 'block';
   }
  if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
  h = parseInt(tt.offsetHeight) + top;
  clearInterval(tt.timer);
  tt.timer = setInterval(function(){tooltip.fade(1)},timer);
  },
  pos:function(e){
   var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
   var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
   tt.style.top = (u - h) + 'px';
   tt.style.left = (l + left) + 'px';
  },
  fade:function(d){
   var a = alpha;
   if((a != endalpha && d == 1) || (a != 0 && d == -1)){
    var i = speed;
   if(endalpha - a < speed && d == 1){
    i = endalpha - a;
   }else if(alpha < speed && d == -1){
     i = a;
   }
   alpha = a + (i * d);
   tt.style.opacity = alpha * .01;
   tt.style.filter = 'alpha(opacity=' + alpha + ')';
  }else{
    clearInterval(tt.timer);
     if(d == -1){tt.style.display = 'none'}
  }
 },
 hide:function(){
  clearInterval(tt.timer);
   tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
  }
 };
}();
</script>
		<style type="text/css">
.field-control label.left{
	width: 175px !important;
	padding-right: 5px;
	color: #AB033A;
}
.field-control input, .field-control select{
	width: 10em !important;
	font-size: 11px !important;
}
legend{
	font-size: 15px;
	font-weight: bold;
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
.pDiv{
	float:left; 
	width: 318px; 
	margin-right: 5px; 
	border-right: 1px gray dashed; 
	margin-top: 9px;
}
.pDiv:hover{
	background:#C1C1C1;
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

/* <![CDATA[ */
button{font-weight: bold;}button{font-size: 19px;}label{font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;font-size: 12px;}input{border: solid 1px #AACFE4;}select{font-size: 12px; border: solid 1px #AACFE4;}div.section-control .title{display:none}#IWDF-control-74,#IWDF-control-76{border: 0 !important;}#IWDF-control-78,#IWDF-control-82{float: none; border: 0 !important}.dynamic-form-required legend{margin-right: 5px !important;margin-top: 5px !important}#IWDF-page-104{border: 1px solid #CCC; padding: 5px}div.section-control{border: 0px !important}#IWDF-control-106{width: 450px !important}
/* ]]> */
</style>
	</head>
	<body style="background: #fff; margin: 0 !important;text-align: left;">
		<div id="loading-mask"></div>
		<div id="loading-wrapper">
			<div id="loading">
				<span id="loading-text">Loading...</span>
			</div>
		</div>
		<script type="text/javascript">
// <![CDATA[

			// Form Loader
			var l_timeout = 20000;
			var l_start = new Date().getTime();
			var l_current = l_start;
			var pollLoader = function(){
			clearTimeout(l_t);
			l_current = new Date().getTime();
			if((l_current - l_start)
			< l_timeout){
			if((typeof _IW == "undefined") || (typeof _IW.FormsRuntime == "undefined") || (typeof _IW.FormsRuntime.isLoaded() == "undefined")){
			if(document.getElementById("loading")){
			document.getElementById("loading-mask").className = "run";
			document.getElementById("loading-wrapper").className = "run";
			l_t = setTimeout("pollLoader()", 500);
			}
			}
			else{
			document.getElementById("loading-mask").className = "";
			document.getElementById("loading-wrapper").className = "";
			}
			}
			else{
			document.getElementById("loading-mask").className = "timeout";
			document.getElementById("loading-wrapper").className = "timeout";
			document.getElementById("loading-text").innerHTML = "This form is currently not available.  We apologize for the inconvenience.";
			}
			}
			var l_t = setTimeout("pollLoader()", 2000);
		
// ]]>
</script>
		<div id="form-wrapper" style="margin-right:0px !important;width:700px; margin-left:0px !important; border: 0px solid #eee; padding: 0px !important; display: <?php echo($form1Display); ?>" class="ui-tabs-left">
			<div id="form-header" style="width:625px;">
				<h2>Request Information</h2>
			</div>
<!--			<iframe id="_dummy" style="display:none;" name="_dummy"></iframe>
 			<form target="_dummy" action="javascript:void(0);"> -->
			<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
				<div id="IWDF-dynamicform-107" class="dynamicFormDefaults clearfix">
					<div id="IWDF-page-108">
						<div class="dynamic-form-required legend" style="margin-bottom: 5px; margin-right: 15px; border-bottom: solid 1px #B7DDF2;">(* = Required Field)</div>
						<ul class="page-child-helper">
							<li class="page-child-wrapper first">
								<div id="IWDF-control-4" sectiontitle="Contact Information" class="form-control section-control page-child first">
								<ul class="control-child-helper control-draggable clearfix wide">
									<fieldset style="background:#f4f4f4; border-radius: 10px !important; margin-bottom:10px;">
									  <legend>Contact Information</legend>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-6" class="form-control field-control">
												<label for="Contacts.685000000003015" style="width:90px !important;" class="dynamic-form-required left">* First Name</label>
												<input id="Contacts.685000000003015" maxlength="40" name="fname" value="" type="text" tabindex="1" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003015", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control">
												<label for="Contacts.685000000003017" style="width:90px !important;" class="dynamic-form-required left">* Last Name</label>
												<input id="Contacts.685000000003017" maxlength="80" name="lname" tabindex="2" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003017", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-12" class="form-control field-control">
												<label for="Contacts.685000000003021" style="width:100px !important;" class="dynamic-form-required left">* Email</label>
												<input id="Contacts.685000000003021" maxlength="100" name="email" value="" tabindex="3" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003021", "validEmail", null, { trim: true, emptyvalid: true });
// ]]>
</script>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003021", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-36" class="form-control field-control">
												<label for="Contacts.685000000003027" style="width:90px !important;" class="left">Home Phone</label>
												<input id="Contacts.685000000003027" maxlength="50" name="home_phone" value="" tabindex="4" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003027", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-38" class="form-control field-control">
												<label for="Contacts.685000000003031" style="width:90px !important;" class="left">Cell Phone</label>
												<input id="Contacts.685000000003031" maxlength="30" name="mobile_phone" value="" tabindex="5" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003031", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>

										<li class="control-draggable control-child-wrapper" id="stateLI">
											<div id="IWDF-control-24" class="form-control field-control">
												<img src="images/about.png" onmouseover="tooltip.show('Our admission office covers the country (and world) geographically. We need to know where you live in order to connect you with your contact in the office.', 150);" onmouseout="tooltip.hide();" style="float:right; padding: 4px 0 0 5px; display: none" />
												<label for="Contacts.685000000123120" style="width:100px !important;" class="dynamic-form-required left">* State/Province</label>
												<select id="Contacts.685000000123120" name="state"  onchange="toggleCountryDiv()" style="width: 85px !important">
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
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000123120", "Please select 1 item", { isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>

										<li class="control-draggable control-child-wrapper" id="streetLI" style="display:none; ">
											<div id="IWDF-control-18" class="form-control field-control">
												<label for="Contacts.685000000003063" style="width:90px !important;" class="dynamic-form-required left">Street</label>
												<input id="Contacts.685000000003063" maxlength="250" name="street" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003063", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper" id="street2LI" style="display:none; ">
											<div id="IWDF-control-20" class="form-control field-control">
												<label for="Contacts.685000000121961" style="width:90px !important;" class="left">Street 2</label>
												<input id="Contacts.685000000121961" maxlength="30" name="street2" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000121961", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>

										<li class="control-draggable control-child-wrapper" id="cityLI" style="display:none; ">
											<div id="IWDF-control-22" class="form-control field-control">
												<label for="Contacts.685000000003065" style="width:100px !important;" class="left">City</label>
												<input id="Contacts.685000000003065" maxlength="30" name="city" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003065", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true  });
// ]]>
</script>
											</div>
										</li>										
										
										<li class="clear-float"></li>

<!-- Contacts.685000000123120, prefilledState -->

										<li class="control-draggable control-child-wrapper" id="prefilledStateLI" style="display:none; ">
											<div class="form-control field-control">
												<label for="prefilledState" style="width:90px !important;" class="left">State</label>
												<input id="prefilledState" maxlength="10" name="prefilledState" value="" readonly type="text" style="background: #ccc" />
											</div>
										</li>


										<li class="control-draggable control-child-wrapper" id="zipLI" style="display:none; ">
											<div id="IWDF-control-26" class="form-control field-control">
												<label for="Contacts.685000000155005" style="width:155px !important;" class="left">Zip/Postal Code</label>
												<input id="Contacts.685000000155005" maxlength="10" name="zip" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000155005", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true  });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper" id="countryLI" style="display:none; float: right; margin-right: 4px;">
											<div id="IWDF-control-28" class="form-control field-control">
												<label for="Contacts.685000000131001" style="width:195px !important;" class="left">Country (if other than U.S.)</label>
												<select id="Contacts.685000000131001" name="country">
													<option selected="selected" value=""></option>
													<option value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>
													<option value="UNITED ARAB EMIRATES">UNITED ARAB EMIRATES</option>
													<option value="AFGHANISTAN">AFGHANISTAN</option>
													<option value="ALGERIA">ALGERIA</option>
													<option value="AZERBAIJAN">AZERBAIJAN</option>
													<option value="ALBANIA">ALBANIA</option>
													<option value="ARMENIA">ARMENIA</option>
													<option value="ANDORRA">ANDORRA</option>
													<option value="ANGOLA">ANGOLA</option>
													<option value="ARGENTINA">ARGENTINA</option>
													<option value="AUSTRALIA">AUSTRALIA</option>
													<option value="AUSTRIA">AUSTRIA</option>
													<option value="BAHRAIN">BAHRAIN</option>
													<option value="BARBADOS">BARBADOS</option>
													<option value="BOTSWANA">BOTSWANA</option>
													<option value="BELGIUM">BELGIUM</option>
													<option value="BAHAMAS, THE">BAHAMAS, THE</option>
													<option value="BANGLADESH">BANGLADESH</option>
													<option value="BELIZE">BELIZE</option>
													<option value="BOSNIA AND HERZEGOVINA">BOSNIA AND HERZEGOVINA</option>
													<option value="BOLIVIA">BOLIVIA</option>
													<option value="BURMA">BURMA</option>
													<option value="BENIN">BENIN</option>
													<option value="BELARUS">BELARUS</option>
													<option value="SOLOMON ISLANDS">SOLOMON ISLANDS</option>
													<option value="BRAZIL">BRAZIL</option>
													<option value="BHUTAN">BHUTAN</option>
													<option value="BULGARIA">BULGARIA</option>
													<option value="BRUNEI">BRUNEI</option>
													<option value="BURUNDI">BURUNDI</option>
													<option value="CANADA">CANADA</option>
													<option value="CAMBODIA">CAMBODIA</option>
													<option value="CHAD">CHAD</option>
													<option value="SRI LANKA">SRI LANKA</option>
													<option value="CONGO (BRAZZAVILLE)">CONGO (BRAZZAVILLE)</option>
													<option value="CONGO (KINSHASA)">CONGO (KINSHASA)</option>
													<option value="CHINA">CHINA</option>
													<option value="CHILE">CHILE</option>
													<option value="CAMEROON">CAMEROON</option>
													<option value="COMOROS">COMOROS</option>
													<option value="COLOMBIA">COLOMBIA</option>
													<option value="COSTA RICA">COSTA RICA</option>
													<option value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>
													<option value="CUBA">CUBA</option>
													<option value="CAPE VERDE">CAPE VERDE</option>
													<option value="CYPRUS">CYPRUS</option>
													<option value="DENMARK">DENMARK</option>
													<option value="DJIBOUTI">DJIBOUTI</option>
													<option value="DOMINICA">DOMINICA</option>
													<option value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
													<option value="ECUADOR">ECUADOR</option>
													<option value="EGYPT">EGYPT</option>
													<option value="IRELAND">IRELAND</option>
													<option value="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>
													<option value="ESTONIA">ESTONIA</option>
													<option value="ERITREA">ERITREA</option>
													<option value="EL SALVADOR">EL SALVADOR</option>
													<option value="ETHIOPIA">ETHIOPIA</option>
													<option value="CZECH REPUBLIC">CZECH REPUBLIC</option>
													<option value="FINLAND">FINLAND</option>
													<option value="FIJI">FIJI</option>
													<option value="MICRONESIA">MICRONESIA</option>
													<option value="FRANCE">FRANCE</option>
													<option value="GAMBIA, THE">GAMBIA, THE</option>
													<option value="GABON">GABON</option>
													<option value="GEORGIA">GEORGIA</option>
													<option value="GHANA">GHANA</option>
													<option value="GRENADA">GRENADA</option>
													<option value="GERMANY">GERMANY</option>
													<option value="GREECE">GREECE</option>
													<option value="GUATEMALA">GUATEMALA</option>
													<option value="GUINEA">GUINEA</option>
													<option value="GUYANA">GUYANA</option>
													<option value="HAITI">HAITI</option>
													<option value="HONDURAS">HONDURAS</option>
													<option value="CROATIA">CROATIA</option>
													<option value="HUNGARY">HUNGARY</option>
													<option value="ICELAND">ICELAND</option>
													<option value="INDONESIA">INDONESIA</option>
													<option value="INDIA">INDIA</option>
													<option value="IRAN">IRAN</option>
													<option value="ISRAEL">ISRAEL</option>
													<option value="ITALY">ITALY</option>
													<option value="CÔTE D&#39;IVOIRE">COTE D&#39;IVOIRE</option>
													<option value="IRAQ">IRAQ</option>
													<option value="JAPAN">JAPAN</option>
													<option value="JAMAICA">JAMAICA</option>
													<option value="JORDAN">JORDAN</option>
													<option value="KENYA">KENYA</option>
													<option value="KYRGYZSTAN">KYRGYZSTAN</option>
													<option value="KOREA, NORTH">KOREA, NORTH</option>
													<option value="KIRIBATI">KIRIBATI</option>
													<option value="KOREA, SOUTH">KOREA, SOUTH</option>
													<option value="KUWAIT">KUWAIT</option>
													<option value="KOSOVO">KOSOVO</option>
													<option value="KAZAKHSTAN">KAZAKHSTAN</option>
													<option value="LAOS">LAOS</option>
													<option value="LEBANON">LEBANON</option>
													<option value="LATVIA">LATVIA</option>
													<option value="LITHUANIA">LITHUANIA</option>
													<option value="LIBERIA">LIBERIA</option>
													<option value="SLOVAKIA">SLOVAKIA</option>
													<option value="LIECHTENSTEIN">LIECHTENSTEIN</option>
													<option value="LESOTHO">LESOTHO</option>
													<option value="LUXEMBOURG">LUXEMBOURG</option>
													<option value="LIBYA">LIBYA</option>
													<option value="MADAGASCAR">MADAGASCAR</option>
													<option value="MOLDOVA">MOLDOVA</option>
													<option value="MONGOLIA">MONGOLIA</option>
													<option value="MALAWI">MALAWI</option>
													<option value="MONTENEGRO">MONTENEGRO</option>
													<option value="MACEDONIA">MACEDONIA</option>
													<option value="MALI">MALI</option>
													<option value="MONACO">MONACO</option>
													<option value="MOROCCO">MOROCCO</option>
													<option value="MAURITIUS">MAURITIUS</option>
													<option value="MAURITANIA">MAURITANIA</option>
													<option value="MALTA">MALTA</option>
													<option value="OMAN">OMAN</option>
													<option value="MALDIVES">MALDIVES</option>
													<option value="MEXICO">MEXICO</option>
													<option value="MALAYSIA">MALAYSIA</option>
													<option value="MOZAMBIQUE">MOZAMBIQUE</option>
													<option value="NIGER">NIGER</option>
													<option value="VANUATU">VANUATU</option>
													<option value="NIGERIA">NIGERIA</option>
													<option value="NETHERLANDS">NETHERLANDS</option>
													<option value="NORWAY">NORWAY</option>
													<option value="NEPAL">NEPAL</option>
													<option value="NAURU">NAURU</option>
													<option value="SURINAME">SURINAME</option>
													<option value="NICARAGUA">NICARAGUA</option>
													<option value="NEW ZEALAND">NEW ZEALAND</option>
													<option value="SOUTH SUDAN">SOUTH SUDAN</option>
													<option value="PARAGUAY">PARAGUAY</option>
													<option value="PERU">PERU</option>
													<option value="PAKISTAN">PAKISTAN</option>
													<option value="POLAND">POLAND</option>
													<option value="PANAMA">PANAMA</option>
													<option value="PORTUGAL">PORTUGAL</option>
													<option value="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>
													<option value="PALAU">PALAU</option>
													<option value="GUINEA-BISSAU">GUINEA-BISSAU</option>
													<option value="QATAR">QATAR</option>
													<option value="SERBIA">SERBIA</option>
													<option value="MARSHALL ISLANDS">MARSHALL ISLANDS</option>
													<option value="ROMANIA">ROMANIA</option>
													<option value="PHILIPPINES">PHILIPPINES</option>
													<option value="RUSSIA">RUSSIA</option>
													<option value="RWANDA">RWANDA</option>
													<option value="SAUDI ARABIA">SAUDI ARABIA</option>
													<option value="SAINT KITTS AND NEVIS">SAINT KITTS AND NEVIS</option>
													<option value="SEYCHELLES">SEYCHELLES</option>
													<option value="SOUTH AFRICA">SOUTH AFRICA</option>
													<option value="SENEGAL">SENEGAL</option>
													<option value="SLOVENIA">SLOVENIA</option>
													<option value="SIERRA LEONE">SIERRA LEONE</option>
													<option value="SAN MARINO">SAN MARINO</option>
													<option value="SINGAPORE">SINGAPORE</option>
													<option value="SOMALIA">SOMALIA</option>
													<option value="SPAIN">SPAIN</option>
													<option value="SAINT LUCIA">SAINT LUCIA</option>
													<option value="SUDAN">SUDAN</option>
													<option value="SWEDEN">SWEDEN</option>
													<option value="SYRIA">SYRIA</option>
													<option value="SWITZERLAND">SWITZERLAND</option>
													<option value="TRINIDAD AND TOBAGO">TRINIDAD AND TOBAGO</option>
													<option value="THAILAND">THAILAND</option>
													<option value="TAJIKISTAN">TAJIKISTAN</option>
													<option value="TONGA">TONGA</option>
													<option value="TOGO">TOGO</option>
													<option value="SAO TOME AND PRINCIPE">SAO TOME AND PRINCIPE</option>
													<option value="TUNISIA">TUNISIA</option>
													<option value="TIMOR-LESTE">TIMOR-LESTE</option>
													<option value="TURKEY">TURKEY</option>
													<option value="TUVALU">TUVALU</option>
													<option value="TURKMENISTAN">TURKMENISTAN</option>
													<option value="TANZANIA">TANZANIA</option>
													<option value="UGANDA">UGANDA</option>
													<option value="UNITED KINGDOM">UNITED KINGDOM</option>
													<option value="UKRAINE">UKRAINE</option>
													<option value="UNITED STATES">UNITED STATES</option>
													<option value="BURKINA FASO">BURKINA FASO</option>
													<option value="URUGUAY">URUGUAY</option>
													<option value="UZBEKISTAN">UZBEKISTAN</option>
													<option value="SAINT VINCENT AND THE GRENADINES">SAINT VINCENT AND THE GRENADINES</option>
													<option value="VENEZUELA">VENEZUELA</option>
													<option value="VIETNAM">VIETNAM</option>
													<option value="HOLY SEE">HOLY SEE</option>
													<option value="NAMIBIA">NAMIBIA</option>
													<option value="SAMOA">SAMOA</option>
													<option value="SWAZILAND">SWAZILAND</option>
													<option value="YEMEN">YEMEN</option>
													<option value="ZAMBIA">ZAMBIA</option>
													<option value="ZIMBABWE">ZIMBABWE</option>
												</select>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000131001", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
												<script type="text/javascript">
// <![CDATA[
_IW.FieldDep.addDependency("Contacts.685000000131001", "Contacts.685000000130005", {"":[""],"HOLY SEE":["VT"],"MOROCCO":["MO"],"LATVIA":["LG"],"CAPE VERDE":["CV"],"MALI":["ML"],"INDIA":["IN"],"FINLAND":["FI"],"DENMARK":["DA"],"TANZANIA":["TZ"],"BURKINA FASO":["UV"],"CZECH REPUBLIC":["EZ"],"ARGENTINA":["AR"],"SLOVENIA":["SI"],"ECUADOR":["EC"],"VENEZUELA":["VE"],"TIMOR-LESTE":["TT"],"SUDAN":["SU"],"BARBADOS":["BB"],"EL SALVADOR":["ES"],"ZAMBIA":["ZA"],"TOGO":["TO"],"CHILE":["CI"],"NAMIBIA":["WA"],"BRUNEI":["BX"],"MALAYSIA":["MY"],"TUVALU":["TV"],"FRANCE":["FR"],"CANADA":["CA"],"AFGHANISTAN":["AF"],"PANAMA":["PM"],"DOMINICAN REPUBLIC":["DR"],"HONDURAS":["HO"],"AUSTRIA":["AU"],"TONGA":["TN"],"DOMINICA":["DO"],"UNITED KINGDOM":["UK"],"ANGOLA":["AO"],"FIJI":["FJ"],"SOLOMON ISLANDS":["BP"],"CENTRAL AFRICAN REPUBLIC":["CT"],"ERITREA":["ER"],"JORDAN":["JO"],"CYPRUS":["CY"],"SURINAME":["NS"],"GAMBIA, THE":["GA"],"LESOTHO":["LT"],"COLOMBIA":["CO"],"VANUATU":["NH"],"AUSTRALIA":["AS"],"SOUTH SUDAN":["OD"],"GERMANY":["GM"],"MARSHALL ISLANDS":["RM"],"MONGOLIA":["MG"],"GUINEA-BISSAU":["PU"],"SAINT LUCIA":["ST"],"UZBEKISTAN":["UZ"],"PAKISTAN":["PK"],"KOREA, NORTH":["KN"],"BURUNDI":["BY"],"BULGARIA":["BU"],"RWANDA":["RW"],"ALGERIA":["AG"],"BAHAMAS, THE":["BF"],"SWEDEN":["SW"],"KIRIBATI":["KR"],"TRINIDAD AND TOBAGO":["TD"],"KYRGYZSTAN":["KG"],"PORTUGAL":["PO"],"SYRIA":["SY"],"SPAIN":["SP"],"NIGERIA":["NI"],"PHILIPPINES":["RP"],"TURKMENISTAN":["TX"],"AZERBAIJAN":["AJ"],"ZIMBABWE":["ZI"],"MICRONESIA":["FM"],"LEBANON":["LE"],"YEMEN":["YM"],"ETHIOPIA":["ET"],"BOTSWANA":["BC"],"NAURU":["NR"],"MAURITIUS":["MP"],"VIETNAM":["VM"],"MEXICO":["MX"],"GHANA":["GH"],"PERU":["PE"],"SEYCHELLES":["SE"],"ARMENIA":["AM"],"ISRAEL":["IS"],"TAJIKISTAN":["TI"],"NEW ZEALAND":["NZ"],"CHAD":["CD"],"KUWAIT":["KU"],"SAINT KITTS AND NEVIS":["SC"],"PAPUA NEW GUINEA":["PP"],"ITALY":["IT"],"CAMEROON":["CM"],"MALDIVES":["MV"],"ROMANIA":["RO"],"TUNISIA":["TS"],"HUNGARY":["HU"],"MACEDONIA":["MK"],"BELGIUM":["BE"],"SAO TOME AND PRINCIPE":["TP"],"BAHRAIN":["BA"],"BELARUS":["BO"],"UNITED STATES":["US"],"GREECE":["GR"],"GABON":["GB"],"LIBYA":["LY"],"KENYA":["KE"],"SAINT VINCENT AND THE GRENADINES":["VC"],"MONTENEGRO":["MJ"],"GRENADA":["GJ"],"SAMOA":["WS"],"TURKEY":["TU"],"GUYANA":["GY"],"ICELAND":["IC"],"UGANDA":["UG"],"SOMALIA":["SO"],"SWITZERLAND":["SZ"],"ANDORRA":["AN"],"PALAU":["PS"],"MALTA":["MT"],"SENEGAL":["SG"],"SAUDI ARABIA":["SA"],"URUGUAY":["UY"],"SINGAPORE":["SN"],"COSTA RICA":["CS"],"IRELAND":["EI"],"LUXEMBOURG":["LU"],"ANTIGUA AND BARBUDA":["AC"],"CUBA":["CU"],"SLOVAKIA":["LO"],"IRAN":["IR"],"PARAGUAY":["PA"],"BRAZIL":["BR"],"JAMAICA":["JM"],"IRAQ":["IZ"],"BOSNIA AND HERZEGOVINA":["BK"],"SIERRA LEONE":["SL"],"NICARAGUA":["NU"],"NIGER":["NG"],"NORWAY":["NO"],"SAN MARINO":["SM"],"MAURITANIA":["MR"],"LITHUANIA":["LH"],"CHINA":["CH"],"MADAGASCAR":["MA"],"GUINEA":["GV"],"COMOROS":["CN"],"BOLIVIA":["BL"],"LIBERIA":["LI"],"HAITI":["HA"],"ESTONIA":["EN"],"JAPAN":["JA"],"ALBANIA":["AL"],"DJIBOUTI":["DJ"],"LAOS":["LA"],"SWAZILAND":["WZ"],"GEORGIA":["GG"],"MALAWI":["MI"],"EQUATORIAL GUINEA":["EK"],"CONGO (BRAZZAVILLE)":["CF"],"NEPAL":["NP"],"KAZAKHSTAN":["KZ"],"LIECHTENSTEIN":["LS"],"POLAND":["PL"],"BURMA":["BM"],"UKRAINE":["UP"],"GUATEMALA":["GT"],"BELIZE":["BH"],"SRI LANKA":["CE"],"THAILAND":["TH"],"KOREA, SOUTH":["KS"],"MONACO":["MN"],"CÔTE D'IVOIRE":["IV"],"BHUTAN":["BT"],"SERBIA":["RI"],"RUSSIA":["RS"],"CAMBODIA":["CB"],"NETHERLANDS":["NL"],"INDONESIA":["ID"],"EGYPT":["EG"],"MOZAMBIQUE":["MZ"],"BENIN":["BN"],"CONGO (KINSHASA)":["CG"],"CROATIA":["HR"],"OMAN":["MU"],"QATAR":["QA"],"MOLDOVA":["MD"],"KOSOVO":["KV"],"BANGLADESH":["BG"],"SOUTH AFRICA":["SF"],"UNITED ARAB EMIRATES":["AE"]});
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<div id="IWDF-control-20" class="form-control field-control" style="margin-left: 10px;">
											<input type="checkbox" name="getAddress" id="getAddress" onclick="toggleAddressDiv(this.checked)" style="vertical-align: top;" />
											<label for="getAddress" style="width:auto !important; text-align:left" class="left">Check this to get info by regular mail</label>
											<img src="images/about.png" onmouseover="tooltip.show('One of the ways we tell you more about Simon\'s Rock is through physical brochures and documents.  If you prefer not to provide us a mailing address, we will contact you primarily by email.', 210);" onmouseout="tooltip.hide();" style="float:left; padding: 0px 0 0 5px" />
										</div>
									</fieldset>
									<fieldset style="background:#f4f4f4; width: auto !important; min-height: 275px; border-radius: 10px !important;">
									  <fieldset style="background:#fff; width: 305px !important; border-radius: 10px !important; float:left; min-height: 255px;">
									   <legend>About Your High School</legend>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper" style="float:right !important">
											<div id="IWDF-control-40" class="form-control field-control">
												<label for="Contacts.685000000110551" style="width:175px !important;" class="left">High School Graduation Year</label>
												<select id="Contacts.685000000110551" name="grad_year" style="width:7em !important">
													<option selected="selected" value=""></option>
													<option value="2012">2012</option>
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
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000110551", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
												<script type="text/javascript">
// <![CDATA[
_IW.FieldDep.addDependency("Contacts.685000000110551", "Contacts.685000000336031", {"":[""],"2017":["201508"],"2018":["201608"],"2019":["201708"],"2013":[""],"2014":["201308"],"2015":["201308"],"2016":["201408"],"2012":[""],"2021":["201908"],"2020":["201808"]});
// ]]>
</script>
											</div>
										</li>
<!--
										<li class="control-draggable control-child-wrapper" style="float:right !important">
											<div id="IWDF-control-76" class="form-control field-control">


<form action="search.php" method="post">
	
	<input type="text" id="EducationHistory.High School.records.IWDF-row-111.685000000002963" name="term" />
	<label for="EducationHistory.High School.records.IWDF-row-111.685000000002963" style="width:170px !important;" class="left">* High School Name</label>
	<input type="submit" value="Search" style="display:none" />
</form>
											</div>
										</li>
-->
										<li class="control-draggable control-child-wrapper" style="float:right !important">
											<div id="IWDF-control-76" class="form-control field-control">
<!--											  <form action="search.php" method="post"> -->
												<label for="EducationHistory" style="width:170px !important;" class="left">* High School Name</label>
												<input id="EducationHistory" maxlength="100" name="term" type="text" />
												<input id="hs_name" maxlength="100" name="hs_name" type="hidden" />
												<input type="submit" value="Search" style="display:none" />
<!--											  </form>	
											</div>
										</li>


<!--
									<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper" style="float:right !important">
											<div id="IWDF-control-76" class="form-control field-control">
												<label for="EducationHistory.High School.records.IWDF-row-111.685000000002963" style="width:170px !important;" class="left">* High School Name</label>
												<input id="EducationHistory.High School.records.IWDF-row-111.685000000002963" maxlength="100" name="hs_name" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("EducationHistory.High School.records.IWDF-row-111.685000000002963", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper" style="float:right !important; display: none">
											<div id="IWDF-control-76" class="form-control field-control">
												<label for="EducationHistory.High School.records.IWDF-row-111.685000000002963" style="width:170px !important;" class="left">* High School Name</label>
												<input id="EducationHistory.High School.records.IWDF-row-111.685000000002963" maxlength="100" name="hs_name" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("EducationHistory.High School.records.IWDF-row-111.685000000002963", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
-->
<!--
										<li class="control-draggable control-child-wrapper" style="display: none ">
											<div id="IWDF-control-78" class="form-control field-control">
												<label for="EducationHistory.High School.records.IWDF-row-111.685000000029103" style="width:170px !important;" class="left">Most Recently Attended School</label>
												<input id="EducationHistory.High School.records.IWDF-row-111.685000000029103" name="most_recent" value="on" type="checkbox" />
											</div>
										</li>
										<li class="clear-float"></li>
-->
										<li class="control-draggable control-child-wrapper" style="float:right !important">
											<div id="IWDF-control-84" class="form-control field-control">
												<label for="EducationHistory.High School.records.IWDF-row-111.685000000002993" style="width:170px !important;" class="left">High School City</label>
												<input id="EducationHistory.High School.records.IWDF-row-111.685000000002993" maxlength="30" name="EducationHistory.High School.records.IWDF-row-111.685000000002993" value="" type="text" />
											<input type="hidden" name="hs_city" id="hs_city" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("EducationHistory.High School.records.IWDF-row-111.685000000002993", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-86" class="form-control field-control">
												<label for="EducationHistory.High School.records.IWDF-row-111.685000000131537" style="width:175px !important;" class="left">High School State</label>
												<select id="EducationHistory.High School.records.IWDF-row-111.685000000131537" name="EducationHistory.High School.records.IWDF-row-111.685000000131537">
													<option selected="selected" value=""></option>
													<option value="AA">AA</option>
													<option value="AB">AB</option>
													<option value="AE">AE</option>
													<option value="AK">AK</option>
													<option value="AL">AL</option>
													<option value="AP">AP</option>
													<option value="AR">AR</option>
													<option value="AS">AS</option>
													<option value="AZ">AZ</option>
													<option value="BC">BC</option>
													<option value="CA">CA</option>
													<option value="CNMI">CNMI</option>
													<option value="CO">CO</option>
													<option value="CT">CT</option>
													<option value="DC">DC</option>
													<option value="DE">DE</option>
													<option value="FL">FL</option>
													<option value="GA">GA</option>
													<option value="GU">GU</option>
													<option value="HI">HI</option>
													<option value="IA">IA</option>
													<option value="ID">ID</option>
													<option value="IL">IL</option>
													<option value="IN">IN</option>
													<option value="KS">KS</option>
													<option value="KY">KY</option>
													<option value="LA">LA</option>
													<option value="MA">MA</option>
													<option value="MB">MB</option>
													<option value="MD">MD</option>
													<option value="ME">ME</option>
													<option value="MH">MH</option>
													<option value="MI">MI</option>
													<option value="MN">MN</option>
													<option value="MO">MO</option>
													<option value="MS">MS</option>
													<option value="MT">MT</option>
													<option value="NB">NB</option>
													<option value="NC">NC</option>
													<option value="ND">ND</option>
													<option value="NE">NE</option>
													<option value="NF">NF</option>
													<option value="NH">NH</option>
													<option value="NJ">NJ</option>
													<option value="NM">NM</option>
													<option value="NS">NS</option>
													<option value="NT">NT</option>
													<option value="NV">NV</option>
													<option value="NY">NY</option>
													<option value="OH">OH</option>
													<option value="OK">OK</option>
													<option value="ON">ON</option>
													<option value="OR">OR</option>
													<option value="PA">PA</option>
													<option value="PE">PE</option>
													<option value="PQ">PQ</option>
													<option value="PR">PR</option>
													<option value="RI">RI</option>
													<option value="SC">SC</option>
													<option value="SD">SD</option>
													<option value="SK">SK</option>
													<option value="TN">TN</option>
													<option value="TX">TX</option>
													<option value="UT">UT</option>
													<option value="VA">VA</option>
													<option value="VI">VI</option>
													<option value="VT">VT</option>
													<option value="WA">WA</option>
													<option value="WI">WI</option>
													<option value="WV">WV</option>
													<option value="WY">WY</option>
													<option value="YT">YT</option>
												</select>
											<input type="hidden" name="hs_state" id="hs_state" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("EducationHistory.High School.records.IWDF-row-111.685000000131537", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
												<script type="text/javascript">
// <![CDATA[
_IW.FieldDep.addDependency("EducationHistory.High School.records.IWDF-row-111.685000000131537", "EducationHistory.High School.records.IWDF-row-111.685000000137015", {"":[""],"VT":["JMP"],"RI":["JMP"],"HI":["SRC"],"VI":["MLD"],"MH":["MLD"],"ME":["JMP"],"VA":["JAC"],"MI":["JMP"],"ID":["AFT"],"DE":["JAC"],"IA":["AED"],"MD":["JAC"],"MA":["JMP"],"MB":["MLD"],"AS":["MLD"],"AR":["AFT"],"IL":["AED"],"UT":["AFT"],"IN":["AED"],"MN":["AED"],"AZ":["AFT"],"MO":["AED"],"MT":["AFT"],"MS":["AED"],"NF":["MLD"],"AA":["MLD"],"NH":["JMP"],"AB":["MLD"],"NJ":["JAC"],"PQ":["MLD"],"AE":["MLD"],"PR":["MLD"],"NM":["AFT"],"AK":["SRC"],"AL":["AED"],"TX":["JAC"],"NB":["SRC"],"YT":["MLD"],"AP":["MLD"],"NC":["AED"],"ND":["AFT"],"NE":["AED"],"NY":[""],"GA":["AED"],"NV":["AFT"],"NT":["MLD"],"TN":["AED"],"NS":["MLD"],"CA":["AFT"],"ON":["SRC"],"OK":["AED"],"CNMI":["MLD"],"BC":["SRC"],"OH":["JMP"],"WY":["AFT"],"FL":["AED"],"SD":["AFT"],"SC":["AED"],"CT":["JMP"],"WV":["JAC"],"DC":["JAC"],"SK":["MLD"],"WI":["AED"],"KY":["AED"],"KS":["AED"],"OR":["SRC"],"LA":["JAC"],"GU":["MLD"],"WA":["SRC"],"PE":["SRC"],"CO":["AFT"],"PA":[""]});
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-88" class="form-control field-control">
												<label for="EducationHistory.High School.records.IWDF-row-111.685000000133093" style="width:175px !important;" class="left">High School Country (other than U.S.)</label>
												<select id="EducationHistory.High School.records.IWDF-row-111.685000000133093" name="EducationHistory.High School.records.IWDF-row-111.685000000133093">
													<option selected="selected" value=""></option>
													<option value="AFGHANISTAN">AFGHANISTAN</option>
													<option value="ALBANIA">ALBANIA</option>
													<option value="ALGERIA">ALGERIA</option>
													<option value="ANDORRA">ANDORRA</option>
													<option value="ANGOLA">ANGOLA</option>
													<option value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>
													<option value="ARGENTINA">ARGENTINA</option>
													<option value="ARMENIA">ARMENIA</option>
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
													<option value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>
													<option value="CHAD">CHAD</option>
													<option value="CHILE">CHILE</option>
													<option value="CHINA">CHINA</option>
													<option value="COLOMBIA">COLOMBIA</option>
													<option value="COMOROS">COMOROS</option>
													<option value="CONGO (BRAZZAVILLE)">CONGO (BRAZZAVILLE)</option>
													<option value="CONGO (KINSHASA)">CONGO (KINSHASA)</option>
													<option value="COSTA RICA">COSTA RICA</option>
													<option value="CÔTE D&#39;IVOIRE">CÔTE D&#39;IVOIRE</option>
													<option value="CROATIA">CROATIA</option>
													<option value="CUBA">CUBA</option>
													<option value="CYPRUS">CYPRUS</option>
													<option value="CZECH REPUBLIC">CZECH REPUBLIC</option>
													<option value="DENMARK">DENMARK</option>
													<option value="DJIBOUTI">DJIBOUTI</option>
													<option value="DOMINICA">DOMINICA</option>
													<option value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
													<option value="ECUADOR">ECUADOR</option>
													<option value="EGYPT">EGYPT</option>
													<option value="EL SALVADOR">EL SALVADOR</option>
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
													<option value="NORWAY">NORWAY</option>
													<option value="OMAN">OMAN</option>
													<option value="PAKISTAN">PAKISTAN</option>
													<option value="PALAU">PALAU</option>
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
													<option value="SENEGAL">SENEGAL</option>
													<option value="SERBIA">SERBIA</option>
													<option value="SEYCHELLES">SEYCHELLES</option>
													<option value="SIERRA LEONE">SIERRA LEONE</option>
													<option value="SINGAPORE">SINGAPORE</option>
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
													<option value="UNITED STATES">UNITED STATES</option>
													<option value="URUGUAY">URUGUAY</option>
													<option value="UZBEKISTAN">UZBEKISTAN</option>
													<option value="VANUATU">VANUATU</option>
													<option value="VENEZUELA">VENEZUELA</option>
													<option value="VIETNAM">VIETNAM</option>
													<option value="YEMEN">YEMEN</option>
													<option value="ZAMBIA">ZAMBIA</option>
													<option value="ZIMBABWE">ZIMBABWE</option>
												</select>
											<input type="hidden" name="hs_country" id="hs_country" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("EducationHistory.High School.records.IWDF-row-111.685000000133093", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-child-wrapper">
											<div id="IWDF-control-74-null" class="form-control page-child">
												<div id="IWDF-wrapper-109">
													<div id="IWDF-control-74-IWDF-row-111" sectiontitle="Education History" style="margin-bottom:10px;" class="form-control section-control">
														<div class="title clearfix">
															<span>Education History</span>
															<a style="display:inline;float:right;" class="right-link right-link" onclick="_IW.FormsRuntime.removeSection(&quot;IWDF-control-74-IWDF-row-111&quot;, &quot;IWDF-link-110&quot;)" href="javascript:void(0)">Remove Entry</a>
														</div>
														<ul class="control-child-helper control-draggable clearfix wide">
			
															<li class="control-draggable control-child-wrapper"></li>
															<li class="control-child-wrapper">
																<div id="IWDF-control-80" class="form-control hidden field-control">
																	<label for="EducationHistory.High School.records.IWDF-row-111.685000000131685" style="width:175px !important;" class="top">High School Type</label>
																	<select id="EducationHistory.High School.records.IWDF-row-111.685000000131685" name="hs_type" disabled="disabled">
																		<option selected="selected" value=""></option>
																		<option value="Public">Public</option>
																		<option value="Private">Private</option>
																		<option value="Parochial">Parochial</option>
																		<option value="Home">Home</option>
																		<option value="Home- Virtual or Correspondence">Home- Virtual or Correspondence</option>
																		<option value="Home School Association">Home School Association</option>
																	</select>
																</div>
															</li>
															<li class="control-child-wrapper">
																<div id="IWDF-control-82" class="form-control hidden field-control">
																	<label for="EducationHistory.High School.records.IWDF-row-111.685000000002975" style="width:175px !important;" class="top">CEEB Code</label>
																	<input id="EducationHistory.High School.records.IWDF-row-111.685000000002975" maxlength="10" name="ceeb" value="" type="text" readonly />
																</div>
															</li>
															<li class="control-child-wrapper">
																<div id="IWDF-control-90" class="form-control hidden field-control">
																	<label for="EducationHistory.High School.records.IWDF-row-111.685000000056005" style="width:16em;" class="top">Education Type</label>
																	<select id="EducationHistory.High School.records.IWDF-row-111.685000000056005" name="ed_type" disabled="disabled">
																		<option value=""></option>
																		<option selected="selected" value="High School">High School</option>
																		<option value="Certificate">Certificate</option>
																		<option value="Undergraduate">Undergraduate</option>
																		<option value="Graduate">Graduate</option>
																		<option value="Doctorate">Doctorate</option>
																	</select>
																</div>
															</li>
														</ul>
														<script type="text/javascript">
			// <![CDATA[
			_IW.InlineLookup.bind("EducationHistory.High School.records.IWDF-row-111.685000000002963", {"lookupType":"organizations","orgLookupFilter":["High School"]}, function(field, oneResult) { _IW.FormsRuntime.inlineLookupSelected(field, oneResult, "685000000002963"); }, { });
			// ]]>
			</script>
													</div>
												</div>
												<div style="text-align:right;">
													<a id="IWDF-link-110" style="display:none;font-weight:bold;" onclick="_IW.FormsRuntime.duplicateSection(&quot;IWDF-wrapper-109&quot;, &quot;EducationHistory.High School&quot;)" href="javascript:void(0)">Add Another Response</a>
												</div>
												<script type="text/javascript">
			// <![CDATA[
			_IW.FormsRuntime.setTemplate("EducationHistory.High School", "<div id=\"IWDF-control-74-RepeatingSectionControlMagicString\" sectionTitle=\"Education History\" style=\"margin-bottom:10px;\" class=\"form-control section-control\"><div class=\"title clearfix\"><span>Education History<\/span>\n<a style=\"display:inline;float:right;\" class=\"right-link\" onclick=\"_IW.FormsRuntime.removeSection(&quot;IWDF-control-74-RepeatingSectionControlMagicString&quot;, &quot;IWDF-link-110&quot;)\" href=\"javascript:void(0)\">Remove Entry<\/a>\n<\/div>\n<ul class=\"control-child-helper control-draggable clearfix wide\"><li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-76\" class=\"form-control field-control\"><label style=\"width:16em;\" class=\"dynamic-form-required top\">* High School Name<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\" maxlength=\"100\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\", \"notEmpty\", null, { trim: true, isReqFunc: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-78\" class=\"form-control field-control\"><label style=\"width:16em;\" class=\"top\">Most Recently Attended School<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000029103\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000029103\" value=\"on\" type=\"checkbox\"\/><\/div>\n<\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-84\" class=\"form-control field-control\"><label style=\"width:16em;\" class=\"top\">High School City<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002993\" maxlength=\"30\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002993\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002993\", \"notEmpty\", null, { trim: true, isReqFunc: true, disabled: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-86\" class=\"form-control field-control\"><label style=\"width:16em;\" class=\"top\">High School State<\/label>\n<select id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000131537\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000131537\"><option selected=\"selected\" value=\"\"><\/option>\n<option value=\"AA\">AA<\/option>\n<option value=\"AB\">AB<\/option>\n<option value=\"AE\">AE<\/option>\n<option value=\"AK\">AK<\/option>\n<option value=\"AL\">AL<\/option>\n<option value=\"AP\">AP<\/option>\n<option value=\"AR\">AR<\/option>\n<option value=\"AS\">AS<\/option>\n<option value=\"AZ\">AZ<\/option>\n<option value=\"BC\">BC<\/option>\n<option value=\"CA\">CA<\/option>\n<option value=\"CNMI\">CNMI<\/option>\n<option value=\"CO\">CO<\/option>\n<option value=\"CT\">CT<\/option>\n<option value=\"DC\">DC<\/option>\n<option value=\"DE\">DE<\/option>\n<option value=\"FL\">FL<\/option>\n<option value=\"GA\">GA<\/option>\n<option value=\"GU\">GU<\/option>\n<option value=\"HI\">HI<\/option>\n<option value=\"IA\">IA<\/option>\n<option value=\"ID\">ID<\/option>\n<option value=\"IL\">IL<\/option>\n<option value=\"IN\">IN<\/option>\n<option value=\"KS\">KS<\/option>\n<option value=\"KY\">KY<\/option>\n<option value=\"LA\">LA<\/option>\n<option value=\"MA\">MA<\/option>\n<option value=\"MB\">MB<\/option>\n<option value=\"MD\">MD<\/option>\n<option value=\"ME\">ME<\/option>\n<option value=\"MH\">MH<\/option>\n<option value=\"MI\">MI<\/option>\n<option value=\"MN\">MN<\/option>\n<option value=\"MO\">MO<\/option>\n<option value=\"MS\">MS<\/option>\n<option value=\"MT\">MT<\/option>\n<option value=\"NB\">NB<\/option>\n<option value=\"NC\">NC<\/option>\n<option value=\"ND\">ND<\/option>\n<option value=\"NE\">NE<\/option>\n<option value=\"NF\">NF<\/option>\n<option value=\"NH\">NH<\/option>\n<option value=\"NJ\">NJ<\/option>\n<option value=\"NM\">NM<\/option>\n<option value=\"NS\">NS<\/option>\n<option value=\"NT\">NT<\/option>\n<option value=\"NV\">NV<\/option>\n<option value=\"NY\">NY<\/option>\n<option value=\"OH\">OH<\/option>\n<option value=\"OK\">OK<\/option>\n<option value=\"ON\">ON<\/option>\n<option value=\"OR\">OR<\/option>\n<option value=\"PA\">PA<\/option>\n<option value=\"PE\">PE<\/option>\n<option value=\"PQ\">PQ<\/option>\n<option value=\"PR\">PR<\/option>\n<option value=\"RI\">RI<\/option>\n<option value=\"SC\">SC<\/option>\n<option value=\"SD\">SD<\/option>\n<option value=\"SK\">SK<\/option>\n<option value=\"TN\">TN<\/option>\n<option value=\"TX\">TX<\/option>\n<option value=\"UT\">UT<\/option>\n<option value=\"VA\">VA<\/option>\n<option value=\"VI\">VI<\/option>\n<option value=\"VT\">VT<\/option>\n<option value=\"WA\">WA<\/option>\n<option value=\"WI\">WI<\/option>\n<option value=\"WV\">WV<\/option>\n<option value=\"WY\">WY<\/option>\n<option value=\"YT\">YT<\/option>\n<\/select>\n<script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addSingleSelectValidator(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000131537\", \"Please select 1 item\", { isReqFunc: true, disabled: true });\n\/\/ ]]&gt;\n<\/script>\n<script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FieldDep.addDependency(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000131537\", \"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000137015\", {\"\":[\"\"],\"VT\":[\"JMP\"],\"RI\":[\"JMP\"],\"HI\":[\"SRC\"],\"VI\":[\"MLD\"],\"MH\":[\"MLD\"],\"ME\":[\"JMP\"],\"VA\":[\"JAC\"],\"MI\":[\"JMP\"],\"ID\":[\"AFT\"],\"DE\":[\"JAC\"],\"IA\":[\"AED\"],\"MD\":[\"JAC\"],\"MA\":[\"JMP\"],\"MB\":[\"MLD\"],\"AS\":[\"MLD\"],\"AR\":[\"AFT\"],\"IL\":[\"AED\"],\"UT\":[\"AFT\"],\"IN\":[\"AED\"],\"MN\":[\"AED\"],\"AZ\":[\"AFT\"],\"MO\":[\"AED\"],\"MT\":[\"AFT\"],\"MS\":[\"AED\"],\"NF\":[\"MLD\"],\"AA\":[\"MLD\"],\"NH\":[\"JMP\"],\"AB\":[\"MLD\"],\"NJ\":[\"JAC\"],\"PQ\":[\"MLD\"],\"AE\":[\"MLD\"],\"PR\":[\"MLD\"],\"NM\":[\"AFT\"],\"AK\":[\"SRC\"],\"AL\":[\"AED\"],\"TX\":[\"JAC\"],\"NB\":[\"SRC\"],\"YT\":[\"MLD\"],\"AP\":[\"MLD\"],\"NC\":[\"AED\"],\"ND\":[\"AFT\"],\"NE\":[\"AED\"],\"NY\":[\"\"],\"GA\":[\"AED\"],\"NV\":[\"AFT\"],\"NT\":[\"MLD\"],\"TN\":[\"AED\"],\"NS\":[\"MLD\"],\"CA\":[\"AFT\"],\"ON\":[\"SRC\"],\"OK\":[\"AED\"],\"CNMI\":[\"MLD\"],\"BC\":[\"SRC\"],\"OH\":[\"JMP\"],\"WY\":[\"AFT\"],\"FL\":[\"AED\"],\"SD\":[\"AFT\"],\"SC\":[\"AED\"],\"CT\":[\"JMP\"],\"WV\":[\"JAC\"],\"DC\":[\"JAC\"],\"SK\":[\"MLD\"],\"WI\":[\"AED\"],\"KY\":[\"AED\"],\"KS\":[\"AED\"],\"OR\":[\"SRC\"],\"LA\":[\"JAC\"],\"GU\":[\"MLD\"],\"WA\":[\"SRC\"],\"PE\":[\"SRC\"],\"CO\":[\"AFT\"],\"PA\":[\"\"]});\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-88\" class=\"form-control field-control\"><label style=\"width:16em;\" class=\"top\">High School Country (other than U.S.)<\/label>\n<select id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000133093\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000133093\"><option selected=\"selected\" value=\"\"><\/option>\n<option value=\"AFGHANISTAN\">AFGHANISTAN<\/option>\n<option value=\"ALBANIA\">ALBANIA<\/option>\n<option value=\"ALGERIA\">ALGERIA<\/option>\n<option value=\"ANDORRA\">ANDORRA<\/option>\n<option value=\"ANGOLA\">ANGOLA<\/option>\n<option value=\"ANTIGUA AND BARBUDA\">ANTIGUA AND BARBUDA<\/option>\n<option value=\"ARGENTINA\">ARGENTINA<\/option>\n<option value=\"ARMENIA\">ARMENIA<\/option>\n<option value=\"AUSTRALIA\">AUSTRALIA<\/option>\n<option value=\"AUSTRIA\">AUSTRIA<\/option>\n<option value=\"AZERBAIJAN\">AZERBAIJAN<\/option>\n<option value=\"BAHAMAS, THE\">BAHAMAS, THE<\/option>\n<option value=\"BAHRAIN\">BAHRAIN<\/option>\n<option value=\"BANGLADESH\">BANGLADESH<\/option>\n<option value=\"BARBADOS\">BARBADOS<\/option>\n<option value=\"BELARUS\">BELARUS<\/option>\n<option value=\"BELGIUM\">BELGIUM<\/option>\n<option value=\"BELIZE\">BELIZE<\/option>\n<option value=\"BENIN\">BENIN<\/option>\n<option value=\"BHUTAN\">BHUTAN<\/option>\n<option value=\"BOLIVIA\">BOLIVIA<\/option>\n<option value=\"BOSNIA AND HERZEGOVINA\">BOSNIA AND HERZEGOVINA<\/option>\n<option value=\"BOTSWANA\">BOTSWANA<\/option>\n<option value=\"BRAZIL\">BRAZIL<\/option>\n<option value=\"BRUNEI\">BRUNEI<\/option>\n<option value=\"BULGARIA\">BULGARIA<\/option>\n<option value=\"BURKINA FASO\">BURKINA FASO<\/option>\n<option value=\"BURMA\">BURMA<\/option>\n<option value=\"BURUNDI\">BURUNDI<\/option>\n<option value=\"CAMBODIA\">CAMBODIA<\/option>\n<option value=\"CAMEROON\">CAMEROON<\/option>\n<option value=\"CANADA\">CANADA<\/option>\n<option value=\"CAPE VERDE\">CAPE VERDE<\/option>\n<option value=\"CENTRAL AFRICAN REPUBLIC\">CENTRAL AFRICAN REPUBLIC<\/option>\n<option value=\"CHAD\">CHAD<\/option>\n<option value=\"CHILE\">CHILE<\/option>\n<option value=\"CHINA\">CHINA<\/option>\n<option value=\"COLOMBIA\">COLOMBIA<\/option>\n<option value=\"COMOROS\">COMOROS<\/option>\n<option value=\"CONGO (BRAZZAVILLE)\">CONGO (BRAZZAVILLE)<\/option>\n<option value=\"CONGO (KINSHASA)\">CONGO (KINSHASA)<\/option>\n<option value=\"COSTA RICA\">COSTA RICA<\/option>\n<option value=\"C&#212;TE D&#39;IVOIRE\">C&Ocirc;TE D\'IVOIRE<\/option>\n<option value=\"CROATIA\">CROATIA<\/option>\n<option value=\"CUBA\">CUBA<\/option>\n<option value=\"CYPRUS\">CYPRUS<\/option>\n<option value=\"CZECH REPUBLIC\">CZECH REPUBLIC<\/option>\n<option value=\"DENMARK\">DENMARK<\/option>\n<option value=\"DJIBOUTI\">DJIBOUTI<\/option>\n<option value=\"DOMINICA\">DOMINICA<\/option>\n<option value=\"DOMINICAN REPUBLIC\">DOMINICAN REPUBLIC<\/option>\n<option value=\"ECUADOR\">ECUADOR<\/option>\n<option value=\"EGYPT\">EGYPT<\/option>\n<option value=\"EL SALVADOR\">EL SALVADOR<\/option>\n<option value=\"EQUATORIAL GUINEA\">EQUATORIAL GUINEA<\/option>\n<option value=\"ERITREA\">ERITREA<\/option>\n<option value=\"ESTONIA\">ESTONIA<\/option>\n<option value=\"ETHIOPIA\">ETHIOPIA<\/option>\n<option value=\"FIJI\">FIJI<\/option>\n<option value=\"FINLAND\">FINLAND<\/option>\n<option value=\"FRANCE\">FRANCE<\/option>\n<option value=\"GABON\">GABON<\/option>\n<option value=\"GAMBIA, THE\">GAMBIA, THE<\/option>\n<option value=\"GEORGIA\">GEORGIA<\/option>\n<option value=\"GERMANY\">GERMANY<\/option>\n<option value=\"GHANA\">GHANA<\/option>\n<option value=\"GREECE\">GREECE<\/option>\n<option value=\"GRENADA\">GRENADA<\/option>\n<option value=\"GUATEMALA\">GUATEMALA<\/option>\n<option value=\"GUINEA\">GUINEA<\/option>\n<option value=\"GUINEA-BISSAU\">GUINEA-BISSAU<\/option>\n<option value=\"GUYANA\">GUYANA<\/option>\n<option value=\"HAITI\">HAITI<\/option>\n<option value=\"HOLY SEE\">HOLY SEE<\/option>\n<option value=\"HONDURAS\">HONDURAS<\/option>\n<option value=\"HUNGARY\">HUNGARY<\/option>\n<option value=\"ICELAND\">ICELAND<\/option>\n<option value=\"INDIA\">INDIA<\/option>\n<option value=\"INDONESIA\">INDONESIA<\/option>\n<option value=\"IRAN\">IRAN<\/option>\n<option value=\"IRAQ\">IRAQ<\/option>\n<option value=\"IRELAND\">IRELAND<\/option>\n<option value=\"ISRAEL\">ISRAEL<\/option>\n<option value=\"ITALY\">ITALY<\/option>\n<option value=\"JAMAICA\">JAMAICA<\/option>\n<option value=\"JAPAN\">JAPAN<\/option>\n<option value=\"JORDAN\">JORDAN<\/option>\n<option value=\"KAZAKHSTAN\">KAZAKHSTAN<\/option>\n<option value=\"KENYA\">KENYA<\/option>\n<option value=\"KIRIBATI\">KIRIBATI<\/option>\n<option value=\"KOREA, NORTH\">KOREA, NORTH<\/option>\n<option value=\"KOREA, SOUTH\">KOREA, SOUTH<\/option>\n<option value=\"KOSOVO\">KOSOVO<\/option>\n<option value=\"KUWAIT\">KUWAIT<\/option>\n<option value=\"KYRGYZSTAN\">KYRGYZSTAN<\/option>\n<option value=\"LAOS\">LAOS<\/option>\n<option value=\"LATVIA\">LATVIA<\/option>\n<option value=\"LEBANON\">LEBANON<\/option>\n<option value=\"LESOTHO\">LESOTHO<\/option>\n<option value=\"LIBERIA\">LIBERIA<\/option>\n<option value=\"LIBYA\">LIBYA<\/option>\n<option value=\"LIECHTENSTEIN\">LIECHTENSTEIN<\/option>\n<option value=\"LITHUANIA\">LITHUANIA<\/option>\n<option value=\"LUXEMBOURG\">LUXEMBOURG<\/option>\n<option value=\"MACEDONIA\">MACEDONIA<\/option>\n<option value=\"MADAGASCAR\">MADAGASCAR<\/option>\n<option value=\"MALAWI\">MALAWI<\/option>\n<option value=\"MALAYSIA\">MALAYSIA<\/option>\n<option value=\"MALDIVES\">MALDIVES<\/option>\n<option value=\"MALI\">MALI<\/option>\n<option value=\"MALTA\">MALTA<\/option>\n<option value=\"MARSHALL ISLANDS\">MARSHALL ISLANDS<\/option>\n<option value=\"MAURITANIA\">MAURITANIA<\/option>\n<option value=\"MAURITIUS\">MAURITIUS<\/option>\n<option value=\"MEXICO\">MEXICO<\/option>\n<option value=\"MICRONESIA\">MICRONESIA<\/option>\n<option value=\"MOLDOVA\">MOLDOVA<\/option>\n<option value=\"MONACO\">MONACO<\/option>\n<option value=\"MONGOLIA\">MONGOLIA<\/option>\n<option value=\"MONTENEGRO\">MONTENEGRO<\/option>\n<option value=\"MOROCCO\">MOROCCO<\/option>\n<option value=\"MOZAMBIQUE\">MOZAMBIQUE<\/option>\n<option value=\"NAMIBIA\">NAMIBIA<\/option>\n<option value=\"NAURU\">NAURU<\/option>\n<option value=\"NEPAL\">NEPAL<\/option>\n<option value=\"NETHERLANDS\">NETHERLANDS<\/option>\n<option value=\"NEW ZEALAND\">NEW ZEALAND<\/option>\n<option value=\"NICARAGUA\">NICARAGUA<\/option>\n<option value=\"NIGER\">NIGER<\/option>\n<option value=\"NIGERIA\">NIGERIA<\/option>\n<option value=\"NORWAY\">NORWAY<\/option>\n<option value=\"OMAN\">OMAN<\/option>\n<option value=\"PAKISTAN\">PAKISTAN<\/option>\n<option value=\"PALAU\">PALAU<\/option>\n<option value=\"PANAMA\">PANAMA<\/option>\n<option value=\"PAPUA NEW GUINEA\">PAPUA NEW GUINEA<\/option>\n<option value=\"PARAGUAY\">PARAGUAY<\/option>\n<option value=\"PERU\">PERU<\/option>\n<option value=\"PHILIPPINES\">PHILIPPINES<\/option>\n<option value=\"POLAND\">POLAND<\/option>\n<option value=\"PORTUGAL\">PORTUGAL<\/option>\n<option value=\"QATAR\">QATAR<\/option>\n<option value=\"ROMANIA\">ROMANIA<\/option>\n<option value=\"RUSSIA\">RUSSIA<\/option>\n<option value=\"RWANDA\">RWANDA<\/option>\n<option value=\"SAINT KITTS AND NEVIS\">SAINT KITTS AND NEVIS<\/option>\n<option value=\"SAINT LUCIA\">SAINT LUCIA<\/option>\n<option value=\"SAINT VINCENT AND THE GRENADINES\">SAINT VINCENT AND THE GRENADINES<\/option>\n<option value=\"SAMOA\">SAMOA<\/option>\n<option value=\"SAN MARINO\">SAN MARINO<\/option>\n<option value=\"SAO TOME AND PRINCIPE\">SAO TOME AND PRINCIPE<\/option>\n<option value=\"SAUDI ARABIA\">SAUDI ARABIA<\/option>\n<option value=\"SENEGAL\">SENEGAL<\/option>\n<option value=\"SERBIA\">SERBIA<\/option>\n<option value=\"SEYCHELLES\">SEYCHELLES<\/option>\n<option value=\"SIERRA LEONE\">SIERRA LEONE<\/option>\n<option value=\"SINGAPORE\">SINGAPORE<\/option>\n<option value=\"SLOVAKIA\">SLOVAKIA<\/option>\n<option value=\"SLOVENIA\">SLOVENIA<\/option>\n<option value=\"SOLOMON ISLANDS\">SOLOMON ISLANDS<\/option>\n<option value=\"SOMALIA\">SOMALIA<\/option>\n<option value=\"SOUTH AFRICA\">SOUTH AFRICA<\/option>\n<option value=\"SOUTH SUDAN\">SOUTH SUDAN<\/option>\n<option value=\"SPAIN\">SPAIN<\/option>\n<option value=\"SRI LANKA\">SRI LANKA<\/option>\n<option value=\"SUDAN\">SUDAN<\/option>\n<option value=\"SURINAME\">SURINAME<\/option>\n<option value=\"SWAZILAND\">SWAZILAND<\/option>\n<option value=\"SWEDEN\">SWEDEN<\/option>\n<option value=\"SWITZERLAND\">SWITZERLAND<\/option>\n<option value=\"SYRIA\">SYRIA<\/option>\n<option value=\"TAJIKISTAN\">TAJIKISTAN<\/option>\n<option value=\"TANZANIA\">TANZANIA<\/option>\n<option value=\"THAILAND\">THAILAND<\/option>\n<option value=\"TIMOR-LESTE\">TIMOR-LESTE<\/option>\n<option value=\"TOGO\">TOGO<\/option>\n<option value=\"TONGA\">TONGA<\/option>\n<option value=\"TRINIDAD AND TOBAGO\">TRINIDAD AND TOBAGO<\/option>\n<option value=\"TUNISIA\">TUNISIA<\/option>\n<option value=\"TURKEY\">TURKEY<\/option>\n<option value=\"TURKMENISTAN\">TURKMENISTAN<\/option>\n<option value=\"TUVALU\">TUVALU<\/option>\n<option value=\"UGANDA\">UGANDA<\/option>\n<option value=\"UKRAINE\">UKRAINE<\/option>\n<option value=\"UNITED ARAB EMIRATES\">UNITED ARAB EMIRATES<\/option>\n<option value=\"UNITED KINGDOM\">UNITED KINGDOM<\/option>\n<option value=\"UNITED STATES\">UNITED STATES<\/option>\n<option value=\"URUGUAY\">URUGUAY<\/option>\n<option value=\"UZBEKISTAN\">UZBEKISTAN<\/option>\n<option value=\"VANUATU\">VANUATU<\/option>\n<option value=\"VENEZUELA\">VENEZUELA<\/option>\n<option value=\"VIETNAM\">VIETNAM<\/option>\n<option value=\"YEMEN\">YEMEN<\/option>\n<option value=\"ZAMBIA\">ZAMBIA<\/option>\n<option value=\"ZIMBABWE\">ZIMBABWE<\/option>\n<\/select>\n<script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addSingleSelectValidator(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000133093\", \"Please select 1 item\", { isReqFunc: true, disabled: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-80\" class=\"form-control hidden field-control\"><label style=\"width:16em;\" class=\"top\">High School Type<\/label>\n<select id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000131685\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000131685\" disabled=\"disabled\"><option selected=\"selected\" value=\"\"><\/option>\n<option value=\"Public\">Public<\/option>\n<option value=\"Private\">Private<\/option>\n<option value=\"Parochial\">Parochial<\/option>\n<option value=\"Home\">Home<\/option>\n<option value=\"Home- Virtual or Correspondence\">Home- Virtual or Correspondence<\/option>\n<option value=\"Home School Association\">Home School Association<\/option>\n<\/select>\n<\/div>\n<\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-82\" class=\"form-control hidden field-control\"><label style=\"width:16em;\" class=\"top\">CEEB Code<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002975\" maxlength=\"10\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002975\" value=\"\" type=\"text\" readonly=\"readonly\"\/><\/div>\n<\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-90\" class=\"form-control hidden field-control\"><label style=\"width:16em;\" class=\"top\">Education Type<\/label>\n<select id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000056005\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000056005\" disabled=\"disabled\"><option value=\"\"><\/option>\n<option selected=\"selected\" value=\"High School\">High School<\/option>\n<option value=\"Certificate\">Certificate<\/option>\n<option value=\"Undergraduate\">Undergraduate<\/option>\n<option value=\"Graduate\">Graduate<\/option>\n<option value=\"Doctorate\">Doctorate<\/option>\n<\/select>\n<\/div>\n<\/li>\n<\/ul>\n<script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.InlineLookup.bind(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\", {\"lookupType\":\"organizations\",\"orgLookupFilter\":[\"High School\"]}, function(field, oneResult) { _IW.FormsRuntime.inlineLookupSelected(field, oneResult, \"685000000002963\"); }, { });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n");
			// ]]>
			</script>
												<input name="EducationHistory.High School.myType" value="High School" type="hidden" />
											</div>
										</li>
										<li class="control-child-wrapper">
											<div id="IWDF-control-30" class="form-control hidden field-control">
												<label for="Contacts.685000000130005" style="width:16em;" class="top">Country (FIPS) Code</label>
												<select id="Contacts.685000000130005" name="fips" disabled="disabled">
													<option selected="selected" value=""></option>
													<option value="AC">AC</option>
													<option value="AE">AE</option>
													<option value="AF">AF</option>
													<option value="AG">AG</option>
													<option value="AJ">AJ</option>
													<option value="AL">AL</option>
													<option value="AM">AM</option>
													<option value="AN">AN</option>
													<option value="AO">AO</option>
													<option value="AR">AR</option>
													<option value="AS">AS</option>
													<option value="AU">AU</option>
													<option value="BA">BA</option>
													<option value="BB">BB</option>
													<option value="BC">BC</option>
													<option value="BE">BE</option>
													<option value="BF">BF</option>
													<option value="BG">BG</option>
													<option value="BH">BH</option>
													<option value="BK">BK</option>
													<option value="BL">BL</option>
													<option value="BM">BM</option>
													<option value="BN">BN</option>
													<option value="BO">BO</option>
													<option value="BP">BP</option>
													<option value="BR">BR</option>
													<option value="BT">BT</option>
													<option value="BU">BU</option>
													<option value="BX">BX</option>
													<option value="BY">BY</option>
													<option value="CA">CA</option>
													<option value="CB">CB</option>
													<option value="CD">CD</option>
													<option value="CE">CE</option>
													<option value="CF">CF</option>
													<option value="CG">CG</option>
													<option value="CH">CH</option>
													<option value="CI">CI</option>
													<option value="CM">CM</option>
													<option value="CN">CN</option>
													<option value="CO">CO</option>
													<option value="CS">CS</option>
													<option value="CT">CT</option>
													<option value="CU">CU</option>
													<option value="CV">CV</option>
													<option value="CY">CY</option>
													<option value="DA">DA</option>
													<option value="DJ">DJ</option>
													<option value="DO">DO</option>
													<option value="DR">DR</option>
													<option value="EC">EC</option>
													<option value="EG">EG</option>
													<option value="EI">EI</option>
													<option value="EK">EK</option>
													<option value="EN">EN</option>
													<option value="ER">ER</option>
													<option value="ES">ES</option>
													<option value="ET">ET</option>
													<option value="EZ">EZ</option>
													<option value="FI">FI</option>
													<option value="FJ">FJ</option>
													<option value="FM">FM</option>
													<option value="FR">FR</option>
													<option value="GA">GA</option>
													<option value="GB">GB</option>
													<option value="GG">GG</option>
													<option value="GH">GH</option>
													<option value="GJ">GJ</option>
													<option value="GM">GM</option>
													<option value="GR">GR</option>
													<option value="GT">GT</option>
													<option value="GV">GV</option>
													<option value="GY">GY</option>
													<option value="HA">HA</option>
													<option value="HO">HO</option>
													<option value="HR">HR</option>
													<option value="HU">HU</option>
													<option value="IC">IC</option>
													<option value="ID">ID</option>
													<option value="IN">IN</option>
													<option value="IR">IR</option>
													<option value="IS">IS</option>
													<option value="IT">IT</option>
													<option value="IV">IV</option>
													<option value="IZ">IZ</option>
													<option value="JA">JA</option>
													<option value="JM">JM</option>
													<option value="JO">JO</option>
													<option value="KE">KE</option>
													<option value="KG">KG</option>
													<option value="KN">KN</option>
													<option value="KR">KR</option>
													<option value="KS">KS</option>
													<option value="KU">KU</option>
													<option value="KV">KV</option>
													<option value="KZ">KZ</option>
													<option value="LA">LA</option>
													<option value="LE">LE</option>
													<option value="LG">LG</option>
													<option value="LH">LH</option>
													<option value="LI">LI</option>
													<option value="LO">LO</option>
													<option value="LS">LS</option>
													<option value="LT">LT</option>
													<option value="LU">LU</option>
													<option value="LY">LY</option>
													<option value="MA">MA</option>
													<option value="MD">MD</option>
													<option value="MG">MG</option>
													<option value="MI">MI</option>
													<option value="MJ">MJ</option>
													<option value="MK">MK</option>
													<option value="ML">ML</option>
													<option value="MN">MN</option>
													<option value="MO">MO</option>
													<option value="MP">MP</option>
													<option value="MR">MR</option>
													<option value="MT">MT</option>
													<option value="MU">MU</option>
													<option value="MV">MV</option>
													<option value="MX">MX</option>
													<option value="MY">MY</option>
													<option value="MZ">MZ</option>
													<option value="NG">NG</option>
													<option value="NH">NH</option>
													<option value="NI">NI</option>
													<option value="NL">NL</option>
													<option value="NO">NO</option>
													<option value="NP">NP</option>
													<option value="NR">NR</option>
													<option value="NS">NS</option>
													<option value="NU">NU</option>
													<option value="NZ">NZ</option>
													<option value="OD">OD</option>
													<option value="PA">PA</option>
													<option value="PE">PE</option>
													<option value="PK">PK</option>
													<option value="PL">PL</option>
													<option value="PM">PM</option>
													<option value="PO">PO</option>
													<option value="PP">PP</option>
													<option value="PS">PS</option>
													<option value="PU">PU</option>
													<option value="QA">QA</option>
													<option value="RI">RI</option>
													<option value="RM">RM</option>
													<option value="RO">RO</option>
													<option value="RP">RP</option>
													<option value="RS">RS</option>
													<option value="RW">RW</option>
													<option value="SA">SA</option>
													<option value="SC">SC</option>
													<option value="SE">SE</option>
													<option value="SF">SF</option>
													<option value="SG">SG</option>
													<option value="SI">SI</option>
													<option value="SL">SL</option>
													<option value="SM">SM</option>
													<option value="SN">SN</option>
													<option value="SO">SO</option>
													<option value="SP">SP</option>
													<option value="ST">ST</option>
													<option value="SU">SU</option>
													<option value="SW">SW</option>
													<option value="SY">SY</option>
													<option value="SZ">SZ</option>
													<option value="TD">TD</option>
													<option value="TH">TH</option>
													<option value="TI">TI</option>
													<option value="TN">TN</option>
													<option value="TO">TO</option>
													<option value="TP">TP</option>
													<option value="TS">TS</option>
													<option value="TT">TT</option>
													<option value="TU">TU</option>
													<option value="TV">TV</option>
													<option value="TX">TX</option>
													<option value="TZ">TZ</option>
													<option value="UG">UG</option>
													<option value="UK">UK</option>
													<option value="UP">UP</option>
													<option value="US">US</option>
													<option value="UV">UV</option>
													<option value="UY">UY</option>
													<option value="UZ">UZ</option>
													<option value="VC">VC</option>
													<option value="VE">VE</option>
													<option value="VM">VM</option>
													<option value="VT">VT</option>
													<option value="WA">WA</option>
													<option value="WS">WS</option>
													<option value="WZ">WZ</option>
													<option value="YM">YM</option>
													<option value="ZA">ZA</option>
													<option value="ZI">ZI</option>
												</select>
											</div>
										</li>
										<li class="control-child-wrapper">
											<div id="IWDF-control-32" class="form-control hidden field-control">
												<label for="Contacts.685000000336031" style="width:16em;" class="top">Term Code</label>
												<select id="Contacts.685000000336031" name="term_code" disabled="disabled">
													<option selected="selected" value=""></option>
													<option value="201301">201301</option>
													<option value="201308">201308</option>
													<option value="201401">201401</option>
													<option value="201408">201408</option>
													<option value="201501">201501</option>
													<option value="201508">201508</option>
													<option value="201601">201601</option>
													<option value="201608">201608</option>
													<option value="201701">201701</option>
													<option value="201708">201708</option>
													<option value="201801">201801</option>
													<option value="201808">201808</option>
													<option value="201901">201901</option>
													<option value="201908">201908</option>
													<option value="202001">202001</option>
													<option value="202008">202008</option>
												</select>
											</div>
										</li>
										<li class="control-child-wrapper">
											<div id="IWDF-control-34" class="form-control hidden field-control">
												<label for="Contacts.685000000110319" style="width:16em;" class="top">Source-SBGI code</label>
												<select id="Contacts.685000000110319" name="sbgi" disabled="disabled">
													<option selected="selected" value=""></option>
													<option value="ADF">ADF</option>
													<option value="ADG">ADG</option>
													<option value="ADV">ADV</option>
													<option value="CTY">CTY</option>
													<option value="ECP">ECP</option>
													<option value="EMC">EMC</option>
													<option value="EPT">EPT</option>
													<option value="EVS">EVS</option>
													<option value="EZC">EZC</option>
													<option value="EZI">EZI</option>
													<option value="GAT">GAT</option>
													<option value="GBA">GBA</option>
													<option value="GCC">GCC</option>
													<option value="GEO">GEO</option>
													<option value="GMC">GMC</option>
													<option value="GPE">GPE</option>
													<option value="GPR">GPR</option>
													<option value="GUK">GUK</option>
													<option value="HSP">HSP</option>
													<option value="INF">INF</option>
													<option value="MDC">MDC</option>
													<option value="OCR">OCR</option>
													<option value="RAL">RAL</option>
													<option value="RBA">RBA</option>
													<option value="RBH">RBH</option>
													<option value="RCF">RCF</option>
													<option value="RCS">RCS</option>
													<option value="RFR">RFR</option>
													<option value="RFS">RFS</option>
													<option value="RGC">RGC</option>
													<option value="RIC">RIC</option>
													<option value="RPA">RPA</option>
													<option value="RPS">RPS</option>
													<option value="RTE">RTE</option>
													<option value="RUK">RUK</option>
													<option value="SCB">SCB</option>
													<option value="SCS">SCS</option>
													<option value="SCT">SCT</option>
													<option value="SDT">SDT</option>
													<option value="SGN">SGN</option>
													<option value="SNR">SNR</option>
													<option value="SPM">SPM</option>
													<option value="SRM">SRM</option>
													<option value="SVS">SVS</option>
													<option value="TCF">TCF</option>
													<option value="TCO">TCO</option>
													<option value="TOV">TOV</option>
													<option value="TSV">TSV</option>
													<option value="VIS">VIS</option>
													<option value="VSG">VSG</option>
													<option value="WWW">WWW</option>
													<option value="YWW">YWW</option>
												</select>
											</div>
										</li>
									</fieldset>
									<fieldset style="background:#fff; width: 316px !important; border-radius: 10px !important; min-height: 255px; float:right">
									  <legend>About You</legend>
										<li class="control-draggable control-child-wrapper" style="float: right;">
											<div id="IWDF-control-14" class="form-control field-control">
													<div style="float: right;" id="orderdateDiv">
													<label for="orderdateDiv" style="float: left !important; margin-top: 3px; width:75px  !important;" class="dynamic-form-required left">Date of Birth</label>
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
														</select>
												</div>


<!-- 
												<input id="Contacts.685000000003033" maxlength="100" name="Contacts.685000000003033" value="" type="text" />
-->
											</div>
										</li>
										<li class="control-draggable control-child-wrapper" style="float: right;">
											<div id="IWDF-control-10" class="form-control field-control">
												<label for="Contacts.685000000120167" style="width:16em;" class="left">Nickname (if any)</label>
												<input id="Contacts.685000000120167" maxlength="30" name="nickname" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000120167", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper" style="float: right;">
											<div id="IWDF-control-16" class="form-control field-control">
												<label for="Contacts.685000000003051" style="width:16em;" class="left">Gender</label>
												<select id="Contacts.685000000003051" name="gender">
													<option selected="selected" value=""></option>
													<option value="Female">Female</option>
													<option value="Male">Male</option>
													<option value="Not Specified">Not Specified</option>
												</select>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000003051", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper" style="float: right;">
											<div id="IWDF-control-42" class="form-control field-control">
												<label for="Contacts.685000000003049" style="width:16em;" class="left">Ethnicity</label>
												<select id="Contacts.685000000003049" name="ethnicity">
													<option selected="selected" value=""></option>
													<option value="African American, Black">African American, Black</option>
													<option value="American Indian, Alaska Native">American Indian, Alaska Native</option>
													<option value="Asian American">Asian American</option>
													<option value="Hispanic, Latino/a">Hispanic, Latino/a</option>
													<option value="Asian, incl. Indian Subcont.">Asian, incl. Indian Subcont.</option>
													<option value="Mexican American, Chicano/a">Mexican American, Chicano/a</option>
													<option value="Multiracial">Multiracial</option>
													<option value="Native Hawaiian, Pacific Isld.">Native Hawaiian, Pacific Isld.</option>
													<option value="Not Reported">Not Reported</option>
													<option value="Other">Other</option>
													<option value="Puerto Rican">Puerto Rican</option>
													<option value="Unknown">Unknown</option>
													<option value="White">White</option>
												</select>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000003049", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
												<script type="text/javascript">
// <![CDATA[
_IW.FieldDep.addDependency("Contacts.685000000003049", "Contacts.685000000358027", {"":[""],"Puerto Rican":["PR"],"Unknown":["UN"],"Multiracial":["MU"],"Other":["OT"],"African American, Black":[""],"Mexican American, Chicano/a":["MA"],"Not Reported":["NR"],"American Indian, Alaska Native":["AI"],"White":["WH"],"Asian American":["AS"],"Asian, incl. Indian Subcont.":["IS"],"Native Hawaiian, Pacific Isld.":["NH"],"Hispanic, Latino/a":["HS"]});
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-child-wrapper">
											<div id="IWDF-control-72" class="form-control hidden field-control">
												<label for="Contacts.685000000358027" style="width:16em;" class="top">Ethnicity Code</label>
												<select id="Contacts.685000000358027" name="eth_code" disabled="disabled">
													<option selected="selected" value=""></option>
													<option value="AF">AF</option>
													<option value="AI">AI</option>
													<option value="AS">AS</option>
													<option value="HS">HS</option>
													<option value="IS">IS</option>
													<option value="MA">MA</option>
													<option value="MU">MU</option>
													<option value="NH">NH</option>
													<option value="NR">NR</option>
													<option value="OT">OT</option>
													<option value="PR">PR</option>
													<option value="UN">UN</option>
													<option value="WH">WH</option>
												</select>
											</div>
										</li>
										<li class="page-child-wrapper" style=" margin-top: 0px !important; ">
											<div id="IWDF-control-92" sectiontitle="Source" class="form-control section-control page-child">
												<ul class="control-child-helper control-draggable clearfix wide">
													<li class="clear-float"></li>
													<li class="control-draggable control-child-wrapper"  style="float: right;">
														<div id="IWDF-control-94" class="form-control field-control">
															<label for="Contacts.685000000003013" style="width:16em;" class="left">How did you hear about us?</label>
															<select id="Contacts.685000000003013" name="how_heard">
																<option selected="selected" value=""></option>
																<option value="I got an email...">I got an email...</option>
																<option value="I received something in the mail...">I received something in the mail...</option>
																<option value="Online...">Online...</option>
																<option value="I saw it in a college guide...">I saw it in a college guide...</option>
																<option value="I know someone who knows the College...">I know someone who knows the College...</option>
																<option value="I met an admission counselor while they were traveling...">I met an admission counselor while they were traveling...</option>
																<option value="An ad for the College...">An ad for the College...</option>
																<option value="Other (please specify...)">Other (please specify...)</option>
															</select>
															<script type="text/javascript">
			// <![CDATA[
			_IW.FormValidator.addSingleSelectValidator("Contacts.685000000003013", "Please select 1 item", { isReqFunc: true, disabled: true });
			// ]]>
			</script>
															<script type="text/javascript">
			// <![CDATA[
			_IW.FieldDep.addDependency("Contacts.685000000003013", "Contacts.685000000155215", {"":[""],"I got an email...":[""],"I met an admission counselor while they were traveling...":["College fair","Conference","Club or organization visit","School visit","Other off-campus recruitment event"],"I received something in the mail...":[""],"Online...":["Facebook","Google Adwords","Web search (please specify...)","Cappex search tool","Peterson's search tool","My College Guide search tool","Venture Scholars search tool","Zinch search tool"],"Other (please specify...)":[""],"An ad for the College...":["Magazine","Newspaper","Radio","Facebook"],"I know someone who knows the College...":["Simon's Rock alumna/us","Current Simon's Rock student","Simon's Rock faculty/staff","Parent of a Simon's Rock student/alumnus","My guidance counselor","My teacher","Independent Consultant","My psychologist","At Bard","At BHSEC"],"I saw it in a college guide...":["Academically Talented","Barron's","Cool Colleges","Duke EOG","My College Guide","Peterson's","Princeton Review","Other guide (please specify...)"]});
			// ]]>
			</script>
														</div>
													</li>


												</ul>
											</div>

											<div id="IWDF-control-96" sectiontitle="Source 2" class="form-control section-control page-child">
												<ul class="control-child-helper control-draggable clearfix wide">
													<li class="clear-float"></li>
													<li class="control-draggable control-child-wrapper">
														<div id="IWDF-control-98" class="form-control field-control">
															<label for="Contacts.685000000155215" style="width:16em;" class="left">Tell us more about that...</label>
															<select id="Contacts.685000000155215" name="how_heard_more">
																<option selected="selected" value=""></option>
																<option value="Magazine">Magazine</option>
																<option value="Newspaper">Newspaper</option>
																<option value="Radio">Radio</option>
																<option value="Facebook">Facebook</option>
																<option value="Google Adwords">Google Adwords</option>
																<option value="Web search (please specify...)">Web search (please specify...)</option>
																<option value="Center for Talented Youth search tool">Center for Talented Youth search tool</option>
																<option value="Cappex search tool">Cappex search tool</option>
																<option value="Peterson&#39;s search tool">Peterson&#39;s search tool</option>
																<option value="My College Guide search tool">My College Guide search tool</option>
																<option value="Venture Scholars search tool">Venture Scholars search tool</option>
																<option value="Zinch search tool">Zinch search tool</option>
																<option value="Academically Talented">Academically Talented</option>
																<option value="Barron&#39;s">Barron&#39;s</option>
																<option value="Cool Colleges">Cool Colleges</option>
																<option value="Duke EOG">Duke EOG</option>
																<option value="My College Guide">My College Guide</option>
																<option value="Peterson&#39;s">Peterson&#39;s</option>
																<option value="Princeton Review">Princeton Review</option>
																<option value="Other guide (please specify...)">Other guide (please specify...)</option>
																<option value="Simon&#39;s Rock alumna/us">Simon&#39;s Rock alumna/us</option>
																<option value="Current Simon&#39;s Rock student">Current Simon&#39;s Rock student</option>
																<option value="Simon&#39;s Rock faculty/staff">Simon&#39;s Rock faculty/staff</option>
																<option value="Parent of a Simon&#39;s Rock student/alumnus">Parent of a Simon&#39;s Rock student/alumnus</option>
																<option value="My guidance counselor">My guidance counselor</option>
																<option value="My teacher">My teacher</option>
																<option value="Independent Consultant">Independent Consultant</option>
																<option value="My psychologist">My psychologist</option>
																<option value="At Bard">At Bard</option>
																<option value="At BHSEC">At BHSEC</option>
																<option value="Someone else (please specify)">Someone else (please specify)</option>
																<option value="College fair">College fair</option>
																<option value="Conference">Conference</option>
																<option value="Club or organization visit">Club or organization visit</option>
																<option value="School visit">School visit</option>
																<option value="Other off-campus recruitment event">Other off-campus recruitment event</option>
															</select>
															<script type="text/javascript">
			// <![CDATA[
			_IW.FormValidator.addSingleSelectValidator("Contacts.685000000155215", "Please select 1 item", { isReqFunc: true, disabled: true });
			// ]]>
			</script>
															<script type="text/javascript">
			// <![CDATA[
			_IW.FieldDep.addDependency("Contacts.685000000155215", "Contacts.685000000110319", {"":[""],"Zinch search tool":["EZI"],"Club or organization visit":["TOV"],"College fair":["TCF"],"Magazine":["ADV"],"Center for Talented Youth search tool":["CTY"],"Peterson's search tool":["EPT"],"Barron's":["GBA"],"Cool Colleges":["GCC"],"Other guide (please specify...)":["GUK"],"Web search (please specify...)":["WWW"],"Google Adwords":["ADG"],"My teacher":["RTE"],"My College Guide search tool":["EMC"],"Current Simon's Rock student":["RCS"],"Cappex search tool":["ECP"],"Radio":["ADV"],"Conference":["TCO"],"Venture Scholars search tool":["EVS"],"Princeton Review":["GPR"],"Other off-campus recruitment event":["OCR"],"My psychologist":["RPS"],"Peterson's":["GPE"],"Academically Talented":["GAT"],"Someone else (please specify)":["RUK"],"Independent Consultant":["RIC"],"At Bard":["RBA"],"At BHSEC":["RBH"],"Simon's Rock faculty/staff":["RFS"],"Parent of a Simon's Rock student/alumnus":["RPA"],"Facebook":["ADF"],"My guidance counselor":["RGC"],"Simon's Rock alumna/us":["RAL"],"My College Guide":["GMC"],"Newspaper":["ADV"],"Duke EOG":["GEO"],"School visit":["TSV"]});
			// ]]>
			</script>
														</div>
													</li>
												</ul>
												<script type="text/javascript">
			// <![CDATA[
			_IW.FieldDep.addConditionalDisplay("IWDF-control-96", {"criteria":[{"values":["Online...","I saw it in a college guide...","I know someone who knows the College...","I met an admission counselor while they were traveling...","An ad for the College..."],"htmlid":"Contacts.685000000003013","fieldid":"685000000003013"}],"match":"any"})
			// ]]>
			</script>
											</div>
											<div id="IWDF-control-100" sectiontitle="Source Other" class="form-control section-control page-child">
												<ul class="control-child-helper control-draggable clearfix wide">
													<li class="clear-float"></li>
													<li class="control-draggable control-child-wrapper">
														<div id="IWDF-control-102" class="form-control field-control">
															<label for="Contacts.685000000156005" style="width:16em;" class="left">Other (comment)</label>
															<input id="Contacts.685000000156005" maxlength="255" name="how_heard_other" value="" type="text" />
															<script type="text/javascript">
			// <![CDATA[
			_IW.FormValidator.addTextFieldValidator("Contacts.685000000156005", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
			// ]]>
			</script>
														</div>
													</li>
												</ul>
												<script type="text/javascript">
			// <![CDATA[
			_IW.FieldDep.addConditionalDisplay("IWDF-control-100", {"criteria":[{"values":["Other (please specify...)"],"htmlid":"Contacts.685000000003013","fieldid":"685000000003013"}],"match":"any"})
			// ]]>
			</script>
											</div>
										</li>
										<li class="page-child-wrapper" style="margin-top: 0px !important; width: 320px !important">
											<div id="IWDF-control-104" sectiontiegendtle="Case Comment" class="form-control section-control page-child">
												<ul class="control-child-helper control-draggable clearfix wide">
													<li class="clear-float"></li>
													<li class="control-draggable control-child-wrapper wide">
														<div id="IWDF-control-106" class="form-control field-control">
															<label for="Inquiries.Inquiry_Comment" style="width:80px !important;" class="left">Questions?</label>
															<textarea id="Inquiries.Inquiry_Comment" cols="5" style="resize: none; width:220px;vertical-align: top;" name="comment" rows="3"></textarea>
															<script style="width:100%;" type="text/javascript">
			// <![CDATA[
			_IW.FormValidator.addTextFieldValidator("Inquiries.Inquiry_Comment", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
			// ]]>
			</script>
														</div>
													</li>
												</ul>
											</div>
										</li>

									</fieldset>
									<li class="clear-float">&nbsp;</li>

									
									<div id="IWDF-control-20" class="form-control field-control" style="margin-left: 10px;margin-top: 10px;">
										<input type="checkbox" name="getParentInfo" id="getParentInfo" onclick="toggleDiv('parentDiv',this.checked)" />
										<label for="getParentInfo" style="width:90% !important; margin: 5px 0; font-size: 14px; font-weight: bold; text-align:left" class="left">Click here if you want us to send info to your parents about Simon's Rock</label>
									</div>
									<fieldset id="parentDiv" style="display:none; border-radius: 10px !important;background:#f4f4f4; height:auto">
									  <legend>About your parents</legend>
										<li class="clear-float"></li>

<!-- 									  <div class="pDiv"> -->
									  <fieldset style="background:#fff; width: 295px !important; border-radius: 10px !important; float:left; min-height: 255px;">
										<legend>Parent/Guardian 1</legend>


										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-44" class="form-control field-control">
												<label for="Contacts.685000000112007" style="width:155px !important;" class="left">First Name</label>
												<input id="Contacts.685000000112007" maxlength="16" name="parent1_fname" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000112007", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-46" class="form-control field-control">
												<label for="Contacts.685000000112009" style="width:155px !important;" class="left">Last Name</label>
												<input id="Contacts.685000000112009" maxlength="30" name="parent1_lname" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000112009", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-48" class="form-control field-control">
												<label for="Contacts.685000000121005" style="width:155px !important;" class="left">Relationship to you</label>
												<select id="Contacts.685000000121005" name="parent1_rel">
													<option selected="selected" value=""></option>
													<option value="Mother">Mother</option>
													<option value="Father">Father</option>
													<option value="Guardian/Other">Guardian/Other</option>
													<option value="Guardian">Guardian</option>
												</select>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000121005", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-50" class="form-control field-control">
												<input id="Contacts.685000000296104" name="parent1_reswith" value="on" type="checkbox" />
												<label for="Contacts.685000000296104" style="width:155px !important; color: #AB033A" >Check the box if this parent shares your address</label>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-52" class="form-control field-control">
												<label for="Contacts.685000000112005" style="width:155px !important;" class="left">Email</label>
												<input id="Contacts.685000000112005" maxlength="100" name="parent1_email" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000112005", "validEmail", null, { trim: true, emptyvalid: true });
// ]]>
</script>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000112005", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-54" class="form-control field-control">
												<label for="Contacts.685000000296102" style="width:155px !important;" class="left">Phone</label>
												<input id="Contacts.685000000296102" maxlength="20" name="parent1_phone" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000296102", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-56" class="form-control field-control">
												<label for="Contacts.685000000296092" style="width:155px !important;" class="left">Specify phone type</label>
												<select id="Contacts.685000000296092" name="parent1_phonetype">
													<option selected="selected" value=""></option>
													<option value="Home">Home</option>
													<option value="Cell">Cell</option>
													<option value="Business">Business</option>
												</select>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000296092", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>

								      </fieldset>
									  <fieldset style="background:#fff; width: 295px !important; border-radius: 10px !important; float:left; min-height: 255px;">
									  	<legend>Parent/Guardian 2</legend>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-58" class="form-control field-control">
												<label for="Contacts.685000000296108" style="width:155px !important;" class="left">First Name</label>
												<input id="Contacts.685000000296108" maxlength="16" name="parent2_fname" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000296108", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-60" class="form-control field-control">
												<label for="Contacts.685000000296106" style="width:155px !important;" class="left">Last Name</label>
												<input id="Contacts.685000000296106" maxlength="30" name="parent2_lname" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000296106", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-62" class="form-control field-control">
												<label for="Contacts.685000000296110" style="width:155px !important;" class="left">Relationship to you</label>
												<select id="Contacts.685000000296110" name="parent2_rel">
													<option selected="selected" value=""></option>
													<option value="Mother">Mother</option>
													<option value="Father">Father</option>
													<option value="Guardian/Other">Guardian/Other</option>
												</select>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000296110", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-64" class="form-control field-control">
												<input id="Contacts.685000000296120" name="parent2_reswith" value="on" type="checkbox" />
												<label for="Contacts.685000000296120" style="color: #AB033A">Check the box if this parent shares your address</label>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-66" class="form-control field-control">
												<label for="Contacts.685000000296122" style="width:155px !important;" class="left">Email</label>
												<input id="Contacts.685000000296122" maxlength="100" name="parent2_email" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000296122", "validEmail", null, { trim: true, emptyvalid: true });
// ]]>
</script>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000296122", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-68" class="form-control field-control">
												<label for="Contacts.685000000296124" style="width:155px !important;" class="left">Phone</label>
												<input id="Contacts.685000000296124" maxlength="20" name="parent2_phone" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000296124", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-70" class="form-control field-control">
												<label for="Contacts.685000000296126" style="width:155px !important;" class="left">Specify phone type</label>
												<select id="Contacts.685000000296126" name="parent2_phonetype">
													<option selected="selected" value=""></option>
													<option value="Home">Home</option>
													<option value="Cell">Cell</option>
													<option value="Business">Business</option>
												</select>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addSingleSelectValidator("Contacts.685000000296126", "Please select 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper"></li>
									   </fieldset>

									  </fieldset>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="form-action-bar bottom" style="text-align: center;">
				  <input id="EducationHistory.High School.records.IWDF-row-111.685000000029103" name="most_recent" value="on" type="hidden" />
				  <button type="submit" name="submit" id="submit" style="border: none; clear: both; margin-left: 0px; width: 188px; height: 35px; background: url(/admission/images/submit.png); cursor:pointer" onmouseover="this.style.background='url(/admission/images/submit-hover.png)'" onmouseout="this.style.background='url(/admission/images/submit.png)'"></button>
				</div>
			</form>
			<div style="display:none;"></div>
		</div>
		<script type="text/javascript">
// <![CDATA[

			jQuery(function() { _IW.FormsRuntime.bootstrap(112, "IWDF-dynamicform-107", 685000004068544, {".doc":true,".css":true,".qt":true,".xlsb":true,".html":true,".xlw":true,".xlsm":true,".xls":true,".csv":true,".eps":true,".xlt":true,".txt":true,".tif":true,".rar":true,".dotm":true,".htm":true,".wk2":true,".wk3":true,".movie":true,".dotx":true,".tiff":true,".wk1":true,".xml":true,".rm":true,".bmp":true,".potx":true,".png":true,".xlam":true,".ppam":true,".mpeg":true,".jpg":true,".zip":true,".dat":true,".pptx":true,".docx":true,".potm":true,".gif":true,".wav":true,".pptm":true,".jpeg":true,".swf":true,".docm":true,".xltx":true,".xltm":true,".mpg":true,".avi":true,".pdf":true,".moov":true,".ppsx":true,".wpd":true,".ppsm":true,".ppt":true,".ani":true,".mov":true,".rtf":true,".xlsx":true}, {"MultiPage":false,"RequiresLogin":false}); });
			jQuery(function() { _IW.InquiryFormRuntime.bootstrap(685000004068544); });
			jQuery(function() {
			var runtimeURL = _IW.FormsRuntime.getRuntimeURL();
			_IW.FormsRuntime.setRuntimeURL(serverURL + runtimeURL);
			_IW.FormsRuntime.setServerURL(serverURL);
			_IW.FormsRuntime.setRemoteAjax(true);
			});
		
// ]]>
</script>
<script>
function toggleDiv(theDiv,theVal){
	if(theVal){
		document.getElementById(theDiv).style.display = '';
	}
	else{
		document.getElementById(theDiv).style.display = 'none';
	}
}
function toggleCountryDiv(){
	document.getElementById('prefilledState').value = document.getElementById('Contacts.685000000123120').value; 
	if(document.getElementById('Contacts.685000000123120').value == "not applicable"){
		document.getElementById('countryLI').style.display = '';
	}
	else{
		document.getElementById('countryLI').style.display = 'none';
		document.getElementById('Contacts.685000000131001').value = '';
	}
}

function toggleAddressDiv(theVal){
	if(theVal){
		document.getElementById('streetLI').style.display = '';
		document.getElementById('street2LI').style.display = '';
		document.getElementById('cityLI').style.display = '';
		document.getElementById('prefilledStateLI').style.display = '';
		document.getElementById('zipLI').style.display = '';
	}
	else{
		document.getElementById('streetLI').style.display = 'none';
		document.getElementById('street2LI').style.display = 'none';
		document.getElementById('cityLI').style.display = 'none';
		document.getElementById('prefilledStateLI').style.display = 'none';
		document.getElementById('zipLI').style.display = 'none';
	}
	toggleCountryDiv()
}


function checkForm() {

	alert('test');
/*    var bgcolor
    var normal
    var rval
    highlight = "#ffcccc"
    normal = "#ffffff"
    rval = true
	fieldFocus = "";
	if (document.layers||document.getElementById||document.all) {
		<?php 
		if(in_array("fname",$requiredFields)){
		?>
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
		<?php 
		}	
		if(in_array("lname",$requiredFields)){
		?>
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
		<?php 
		}	
		if(in_array("email",$requiredFields)){
		?>
		
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
		<?php 
		}	
		if(in_array("phone",$requiredFields)){
		?>

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
		<?php 
		}	
		if(in_array("hs_gradyear",$requiredFields)){
		?>
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
		<?php 
		}	
		if(in_array("state",$requiredFields)){
		?>
		if (document.request.state.value.length == 0) {
            document.request.state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "state";
			}
		} 
		else {
            document.request.state.style.backgroundColor = normal
		}
		<?php 
		}	
		?>

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
*/
return false
}
</script>
<?
}
?>
	</body>
</html>
