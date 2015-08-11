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
$sbgi_source = "ADG";
$lead_source = "Online...";
$specify_source = "Google Adwords";
if(stristr($_SERVER['QUERY_STRING'],"inquire")){
	$sbgi_source = "SGN";
	$lead_source = "I received something in the mail...";
	$specify_source = "";
}
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
//			$iwFrame = makeIWShortFrame($postArray);

			if($postArray['phonetype'] == 'Cell'){
				$phonekey = "685000000003031";
			}
			else {
				$phonekey = "685000000003027";
			}
			$formStr = "";
			$formStr .= "fname=".$postArray['fname']; // fname
			$formStr .= "&";
			$formStr .= "lname=".$postArray['lname']; // lname
			$formStr .= "&";
			$formStr .= "phonekey=$phonekey"; // phonetype
			$formStr .= "&";
			$formStr .= "phone=".$postArray['phone']; // phone
			$formStr .= "&";
			$formStr .= "email=".$postArray['email']; 
			$formStr .= "&";
			$formStr .= "hs_gradyear=".$postArray['hs_gradyear']; // hs grad year
			$formStr .= "&";
			$formStr .= "street=".$postArray['street']; // hs grad year
			$formStr .= "&";
			$formStr .= "street2=".$postArray['street2']; // hs grad year
			$formStr .= "&";
			$formStr .= "city=".$postArray['city']; // hs grad year
			$formStr .= "&";
			$formStr .= "state=".$postArray['state']; // hs grad year
			$formStr .= "&";
			$formStr .= "zip=".$postArray['zip']; // hs grad year
			$formStr .= "&";
			$formStr .= "country=".$postArray['country']; // hs grad year
			$formStr .= "&";
			$formStr .= "three_words=".$postArray['three_words']; // three words
			$formStr .= "&";
			// 3 source-related fields
			//	<input id="Contacts.685000000110319" name="Contacts.685000000110319" value="ADG" type="hidden" />
			//	<input id="Contacts.685000000003013" name="Contacts.685000000003013" value="Online..." type="hidden" />
			//	<input id="Contacts.685000000156005" name="Contacts.685000000155215" value="Google Adwords" type="hidden" />
			$formStr .= "Contacts.685000000110319=".$postArray['Contacts.685000000110319']; // three words
			$formStr .= "&";
			$formStr .= "Contacts.685000000003013=".$postArray['Contacts.685000000003013']; // three words
			$formStr .= "&";
			$formStr .= "Contacts.685000000156005=".$postArray['Contacts.685000000156005']; // three words
			$formFrame = "<iframe src=\"http://forms.simons-rock.edu/admission/l/iwgad/iw-short.php?$formStr\" width=\"0\" height=\"0\" style=\"border: 0\"></iframe>";
		}
		echo $formFrame;
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
//			$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter&tid=$db_id";
			$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter";
			// header("Location: $redirStr");
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
	$territoryInfo = getTerritoryInfo($_POST['state'],$territories);
	$fields_recruiter = $territoryInfo['fields_recruiter'];//$_POST['counselor'];
	$email = $email;
	$doRedir = $territoryInfo['doRedir'];
	// HEADS UP THIS IS A MAJOR HACK... We are giving all NY and PA to Joel for this formn, since we only get state and not the futher area breakdown
	if($_POST['state'] == "NY" || $_POST['state'] == "PA"){
		$redir = "joel-pitt";
		$fields_recruiter = "pitt";
		$recruiter_email_handle = "jpitt@simons-rock.edu";
	}
//			$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter&tid=$db_id";
	$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter";
//	header("Location: $redirStr");

?>
<script>
function timeout_trigger() {
	window.location = "<?php echo($redirStr);?>";
}

function timeout_init() {
    setTimeout('timeout_trigger()', 2000);
}
//timeout_init();
</script>
<?php
		//exit();

	include $redirStr;	
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
<style>
.field-control{padding: 1px 5px; !important}
</style>
	<div id="form-wrapper" style="padding-left:0;margin-right:auto;width:455px; min-height:669px; margin-left:auto; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top: none" class="ui-tabs-left">
		<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
			<div id="IWDF-dynamicform-49" class="dynamicFormDefaults clearfix">
				<div id="IWDF-page-50">
					<div class="dynamic-form-required legend" style="text-align:right; padding-right: 10px;">Complete this form to receive more information about Simon’s Rock.<br />(* = required field)</div>
						<ul class="page-child-helper">
							<li class="page-child-wrapper first">
								<div id="IWDF-control-4" sectiontitle="Student Information" class="form-control section-control page-child first" style="border: none">
									<ul class="control-child-helper control-draggable clearfix wide">
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-6" class="form-control field-control">
												<label for="fname" style="width:18em;" class="dynamic-form-required left">* First name</label>
												<input id="fname" maxlength="40" style="width:14em;" name="fname" value="<?php echo($_REQUEST['fname']); ?>" type="text" />
											</div>
										</li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control">
												<label for="lname" style="width:18em;" class="dynamic-form-required left">* Last name</label>
												<input id="lname" maxlength="80" style="width:14em;" name="lname" value="<?php echo($_REQUEST['lname']); ?>" type="text" />
											</div>
										</li>
										<li class="clear-float"></li>


<?php 
if( !(isset($_REQUEST['eml'])) || $_REQUEST['eml'] == ""){
	

?>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control">
												<label for="email" style="width:18em;" class="dynamic-form-required left">* E-mail</label>
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
												<label for="phone" style="width:18em;" class="left">Phone</label>
												<input id="phone" maxlength="50" style="width:14em;" name="phone" value="" type="text" />
											</div>
										</li>
										
										
										
<?php // clarify type of phone (to pass the correct field to IW) ?>										

										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="" class="form-control field-control">
												<label for="phonetype" style="width:18em;" class="left">Phone type:</label>
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
												<label for="hs_gradyear" style="width:18em;" class="dynamic-form-required left">* Anticipated year of HS graduation</label>
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
							<li class="clear-float" style="font-size: 0px"></li>
							
							
							<li class="control-draggable control-child-wrapper wide" id="addressLI" style="height: auto; width:455px;-moz-border-radius: 10px;border-radius: 10px;">
								<div id="addressDiv" class="form-control field-control" style="margin-left: 10px; display:none">
									<div id="streetDiv" class="form-control field-control" style="padding: 0 !important;">
										<label for="street" style="width:17em;" class="left">Street</label>
										<input id="street" maxlength="50" style="width:14em;" name="street" value="" type="text" />
									</div>
									<div id="street2Div" class="form-control field-control" style="padding: 0 !important;">
										<label for="street2" style="width:17em;" class="left">Street 2</label>
										<input id="street2" maxlength="50" style="width:14em;" name="street2" value="" type="text" />
									</div>
									<div id="cityDiv" class="form-control field-control" style="padding: 0 !important;">
										<label for="city" style="width:17em;" class="left">City</label>
										<input id="city" maxlength="50" style="width:14em;" name="city" value="" type="text" />
									</div>
									
								</div>

<?php 
if( !(isset($state)) || $state == ""){
?>
								<div id="stateDiv" class="form-control field-control">
									<label id="stateLabel" for="state" style="width:18em;" class="left">* State/Province:</label>
									<select id="state" style="width:14em;" name="state">
									  <option selected="selected" value=""></option>
									  <option>not applicable</option>
									  <option>AA</option>
									  <option>AE</option>
									  <option>AL</option>
									  <option>AK</option>
									  <option>AP</option>
									  <option>AR</option>
									  <option>AS</option>
									  <option>AZ</option>
									  <option>CA</option>
									  <option>CO</option>
									  <option>CT</option>
									  <option>DC</option>
									  <option>DE</option>
									  <option>FL</option>
									  <option>FM</option>
									  <option>GA</option>
									  <option>GU</option>
									  <option>HI</option>
									  <option>ID</option>
									  <option>IL</option>
									  <option>IN</option>
									  <option>IA</option>
									  <option>KS</option>
									  <option>KY</option>
									  <option>LA</option>
									  <option>ME</option>
									  <option>MD</option>
									  <option>MA</option>
									  <option>MH</option>
									  <option>MI</option>
									  <option>MN</option>
									  <option>MP</option>
									  <option>MS</option>
									  <option>MO</option>
									  <option>MT</option>
									  <option>NE</option>
									  <option>NV</option>
									  <option>NH</option>
									  <option>NJ</option>
									  <option>NM</option>
									  <option>NY</option>
									  <option>NC</option>
									  <option>ND</option>
									  <option>OH</option>
									  <option>OK</option>
									  <option>OR</option>
									  <option>PA</option>
									  <option>PR</option>
									  <option>PW</option>
									  <option>RI</option>
									  <option>SC</option>
									  <option>SD</option>
									  <option>TN</option>
									  <option>TX</option>
									  <option>UT</option>
									  <option>VI</option>
									  <option>VT</option>
									  <option>VA</option>
									  <option>WA</option>
									  <option>WV</option>
									  <option>WI</option>
									  <option>WY</option>
									  <option>AB</option>
									  <option>BC</option>
									  <option>MB</option>
									  <option>NB</option>
									  <option>NL</option>
									  <option>NT</option>
									  <option>NS</option>
									  <option>NU</option>
									  <option>ON</option>
									  <option>PE</option>
									  <option>QC</option>
									  <option>SK</option>
									  <option>YT</option>
									  <option>not applicable</option>
									</select>
								</div>
<?php 
}
else {
	
?>
				  <input name="state" value="<?php echo($state); ?>" type="hidden" />
<?php 
}
?>

								<div id="addressDiv2" class="form-control field-control" style="margin-left: 10px; display:none">
									<div id="zipDiv" class="form-control field-control" style="padding: 0 !important;">
										<label for="zip" style="width:17em;" class="left">Zip/Postal code</label>
										<input id="zip" maxlength="50" style="width:14em;" name="zip" value="" type="text" />
									</div>
									<div id="countryDiv" class="form-control field-control" style="padding: 0 !important;">
										<label for="country" style="width:17em;" class="left">Country  (if other than U.S.)</label>
											<select id="country" name="country">
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
													<option value="CÔTE D&#39;IVOIRE">CÔTE D&#39;IVOIRE</option>
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
									</div>
								
								</div>
									
								<div id="IWDF-control-20" class="form-control field-control" style="margin-left: 10px;">
									<input type="checkbox" name="getAddress" id="getAddress" onClick="toggleAddressDiv(this.checked)" />
									<label for="getAddress" style="width:auto; text-align:left" class="left">Check this to receive information by regular mail</label>
								</div>
							</li>
							<li class="clear-float" style="font-size: 3px"></li>
							
							<li class="control-draggable control-child-wrapper wide">
								<div id="IWDF-control-20" class="form-control field-control" style="margin-left: 100px;">
									<label style="width:22em;" class="dynamic-form-required left">What are three words that best describe you?</label>
									<textarea id="three_words" cols="5" style="width:250px;" name="three_words" rows="3"></textarea>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="form-action-bar bottom" style="text-align:center">
				<input name="Contacts.685000000110319" value="<?php echo($sbgi_source); ?>" type="hidden" />
				<input name="Contacts.685000000003013" value="<?php echo($lead_source); ?>" type="hidden" />
				<input name="Contacts.685000000155215" value="<?php echo($specify_source); ?>" type="hidden" />
				
				  <button onClick="_gaq.push(['_trackEvent', 'Form', 'Submit', 'Slideshow LP Short'])" type="submit" name="submit" id="submit" style="clear: both; margin-left: 0px; width: 188px; height: 35px; background: url(/admission/images/submit.png); cursor:pointer" onMouseOver="this.style.background='url(/admission/images/submit-hover.png)'" onMouseOut="this.style.background='url(/admission/images/submit.png)'"></button>
				</div>
			</form>
	        <div style="text-align:center; margin: 20px 0"><img src="images/primary_stacked_red.jpg" alt="Bard College at Simon's Rock" /></div>
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

function toggleAddressDiv(theVal){
	if(theVal){
		document.getElementById('addressDiv').style.display = '';
		document.getElementById('addressDiv2').style.display = '';
		document.getElementById('addressLI').style.background = '#dadada';
		document.getElementById('addressLI').style.margin = '0 0 0 5px';
		document.getElementById('addressLI').style.width = '443px';
		document.getElementById('addressLI').style.border = '1px solid #BF2A23';
		document.getElementById('stateDiv').style.padding = "0px";
		document.getElementById('stateLabel').style.width = '219px';
	}
	else{
		document.getElementById('addressDiv').style.display = 'none';
		document.getElementById('addressDiv2').style.display = 'none';
		document.getElementById('addressLI').style.background = '#fff';
		document.getElementById('addressLI').style.margin = '0 0 0 0';
		document.getElementById('addressLI').style.width = '455px';
		document.getElementById('stateDiv').style.padding = '1px 5px';
		document.getElementById('stateLabel').style.width = '18em';
		document.getElementById('addressLI').style.border = '0px solid #fff';
	}
}


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