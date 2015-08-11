<?php
$stdt_lname = $_REQUEST['stdt_lname'];
$stdt_eml	= $_REQUEST['stdt_eml'];
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

<style>
body{
	background: #ccc;
	margin: 0px !important;
	padding: 0px !important;
}
#form-wrapper{
	border-right: 1px solid;
	border-left: 1px solid;
	border-bottom: 1px solid;
	padding: 10px !important;
	background: #fff;
	padding-top: 0px  !important;

}
legend{
	font-size: 15px;
	font-weight: bold;
}
fieldset{
	background: #F4F4F4;
	border-radius: 10px !important;
	margin-bottom: 10px;
}
div.section-control{
	border: none !important;
}
.field-control input, .field-control select{
	border: solid 1px #AACFE4 !important;
	width: 10em !important;
	font-size: 11px !important;
	min-width: 1em !important;
}
.field-control select{
	min-width: 114px !important;
}
span.note {font-style: italic}
.field-control label{
	width: 10em;
	max-width:290px;
}
body{
	background: #ccc;
	margin-top: 0px !important;
	margin: 0px !important;
	padding: 0px !important;
	font-family: Arial, Helvetica, Verdana, sans-serif;
}
#topDiv{
	margin: auto;
	width: 900px;
	background: #fff;
	border-left: 1px solid;
	border-right: 1px solid;
	padding: 0 11px;
}
.dynamic-form-required{
	color: #000 !important;
}
.ifbox{
	float: left; 
	width: 420px;
	height: auto;
	border: 1px solid #ccc;
	margin-right: 5px;
	padding: 5px;
}
</style>
<script>
function checkUploadStatus() {
	var x=document.getElementById("uploadFrame");
	var y=(x.contentWindow || x.contentDocument);
	if (y.document)y=y.document;
	// y.body.style.backgroundColor="#0000ff";
	str = y.location.href;
	var n = str.indexOf("upload-report.php");
	if (n == "-1"){
		return true;
	}
	else{
		return false;
	}
}
function disp_confirm(theForm) {
	if(!checkUploadStatus()){
		alert("The recommendation upload is required.");
		return false
	}
	else {
		_IW.FormsRuntime.submit(theForm);
	}
}
</script>
<script src="/js/valid-email.js"></script>
	</head>
	<body>
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
    <div id="topDiv">
        <img src="/admission/images/secondary_wide_no_tagline.jpg" style="width: 904px; margin-top: 10px;" />
            <span>Bard College at Simon's Rock is a selective, private, nondenominational, coeducational college of the liberal arts and sciences specifically designed to offer bright, highly motivated students the opportunity to begin college after the tenth or eleventh grade.  We appreciate your frank and detailed account of the candidate. <br />
            <br />
            Enter your information below, then upload the Secondary School Report, and your evaluation.  If you are able, please also upload the applicant's official transcript, including courses in progress, a school profile, grading scale, and transcript legend.</span>
    </div>
		<div id="form-wrapper" class="ui-tabs-left">
			<iframe id="_dummy" style="display:none;" name="_dummy"></iframe>
			<form target="_dummy" action="javascript:void(0);">
				<div id="IWDF-dynamicform-33" class="dynamicFormDefaults clearfix">
					<ul>
						<li>
							<a href="#IWDF-page-34">Untitled Page</a>
						</li>
					</ul>
					<div id="IWDF-page-34">
						<div class="dynamic-form-required legend">* = Required Field</div>
						<ul class="page-child-helper">
							<li class="page-child-wrapper first">
								<div id="IWDF-control-4" sectiontitle="Your Information" class="form-control section-control page-child first">
									<div class="title clearfix">
										<span>Your Information</span>
									</div>
									<ul class="control-child-helper control-draggable clearfix wide">
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-6" class="form-control field-control">
												<label class="dynamic-form-required top">* Last Name</label>
												<input id="Contacts.685000000003017" maxlength="80" name="Contacts.685000000003017" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003017", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control">
												<label class="dynamic-form-required top">* First Name</label>
												<input id="Contacts.685000000003015" maxlength="40" name="Contacts.685000000003015" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003015", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-10" class="form-control field-control">
												<label class="dynamic-form-required top">* Email</label>
												<input id="Contacts.685000000003021" maxlength="100" name="Contacts.685000000003021" value="" type="text" onblur="return echeck(this.value,this.id)" />
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
											<div id="IWDF-control-12" class="form-control field-control">
												<label class="dynamic-form-required top">* Work Phone</label>
												<input id="Contacts.685000007210339" maxlength="17" name="Contacts.685000007210339" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000007210339", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-14" class="form-control field-control">
												<label style="width:30em;" class="dynamic-form-required top">* Full name of the student you are recommending</label>
												<textarea id="Cases.685000000003279" cols="40" name="Cases.685000000003279" rows="1"></textarea>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Cases.685000000003279", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
									</ul>
								</div>
							</li>
							<li class="page-child-wrapper">
								<div id="IWDF-control-16-null" class="form-control page-child">
									<div id="IWDF-wrapper-35">
										<div id="IWDF-control-16-IWDF-row-37" sectiontitle="Experience" style="margin-bottom:10px;" class="form-control section-control">
											<div class="title clearfix hidden" style="display:none;">
												<span>Experience</span>
												<a style="display:none;float:right;" class="right-link right-link" onclick="_IW.FormsRuntime.removeSection(&quot;IWDF-control-16-IWDF-row-37&quot;, &quot;IWDF-link-36&quot;)" href="javascript:void(0)">Remove Entry</a>
											</div>
											<ul class="control-child-helper control-draggable clearfix wide">
												<li class="control-draggable control-child-wrapper">
													<div id="IWDF-control-18" class="form-control field-control">
														<label class="dynamic-form-required top">* School Name</label>
														<input id="Experience.-None-.records.IWDF-row-37.685000000002963" maxlength="100" name="Experience.-None-.records.IWDF-row-37.685000000002963" value="" type="text" />
														<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Experience.-None-.records.IWDF-row-37.685000000002963", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
													</div>
												</li>
												<li class="control-draggable control-child-wrapper" style="display:none">
													<div id="IWDF-control-20" class="form-control field-control">
														<label class="top">CEEB Code</label>
														<input id="Experience.-None-.records.IWDF-row-37.685000000002975" maxlength="10" name="Experience.-None-.records.IWDF-row-37.685000000002975" value="" type="text" />
														<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Experience.-None-.records.IWDF-row-37.685000000002975", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
													</div>
												</li>
												<li class="control-draggable control-child-wrapper">
													<div id="IWDF-control-22" class="form-control field-control">
														<label class="dynamic-form-required top">* Title/Position</label>
														<input id="Experience.-None-.records.IWDF-row-37.685000000063013" maxlength="255" name="Experience.-None-.records.IWDF-row-37.685000000063013" value="" type="text" />
														<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Experience.-None-.records.IWDF-row-37.685000000063013", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
													</div>
												</li>
												<li class="control-draggable control-child-wrapper"></li>
												<li class="control-child-wrapper">
													<div id="IWDF-control-24" class="form-control hidden field-control">
														<label style="width:30em;" class="dynamic-form-required top">* Please decribe your affiliation with this school.</label>
														<select id="Experience.-None-.records.IWDF-row-37.685000000057003" name="Experience.-None-.records.IWDF-row-37.685000000057003" disabled="disabled">
															<option value=""></option>
															<option selected="selected" value="Employment">Employment</option>
															<option value="Voluntary Work">Voluntary Work</option>
															<option value="Internship">Internship</option>
															<option value="Part Time Work">Part Time Work</option>
														</select>
													</div>
												</li>
											</ul>
											<script type="text/javascript">
// <![CDATA[
_IW.InlineLookup.bind("Experience.-None-.records.IWDF-row-37.685000000002963", {"lookupType":"organizations","orgLookupFilter":[]}, function(field, oneResult) { _IW.FormsRuntime.inlineLookupSelected(field, oneResult, "685000000002963"); }, { });
// ]]>
</script>
										</div>
									</div>
									<div style="text-align:right; display:none">
										<a id="IWDF-link-36" style="display:inline;font-weight:bold;" onclick="_IW.FormsRuntime.duplicateSection(&quot;IWDF-wrapper-35&quot;, &quot;Experience.-None-&quot;)" href="javascript:void(0)">Add Another Response</a>
									</div>
									<script type="text/javascript">
// <![CDATA[
_IW.FormsRuntime.setTemplate("Experience.-None-", "<div id=\"IWDF-control-16-RepeatingSectionControlMagicString\" sectionTitle=\"Experience\" style=\"margin-bottom:10px;\" class=\"form-control section-control\"><div class=\"title clearfix\"><span>Experience<\/span>\n<a style=\"display:inline;float:right;\" class=\"right-link\" onclick=\"_IW.FormsRuntime.removeSection(&quot;IWDF-control-16-RepeatingSectionControlMagicString&quot;, &quot;IWDF-link-36&quot;)\" href=\"javascript:void(0)\">Remove Entry<\/a>\n<\/div>\n<ul class=\"control-child-helper control-draggable clearfix wide\"><li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-18\" class=\"form-control field-control\"><label class=\"dynamic-form-required top\">* School Name<\/label>\n<input id=\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000002963\" maxlength=\"100\" name=\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000002963\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000002963\", \"notEmpty\", null, { trim: true, isReqFunc: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-20\" class=\"form-control field-control\"><label class=\"top\">CEEB Code<\/label>\n<input id=\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000002975\" maxlength=\"10\" name=\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000002975\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000002975\", \"notEmpty\", null, { trim: true, isReqFunc: true, disabled: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-22\" class=\"form-control field-control\"><label class=\"top\">Title\/Position<\/label>\n<input id=\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000063013\" maxlength=\"255\" name=\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000063013\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000063013\", \"notEmpty\", null, { trim: true, isReqFunc: true, disabled: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-24\" class=\"form-control hidden field-control\"><label style=\"width:30em;\" class=\"dynamic-form-required top\">* Please decribe your affiliation with this school.<\/label>\n<select id=\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000057003\" name=\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000057003\" disabled=\"disabled\"><option value=\"\"><\/option>\n<option selected=\"selected\" value=\"Employment\">Employment<\/option>\n<option value=\"Voluntary Work\">Voluntary Work<\/option>\n<option value=\"Internship\">Internship<\/option>\n<option value=\"Part Time Work\">Part Time Work<\/option>\n<\/select>\n<\/div>\n<\/li>\n<\/ul>\n<script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.InlineLookup.bind(\"Experience.-None-.records.RepeatingSectionControlMagicString.685000000002963\", {\"lookupType\":\"organizations\",\"orgLookupFilter\":[]}, function(field, oneResult) { _IW.FormsRuntime.inlineLookupSelected(field, oneResult, \"685000000002963\"); }, { });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n");
// ]]>
</script>
									<input name="Experience.-None-.myType" value="-None-" type="hidden" />
								</div>
							</li>
							<li class="page-child-wrapper" style="display:none">
								<div id="IWDF-control-27-null" class="form-control page-child">
									<div id="IWDF-wrapper-38">
										<div id="IWDF-control-27-IWDF-row-40" sectiontitle="Connections" style="margin-bottom:10px;" class="form-control section-control">
											<div class="title clearfix">
												<span>Connections</span>
												<a style="display:inline;float:right;" class="right-link right-link" onclick="_IW.FormsRuntime.removeSection(&quot;IWDF-control-27-IWDF-row-40&quot;, &quot;IWDF-link-39&quot;)" href="javascript:void(0)">Remove Entry</a>
											</div>
											<ul class="control-child-helper control-draggable clearfix wide">
												<li class="clear-float"></li>
												<li class="control-draggable control-child-wrapper">
													<div id="IWDF-control-29" class="form-control field-control">
														<label class="dynamic-form-required top">* Last Name</label>
														<input id="Connections.Advisor to Student.records.IWDF-row-40.685000000003017" maxlength="80" name="Connections.Advisor to Student.records.IWDF-row-40.685000000003017" value="<?php echo ($stdt_lname);?>" type="text" />
														<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Connections.Advisor to Student.records.IWDF-row-40.685000000003017", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
													</div>
												</li>
												<li class="control-draggable control-child-wrapper">
													<div id="IWDF-control-31" class="form-control field-control">
														<label class="top">Email</label>
														<input id="Connections.Advisor to Student.records.IWDF-row-40.685000000003021" maxlength="100" name="Connections.Advisor to Student.records.IWDF-row-40.685000000003021" value="<?php echo ($stdt_eml);?>" type="text" />
														<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Connections.Advisor to Student.records.IWDF-row-40.685000000003021", "validEmail", null, { trim: true, emptyvalid: true });
// ]]>
</script>
														<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Connections.Advisor to Student.records.IWDF-row-40.685000000003021", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
													</div>
												</li>
												<li class="clear-float"></li>
												<li class="control-draggable control-child-wrapper"></li>
												<li class="control-child-wrapper">
													<div id="IWDF-control-32" class="form-control hidden field-control">
														<label class="top">Connection Type</label>
														<select id="Connections.Advisor to Student.records.IWDF-row-40.685000000029363" name="Connections.Advisor to Student.records.IWDF-row-40.685000000029363" disabled="disabled">
															<option value=""></option>
															<option value="Parent to Child">Parent to Child</option>
															<option value="Child to Parent">Child to Parent</option>
															<option value="Sibling to Sibling">Sibling to Sibling</option>
															<option value="Friend to Friend">Friend to Friend</option>
															<option value="Emergency Contact to Emergency Contact">Emergency Contact to Emergency Contact</option>
															<option value="Colleague to Colleague">Colleague to Colleague</option>
															<option value="Spouse to Spouse">Spouse to Spouse</option>
															<option value="Guardian to Dependant">Guardian to Dependant</option>
															<option value="Dependant to Guardian">Dependant to Guardian</option>
															<option value="Parent to Parent">Parent to Parent</option>
															<option value="Teacher to Student">Teacher to Student</option>
															<option value="Advisor to Student" selected="selected">Advisor to Student</option>
														</select>
													</div>
												</li>
											</ul>
										</div>
									</div>
									<div style="text-align:right; display:none">
										<a id="IWDF-link-39" style="display:inline;font-weight:bold;" onclick="_IW.FormsRuntime.duplicateSection(&quot;IWDF-wrapper-38&quot;, &quot;Connections.Teacher to Student&quot;)" href="javascript:void(0)">Add Another Response</a>
									</div>
									<script type="text/javascript">
// <![CDATA[
_IW.FormsRuntime.setTemplate("Connections.Teacher to Student", "<div id=\"IWDF-control-27-RepeatingSectionControlMagicString\" sectionTitle=\"Connections\" style=\"margin-bottom:10px;\" class=\"form-control section-control\"><div class=\"title clearfix\"><span>Connections<\/span>\n<a style=\"display:inline;float:right;\" class=\"right-link\" onclick=\"_IW.FormsRuntime.removeSection(&quot;IWDF-control-27-RepeatingSectionControlMagicString&quot;, &quot;IWDF-link-39&quot;)\" href=\"javascript:void(0)\">Remove Entry<\/a>\n<\/div>\n<ul class=\"control-child-helper control-draggable clearfix wide\"><li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-29\" class=\"form-control field-control\"><label class=\"dynamic-form-required top\">* Last Name<\/label>\n<input id=\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000003017\" maxlength=\"80\" name=\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000003017\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000003017\", \"notEmpty\", null, { trim: true, isReqFunc: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-31\" class=\"form-control field-control\"><label class=\"top\">Email<\/label>\n<input id=\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000003021\" maxlength=\"100\" name=\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000003021\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000003021\", \"validEmail\", null, { trim: true, emptyvalid: true });\n\/\/ ]]&gt;\n<\/script>\n<script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000003021\", \"notEmpty\", null, { trim: true, isReqFunc: true, disabled: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-32\" class=\"form-control hidden field-control\"><label class=\"top\">Connection Type<\/label>\n<select id=\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000029363\" name=\"Connections.Teacher to Student.records.RepeatingSectionControlMagicString.685000000029363\" disabled=\"disabled\"><option value=\"\"><\/option>\n<option value=\"Parent to Child\">Parent to Child<\/option>\n<option value=\"Child to Parent\">Child to Parent<\/option>\n<option value=\"Sibling to Sibling\">Sibling to Sibling<\/option>\n<option value=\"Friend to Friend\">Friend to Friend<\/option>\n<option value=\"Emergency Contact to Emergency Contact\">Emergency Contact to Emergency Contact<\/option>\n<option value=\"Colleague to Colleague\">Colleague to Colleague<\/option>\n<option value=\"Spouse to Spouse\">Spouse to Spouse<\/option>\n<option value=\"Guardian to Dependant\">Guardian to Dependant<\/option>\n<option value=\"Dependant to Guardian\">Dependant to Guardian<\/option>\n<option value=\"Parent to Parent\">Parent to Parent<\/option>\n<option selected=\"selected\" value=\"Teacher to Student\">Teacher to Student<\/option>\n<option value=\"Advisor to Student\">Advisor to Student<\/option>\n<\/select>\n<\/div>\n<\/li>\n<\/ul>\n<\/div>\n");
// ]]>
</script>
									<input name="Connections.Teacher to Student.myType" value="Teacher to Student" type="hidden" />
								</div>
							</li>
						</ul>
					</div>
				</div>
				<fieldset>
                    <legend>Uploads</legend>
                    <p><strong>If you have not already completed the Secondary School Report, please first check the email that directed you to this page for instructions.</strong></p>
                    <div style="width:880px; height:300px">
                    	<div class="ifbox">
							<iframe name="uploadFrame" id="uploadFrame"   src="upload-report.php?stdt_lname=<?php echo($stdt_lname); ?>&stdt_eml=<?php echo($stdt_eml); ?>" frameborder="0" height="215" scrolling="no" width="450"></iframe>
                        </div>
                    	<div class="ifbox">
		        			<iframe name="uploadFrame2" id="uploadFrame2" src="upload-transcript.php?stdt_lname=<?php echo($stdt_lname); ?>&stdt_eml=<?php echo($stdt_eml); ?>" frameborder="0" height="215" scrolling="no" width="450"></iframe>
                        </div>
					</div>
			    </fieldset>
				<div class="form-action-bar bottom">
					<div class="left-buttons">
						<button class="previous-page first last fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.prevpage(this.form, true);" type="button">Previous</button>
					</div>
					<div class="right-buttons">
						<button class="next-page first last fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.nextpage(this.form, true);" type="button">Next</button>
					</div>
					<div class="middle-buttons">
						<button style="padding: 10px; font-size: 1.5em; font-weight: bold; border: 2px solid;" class="submit fg-button ui-state-default ui-corner-all" onclick="disp_confirm(this.form);" type="button">Submit</button>
					</div>
				</div>
			</form>
			<div style="display:none;"></div>
		</div>
		<script type="text/javascript">
// <![CDATA[

			jQuery(function() { _IW.FormsRuntime.bootstrap(41, "IWDF-dynamicform-33", 685000007621304, {".doc":true,".css":true,".qt":true,".xlsb":true,".html":true,".xlw":true,".xlsm":true,".xls":true,".csv":true,".eps":true,".xlt":true,".txt":true,".tif":true,".rar":true,".dotm":true,".htm":true,".wk2":true,".wk3":true,".movie":true,".dotx":true,".tiff":true,".wk1":true,".xml":true,".rm":true,".bmp":true,".potx":true,".png":true,".xlam":true,".ppam":true,".mpeg":true,".jpg":true,".zip":true,".dat":true,".pptx":true,".docx":true,".potm":true,".gif":true,".wav":true,".pptm":true,".jpeg":true,".swf":true,".docm":true,".xltx":true,".xltm":true,".mpg":true,".avi":true,".pdf":true,".moov":true,".ppsx":true,".wpd":true,".ppsm":true,".ppt":true,".ani":true,".mov":true,".rtf":true,".xlsx":true}, {"MultiPage":false,"RequiresLogin":false}); });
			jQuery(function() { _IW.InquiryFormRuntime.bootstrap(685000007621304); });
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
