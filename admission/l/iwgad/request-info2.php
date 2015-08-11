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

// !!!! these two values are needed for IW to know which form was completed !!!!
$formid = '685000002104499';
$seed = 62; // get from z value in IW form code

// grab and parse google ad params
// m=p&n=g&d=c&dm=&c=24075137417&k=simon's%20rock&p=&gclid=CN_ikKWPt7gCFcmf4Aodg1EAug
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

require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$this_source = setSource('ADG');
$lead_source = "Online...";
$specify_source = "Google Adwords";
if(stristr($_SERVER['QUERY_STRING'],"inquire")){
	$sbgi_source = "SGN";
	$lead_source = "I received something in the mail...";
	$specify_source = "";
}
else if(stristr($_SERVER['QUERY_STRING'],"share")){
	$sbgi_source = "SGN";
	$lead_source = "I got an email...";
	$specify_source = "";
}

$form1Display = '';
$thankyouDisplay = 'none';

if(isset($_POST['submit'])) {
	$form1Display = 'none';
	$thankyouDisplay = '';
	$postArray = $_POST;
//	$postArray['ethnicities'] = $ethnicities;
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
	

/*
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
		'three_words',
		$ptype
	); 

	$formid = '685000002104499';
	$seed = 62; // get from z value in IW form code
*/
	$formId = 1;
}

if($thankyouDisplay == ""){
//	$territoryInfo = getTerritoryInfo($_POST['state'],$territories);
	$territoryInfo = getTerritoryInfoDB($state,$country,$db);
	$fields_recruiter = $territoryInfo['fields_recruiter'];
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

	$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter";
//	$_POST['redirect'] = $redirStr;

?>
<script>
	_gaq.push(['_trackEvent', 'Form', 'Submit', 'Slideshow LP Short']);
</script>
<?php
	include $_SERVER['DOCUMENT_ROOT']."/includes/iw-curl.php";
}
else {
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
												<label for="telephonenumber" style="width:18em;" class="left">Phone</label>
												<input id="telephonenumber" maxlength="50" style="width:14em;" name="telephonenumber" value="" type="text" />
                                                <input type="hidden" name="phone" id="phone" value="" />
                                                <input type="hidden" name="cell" id="cell" value="" />
											</div>
										</li>
									
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="" class="form-control field-control">
												<label for="phonetype" style="width:18em;" class="left">Phone type:</label>
												<select id="phonetype" style="width:14em;" name="phonetype" onChange="setPhoneValues(this.value)">
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
									<select id="state" style="width:14em;" name="state" onChange="toggleCountryDiv()">
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
								</div>
								<div id="addressDiv3" class="form-control field-control" style="margin-left: 10px; display:none">
									<div id="countryDiv" class="form-control field-control" style="padding: 0 !important;">
										<label for="country" style="width:17em;" class="left">* Country</label>
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
				
				  <button type="submit" name="submit" id="submit" style="clear: both; margin-left: 0px; width: 188px; height: 35px; background: url(/admission/images/submit.png); cursor:pointer" onMouseOver="this.style.background='url(/admission/images/submit-hover.png)'" onMouseOut="this.style.background='url(/admission/images/submit.png)'"></button>
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
	toggleCountryDiv();
}
function toggleCountryDiv(){
	if(document.getElementById('state').value == "not applicable"){
		document.getElementById('addressDiv3').style.display = '';
	}
	else{
		document.getElementById('addressDiv3').style.display = 'none';
		document.getElementById('country').value = '';
	}
}

function setPhoneValues(type){
	if (type == "Home"){
		document.request.phone.value = document.getElementById('telephonenumber').value;
		document.request.cell.value = "";
	}
	else{
		document.request.phone.value = "";
		document.request.cell.value = document.getElementById('telephonenumber').value;
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

		if (document.request.state.value == "not applicable") {
			if (document.request.country.value.length == 0) {
				document.request.country.style.backgroundColor = highlight
				rval = false
				if(fieldFocus == ""){
					fieldFocus = "country";
				}
			}
			else {
				document.request.country.style.backgroundColor = normal
			}
		}		
		else {
			document.request.country.style.backgroundColor = normal
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
<?php
}
?>