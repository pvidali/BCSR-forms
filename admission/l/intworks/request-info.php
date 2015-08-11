<div style="display: <?php echo($form1Display); ?>">
	<div id="righttop">Request More Information Below
		<hr style="width:325px;" align="center" />
	</div>

	<div id="stylized" class="myform" >

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
		<div id="form-wrapper" style="padding-left:0;margin-right:auto;width:430px;margin-left:auto;" class="ui-tabs-left">
			<div id="form-header" style="width:430px; display: none">
				<div style="text-align: center;">Simons Rock</div>
			</div>
			<iframe id="_dummy" style="display:none;" name="_dummy"></iframe>
			<form target="_dummy" action="javascript:void(0);">
				<div id="IWDF-dynamicform-39" class="dynamicFormDefaults clearfix">
					<ul>
						<li>
							<a href="#IWDF-page-40">Untitled Page</a>
						</li>
					</ul>
					<div id="IWDF-page-40">
						<div class="dynamic-form-required legend">* = Required Field</div>
						<ul class="page-child-helper">
							<li class="page-child-wrapper first">
								<div id="IWDF-control-4" sectiontitle="Student Information" class="form-control section-control page-child first">
									<div class="title clearfix">
										<span>Student Information</span>
									</div>
									<ul class="control-child-helper control-draggable clearfix wide">
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-6" class="form-control field-control">
												<label style="width:15em;" class="dynamic-form-required left">* Student First Name</label>
												<input id="Contacts.685000000003015" maxlength="40" style="width:14em;" name="Contacts.685000000003015" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003015", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control">
												<label style="width:15em;" class="dynamic-form-required left">* Student Last Name</label>
												<input id="Contacts.685000000003017" maxlength="80" style="width:14em;" name="Contacts.685000000003017" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003017", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-10" class="form-control field-control">
												<label style="width:15em;" class="left">Gender</label>
												<select id="Contacts.685000000003051" style="width:14em;" name="Contacts.685000000003051">
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
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-12" class="form-control field-control">
												<label style="width:15em;" class="dynamic-form-required left">* Street Address</label>
												<input id="Contacts.685000000003063" maxlength="250" style="width:14em;" name="Contacts.685000000003063" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003063", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-14" class="form-control field-control">
												<label style="width:15em;" class="dynamic-form-required left">* City</label>
												<input id="Contacts.685000000003065" maxlength="30" style="width:14em;" name="Contacts.685000000003065" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003065", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-16" class="form-control field-control">
												<label style="width:15em;" class="dynamic-form-required left">* State/Province</label>
												<input id="Contacts.685000000003069" maxlength="30" style="width:14em;" name="Contacts.685000000003069" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003069", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-18" class="form-control field-control">
												<label style="width:15em;" class="dynamic-form-required left">* Zip/Postal Code</label>
												<input id="Contacts.685000000003067" maxlength="30" style="width:14em;" name="Contacts.685000000003067" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003067", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-20" class="form-control field-control">
												<label style="width:15em;" class="left">Country</label>
												<input id="Contacts.685000000003071" maxlength="30" style="width:14em;" name="Contacts.685000000003071" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003071", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-22" class="form-control field-control">
												<label style="width:15em;" class="dynamic-form-required left">* Student E-mail</label>
												<input id="Contacts.685000000003021" maxlength="100" style="width:14em;" name="Contacts.685000000003021" value="" type="text" />
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
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-24" class="form-control field-control">
												<label style="width:15em;" class="left">Phone</label>
												<input id="Contacts.685000000003027" maxlength="50" style="width:14em;" name="Contacts.685000000003027" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003027", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-26" class="form-control field-control">
												<label style="width:15em;" class="left">Date of Birth</label>
												<input id="Contacts.685000000003033" maxlength="100" style="width:14em;" name="Contacts.685000000003033" value="" type="text" />
												<br />
												<span style="color:rgb(0, 0, 0); float: right">[mm/dd/yyyy]</span>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003033", "validDate", "Please enter a valid date [mm/dd/yyyy]", { compareTo: "MM/dd/yyyy", trim: true, emptyvalid: true });
// ]]>
</script>
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003033", "notEmpty", null, { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
									</ul>
								</div>
							</li>
							<li class="page-child-wrapper">
								<div id="IWDF-control-28-null" class="form-control page-child">
									<div id="IWDF-wrapper-41">
										<div id="IWDF-control-28-IWDF-row-43" sectiontitle="School History" style="margin-bottom:10px;" class="form-control section-control">
											<div class="title clearfix">
												<span>School History</span>
												<a style="display:inline;float:right;" class="right-link right-link" onclick="_IW.FormsRuntime.removeSection(&quot;IWDF-control-28-IWDF-row-43&quot;, &quot;IWDF-link-42&quot;)" href="javascript:void(0)">Remove Entry</a>
											</div>
											<ul class="control-child-helper control-draggable clearfix wide">
												<li class="control-draggable control-child-wrapper">
													<div id="IWDF-control-30" class="form-control field-control">
														<label style="width:10em;" class="dynamic-form-required top">* High School Name</label>
														<input id="EducationHistory.High School.records.IWDF-row-43.685000000002963" maxlength="100" name="EducationHistory.High School.records.IWDF-row-43.685000000002963" value="" type="text" />
														<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("EducationHistory.High School.records.IWDF-row-43.685000000002963", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
													</div>
												</li>
												<li class="control-draggable control-child-wrapper">
													<div id="IWDF-control-32" class="form-control field-control">
														<label class="top">Most Recently Attended School</label>
														<input id="EducationHistory.High School.records.IWDF-row-43.685000000029103" name="EducationHistory.High School.records.IWDF-row-43.685000000029103" value="on" type="checkbox" />
													</div>
												</li>
												<li class="clear-float"></li>
												<li class="control-draggable control-child-wrapper"></li>
												<li class="clear-float"></li>
												<li class="control-draggable control-child-wrapper"></li>
												<li class="clear-float"></li>
												<li class="control-draggable control-child-wrapper"></li>
												<li class="control-child-wrapper">
													<div id="IWDF-control-34" class="form-control hidden field-control">
														<label class="top">CEEB Code</label>
														<input id="EducationHistory.High School.records.IWDF-row-43.685000000002975" maxlength="10" name="EducationHistory.High School.records.IWDF-row-43.685000000002975" value="" type="text" readonly />
													</div>
												</li>
												<li class="control-child-wrapper">
													<div id="IWDF-control-36" class="form-control hidden field-control">
														<label class="top">Primary State</label>
														<input id="EducationHistory.High School.records.IWDF-row-43.685000000002997" maxlength="30" name="EducationHistory.High School.records.IWDF-row-43.685000000002997" value="" type="text" readonly />
													</div>
												</li>
												<li class="control-child-wrapper">
													<div id="IWDF-control-38" class="form-control hidden field-control">
														<label class="top">Education Type</label>
														<select id="EducationHistory.High School.records.IWDF-row-43.685000000056005" name="EducationHistory.High School.records.IWDF-row-43.685000000056005" disabled="disabled">
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
_IW.InlineLookup.bind("EducationHistory.High School.records.IWDF-row-43.685000000002963", {"lookupType":"organizations","orgLookupFilter":["High School"]}, function(field, oneResult) { _IW.FormsRuntime.inlineLookupSelected(field, oneResult, "685000000002963"); }, { });
// ]]>
</script>
										</div>
									</div>
									<div style="text-align:right;">
										<a id="IWDF-link-42" style="display:inline;font-weight:bold;" onclick="_IW.FormsRuntime.duplicateSection(&quot;IWDF-wrapper-41&quot;, &quot;EducationHistory.High School&quot;)" href="javascript:void(0)">Add Another Response</a>
									</div>
									<script type="text/javascript">
// <![CDATA[
_IW.FormsRuntime.setTemplate("EducationHistory.High School", "<div id=\"IWDF-control-28-RepeatingSectionControlMagicString\" sectionTitle=\"School History\" style=\"margin-bottom:10px;\" class=\"form-control section-control\"><div class=\"title clearfix\"><span>School History<\/span>\n<a style=\"display:inline;float:right;\" class=\"right-link\" onclick=\"_IW.FormsRuntime.removeSection(&quot;IWDF-control-28-RepeatingSectionControlMagicString&quot;, &quot;IWDF-link-42&quot;)\" href=\"javascript:void(0)\">Remove Entry<\/a>\n<\/div>\n<ul class=\"control-child-helper control-draggable clearfix wide\"><li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-30\" class=\"form-control field-control\"><label style=\"width:10em;\" class=\"dynamic-form-required top\">* High School Name<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\" maxlength=\"100\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\" value=\"\" type=\"text\"\/><script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.FormValidator.addTextFieldValidator(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\", \"notEmpty\", null, { trim: true, isReqFunc: true });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n<\/li>\n<li class=\"control-draggable control-child-wrapper\"><div id=\"IWDF-control-32\" class=\"form-control field-control\"><label class=\"top\">Most Recently Attended School<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000029103\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000029103\" value=\"on\" type=\"checkbox\"\/><\/div>\n<\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"clear-float\"><\/li>\n<li class=\"control-draggable control-child-wrapper\"><\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-34\" class=\"form-control hidden field-control\"><label class=\"top\">CEEB Code<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002975\" maxlength=\"10\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002975\" value=\"\" type=\"text\" readonly=\"readonly\"\/><\/div>\n<\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-36\" class=\"form-control hidden field-control\"><label class=\"top\">Primary State<\/label>\n<input id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002997\" maxlength=\"30\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002997\" value=\"\" type=\"text\" readonly=\"readonly\"\/><\/div>\n<\/li>\n<li class=\"control-child-wrapper\"><div id=\"IWDF-control-38\" class=\"form-control hidden field-control\"><label class=\"top\">Education Type<\/label>\n<select id=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000056005\" name=\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000056005\" disabled=\"disabled\"><option value=\"\"><\/option>\n<option selected=\"selected\" value=\"High School\">High School<\/option>\n<option value=\"Certificate\">Certificate<\/option>\n<option value=\"Undergraduate\">Undergraduate<\/option>\n<option value=\"Graduate\">Graduate<\/option>\n<option value=\"Doctorate\">Doctorate<\/option>\n<\/select>\n<\/div>\n<\/li>\n<\/ul>\n<script type=\"text\/javascript\">\n\/\/ <![CDATA[\n_IW.InlineLookup.bind(\"EducationHistory.High School.records.RepeatingSectionControlMagicString.685000000002963\", {\"lookupType\":\"organizations\",\"orgLookupFilter\":[\"High School\"]}, function(field, oneResult) { _IW.FormsRuntime.inlineLookupSelected(field, oneResult, \"685000000002963\"); }, { });\n\/\/ ]]&gt;\n<\/script>\n<\/div>\n");
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
						<button class="submit fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.submit(this.form);" type="button">Submit</button>
					</div>
				</div>
			</form>
			<div style="display:none;"></div>
		</div>
		<script type="text/javascript">
// <![CDATA[

			jQuery(function() { _IW.FormsRuntime.bootstrap(44, "IWDF-dynamicform-39", 685000000110077, {".doc":true,".css":true,".qt":true,".xlsb":true,".html":true,".xlw":true,".xlsm":true,".xls":true,".csv":true,".eps":true,".xlt":true,".txt":true,".tif":true,".rar":true,".dotm":true,".htm":true,".wk2":true,".wk3":true,".movie":true,".dotx":true,".tiff":true,".wk1":true,".xml":true,".rm":true,".bmp":true,".potx":true,".png":true,".xlam":true,".ppam":true,".mpeg":true,".jpg":true,".zip":true,".dat":true,".pptx":true,".docx":true,".potm":true,".gif":true,".wav":true,".pptm":true,".jpeg":true,".swf":true,".docm":true,".xltx":true,".xltm":true,".mpg":true,".avi":true,".pdf":true,".moov":true,".ppsx":true,".wpd":true,".ppsm":true,".ppt":true,".ani":true,".mov":true,".rtf":true,".xlsx":true}, {"MultiPage":false,"RequiresLogin":false}); });
			jQuery(function() { _IW.InquiryFormRuntime.bootstrap(685000000110077); });
			jQuery(function() {
			var runtimeURL = _IW.FormsRuntime.getRuntimeURL();
			_IW.FormsRuntime.setRuntimeURL(serverURL + runtimeURL);
			_IW.FormsRuntime.setServerURL(serverURL);
			_IW.FormsRuntime.setRemoteAjax(true);
			});
		
// ]]>
</script>
</div>
