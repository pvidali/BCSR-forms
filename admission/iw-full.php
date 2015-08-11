<?php
$ethnicity = $_REQUEST['REPLACE_ethnicity'];
$eth_code = $_REQUEST['REPLACE_eth_code'];
$hs_name =  str_replace("*","&",$_REQUEST['hs_name']);
if($_REQUEST['sbgi'] == ""){
	$sbgi = "WWW";
}
else {
	$sbgi = $_REQUEST['sbgi'];
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
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
<script>
// grab parent. values for this form, then submit it
function grabParentValues(){
	document.getElementById('Contacts.685000000003015').value = parent.document.getElementById('Contacts.685000000003015').value;
	document.getElementById('Contacts.685000000003017').value = parent.document.getElementById('Contacts.685000000003017').value;
	document.getElementById('Contacts.685000000120167').value = parent.document.getElementById('Contacts.685000000120167').value;
	document.getElementById('Contacts.685000000003021').value = parent.document.getElementById('Contacts.685000000003021').value;
	document.getElementById('Contacts.685000000003063').value = parent.document.getElementById('Contacts.685000000003063').value;
	document.getElementById('Contacts.685000000121961').value = parent.document.getElementById('Contacts.685000000121961').value;
	document.getElementById('Contacts.685000000003065').value = parent.document.getElementById('Contacts.685000000003065').value;
	document.getElementById('Contacts.685000000123120').value = parent.document.getElementById('Contacts.685000000123120').value;
	document.getElementById('Contacts.685000000155005').value = parent.document.getElementById('Contacts.685000000155005').value;
	document.getElementById('Contacts.685000000131001').value = parent.document.getElementById('Contacts.685000000131001').value;
	document.getElementById('Contacts.685000000003027').value = parent.document.getElementById('Contacts.685000000003027').value;
	document.getElementById('Contacts.685000000003031').value = parent.document.getElementById('Contacts.685000000003031').value;
	document.getElementById('Contacts.685000000003033').value = parent.document.getElementById('Contacts.685000000003033').value;
	document.getElementById('Contacts.685000000003051').value = parent.document.getElementById('Contacts.685000000003051').value;
	document.getElementById('Contacts.685000000110551').value = parent.document.getElementById('Contacts.685000000110551').value;
	document.getElementById('Contacts.685000000003049').value = parent.document.getElementById('Contacts.685000000003049').value;
	document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000002963').value = parent.document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000002963').value;
	document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000029103').value = parent.document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000029103').value;
	document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000002993').value = parent.document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000002993').value;
	document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000131537').value = parent.document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000131537').value;
	document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000133093').value = parent.document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000133093').value;
	document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000131685').value = parent.document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000131685').value;
	document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000002975').value = parent.document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000002975').value;
	document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000056005').value = parent.document.getElementById('EducationHistory.High School.records.IWDF-row-111.685000000056005').value;
	document.getElementById('EducationHistory.High School.myType').value = parent.document.getElementById('EducationHistory.High School.myType').value;
	document.getElementById('Contacts.685000000130005').value = parent.document.getElementById('Contacts.685000000130005').value;
	document.getElementById('Contacts.685000000336031').value = parent.document.getElementById('Contacts.685000000336031').value;
	document.getElementById('Contacts.685000000110319').value = parent.document.getElementById('Contacts.685000000110319').value;
	document.getElementById('Contacts.685000000358027').value = parent.document.getElementById('Contacts.685000000358027').value;
	document.getElementById('Contacts.685000000003013').value = parent.document.getElementById('Contacts.685000000003013').value;
	document.getElementById('Contacts.685000000155215').value = parent.document.getElementById('Contacts.685000000155215').value;
	document.getElementById('Contacts.685000000156005').value = parent.document.getElementById('Contacts.685000000156005').value;
	document.getElementById('Cases.685000000003279').value = parent.document.getElementById('Cases.685000000003279').value;
	document.getElementById('Contacts.685000000112007').value = parent.document.getElementById('Contacts.685000000112007').value;
	document.getElementById('Contacts.685000000112009').value = parent.document.getElementById('Contacts.685000000112009').value;
	document.getElementById('Contacts.685000000121005').value = parent.document.getElementById('Contacts.685000000121005').value;
	document.getElementById('Contacts.685000000296104').value = parent.document.getElementById('Contacts.685000000296104').value;
	document.getElementById('Contacts.685000000112005').value = parent.document.getElementById('Contacts.685000000112005').value;
	document.getElementById('Contacts.685000000296102').value = parent.document.getElementById('Contacts.685000000296102').value;
	document.getElementById('Contacts.685000000296092').value = parent.document.getElementById('Contacts.685000000296092').value;
	document.getElementById('Contacts.685000000296108').value = parent.document.getElementById('Contacts.685000000296108').value;
	document.getElementById('Contacts.685000000296106').value = parent.document.getElementById('Contacts.685000000296106').value;
	document.getElementById('Contacts.685000000296110').value = parent.document.getElementById('Contacts.685000000296110').value;
	document.getElementById('Contacts.685000000296120').value = parent.document.getElementById('Contacts.685000000296120').value;
	document.getElementById('Contacts.685000000296122').value = parent.document.getElementById('Contacts.685000000296122').value;
	document.getElementById('Contacts.685000000296124').value = parent.document.getElementById('Contacts.685000000296124').value;
	document.getElementById('Contacts.685000000296126').value = parent.document.getElementById('Contacts.685000000296126').value;

	_IW.FormsRuntime.submit(document.forms['iwsubmit']);
}
</script>
	</head>
 	<body onload="grabParentValues()"> 
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
	<iframe id="_dummy" style="display:none;" name="_dummy"></iframe>
	<form target="_dummy" name="iwsignup" action="javascript:void(0);">
		<input id="Contacts.685000000003015" name="Contacts.685000000003015" value="<?php echo($_REQUEST['fname']); ?>" type="hidden" />
		<input id="Contacts.685000000003017" name="Contacts.685000000003017" value="<?php echo($_REQUEST['lname']); ?>" type="hidden" />
		<input id="Contacts.685000000120167" name="Contacts.685000000120167" value="<?php echo($_REQUEST['nickname']); ?>" type="hidden" />
 		<input id="Contacts.685000000003021" name="Contacts.685000000003021" value="<?php echo($_REQUEST['email']); ?>" type="hidden" />
 		<input id="Contacts.685000000003063" name="Contacts.685000000003063" value="<?php echo($_REQUEST['street']); ?>" type="hidden" />
 		<input id="Contacts.685000000121961" name="Contacts.685000000121961" value="<?php echo($_REQUEST['street2']); ?>" type="hidden" />
 		<input id="Contacts.685000000003065" name="Contacts.685000000003065" value="<?php echo($_REQUEST['city']); ?>" type="hidden" />
 		<input id="Contacts.685000000123120" name="Contacts.685000000123120" value="<?php echo($_REQUEST['state']); ?>" type="hidden" />
 		<input id="Contacts.685000000155005" name="Contacts.685000000155005" value="<?php echo($_REQUEST['zip']); ?>" type="hidden" />
 		<input id="Contacts.685000000131001" name="Contacts.685000000131001" value="<?php echo($_REQUEST['country']); ?>" type="hidden" />
 		<input id="Contacts.685000000003027" name="Contacts.685000000003027" value="<?php echo($_REQUEST['home_phone']); ?>" type="hidden" />
 		<input id="Contacts.685000000003031" name="Contacts.685000000003031" value="<?php echo($_REQUEST['mobile_phone']); ?>" type="hidden" />
 		<input id="Contacts.685000000003033" name="Contacts.685000000003033" value="<?php echo($_REQUEST['dob_m']."/".$_REQUEST['dob_d']."/".$_REQUEST['dob_y']); ?>" type="hidden" />
 		<input id="Contacts.685000000003051" name="Contacts.685000000003051" value="<?php echo($_REQUEST['gender']); ?>" type="hidden" />
 		<input id="Contacts.685000000110551" name="Contacts.685000000110551" value="<?php echo($_REQUEST['grad_year']); ?>" type="hidden" />
 		<input id="Contacts.685000000003049" name="Contacts.685000000003049" value="<?php echo($ethnicity); ?>" type="hidden" />
 		<input id="EducationHistory.High School.records.IWDF-row-111.685000000002963" name="EducationHistory.High School.records.IWDF-row-111.685000000002963" value="<?php echo($hs_name); ?>" type="hidden" />
 		<input id="EducationHistory.High School.records.IWDF-row-111.685000000029103" name="EducationHistory.High School.records.IWDF-row-111.685000000029103" value="<?php echo($_REQUEST['most_recent']); ?>" type="hidden" />
 		<input id="EducationHistory.High School.records.IWDF-row-111.685000000002993" name="EducationHistory.High School.records.IWDF-row-111.685000000002993" value="<?php echo($_REQUEST['hs_city']); ?>" type="hidden" />
 		<input id="EducationHistory.High School.records.IWDF-row-111.685000000131537" name="EducationHistory.High School.records.IWDF-row-111.685000000131537" value="<?php echo($_REQUEST['hs_state']); ?>" type="hidden" />
 		<input id="EducationHistory.High School.records.IWDF-row-111.685000000133093" name="EducationHistory.High School.records.IWDF-row-111.685000000133093" value="<?php echo($_REQUEST['hs_country']); ?>" type="hidden" />
 		<input id="EducationHistory.High School.records.IWDF-row-111.685000000131685" name="EducationHistory.High School.records.IWDF-row-111.685000000131685" value="<?php echo($_REQUEST['hs_type']); ?>" type="hidden" />
 		<input id="EducationHistory.High School.records.IWDF-row-111.685000000002975" name="EducationHistory.High School.records.IWDF-row-111.685000000002975" value="<?php echo($_REQUEST['ceeb']); ?>" type="hidden" />
 		<input id="EducationHistory.High School.records.IWDF-row-111.685000000056005" name="EducationHistory.High School.records.IWDF-row-111.685000000056005" value="<?php echo($_REQUEST['ed_type']); ?>" type="hidden" />
		<input id="EducationHistory.High School.myType" name="EducationHistory.High School.myType" value="High School" type="hidden" />
 		<input id="Contacts.685000000130005" name="Contacts.685000000130005" value="<?php echo($_REQUEST['fips']); ?>" type="hidden" />
 		<input id="Contacts.685000000336031" name="Contacts.685000000336031" value="<?php echo($_REQUEST['term_code']); ?>" type="hidden" />
 		<input id="Contacts.685000000110319" name="Contacts.685000000110319" value="<?php echo($sbgi); ?>" type="hidden" />
 		<input id="Contacts.685000000358027" name="Contacts.685000000358027" value="<?php echo($eth_code); ?>" type="hidden" />
 		<input id="Contacts.685000000003013" name="Contacts.685000000003013" value="<?php echo($_REQUEST['how_heard']); ?>" type="hidden" />
 		<input id="Contacts.685000000155215" name="Contacts.685000000155215" value="<?php echo($_REQUEST['how_heard_more']); ?>" type="hidden" />
 		<input id="Contacts.685000000156005" name="Contacts.685000000156005" value="<?php echo($_REQUEST['how_heard_other']); ?>" type="hidden" />
 		<input id="Cases.685000000003279" name="Cases.685000000003279" value="<?php echo($_REQUEST['comment']); ?>" type="hidden" />
 		<input id="Contacts.685000000112007" name="Contacts.685000000112007" value="<?php echo($_REQUEST['parent1_fname']); ?>" type="hidden" />
 		<input id="Contacts.685000000112009" name="Contacts.685000000112009" value="<?php echo($_REQUEST['parent1_lname']); ?>" type="hidden" />
 		<input id="Contacts.685000000121005" name="Contacts.685000000121005" value="<?php echo($_REQUEST['parent1_rel']); ?>" type="hidden" />
 		<input id="Contacts.685000000296104" name="Contacts.685000000296104" value="<?php echo($_REQUEST['parent1_reswith']); ?>" type="hidden" />
 		<input id="Contacts.685000000112005" name="Contacts.685000000112005" value="<?php echo($_REQUEST['parent1_email']); ?>" type="hidden" />
 		<input id="Contacts.685000000296102" name="Contacts.685000000296102" value="<?php echo($_REQUEST['parent1_phone']); ?>" type="hidden" />
 		<input id="Contacts.685000000296092" name="Contacts.685000000296092" value="<?php echo($_REQUEST['parent1_phonetype']); ?>" type="hidden" />
 		<input id="Contacts.685000000296108" name="Contacts.685000000296108" value="<?php echo($_REQUEST['parent2_fname']); ?>" type="hidden" />
 		<input id="Contacts.685000000296106" name="Contacts.685000000296106" value="<?php echo($_REQUEST['parent2_lname']); ?>" type="hidden" />
 		<input id="Contacts.685000000296110" name="Contacts.685000000296110" value="<?php echo($_REQUEST['parent2_rel']); ?>" type="hidden" />
 		<input id="Contacts.685000000296120" name="Contacts.685000000296120" value="<?php echo($_REQUEST['parent2_reswith']); ?>" type="hidden" />
 		<input id="Contacts.685000000296122" name="Contacts.685000000296122" value="<?php echo($_REQUEST['parent2_email']); ?>" type="hidden" />
 		<input id="Contacts.685000000296124" name="Contacts.685000000296124" value="<?php echo($_REQUEST['parent2_phone']); ?>" type="hidden" />
 		<input id="Contacts.685000000296126" name="Contacts.685000000296126" value="<?php echo($_REQUEST['parent2_phonetype']); ?>" type="hidden" />
<!--
		<input id="Contacts.685000000121545" name="Contacts.685000000121545" value="<?php echo($_REQUEST['acadInterests']); ?>" type="hidden" />
		<input id="Contacts.685000000121649" name="Contacts.685000000121649" value="<?php echo($_REQUEST['extraInterests']); ?>" type="hidden" />
		<input id="Contacts.685000000121543" name="Contacts.685000000121543" value="<?php echo($_REQUEST['otherInterests']); ?>" type="hidden" />
		<button class="submit fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.submit(this.form);" type="button">Submit</button>
-->		<button class="submit fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.submit(this.form);" type="button">Submit</button>
	</form>
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
	</body>
</html>
