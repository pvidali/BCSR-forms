<?php 
if(isset($_POST['submit'])){
	print_r($_POST);
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
var _runtimeURL = "<?php echo($_SERVER['PHP_SELF']);?>";
// ]]>
</script>
		<script src="https://crm.orionondemand.com/crm/javascript/inquiryformruntime.js" type="text/javascript"></script>
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


function checkIt(frm){

	_IW.FormsRuntime.submit(frm);
//	_IW.FormsRuntime.submit(this.form);

}
		
// ]]>
</script>
		<div id="form-wrapper" class="ui-tabs-left">
			<div id="form-header">
				<div style="text-align: center;">Simons Rock</div>
			</div>
			<iframe id="_dummy" style="display:none;" name="_dummy"></iframe>
			<form target="_dummy" action="<?php echo($_SERVER['PHP_SELF']);?>" name="inq" onsubmit="return checkIt(this.form)" method="post">
<!--			<form target="_dummy" action="javascript:void(0);">
-->
				<div id="IWDF-dynamicform-19" class="dynamicFormDefaults clearfix">
					<ul>
						<li>
							<a href="#IWDF-page-20">Untitled Page</a>
						</li>
					</ul>
					<div id="IWDF-page-20">
						<div class="dynamic-form-required legend">* = Required Field</div>
						<ul class="page-child-helper">
							<li class="page-child-wrapper first">
								<div id="IWDF-control-4" sectiontitle="Untitled Section" class="form-control section-control page-child first">
									<div class="title clearfix">
										<span>Untitled Section</span>
									</div>
									<ul class="control-child-helper control-draggable clearfix wide">
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-6" class="form-control field-control">
												<label style="width:15em;" class="dynamic-form-required top">* Your First Name</label>
												<input id="Contacts.685000000003015" maxlength="40" style="width:15em;" name="Contacts.685000000003015" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003015", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
												<p style="width:15em;" class="note">Please use proper capitilization</p>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control">
												<label class="dynamic-form-required top">* Last Name</label>
												<input id="Contacts.685000000003017" maxlength="80" name="Contacts.685000000003017" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003017", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
									</ul>
								</div>
							</li>
							<li class="page-child-wrapper">
								<div id="IWDF-control-10-null" class="form-control page-child">
									<div id="IWDF-wrapper-21">
										<div id="IWDF-control-10-IWDF-row-23" sectiontitle="School History" style="margin-bottom:10px;" class="form-control section-control">
											<div class="title clearfix">
												<span>School History</span>
												<a style="display:inline;float:right;" class="right-link right-link" onclick="_IW.FormsRuntime.removeSection(&quot;IWDF-control-10-IWDF-row-23&quot;, &quot;IWDF-link-22&quot;)" href="javascript:void(0)">Remove Entry</a>
											</div>
											<ul class="control-child-helper control-draggable clearfix wide">
												<li class="control-draggable control-child-wrapper">
													<div id="IWDF-control-12" class="form-control field-control">
														<label style="width:10em;" class="dynamic-form-required top">* High School Name</label>
														<input id="EducationHistory.High School.records.IWDF-row-23.685000000002963" maxlength="100" name="EducationHistory.High School.records.IWDF-row-23.685000000002963" value="" type="text" />
														<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("EducationHistory.High School.records.IWDF-row-23.685000000002963", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
													</div>
												</li>
												<li class="control-draggable control-child-wrapper">
													<div id="IWDF-control-14" class="form-control field-control">
														<label class="top">Most Recently Attended School</label>
														<input id="EducationHistory.High School.records.IWDF-row-23.685000000029103" name="EducationHistory.High School.records.IWDF-row-23.685000000029103" value="on" type="checkbox" />
													</div>
												</li>
												<li class="clear-float"></li>
												<li class="control-draggable control-child-wrapper"></li>
												<li class="clear-float"></li>
												<li class="control-draggable control-child-wrapper"></li>
												<li class="control-child-wrapper">
													<div id="IWDF-control-16" class="form-control hidden field-control">
														<label class="top">CEEB Code</label>
														<input id="EducationHistory.High School.records.IWDF-row-23.685000000002975" maxlength="10" name="EducationHistory.High School.records.IWDF-row-23.685000000002975" value="" type="text" readonly="readonly" />
													</div>
												</li>
												<li class="control-child-wrapper">
													<div id="IWDF-control-18" class="form-control hidden field-control">
														<label class="top">Education Type</label>
														<select id="EducationHistory.High School.records.IWDF-row-23.685000000056005" name="EducationHistory.High School.records.IWDF-row-23.685000000056005" disabled="disabled">
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
_IW.InlineLookup.bind("EducationHistory.High School.records.IWDF-row-23.685000000002963", {"lookupType":"organizations","orgLookupFilter":["High School"]}, function(field, oneResult) { _IW.FormsRuntime.inlineLookupSelected(field, oneResult, "685000000002963"); }, { });
// ]]>
</script>
										</div>
									</div>
									<div style="text-align:right;">
										<a id="IWDF-link-22" style="display:inline;font-weight:bold;" onclick="_IW.FormsRuntime.duplicateSection(&quot;IWDF-wrapper-21&quot;, &quot;EducationHistory.High School&quot;)" href="javascript:void(0)">Add Another Response</a>
									</div>
									<script type="text/javascript">
// <![CDATA[
_IW.FormsRuntime.setTemplate("EducationHistory.High School", "<div id=\"IWDF-control-10-RepeatingSectionControlMagicString\" sectionTitle=\"School History\" style=\"margin-bottom:10px;\" class=\"form-control section-control\"><div class=\"title clearfix\"><span>School History<\/span>\n<a style=\"display:inline;float:right;\" class=\"right-link\" onclick=\"_IW.FormsRuntime.removeSection(&quot;IWDF-control-10-RepeatingSectionControlMagicString&quot;, &quot;IWDF-link-22&quot;)\" href=\"javascript:void(0)\">Remove Entry<\/a>\n<\/div>\n<ul class=\"control-child-helper control-draggable clearfix wide\"><li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-12\" class=\"form-control field-control\"><label style=\"width:10em;\" class=\"dynamic-form-required top\">* High School Name<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\" maxlength=\"100\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\", \"notEmpty\", null, { trim: true, isReqFunc: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-14\" class=\"form-control field-control\"><label class=\"top\">Most Recently Attended School<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000029103\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000029103\" value=\"on\" type=\"checkbox\"\/><\/div>\n<\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-16\" class=\"form-control hidden field-control\"><label class=\"top\">CEEB Code<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002975\" maxlength=\"10\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002975\" value=\"\" type=\"text\" readonly=\"readonly\"\/><\/div>\n<\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-18\" class=\"form-control hidden field-control\"><label class=\"top\">Education Type<\/label>\n<select id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000056005\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000056005\" disabled=\"disabled\"><option value=\"\"><\/option>\n<option selected=\"selected\" value=\"High School\">High School<\/option>\n<option value=\"Certificate\">Certificate<\/option>\n<option value=\"Undergraduate\">Undergraduate<\/option>\n<option value=\"Graduate\">Graduate<\/option>\n<option value=\"Doctorate\">Doctorate<\/option>\n<\/select>\n<\/div>\n<\/li>\n<\/ul>\n<script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.InlineLookup.bind(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\", {\"lookupType\":\"organizations\",\"orgLookupFilter\":[\"High School\"]}, function(field, oneResult) { _IW.FormsRuntime.inlineLookupSelected(field, oneResult, \"685000000002963\"); }, { });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n");
// ]]>
</script>
									<input name="EducationHistory.High School.myType" value="High School" type="hidden" />
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="form-action-bar bottom">
					<div class="left-buttons">
						<button class="previous-page first last fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.prevpage(this.form, true);" type="button">Previous</button>
					</div>
					<div class="right-buttons">
						<button class="next-page first last fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.nextpage(this.form, true);" type="button">Next</button>
					</div>
					<div class="middle-buttons">
						<input type="submit" class="fg-button ui-state-default ui-corner-all" >Submit</button>
<!-- 						<button class="submit fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.submit(this.form);" type="button">Submit</button>
-->
					</div>
				</div>
			</form>
			<div style="display:none;"></div>
		</div>
		<script type="text/javascript">
// <![CDATA[

			jQuery(function() { _IW.FormsRuntime.bootstrap(24, "IWDF-dynamicform-19", 685000000110077, {".doc":true,".css":true,".qt":true,".xlsb":true,".html":true,".xlw":true,".xlsm":true,".xls":true,".csv":true,".eps":true,".xlt":true,".txt":true,".tif":true,".rar":true,".dotm":true,".htm":true,".wk2":true,".wk3":true,".movie":true,".dotx":true,".tiff":true,".wk1":true,".xml":true,".rm":true,".bmp":true,".potx":true,".png":true,".xlam":true,".ppam":true,".mpeg":true,".jpg":true,".zip":true,".dat":true,".pptx":true,".docx":true,".potm":true,".gif":true,".wav":true,".pptm":true,".jpeg":true,".swf":true,".docm":true,".xltx":true,".xltm":true,".mpg":true,".avi":true,".pdf":true,".moov":true,".ppsx":true,".wpd":true,".ppsm":true,".ppt":true,".ani":true,".mov":true,".rtf":true,".xlsx":true}, {"MultiPage":false,"RequiresLogin":false}); });
			jQuery(function() { _IW.InquiryFormRuntime.bootstrap(685000000110077); });
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
