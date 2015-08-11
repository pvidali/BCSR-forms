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
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";

$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$form1Display = '';
$thankyouDisplay = 'none';

$email = $_REQUEST['eml'];
$lname = $_REQUEST['lname'];
$state = $_REQUEST['state'];


if(isset($_POST['submit'])) {
	$acadInterests = "";
	foreach($_POST as $k => $v){
		if(strstr($k,"acint_")){
			$intrst = substr($k,6);
			$acadInterests .= $intrst . ",";
		}
	}
	if($acadInterests != ""){
		$acadInterests = substr($acadInterests,0,strlen($acadInterests)-1);
		$acint = serialize($acadInterests);
	}

	$extraInterests = "";
	foreach($_POST as $k => $v){
		if(strstr($k,"exint_")){
			$intrst = substr($k,6);
			$extraInterests .= $intrst . ",";
		}
	}
	if($extraInterests != ""){
		$extraInterests = substr($extraInterests,0,strlen($extraInterests)-1);
		$exint = serialize($extraInterests);
	}

	$form1Display = 'none';
	$thankyouDisplay = '';
	$postArray = $_POST;
	$post_msg = "";
	
	fixFormatting($postArray);

	foreach($postArray as $k => $v){
		$$k = $v;
	}

	// add auto-submit intelliworks submission form in hidden iframe
	if(!$test_env){
//			$iwFrame = makeIWFrame($email,$fname,$lname,$street_address,$city,$state,$zip,getDOB($dob_y,$dob_m,$dob_d),$anticipated_grad_year,$fields_recruiter);
//			$iwFrame = makeIWShortFrame($postArray);

		$formStr = "";
		$formStr .= "lname=".$postArray['lname']; // lname
		$formStr .= "&";
		$formStr .= "email=".$postArray['email']; // three words
		$formStr .= "&";
		$formStr .= "acadInterests=".str_replace("_"," ",$acadInterests); // academic interests
		$formStr .= "&";
		$formStr .= "extraInterests=".str_replace("_"," ",$extraInterests);// extracurricular interests
		$formStr .= "&";
		$formStr .= "685000000112005=".$postArray['Contacts.685000000112005']; // other interests
		$formStr .= "&";
		$formStr .= "685000000112007=".$postArray['Contacts.685000000112007']; // other interests
		$formStr .= "&";
		$formStr .= "685000000112009=".$postArray['Contacts.685000000112009']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296104=".$postArray['Contacts.685000000296104']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296102=".$postArray['Contacts.685000000296102']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296092=".$postArray['Contacts.685000000296092']; // other interests
		$formStr .= "&";
		$formStr .= "685000000121005=".$postArray['Contacts.685000000121005']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296122=".$postArray[Contacts.'685000000296122']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296108=".$postArray['Contacts.685000000296108']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296106=".$postArray['Contacts.685000000296106']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296120=".$postArray['Contacts.685000000296120']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296124=".$postArray['Contacts.685000000296124']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296126=".$postArray['Contacts.685000000296126']; // other interests
		$formStr .= "&";
		$formStr .= "685000000296110=".$postArray['Contacts.685000000296110']; // other interests
		$formFrame = "<iframe src=\"http://forms.simons-rock.edu/admission/l/iw-interests/iw-short.php?$formStr\" width=\"0\" height=\"0\" style=\"border: 0\"></iframe>";
	}
//	echo($formStr);
	echo $formFrame;
//	exit();

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
//	if($doRedir == true && $formNum == 2){
		$territoryInfo = getTerritoryInfo($territory,$territories);
		$fields_recruiter = $_POST['counselor'];
		$email = $email;
		$doRedir = $territoryInfo['doRedir'];
//			$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter&tid=$db_id";
		$redirStr = "http://www.simons-rock.edu/admission/thanks-for-sharing?email=$email&couns=$fields_recruiter&acint=$acint&exinst=$exint";
		// header("Location: $redirStr");
//	}	
}
?>

<!DOCTYPE HTML>
<html><head>
<meta charset="utf-8">
<title>Start College Now | Bard College at Simon's Rock</title>
<?php

if(isset($_POST['submit'])) {
	
?>
<script>
function timeout_trigger() {
	window.location = "<?php echo($redirStr);?>";
}

function timeout_init() {
    setTimeout('timeout_trigger()', 3000);
}
// timeout_init();
</script>
<?php
}
?>

<?php
if(isset($_POST['submit'])) {
	$territoryInfo = getTerritoryInfo($_POST['state'],$territories);
	$fields_recruiter = $territoryInfo['fields_recruiter'];//$_POST['counselor'];
	$email = $email;
	$doRedir = $territoryInfo['doRedir'];
	// HEADS UP THIS IS A MAJOR HACK... We are giving all NY and PA to Joel for this form, since we only get state and not the futher area breakdown
	if($_POST['state'] == "NY" || $_POST['state'] == "PA"){
		$redir = "joel-pitt";
		$fields_recruiter = "pitt";
		$recruiter_email_handle = "jpitt@simons-rock.edu";
	}
//			$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter&tid=$db_id";
	$redirStr = "http://www.simons-rock.edu/admission/thanks-for-sharing?email=$email&couns=$fields_recruiter&acint=$acint&exinst=$exint";
//	header("Location: $redirStr");

?>
<?php
		//exit();

	include $redirStr;	
//	echo $redirStr;
	exit();
}

?>

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

<script type="text/javascript" src="/js/form-funcs.js"></script>
<link rel="stylesheet" href="css/main.css" />
<link rel="stylesheet" href="/css/forms.css" />
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/google-analytics.php";
?>
<style>
.field-control label.left, .legend, label.left{
	font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #AB033A;
}
.legend{
	margin-bottom: 5px;
	border-bottom: solid 1px #B7DDF2;
	width: 414px;
	margin-left: 15px;
}
label.left{width: 165px; font-size: 13px;}

</style>
<body>
<style>
.field-control{padding: 1px 5px; !important}
</style>
<div id="container">
  <div id="content">
	<div id="main">
	<div id="form-wrapper" style="padding-left:14px;margin-right:auto;width:660px; margin-left:auto; border: 1px solid #000" class="ui-tabs-left">
		<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
			<div id="IWDF-dynamicform-49" class="dynamicFormDefaults clearfix">
				<div id="IWDF-page-50">
					<div class="dynamic-form-required legend" style="font-weight: bold; font-size: 17px; text-align: left; padding: 10px 10px 10px 0;">Use this form to tell us about your interests.</div>
						<ul class="page-child-helper">
							<li class="page-child-wrapper first">
								<div id="IWDF-control-4" sectiontitle="Student Information" class="form-control section-control page-child first" style="border: none">
									<ul class="control-child-helper control-draggable clearfix wide">
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-8" class="form-control field-control" style="margin: 5px; border: 1px solid #000; border-radius:10px; background:#DADADA">
												<label for="Contacts.685000000121545" class="left" style="width:auto; vertical-align: top; font-size: 14px; font-weight: bold; border-bottom: 1px dashed; text-align:left" >Academic Interests</label><br />
												
												<div style="float:left; width: 208px">
													<input type="checkbox" name="acint_Anthropology" id="acint_Anthropology"><label for="acint_Anthropology">Anthropology</label><br />
													<input type="checkbox" name="acint_Art - General" id="acint_Art - General"><label for="acint_Art - General">Art - General</label><br />
													<input type="checkbox" name="acint_Arabic" id="acint_Arabic"><label for="acint_Arabic">Arabic</label><br />
													<input type="checkbox" name="acint_Architecture" id="acint_Architecture"><label for="acint_Architecture">Architecture</label><br />
													<input type="checkbox" name="acint_Art History" id="acint_Art History"><label for="acint_Art History">Art History</label><br />
													<input type="checkbox" name="acint_Art - Painting or Drawing" id="acint_Art - Painting or Drawing"><label for="acint_Art - Painting or Drawing">Painting or Drawing</label><br />
													<input type="checkbox" name="acint_Art - Photography" id="acint_Art - Photography"><label for="acint_Art - Photography">Photography</label><br />
													<input type="checkbox" name="acint_Art - Sculpture or Ceramics" id="acint_Art - Sculpture or Ceramics"><label for="acint_Art - Sculpture or Ceramics">Sculpture or Ceramics</label><br />
													<input type="checkbox" name="acint_Asian Studies" id="acint_Asian Studies"><label for="acint_Asian Studies">Asian Studies</label><br />
													<input type="checkbox" name="acint_Biology" id="acint_Biology"><label for="acint_Biology">Biology</label><br />
													<input type="checkbox" name="acint_Business" id="acint_Business"><label for="acint_Business">Business</label><br />
													<input type="checkbox" name="acint_Chemistry" id="acint_Chemistry"><label for="acint_Chemistry">Chemistry</label><br />
													<input type="checkbox" name="acint_Chinese" id="acint_Chinese"><label for="acint_Chinese">Chinese</label><br />
													<input type="checkbox" name="acint_Computing/Computer Science" id="acint_Computing/Computer Science"><label for="acint_Computing/Computer Science">Computer Science</label><br />
													<input type="checkbox" name="acint_Dance" id="acint_Dance"><label for="acint_Dance">Dance</label><br />
													<input type="checkbox" name="acint_Economics" id="acint_Economics"><label for="acint_Economics">Economics</label><br />
													<input type="checkbox" name="acint_Education" id="acint_Education"><label for="acint_Education">Education</label><br />
												</div>
												<div style="float:left; width: 208px">
													<input type="checkbox" name="acint_Engineering" id="acint_Engineering"><label for="acint_Engineering">Engineering</label><br />
													<input type="checkbox" name="acint_English Literature" id="acint_English Literature"><label for="acint_English Literature">English Literature</label><br />
													<input type="checkbox" name="acint_Environmental Studies, Ecology" id="acint_Environmental Studies, Ecology"><label for="acint_Environmental Studies, Ecology">Environmental Studies, Ecology</label><br />
													<input type="checkbox" name="acint_Fashion/Fashion Design" id="acint_Fashion/Fashion Design"><label for="acint_Fashion/Fashion Design">Fashion Design</label><br />
													<input type="checkbox" name="acint_Forensics/Forensic Sciences" id="acint_Forensics/Forensic Sciences"><label for="acint_Forensics/Forensic Sciences">Forensic Sciences</label><br />
													<input type="checkbox" name="acint_French" id="acint_French"><label for="acint_French">French</label><br />
													<input type="checkbox" name="acint_German" id="acint_German"><label for="acint_German">German</label><br />
													<input type="checkbox" name="acint_Graphic Design" id="acint_Graphic Design"><label for="acint_Graphic Design">Graphic Design</label><br />
													<input type="checkbox" name="acint_History" id="acint_History"><label for="acint_History">History</label><br />
													<input type="checkbox" name="acint_Interior Design" id="acint_Interior Design"><label for="acint_Interior Design">Interior Design</label><br />
													<input type="checkbox" name="acint_International Relations" id="acint_International Relations"><label for="acint_International Relations">International Relations</label><br />
													<input type="checkbox" name="acint_Journalism" id="acint_Journalism"><label for="acint_Journalism">Journalism</label><br />
													<input type="checkbox" name="acint_Languages/Linguistics" id="acint_Languages/Linguistics"><label for="acint_Languages/Linguistics">Languages/Linguistics</label><br />
													<input type="checkbox" name="acint_Latin" id="acint_Latin"><label for="acint_Latin">Latin</label><br />
													<input type="checkbox" name="acint_Law or Criminal Justice" id="acint_Law or Criminal Justice"><label for="acint_Law or Criminal Justice">Law, Criminal Justice</label><br />
													<input type="checkbox" name="acint_Mathematics" id="acint_Mathematics"><label for="acint_Mathematics">Mathematics</label><br />
													<input type="checkbox" name="acint_Medicine" id="acint_Medicine"><label for="acint_Medicine">Medicine</label><br />
												</div>
												<div style="float:left; width: 208px">
													<input type="checkbox" name="acint_Music - General" id="acint_Music - General"><label for="acint_Music - General">Music - General</label><br />
													<input type="checkbox" name="acint_Music - Instrumental" id="acint_Music - Instrumental"><label for="acint_Music - Instrumental">Music - Instrumental</label><br />
													<input type="checkbox" name="acint_Music - Vocal" id="acint_Music - Vocal"><label for="acint_Music - Vocal">Music - Vocal</label><br />
													<input type="checkbox" name="acint_Philosophy" id="acint_Philosophy"><label for="acint_Philosophy">Philosophy</label><br />
													<input type="checkbox" name="acint_Physical Therapy" id="acint_Physical Therapy"><label for="acint_Physical Therapy">Physical Therapy</label><br />
													<input type="checkbox" name="acint_Physics" id="acint_Physics"><label for="acint_Physics">Physics</label><br />
													<input type="checkbox" name="acint_Political Science" id="acint_Political Science"><label for="acint_Political Science">Political Science</label><br />
													<input type="checkbox" name="acint_Psychology" id="acint_Psychology"><label for="acint_Psychology">Psychology</label><br />
													<input type="checkbox" name="acint_Religion/Religious Studies" id="acint_Religion/Religious Studies"><label for="acint_Religion/Religious Studies">Religion/Religious Studies</label><br />
													<input type="checkbox" name="acint_Sciences - General" id="acint_Sciences - General"><label for="acint_Sciences - General">Science</label><br />
													<input type="checkbox" name="acint_Sociology" id="acint_Sociology"><label for="acint_Sociology">Sociology</label><br />
													<input type="checkbox" name="acint_Spanish" id="acint_Spanish"><label for="acint_Spanish">Spanish</label><br />
													<input type="checkbox" name="acint_Theater" id="acint_Theater"><label for="acint_Theater">Theater</label><br />
													<input type="checkbox" name="acint_Veterinary Medicine" id="acint_Veterinary Medicine"><label for="acint_Veterinary Medicine">Veterinary Medicine</label><br />
													<input type="checkbox" name="acint_Women&#39;s or Gender Studies" id="acint_Women&#39;s or Gender Studies"><label for="acint_Women&#39;s or Gender Studies">Women&#39;s or Gender Studies</label><br />
													<input type="checkbox" name="acint_Writing" id="acint_Writing"><label for="acint_Writing">Writing</label><br />
													<input type="checkbox" name="acint_Other (Please specify):" id="acint_Other (Please specify):"><label for="acint_Other (Please specify):">Other (Please specify):</label><br />
												</div>
												<div style="clear:both; height:10px"></div>
<!-- 
												<select id="Contacts.685000000121545" style="color:#000000;background-color:#ffffff;padding:1px;border:1px solid #bababa;" name="Contacts.685000000121545[]" multiple="multiple" size="5">
													<option value="Anthropology">Anthropology</option>
													<option value="Art - General">Art - General</option>
													<option value="Arabic">Arabic</option>
													<option value="Architecture">Architecture</option>
													<option value="Art History">Art History</option>
													<option value="Art - Painting or Drawing">Art - Painting or Drawing</option>
													<option value="Art - Photography">Art - Photography</option>
													<option value="Art - Sculpture or Ceramics">Art - Sculpture or Ceramics</option>
													<option value="Asian Studies">Asian Studies</option>
													<option value="Biology">Biology</option>
													<option value="Business">Business</option>
													<option value="Chemistry">Chemistry</option>
													<option value="Chinese">Chinese</option>
													<option value="Computing/Computer Science">Computing/Computer Science</option>
													<option value="Dance">Dance</option>
													<option value="Economics">Economics</option>
													<option value="Education">Education</option>
													<option value="Engineering">Engineering</option>
													<option value="English Literature">English Literature</option>
													<option value="Environmental Studies, Ecology">Environmental Studies, Ecology</option>
													<option value="Fashion/Fashion Design">Fashion/Fashion Design</option>
													<option value="Forensics/Forensic Sciences">Forensics/Forensic Sciences</option>
													<option value="French">French</option>
													<option value="German">German</option>
													<option value="Graphic Design">Graphic Design</option>
													<option value="History">History</option>
													<option value="Interior Design">Interior Design</option>
													<option value="International Relations">International Relations</option>
													<option value="Journalism">Journalism</option>
													<option value="Languages/Linguistics">Languages/Linguistics</option>
													<option value="Latin">Latin</option>
													<option value="Law or Criminal Justice">Law or Criminal Justice</option>
													<option value="Mathematics">Mathematics</option>
													<option value="Medicine">Medicine</option>
													<option value="Music - General">Music - General</option>
													<option value="Music - Instrumental">Music - Instrumental</option>
													<option value="Music - Vocal">Music - Vocal</option>
													<option value="Philosophy">Philosophy</option>
													<option value="Physical Therapy">Physical Therapy</option>
													<option value="Physics">Physics</option>
													<option value="Political Science">Political Science</option>
													<option value="Psychology">Psychology</option>
													<option value="Religion/Religious Studies">Religion/Religious Studies</option>
													<option value="Sciences - General">Sciences - General</option>
													<option value="Sociology">Sociology</option>
													<option value="Spanish">Spanish</option>
													<option value="Theater">Theater</option>
													<option value="Veterinary Medicine">Veterinary Medicine</option>
													<option value="Women&#39;s or Gender Studies">Women&#39;s or Gender Studies</option>
													<option value="Writing">Writing</option>
													<option value="Other (Please specify):">Other (Please specify):</option>
												</select>
-->
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addMultiSelectValidator("Contacts.685000000121545", 1, null, "Please select at least 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-12" class="form-control field-control" style="margin: 5px; border: 1px solid #000; border-radius:10px; background:#DADADA">
												<label for="Contacts.685000000121649" class="left" style="width:auto; vertical-align: top; font-size: 14px; font-weight: bold; border-bottom: 1px dashed; text-align:left">Extracurricular Interests</label><br />

												<div style="float:left; width: 208px">
													<input type="checkbox" name="exint_Athletics - Basketball" id="exint_Athletics - Basketball"><label for="exint_Athletics - Basketball">Basketball</label><br />
													<input type="checkbox" name="exint_Athletics - Soccer" id="exint_Athletics - Soccer"><label for="exint_Athletics - Soccer">Soccer</label><br />
													<input type="checkbox" name="exint_Athletics - Swimming/Diving" id="exint_Athletics - Swimming/Diving"><label for="exint_Athletics - Swimming/Diving">Swimming/Diving</label><br />
													<input type="checkbox" name="exint_Athletics - Other or General" id="exint_Athletics - Other or General"><label for="exint_Athletics - Other or General">Athletics - Other</label><br />
													<input type="checkbox" name="exint_Business Clubs/Organizations" id="exint_Business Clubs/Organizations"><label for="exint_Business Clubs/Organizations">Business Clubs/Organizations</label><br />
													<input type="checkbox" name="exint_Community Service/Volunteerism" id="exint_Community Service/Volunteerism"><label for="exint_Community Service/Volunteerism">Community Service/Volunteerism</label><br />
													<input type="checkbox" name="exint_Computing/Web/Internet" id="exint_Computing/Web/Internet"><label for="exint_Computing/Web/Internet">Computing/Web/Internet</label><br />
													<input type="checkbox" name="exint_Dance" id="exint_Dance"><label for="exint_Dance">Dance</label><br />
													<input type="checkbox" name="exint_Debate and Speech" id="exint_Debate and Speech"><label for="exint_Debate and Speech">Debate and Speech</label><br />
													<input type="checkbox" name="exint_Environmental Clubs/Orgs." id="exint_Environmental Clubs/Orgs."><label for="exint_Environmental Clubs/Orgs.">Environmental Clubs/Orgs.</label><br />
													<input type="checkbox" name="exint_Ethnic Clubs/Organizations" id="exint_Ethnic Clubs/Organizations"><label for="exint_Ethnic Clubs/Organizations">Ethnic Clubs/Organizations</label><br />
													<input type="checkbox" name="exint_Film, Television and Radio" id="exint_Film, Television and Radio"><label for="exint_Film, Television and Radio">Film, Television and Radio</label><br />
												</div>
												<div style="float:left; width: 208px">
													<input type="checkbox" name="exint_GLBTQ/Gay-Straight Orgs." id="exint_GLBTQ/Gay-Straight Orgs."><label for="exint_GLBTQ/Gay-Straight Orgs.">GLBTQ/Gay-Straight Orgs.</label><br />
													<input type="checkbox" name="exint_Honor Societies/NHS" id="exint_Honor Societies/NHS"><label for="exint_Honor Societies/NHS">Honor Societies/NHS</label><br />
													<input type="checkbox" name="exint_Language Clubs/Organizations" id="exint_Language Clubs/Organizations"><label for="exint_Language Clubs/Organizations">Language Clubs/Organizations</label><br />
													<input type="checkbox" name="exint_Math Clubs/Organizations" id="exint_Math Clubs/Organizations"><label for="exint_Math Clubs/Organizations">Math Clubs/Organizations</label><br />
													<input type="checkbox" name="exint_Model United Nations" id="exint_Model United Nations"><label for="exint_Model United Nations">Model United Nations</label><br />
													<input type="checkbox" name="exint_Music - Instrumental" id="exint_Music - Instrumental"><label for="exint_Music - Instrumental">Music - Instrumental</label><br />
													<input type="checkbox" name="exint_Music - Vocal" id="exint_Music - Vocal"><label for="exint_Music - Vocal">Music - Vocal</label><br />
													<input type="checkbox" name="exint_Off-Campus Study or Travel" id="exint_Off-Campus Study or Travel"><label for="exint_Off-Campus Study or Travel">Off-Campus Study or Travel</label><br />	
													<input type="checkbox" name="exint_Political Clubs/Organizations" id="exint_Political Clubs/Organizations"><label for="exint_Political Clubs/Organizations">Political Clubs/Organizations</label><br />
													<input type="checkbox" name="exint_Publications - Paper/Literary" id="exint_Publications - Paper/Literary"><label for="exint_Publications - Paper/Literary">Publications - Paper/Literary</label><br />
													<input type="checkbox" name="exint_Quiz Teams - Odyssey/Decathlon" id="exint_Quiz Teams - Odyssey/Decathlon"><label for="exint_Quiz Teams - Odyssey/Decathlon">Quiz Teams - Odyssey/Decathlon</label><br />
													<input type="checkbox" name="exint_Reading" id="exint_Reading"><label for="exint_Reading">Reading</label><br />

												</div>
												<div style="float:left; width: 208px">
													<input type="checkbox" name="exint_Religious Clubs/Organizations" id="exint_Religious Clubs/Organizations"><label for="exint_Religious Clubs/Organizations">Religious Clubs/Organizations</label><br />
													<input type="checkbox" name="exint_Robotics" id="exint_Robotics"><label for="exint_Robotics">Robotics</label><br />
													<input type="checkbox" name="exint_Science Clubs/Organizations" id="exint_Science Clubs/Organizations"><label for="exint_Science Clubs/Organizations">Science Clubs/Organizations</label><br />
													<input type="checkbox" name="exint_Scouting: Girl/Boy/Eagle Scouts" id="exint_Scouting: Girl/Boy/Eagle Scouts"><label for="exint_Scouting: Girl/Boy/Eagle Scouts">Scouting: Girl/Boy/Eagle Scouts</label><br />
													<input type="checkbox" name="exint_Student Government" id="exint_Student Government"><label for="exint_Student Government">Student Government</label><br />
													<input type="checkbox" name="exint_Theater and Dramatics" id="exint_Theater and Dramatics"><label for="exint_Theater and Dramatics">Theater and Dramatics</label><br />
													<input type="checkbox" name="exint_Visual Arts" id="exint_Visual Arts"><label for="exint_Visual Arts">Visual Arts</label><br />
													<input type="checkbox" name="exint_Work/Jobs/Employment" id="exint_Work/Jobs/Employment"><label for="exint_Work/Jobs/Employment">Work/Jobs/Employment</label><br />
													<input type="checkbox" name="exint_Writing" id="exint_Writing"><label for="exint_Writing">Writing</label><br />
													<input type="checkbox" name="exint_Other (Please specify):" id="exint_Other (Please specify):"><label for="exint_Other (Please specify):">Other (Please specify):</label><br />
												</div>
												<div style="clear:both; height:10px"></div>
<!-- 
												<select id="Contacts.685000000121649" style="color:#000000;background-color:#ffffff;padding:1px;border:1px solid #bababa;" name="Contacts.685000000121649[]" multiple="multiple" size="5">
													<option value="Animation/Anime and Manga">Animation/Anime and Manga</option>
													<option value="Athletics - Basketball">Athletics - Basketball</option>
													<option value="Athletics - Soccer">Athletics - Soccer</option>
													<option value="Athletics - Swimming/Diving">Athletics - Swimming/Diving</option>
													<option value="Athletics - Other or General">Athletics - Other or General</option>
													<option value="Business Clubs/Organizations">Business Clubs/Organizations</option>
													<option value="Community Service/Volunteerism">Community Service/Volunteerism</option>
													<option value="Computing/Web/Internet">Computing/Web/Internet</option>
													<option value="Dance">Dance</option>
													<option value="Debate and Speech">Debate and Speech</option>
													<option value="Environmental Clubs/Orgs.">Environmental Clubs/Orgs.</option>
													<option value="Ethnic Clubs/Organizations">Ethnic Clubs/Organizations</option>
													<option value="Film, Television and Radio">Film, Television and Radio</option>
													<option value="GLBTQ/Gay-Straight Orgs.">GLBTQ/Gay-Straight Orgs.</option>
													<option value="Honor Societies/NHS">Honor Societies/NHS</option>
													<option value="Language Clubs/Organizations">Language Clubs/Organizations</option>
													<option value="Math Clubs/Organizations">Math Clubs/Organizations</option>
													<option value="Model United Nations">Model United Nations</option>
													<option value="Music - Instrumental">Music - Instrumental</option>
													<option value="Music - Vocal">Music - Vocal</option>
													<option value="Off-Campus Study or Travel">Off-Campus Study or Travel</option>
													<option value="Political Clubs/Organizations">Political Clubs/Organizations</option>
													<option value="Publications - Paper/Literary">Publications - Paper/Literary</option>
													<option value="Quiz Teams - Odyssey/Decathlon">Quiz Teams - Odyssey/Decathlon</option>
													<option value="Reading">Reading</option>
													<option value="Religious Clubs/Organizations">Religious Clubs/Organizations</option>
													<option value="Robotics">Robotics</option>
													<option value="Science Clubs/Organizations">Science Clubs/Organizations</option>
													<option value="Scouting: Girl/Boy/Eagle Scouts">Scouting: Girl/Boy/Eagle Scouts</option>
													<option value="Student Government">Student Government</option>
													<option value="Theater and Dramatics">Theater and Dramatics</option>
													<option value="Visual Arts">Visual Arts</option>
													<option value="Work/Jobs/Employment">Work/Jobs/Employment</option>
													<option value="Writing">Writing</option>
													<option value="Other (Please specify):">Other (Please specify):</option>
												</select>
-->
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addMultiSelectValidator("Contacts.685000000121649", 1, null, "Please select at least 1 item", { isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>
										<li class="control-draggable control-child-wrapper">
											<div id="IWDF-control-14" class="form-control field-control">
												<label for="Contacts.685000000121543" class="left" style="width: 150px">Other Interests</label>
												<input id="Contacts.685000000121543" maxlength="60" name="Contacts.685000000121543" value="" type="text" />
												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000121543", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
// ]]>
</script>
											</div>
										</li>
										<li class="clear-float"></li>

										<div id="IWDF-control-20" class="form-control field-control" style="margin-left: 10px;">
											<input style="float:left" type="checkbox" name="getParentInfo" id="getParentInfo" onClick="toggleParentDiv(this.checked)" />
											<label for="getParentInfo" style="width:385px; text-align:left" class="left">Click here if you want us to send information to your parents about Simon's Rock</label>
										</div>
<!-- HIDDEN PARENT INFO -->

										<div style="display:none; padding:10px; width:624px !important; border-radius: 10px" id="parentDiv">
										
											<div style="font-weight: bold; font-family: 'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif; font-size: 12px;">Parent/Guardian 1</div>

											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-16" class="form-control field-control">
													<label for="Contacts.685000000112005" class="left">Parent 1 Email</label>
													<input id="Contacts.685000000112005" maxlength="100" name="Contacts.685000000112005" value="" type="text" />
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
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-18" class="form-control field-control">
													<label for="Contacts.685000000112007" class="left">Parent 1 First Name</label>
													<input id="Contacts.685000000112007" maxlength="16" name="Contacts.685000000112007" value="" type="text" />
													<script type="text/javascript">
	// <![CDATA[
	_IW.FormValidator.addTextFieldValidator("Contacts.685000000112007", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
	// ]]>
	</script>
												</div>
											</li>
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-20" class="form-control field-control">
													<label for="Contacts.685000000112009" class="left">Parent 1 Last Name</label>
													<input id="Contacts.685000000112009" maxlength="30" name="Contacts.685000000112009" value="" type="text" />
													<script type="text/javascript">
	// <![CDATA[
	_IW.FormValidator.addTextFieldValidator("Contacts.685000000112009", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
	// ]]>
	</script>
												</div>
											</li>
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-22" class="form-control field-control">
													<label for="Contacts.685000000296104" class="left">Parent 1 lives with student</label>
													<input id="Contacts.685000000296104" name="Contacts.685000000296104" value="on" type="checkbox" />
												</div>
											</li>
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-24" class="form-control field-control">
													<label for="Contacts.685000000296102" class="left">Parent 1 Phone</label>
													<input id="Contacts.685000000296102" maxlength="20" name="Contacts.685000000296102" value="" type="text" />
													<script type="text/javascript">
	// <![CDATA[
	_IW.FormValidator.addTextFieldValidator("Contacts.685000000296102", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
	// ]]>
	</script>
												</div>
											</li>
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-26" class="form-control field-control">
													<label for="Contacts.685000000296092" class="left">Parent 1 Phone type</label>
													<select id="Contacts.685000000296092" name="Contacts.685000000296092">
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
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-28" class="form-control field-control">
													<label for="Contacts.685000000121005" class="left">Parent 1 Relationship</label>
													<select id="Contacts.685000000121005" name="Contacts.685000000121005">
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

											<div style="font-weight: bold; font-family: 'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif; font-size: 12px;">Parent/Guardian 2</div>

											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-30" class="form-control field-control">
													<label for="Contacts.685000000296122" class="left">Parent 2 Email</label>
													<input id="Contacts.685000000296122" maxlength="100" name="Contacts.685000000296122" value="" type="text" />
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
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-32" class="form-control field-control">
													<label for="Contacts.685000000296108" class="left">Parent 2 First Name</label>
													<input form="Contacts.685000000296108" id="Contacts.685000000296108" maxlength="16" name="Contacts.685000000296108" value="" type="text" />
													<script type="text/javascript">
	// <![CDATA[
	_IW.FormValidator.addTextFieldValidator("Contacts.685000000296108", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
	// ]]>
	</script>
												</div>
											</li>
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-34" class="form-control field-control">
													<label for="Contacts.685000000296106" class="left">Parent 2 Last Name</label>
													<input id="Contacts.685000000296106" maxlength="30" name="Contacts.685000000296106" value="" type="text" />
													<script type="text/javascript">
	// <![CDATA[
	_IW.FormValidator.addTextFieldValidator("Contacts.685000000296106", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
	// ]]>
	</script>
												</div>
											</li>
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-36" class="form-control field-control">
													<label for="Contacts.685000000296120" class="left">Parent 2 lives with student</label>
													<input id="Contacts.685000000296120" name="Contacts.685000000296120" value="on" type="checkbox" />
												</div>
											</li>
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-38" class="form-control field-control">
													<label for="Contacts.685000000296124" class="left">Parent 2 Phone</label>
													<input id="Contacts.685000000296124" maxlength="20" name="Contacts.685000000296124" value="" type="text" />
													<script type="text/javascript">
	// <![CDATA[
	_IW.FormValidator.addTextFieldValidator("Contacts.685000000296124", "notEmpty", null, { trim: true, isReqFunc: true, disabled: true });
	// ]]>
	</script>
												</div>
											</li>
											<li class="clear-float"></li>
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-40" class="form-control field-control">
													<label for="Contacts.685000000296126" class="left">Parent 2 phone type</label>
													<select id="Contacts.685000000296126" name="Contacts.685000000296126">
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
											<li class="control-draggable control-child-wrapper">
												<div id="IWDF-control-42" class="form-control field-control">
													<label for="Contacts.685000000296110" class="left">Parent 2 Relationship</label>
													<select id="Contacts.685000000296110" name="Contacts.685000000296110">
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
										</div>
									</ul>
								</div>
									
							</li>




<!-- HIDDEN INPUT, PREPOPULATED FROM PASSTHRU VALS
email
Last name
-->

						</ul>
					</div>
				</div>
				<div class="form-action-bar bottom" style="text-align:center">
				<input name="email" value="<?php echo($email); ?>" type="hidden" />
				<input name="lname" value="<?php echo($lname); ?>" type="hidden" />
				<input name="state" value="<?php echo($state); ?>" type="hidden" />
				
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
<script>
function toggleParentDiv(theVal){
	if(theVal){
		document.getElementById('parentDiv').style.display = '';
//		document.getElementById('addressDiv2').style.display = '';
		document.getElementById('parentDiv').style.background = '#dadada';
		document.getElementById('parentDiv').style.margin = '0 0 0 5px';
		document.getElementById('parentDiv').style.width = '443px';
		document.getElementById('parentDiv').style.border = '1px solid #BF2A23';
//		document.getElementById('stateDiv').style.padding = "0px";
//		document.getElementById('stateLabel').style.width = '219px';
	}
	else{
		document.getElementById('parentDiv').style.display = 'none';
//		document.getElementById('addressDiv2').style.display = 'none';
		document.getElementById('parentDiv').style.background = '#fff';
		document.getElementById('parentDiv').style.margin = '0 0 0 0';
		document.getElementById('parentDiv').style.width = '455px';
//		document.getElementById('stateDiv').style.padding = '1px 5px';
//		document.getElementById('stateLabel').style.width = '18em';
//		document.getElementById('addressLI').style.border = '0px solid #fff';
	}
}
</script>
	</div>
  </div>
</div>
<div class="spacer" style="height:50px"></div>