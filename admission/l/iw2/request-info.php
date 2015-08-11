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

//	foreach($_POST as $iw_formfield_name => $field_value){
//		echo "<p>$iw_formfield_name = $field_value</p>";
//		$conventional_fieldname = iw_fieldmapping($db,"iw_post_varname",$iw_formfield_name);
//		echo "CL: $conventional_fieldname";
//		$conventions[$conventional_fieldname] = $field_value;
//	}
//	print_r($conventions);
//	echo $conventions['fname'];
//	exit();

		// get their state
		// exceptions: PA (West), PA (East),  NY (except NYC, Nassau & Suffok), NY (Nassau & Suffolk), 
		$territory = $high_school_state;
		if($territory == "NY") {
			$territory = $nycounty;
		}
		if($territory == "PA") {
			$territory = $paArea;
		}
		$territoryInfo = getTerritoryInfo($territory,$territories);
		$redir = $territoryInfo['redir'];
		$fields_recruiter = $territoryInfo['fields_recruiter'];
		$redirStr = $territoryInfo['redirStr'];
		$doRedir = $territoryInfo['doRedir'];
		$recruiter_email_handle = $territoryInfo['recruiter_email_handle'];

		$dup_flag = dupCheck($db,$email,$fname,$lname,$zip);
		
/* !!!!!!!!!!!!!  SET $dup_flag to empty string until DB upload is fully ready
		$dup_flag = "";
*/

		// build the form 1 email
	//	$emailArray = makeEmail($postArray,$formNum,$dup_flag);
		
		// add auto-submit icontact submission form in hidden iframe
		if(!$test_env){
//				$iwFrame = makeIWFrame($email,$fname,$lname,$street_address,$city,$state,$zip,getDOB($dob_y,$dob_m,$dob_d),$anticipated_grad_year,$fields_recruiter);
			$iwFrame = makeIWShortFrame($postArray);
		}
		echo $iwFrame;
		// add to mysql db
		// get it all ready for safe insertion
		// $db->do_query(makeSQL($postArray,$formNum));
		// $db_id = mysql_insert_id();



		$bad = array("emeraldninjadragon@gmail.com","rooneyl14@nycxavierhs.org");

		$from = $email;
		if( ! in_array($bad,$from) ){
			$headers = "From: $from\r\n";
			$headers .= 'Cc: recruit@simons-rock.edu' . "\r\n";
			$headers .= 'Bcc: dscheff@simons-rock.edu' . "\r\n";			
			if(!$test_env){
				if(!isset($recruiter_email_handle)){
//					$recruiter_email_handle = getCounselorEmailHandle($_POST['counselor']);
				}
//				mail($recruiter_email_handle,$emailArray['subj'],$emailArray['body'],$headers);
			}
			$emailArray['body'] .= "\n\nRECRUITER EMAIL HANDLE: $recruiter_email_handle\n\n";
			$emailArray['body'] .= "\n\nPATH: $redirStr\n\n";
			$headers = "From: $from\r\n";
			mail("dscheff@simons-rock.edu",$emailArray['subj'],$emailArray['body'],$headers);
		}
		if($doRedir == true && $formNum == 2){
			$territoryInfo = getTerritoryInfo($territory,$territories);
			$fields_recruiter = $_POST['counselor'];
			$email = $email;
			$doRedir = $territoryInfo['doRedir'];
			$redirStr = "http://forms.simons-rock.edu/admission/thankyou.php?email=$email&couns=$fields_recruiter&tid=$db_id";
			header("Location: $redirStr");
		}	
}
/*
if($doRedir){
	if($formNum == '1'){
		$form1Display = 'none';
		$form2Display = '';
		echo "
			<script>
				document.getElementById('left').style.display='none';
				document.getElementById('right').style.width='1020px';
				document.getElementById('right').style.float='left';
				document.getElementById('righttop').style.width='1018px';
				
			</script>";
		$page3Display = 'none';
	}
	else if($formNum == '2'){
		$form1Display = 'none';
		$form2Display = 'none';
		$righttopDisplay = 'none';

		$page3Display = '';
		echo "
			<script>
				document.getElementById('left').style.display='none';
				document.getElementById('right').style.width='1020px';
				document.getElementById('right').style.float='left';
			</script>";
	}
	else {
		$form1Display = 'none';
		$form2Display = 'none';
		$page3Display = '';
	}
}
else {
	$form1Display = '';
	$form2Display = 'none';
	$page3Display = 'none';
}
*/
?>
<?php
if($thankyouDisplay == ""){
	include $_SERVER['DOCUMENT_ROOT'] . "/admission/thankyou-iw.php";	
}

?>
<div style="display: <?php echo($form1Display); ?>">
	<div id="righttop">Request More Information Below
		<hr style="width:325px;" align="center" />
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
	<div id="form-wrapper" style="padding-left:0;margin-right:auto;width:455px; min-height:669px; margin-left:auto; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top: none" class="ui-tabs-left">
		<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
			<div id="IWDF-dynamicform-49" class="dynamicFormDefaults clearfix">
				<div id="IWDF-page-50">
					<div class="dynamic-form-required legend" style="text-align:right; padding-right: 10px;">Fill in this form and we’ll mail you brochures about Simon’s Rock.<br />(* = required field)</div>
						<ul class="page-child-helper">
							<li class="page-child-wrapper first">
								<div id="IWDF-control-4" sectiontitle="Student Information" class="form-control section-control page-child first" style="border: none">
									<ul class="control-child-helper control-draggable clearfix wide">
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-6" class="form-control field-control">
												<label for="fname" style="width:17em;" class="dynamic-form-required left">* First Name</label>
												<input id="fname" maxlength="40" style="width:14em;" name="fname" value="<?php echo($_REQUEST['fname']); ?>" type="text" />
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control">
												<label for="lname" style="width:17em;" class="dynamic-form-required left">* Last Name</label>
												<input id="lname" maxlength="80" style="width:14em;" name="lname" value="<?php echo($_REQUEST['lname']); ?>" type="text" />
											</div>
										</li>
										<li class="clear-float"></li>


<?php 
if( !(isset($_REQUEST['eml'])) || $_REQUEST['eml'] == ""){
	

?>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control">
												<label for="email" style="width:17em;" class="dynamic-form-required left">* E-mail</label>
												<input id="email" maxlength="80" style="width:14em;" name="email" value="<?php echo($_REQUEST['eml']); ?>" type="text" />
											</div>
										</li>
										<li class="clear-float"></li>
<?php 
}
else {
	
?>
				  <input name="email" value="<?php echo($_REQUEST['eml']); ?>" type="hidden" />
<?php 
}
?>



										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-28" class="form-control field-control">
												<label for="phone" style="width:17em;" class="left">Phone</label>
												<input id="phone" maxlength="50" style="width:14em;" name="phone" value="" type="text" />
											</div>
										</li>
										
										
										
<?php // clarify type of phone (to pass the correct field to IW) ?>										

										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="" class="form-control field-control">
												<label for="phonetype" style="width:17em;" class="left">Phone type:</label>
												<select id="phonetype" style="width:14em;" name="phonetype">
													<option></option>
													<option value="Home">Home</option>
													<option value="Cell">Cell</option>
												</select>
											</div>
										</li>

										
										
										<li class="clear-float"></li>

										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-16" class="form-control field-control">
												<label for="hs_gradyear" style="width:17em;" class="dynamic-form-required left">* Anticipated Year of Graduation</label>
												<select id="hs_gradyear" style="width:14em;" name="hs_gradyear">
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
											</div>
										</li>
									</ul>
								</div>
							</li>
							<li class="clear-float"></li>
							<li class="control-draggable control-child-wrapper wide">
								<div id="IWDF-control-20" class="form-control field-control" style="margin-left: 100px;">
									<label style="width:22em;" class="dynamic-form-required left">What are three words that best describe you?</label>
									<textarea id="three_words" cols="5" style="width:250px;" name="three_words" rows="3"></textarea>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="form-action-bar bottom">
				  <input name="state" value="<?php echo($_REQUEST['state']); ?>" type="hidden" />
				  <button onClick="_gaq.push(['_trackEvent', 'Form', 'Submit', 'Slideshow LP Short'])" type="submit" name="submit" id="submit" style="clear: both; margin-left: 150px; width: 188px; height: 35px; background: url(/admission/images/submit.png); cursor:pointer" onMouseOver="this.style.background='url(/admission/images/submit-hover.png)'" onMouseOut="this.style.background='url(/admission/images/submit.png)'"></button>
				</div>
			</form>
			<div style="display:none;"></div>
		</div>
		<script type="text/javascript">
// <![CDATA[

			jQuery(function() { _IW.FormsRuntime.bootstrap(23, "IWDF-dynamicform-21", 685000000420003, {".doc":true,".css":true,".qt":true,".xlsb":true,".html":true,".xlw":true,".xlsm":true,".xls":true,".csv":true,".eps":true,".xlt":true,".txt":true,".tif":true,".rar":true,".dotm":true,".htm":true,".wk2":true,".wk3":true,".movie":true,".dotx":true,".tiff":true,".wk1":true,".xml":true,".rm":true,".bmp":true,".potx":true,".png":true,".xlam":true,".ppam":true,".mpeg":true,".jpg":true,".zip":true,".dat":true,".pptx":true,".docx":true,".potm":true,".gif":true,".wav":true,".pptm":true,".jpeg":true,".swf":true,".docm":true,".xltx":true,".xltm":true,".mpg":true,".avi":true,".pdf":true,".moov":true,".ppsx":true,".wpd":true,".ppsm":true,".ppt":true,".ani":true,".mov":true,".rtf":true,".xlsx":true}, {"MultiPage":false,"RequiresLogin":false}); });
			jQuery(function() { _IW.InquiryFormRuntime.bootstrap(685000000420003); });
			jQuery(function() {
			var runtimeURL = _IW.FormsRuntime.getRuntimeURL();
			_IW.FormsRuntime.setRuntimeURL(serverURL + runtimeURL);
			_IW.FormsRuntime.setServerURL(serverURL);
			_IW.FormsRuntime.setRemoteAjax(true);
			});


		
// ]]>
</script>
	</div>

</div>
<div class="spacer" style="height:50px"></div>

<script type="text/javascript">
<!--

function checkForm() {

    var bgcolor
    var normal
    var rval
    highlight = "#ffcccc"
    normal = "#ffffff"
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
    } else
        return true
}
// -->
			
</script>