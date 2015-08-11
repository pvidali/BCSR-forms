<?php
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";

require_once $_SERVER['DOCUMENT_ROOT']."/includes/iw-form-html/top.php";

// for this form, what are the fields being pushed to IW...
$iw_push_fields = array(
	'email',
	'fname',
	'lname',
	'hs_gradyear',
	'street',
	'street2',
	'city',
	'state',
	'zip',
	'country',
	'three_words'
);

$fieldsString = "";
$post_values = array();
foreach($iw_push_fields as $field){
//		$fields[$field]['iw_formfield_name'] = $k;
//		$fields[$field]['iw_post_varname'] = $v;
	$iw_formfield_name = iw_fieldmap_name($db,$field);
	$thisfieldvalue = $$field;
	//$fieldsString .= "\t<input type=\"hidden\" name=\"$iw_formfield_name\" value=\"$thisfieldvalue\" />\n";
	$post_values["$iw_formfield_name"] = $thisfieldvalue;
}
?>

		<input name="Contacts.<?php echo($_REQUEST['phonekey']); ?>" value="<?php echo($_REQUEST['phone']); ?>" type="hidden" />


		<input id="Contacts.685000000110319" name="Contacts.685000000110319" value="<?php echo($_REQUEST['Contacts_685000000110319']); ?>" type="hidden" />
		<input id="Contacts.685000000003013" name="Contacts.685000000003013" value="<?php echo($_REQUEST['Contacts_685000000003013']); ?>" type="hidden" />
		<input id="Contacts.685000000155215" name="Contacts.685000000155215" value="<?php echo($_REQUEST['Contacts_685000000155215']); ?>" type="hidden" />
		<input id="Contacts.685000006711125" name="Contacts.685000006711125" value="<?php echo($dateSource); ?>" type="hidden" />

<script type="text/javascript">
// <![CDATA[
_IW.FieldDep.addDependency("Contacts.685000000110551", "Contacts.685000000336031", {"":[""],"2017":["201508"],"2018":["201608"],"2019":["201708"],"2013":["201301"],"2014":["201308"],"2015":["201308"],"2016":["201408"],"2012":["201301"],"2021":["201908"],"2020":["201808"]});
// ]]>
</script>
												<select id="Contacts.685000000336031" name="Contacts.685000000336031" disabled="disabled">
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

		<button class="submit fg-button ui-state-default ui-corner-all" onclick="_IW.FormsRuntime.submit(this.form);" type="button">Submit</button>
	</form>
		<script type="text/javascript">
// <![CDATA[
			jQuery(function() { _IW.FormsRuntime.bootstrap(62, "IWDF-dynamicform-57", 685000002104499, {".doc":true,".css":true,".qt":true,".xlsb":true,".html":true,".xlw":true,".xlsm":true,".xls":true,".csv":true,".eps":true,".xlt":true,".txt":true,".tif":true,".rar":true,".dotm":true,".htm":true,".wk2":true,".wk3":true,".movie":true,".dotx":true,".tiff":true,".wk1":true,".xml":true,".rm":true,".bmp":true,".potx":true,".png":true,".xlam":true,".ppam":true,".mpeg":true,".jpg":true,".zip":true,".dat":true,".pptx":true,".docx":true,".potm":true,".gif":true,".wav":true,".pptm":true,".jpeg":true,".swf":true,".docm":true,".xltx":true,".xltm":true,".mpg":true,".avi":true,".pdf":true,".moov":true,".ppsx":true,".wpd":true,".ppsm":true,".ppt":true,".ani":true,".mov":true,".rtf":true,".xlsx":true}, {"MultiPage":false,"RequiresLogin":false}); });
			jQuery(function() { _IW.InquiryFormRuntime.bootstrap(685000002104499); });
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
