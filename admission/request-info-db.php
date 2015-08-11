<?php 
ini_set("display_errors","On");
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
// require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// $db = new DB(HOST,USER,PASSWORD,DATABASE);
// $db->connect();

if(isset($_POST['submit'])) {
	require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
	// build an error message if one needed
	$post_msg = "";
	
	foreach($_POST as $k => $v){
		//echo "KEY: $k, VAL: $v<br />";
		$$k = $v;
	}
	

	$parent_url = $_POST['parent_url'];
	if($parent_url != "inquire"){
		$requiredFields = array("fname","lname","street_address","city","state","zip","email","dob_month","dob_day","dob_year","high_school","high_school_state","anticipated_grad_year");
	}
	else{
		$requiredFields = array("fname","lname","street_address","city","state","zip","email","dob_month","dob_day","dob_year","high_school","high_school_state","anticipated_grad_year","how_did_you_hear");
	}

	if($_POST['high_school_state']=="NY"){
		 $requiredFields[] = "nycounty";
	}
	if($_POST['high_school_state']=="PA"){
		 $requiredFields[] = "paArea";
	}
	
	$firstToFix = "";
	foreach($requiredFields as $field){
		$select_str = strtolower($_POST["$field"]);
		if($_POST["$field"] == "" || strstr($select_str,"please select")){
			$post_msg .= $field."<br />";
			$field_msg = $field."_msg";
			$field_style = $field."_errors";
			$$field_msg = true;
			if($firstToFix == ""){
				$firstToFix = $field;
			}
		}
	}
	
    if($post_msg != ""){
    	$do_post_msg = true;
		$scrollup = true;
	}
    else{
		// get their state
		// exceptions: PA (West), PA (East),  NY (except NYC, Nassau & Suffok), NY (Nassau & Suffolk), 
		
		$territory = $_POST['high_school_state'];
		if($territory == "NY") {
			$territory = $_POST['nycounty'];
		}
		if($territory == "PA") {
			$territory = $_POST['paArea'];
		}
		$AEDArray = array('KY', 'TN', 'NC', 'SC', 'MS', 'AL', 'GA', 'FL', 'IA', 'MO', 'AR', 'WI', 'MN','NS');
		$JACArray = array('NJ', 'DE', 'MD', 'DC', 'VA', 'WV', 'TX', 'LA', 'IL', 'PAE');
		$JMPArray = array('MA', 'CT', 'RI', 'VT', 'NH', 'ME', 'OH', 'IN', 'MI','PAW','OTH');
		$MSArray  = array('NYC', 'AZ', 'CA', 'CO', 'ID', 'KS', 'MT', 'ND', 'NE', 'NM', 'NV', 'OK', 'SD', 'UT', 'WY');
		$SRCArray = array('OR', 'WA', 'AK', 'HI');
		if(in_array($territory,$AEDArray)){
			$redir = "amanda-dubrowski";
		}
		elseif(in_array($territory,$JACArray)){
			$redir = "corso";
		}
		elseif(in_array($territory,$JMPArray)){
			$redir = "joel-pitt";
		}
		elseif(in_array($territory,$MSArray)){
			$redir = "taylor";
		}
		elseif(in_array($territory,$SRCArray)){
			$redir = "coleman";
		}
		else{
			$redir = "on-the-road/locations-outside-the-united-states/davidson";
		}
		$redirStr  = "http://www.simons-rock.edu/admission/";
		$redirStr .= $redir;
		$redirStr .= "/";
//		echo "$redirStr";
		$doRedir = true;
		
		// fix some formatting
		if(isset($_POST['fname']) && $_POST['fname'] != ""){
			$fname = formatFirstname($_POST['fname']);
		}
		else {
			$fname = "";
		}
		if(isset($_POST['mname']) && $_POST['mname'] != ""){
			$mname = formatFirstname($_POST['mname']);
		}
		else {
			$mname = "";
		}
		if(isset($_POST['lname']) && $_POST['lname'] != ""){
			$lname = formatLastname($_POST['lname']);
		}
		else {
			$lname = "";
		}
		if(isset($_POST['nickname']) && $_POST['nickname'] != ""){
			$nickname = formatFirstname($_POST['nickname']);
		}
		else {
			$nickname = "";
		}
		if(isset($_POST['street_address']) && $_POST['street_address'] != ""){
			$street_address = formatAddress($_POST['street_address']);
		}
		else {
			$street_address = "";
		}
		if(isset($_POST['city']) && $_POST['city'] != ""){
			$city = formatCity($_POST['city']);
		}
		else {
			$city = "";
		}
		if(isset($_POST['zip']) && $_POST['zip'] != ""){
			$zip = formatZip($_POST['zip']);
		}			
		else {
			$zip = "";
		}
		// now build and send the email
		$body = "";
		$body .= "This request was submitted online at ". date('M j, Y ')."\n\n\n";
		$body .= "            Student First Name: $fname \n";
		$body .= "           Student Middle Name: $mname \n";
		$body .= "             Student Last Name: $lname \n";
		$body .= "                Usually Called: $nickname \n";
		$body .= "                        Gender: $gender \n";
		$body .= "                Street Address: $street_address \n";
		$body .= "                          City: $city \n";
		$body .= "                State/Province: ". $_POST['state']."\n";
		$body .= "                      Zip code: $zip \n";
		$body .= "                       Country: " . $_POST['country']."\n";
		$body .= "                 Email address: " . $_POST['email']."\n";
		$body .= "                         Phone: " . $_POST['phone']."\n";
		$body .= "                 Date of Birth: " . $_POST['dob_month']."/".$_POST['dob_day']."/".$_POST['dob_year']."\n";
		$body .= "                   High School: " . $_POST['high_school']."\n";
		$body .= "         High School City/Town: " . $_POST['high_school_city']."\n";
		$body .= "    High School State/Province: " . $_POST['high_school_state']."\n";
		if($_POST['high_school_state'] == "NY"){
			$body .= "     High School County/Region: " . $_POST['nycounty']."\n";
		}
		if($_POST['high_school_state'] == "PA"){
			$body .= "     High School County/Region: " . $_POST['paArea']."\n";
		}
		$body .= "           High School Country: " . $_POST['high_school_country']."\n";
		$body .= "Anticipated year of graduation: " . $_POST['anticipated_grad_year']."\n\n";
		$body .= "     How did you hear about SR? " . $_POST['how_did_you_hear'];
		if($parent_url == "inquire" && $_POST['how_did_you_hear'] == "Other"){
			$body .= ": \t( ".$_POST['how_hear_other']." )";
		}
		$body .= "\n\n";
		$body .= "            Academic Interests: " . $_POST['academic_interests']."\n\n";
		$body .= "    Extracurricular Activities: " . $_POST['extra_interests']."\n\n";
		$body .= "Ethnic Background\n";
		$body .= "     AF: ".$_POST['ethnicity_af']."\n";
		$body .= "     AI: ".$_POST['ethnicity_ai']."\tTribal affiliation: ".$_POST['ethnicity_ai_tribe']."     Enrolled: ".$_POST['ethnicity_ai_enrolled']."\n";
		$body .= "     AS: ".$_POST['ethnicity_as']."\t\tCountry/ies of family's origin: ".$_POST['as_origin_country']."\n";
		$body .= "     IS: ".$_POST['ethnicity_is']."\t\tCountry/ies: ".$_POST['is_origin_country']."\n";
		$body .= "     HS: ".$_POST['ethnicity_hs']."\t\tCountry/ies: ".$_POST['hs_origin_country']."\n";
		$body .= "     MA: ".$_POST['ethnicity_ma']."\n";
		$body .= "     NH: ".$_POST['ethnicity_nh']."\n";
		$body .= "     PR: ".$_POST['ethnicity_pr']."\n";
		$body .= "     UN: ".$_POST['ethnicity_un']."\n";
		$body .= "     WH: ".$_POST['ethnicity_wh']."\n";
		$body .= "     OT: ".$_POST['ethnicity_ot']."\t\tSpecify: ".$_POST['ot_specify']."\n\n";
//		$body .= "What three words capture your essence?: ".$_POST['']."\n";
// parent1_fname, parent1_lname, parent1_email, parent1_phone, parent1_phonetype
// parent2_fname, parent2_lname, parent2_email, parent2_phone, parent2_phonetype
		$body .= "           Parent 1 first name: ".$_POST['parent1_fname']."\n";
		$body .= "            Parent 1 last name: ".$_POST['parent1_lname']."\n";
		$body .= "                 Parent 1 type: ".$_POST['parent1_type']."\n";
		$body .= "                Parent 1 email: ".$_POST['parent1_email']."\n";
		$body .= "                Parent 1 phone: ".$_POST['parent1_phone']."\n";
		$body .= "           Parent 1 phone type: ".$_POST['parent1_phonetype']."\n";
		$body .= "           Parent 2 first name: ".$_POST['parent2_fname']."\n";
		$body .= "            Parent 2 last name: ".$_POST['parent2_lname']."\n";
		$body .= "                 Parent 2 type: ".$_POST['parent2_type']."\n";
		$body .= "                Parent 2 email: ".$_POST['parent2_email']."\n";
		$body .= "                Parent 2 phone: ".$_POST['parent2_phone']."\n";
		$body .= "           Parent 2 phone type: ".$_POST['parent2_phonetype']."\n";

		if($parent_url != "inquire"){
			$body .= "                  Mailing list: ".$_POST['mailinglist']."\n";
		}
		else{
			$body .= "What three words capture your essence: ".$_POST['three_words']."\n";
		}

		$body .= "I have additional questions, please contact me: ".$_POST['additional_questions']."\n";
		$body .= "Questions/Comments: ".$_POST['questions_and_comments']."\n\n";

		if($parent_url != "inquire"){
			$body .= "Form used: http://www.simons-rock.edu/admission/forms/request_info\n\n";
		}
		else{
			$body .= "Form used: http://www.simons-rock.edu/inquire\n\n";
		}

		if($parent_url != "inquire"){
			$subj = "Information Request";
		}
		else {
			$subj = "Information Request -- Search Inquiry Mailing";
		}

		$from = $_POST['email'];
		$headers = "From: $from";
		// mail("recruit@simons-rock.edu",$subj,$body,$headers);

		$body .= "\n\nPATH: $redirStr\n\n";
		mail("dscheff@simons-rock.edu",$subj,$body,$headers);

		/* #20120522 @dscheff - add record to db ********\
		**	INSERT INTO forms.contact
		**	(form_id, firstname, middlename, lastname, nickname, email, role, gender, street_address, street_address_2, city, state, country, postal_code, phone, dob, high_school, high_school_city, high_school_state, high_school_country, anticipated_grad_year, academic_interests, extra_curricular, ethnicity, reference, mail_list, `call`, comment, date_submitted) 
		**	VALUES (form_id, 'firstname', 'middlename', 'lastname', 'nickname', 'email', 'role', 'gender', 'street_address', 'street_address_2', 'city', 'state', 'country', 'postal_code', 'phone', 'dob', high_school, high_school_city, high_school_state, high_school_country, anticipated_grad_year, 'academic_interests', 'extra_curricular', ethnicity, 'reference', 'mail_list', 'call', 'comment', 'date_submitted');
		\************************************************/
		$CLEAN_POST = array();
		foreach($_POST as $k => $v){
			if($k == "fname" || $k == "mname" || $k == "nickname"){
				$v = formatFirstname($v);
			}
			else if($k == "lname"){
				$v = formatLastname($v);
			}
			else if($k == "street_address"){
				$v = formatAddress($v);
			}
			else if($k == "city"){
				$v = formatCity($v);
			}
			else if($k == "zip"){
				$v = formatZip($v);
			}
			$CLEAN_POST[$k] = safe($v);
			echo ("PRE-CLEAN $k : " . $v . "<br />");
			echo ("CLEAN $k : " . $CLEAN_POST[$k] . "<br /><br />");
		}
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Request Information</title>
<script>
<!--
function checkState(state){
	if(state == "NY"){
		document.getElementById('nycountyDiv').style.display = '';
		document.getElementById('paAreaDiv').style.display = 'none';
	}
	else if(state == "PA"){
		document.getElementById('paAreaDiv').style.display = '';
		document.getElementById('nycountyDiv').style.display = 'none';
	}
	else {
		document.getElementById('nycountyDiv').style.display = 'none';
		document.getElementById('paAreaDiv').style.display = 'none';
		if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "NY"){
			document.getElementById('nycountyDiv').style.display = '';
		}
		if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "PA"){
			document.getElementById('paAreaDiv').style.display = '';
		}
	}
}

function showDiv(val,div){
	if(val == 'Other'){
		document.getElementById(div).style.display = '';
	}
	else {
		document.getElementById(div).style.display = 'none';
	}
}

// -->
</script>
<?php
	$parent_url = $_REQUEST['parent_url'];
?>
<?php 
if($doRedir){
//	echo $body;
//	exit();
	echo "<script>
			window.top.location.href = \"$redirStr\";
		</script>";
}
?>
<style>
body{
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	background-color:#FFF;
}
p, h1, form, button{
	border:0; margin:0; padding:0;
}
.spacer{
	clear:both; height:1px;
}
/* ----------- My Form ----------- */
.myform{
	margin:0 auto;
	width:530px;
	padding:6px;
}
/* ----------- stylized ----------- */
#stylized{
	border:solid 1px #b7ddf2;
}
#stylized h1 {
	font-size:14px;
	font-weight:bold;
	margin-bottom:8px;
}
#stylized p{
	font-size:11px;
	color:#666666;
	margin-bottom:20px;
	border-bottom:solid 1px #b7ddf2;
	padding:10px;
}
#stylized label{
	display:block;
	text-align:right;
	width:140px;
	padding-top: 5px;
	float:left;
}
#stylized label.labelwide{
	width: 340px;
	text-align:left;
	padding: 0;
	margin: 0;
}
#stylized label.labelmed{
	text-align:right; 
	width: 180px;
	padding: 0;
	margin: 0;
}
#stylized label.labelsmall{
	text-align:right; 
	width: 25px;
	padding: 0;
	margin: 0;
}
#stylized .small{
	color:#666666;
	display:block;
	font-size:11px;
	font-weight:normal;
	text-align:right;
	width:140px;
}
#stylized input{
	float:left;
	font-size:11px;
	padding:4px 2px;
	border:solid 1px #aacfe4;
	width:200px;
	margin:2px 0 20px 10px;
}
#stylized select{
	float:left;
	font-size:12px;
	padding:4px 2px;
	border:solid 1px #aacfe4;
	width:206px;
	margin:2px 0 20px 10px;
}
#stylized input.radio{
	width: 10px;
	border: 0;
	margin-left: 5px;
	margin-right: 5px;
}
#stylized .radiorow1{
	background-color:#E9E9E9; 
	width:380px; 
	float:left;
}
#stylized .radiorow2{
	background-color: #D9D9D9; 
	width:380px; 
	float:left;
}
.radiolabels {
	clear:right; 
	float:left; 
	width: 150px; 
	padding-top: 3px;
}
#stylized button{
	clear:both;
	margin-left:150px;
	width:125px;
	height:31px;
	background:#666666 url(img/button.png) no-repeat;
	text-align:center;
	line-height:31px;
	color:#FFFFFF;
	font-size:11px;
	font-weight:bold;
}
.required {
	color:#FF0000;
	font-size:14px;
	padding: 0 5px;
}
.errors{
	background-color:#ffcccc;
}
</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17909295-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
	<div id="stylized" class="myform">
    	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onsubmit="return checkForm()" >
        <p><strong>Your Information</strong> ( * = required field)<br /><br />
        	<?php 
            if($do_post_msg){
            //	echo $post_msg;
                echo "Please complete all highlighted fields.";
            }
            ?>
        </p>
			
		<div style="clear:both">
          <label for="fname">Student First Name
          <?php 
			if(isset($fname_msg) && $fname_msg == true){
				echo '<span class="small">First name is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="fname" id="fname" class="<?php echo($required); ?>" value="<?php echo($fname);?>" /><span class="required">*</span>
          </div>
		<div style="clear:both">
          <label for="mname">Student Middle Name</label>
          <input type="text" name="mname" id="mname" value="<?php echo($mname);?>" />
		</div>

        <div style="clear:both">
          <label for="lname">Student Last Name
          <?php 
			if(isset($lname_msg) && $lname_msg == true){
				echo '<span class="small">Last name is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="lname" id="lname" value="<?php echo($lname);?>" class="<?php echo($required); ?>" /><span class="required">*</span>
        </div>
        
        <div style="clear:both">
          <label for="nickname">Usually Called
          </label>
          <input type="text" name="nickname" id="nickname" value="<?php echo($nickname);?>" />
		</div>
        <div style="clear: both">
          <label for="gender">Gender</label>
	      <div style="margin: 0 0 0 150px;">
              <div style="float:left">
	              <input class="radio" type="radio" name="gender" id="genderM" value="male" 
					<?php 
					if (isset($_POST['gender']) && $_POST['gender'] == "male")
					 echo " checked ";
					?>
				  />
                  	<label for="genderM" class="labelsmall">Male</label></div>
              <div style="padding: 0 0 0 10px; float:left">
    	          <input class="radio" type="radio" name="gender" id="genderF" value="female" 
					<?php 
					if (isset($_POST['gender']) && $_POST['gender'] == "female")
					 echo " checked ";
					?>
				  />
                  	<label for="genderF" class="labelsmall">Female</label></div>
          </div>
        </div>
        <div class="spacer"></div>
        <div style="clear:both">
          <label for="street_address">Street Address
          <?php 
			if(isset($street_address_msg) && $street_address_msg == true){
				echo '<span class="small">Street address is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="street_address" id="street_address" class="<?php echo($required); ?>" value="<?php echo($street_address);?>" /><span class="required">*</span>
        </div>
		<div style="clear:both">
		  <label for="city">City
          <?php 
			if(isset($city_msg) && $city_msg == true){
				echo '<span class="small">City is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="city" id="city" class="<?php echo($required); ?>" value="<?php echo($city);?>" /><span class="required">*</span>
        </div>
        <div style="clear:both">
          <label id="state_div" for="state">State/Province
          <?php 
			if(isset($state_msg) && $state_msg == true){
				echo '<span class="small">State is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <select name="state" id="state" class="<?php echo($required); ?>" />
			  <?php
			  if (isset($_POST['state']) && !(stristr($_POST['state'],"please select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['state']."</option>";
			  } 
    		  ?>
 			  <option>---Please Select---</option>
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
          <span class="required">*</span>
		</div>
        <div style="clear:both">
          <label for="zip">Zip/Postal Code
          <?php 
			if(isset($zip_msg) && $zip_msg == true){
				echo '<span class="small">Postal code is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="zip" id="zip" class="<?php echo($required); ?>" value="<?php echo($zip);?>" /><span class="required">*</span>
		</div>
        <div style="clear:both">
          <label for="country">Country
          </label>
          <input type="text" name="country" id="country" value="<?php echo($country); ?>" />
		</div>
        <div style="clear:both">
          <label for="email">Student E-mail
          <?php 
			if(isset($email_msg) && $email_msg == true){
				echo '<span class="small">Email is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label><span class="required">*</span>
          <input type="email" name="email" id="email" class="<?php echo($required); ?>" value="<?php echo($email);?>" style="margin:2px 0 4px 10px" />
          <div style="clear:both; padding: 0 0 10px 150px; font-size:10px">We won't ask you to type it twice (we know you hate that), but we do ask that you enter your email address carefully, as it is our primary mode of contact.</div>
		</div>
        <div style="clear:both">
          <label for="phone">Phone
          </label>
          <input type="text" name="phone" id="phone" value="<?php echo($phone); ?>" />
		</div>
        <div style="clear:both; padding: 10px 0 10px 130px; font-weight:bold">Date of Birth</div>
        <div style="clear:both">
          <label for="dob_month">Month
          <?php 
			if(isset($dob_month_msg) && $dob_month_msg == true){
				echo '<span class="small">Your date of birth month is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <select name="dob_month" id="dob_month" class="<?php echo($required); ?>" />
			  <?php
			  if (isset($_POST['dob_month']) && !(stristr($_POST['dob_month'],"Please Select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['dob_month']."</option>";
			  } 
    		  ?>
          	<option>---Please Select---</option>
          	<option>01</option>
          	<option>02</option>
          	<option>03</option>
          	<option>04</option>
          	<option>05</option>
          	<option>06</option>
          	<option>07</option>
          	<option>08</option>
          	<option>09</option>
          	<option>10</option>
          	<option>11</option>
          	<option>12</option>
          </select><span class="required">*</span>
        </div>
        <div style="clear:both">
          <label for="dob_day">Day
          <?php 
			if(isset($dob_day_msg) && $dob_day_msg == true){
				echo '<span class="small">Date of birth day is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <select name="dob_day" id="dob_day" class="<?php echo($required); ?>"  />
			  <?php
			  if (isset($_POST['dob_day']) && !(stristr($_POST['dob_day'],"please select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['dob_day']."</option>";
			  } 
    		  ?>
          	<option>---Please Select---</option>
          	<option>01</option>
          	<option>02</option>
          	<option>03</option>
          	<option>04</option>
          	<option>05</option>
          	<option>06</option>
          	<option>07</option>
          	<option>08</option>
          	<option>09</option>
          	<option>10</option>
          	<option>11</option>
          	<option>12</option>
          	<option>13</option>
          	<option>14</option>
          	<option>15</option>
          	<option>16</option>
          	<option>17</option>
          	<option>18</option>
          	<option>19</option>
          	<option>20</option>
          	<option>21</option>
          	<option>22</option>
          	<option>23</option>
          	<option>24</option>
          	<option>25</option>
          	<option>26</option>
          	<option>27</option>
          	<option>28</option>
          	<option>29</option>
          	<option>30</option>
          	<option>31</option>
          </select><span class="required">*</span>
        </div>
        <div style="clear:both">
          <label for="dob_year">Year
          <?php 
			if(isset($dob_year_msg) && $dob_year_msg == true){
				echo '<span class="small">Your date of birth year is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <select name="dob_year" id="dob_year" class="<?php echo($required); ?>" />
			  <?php
			  if (isset($_POST['dob_year']) && !(stristr($_POST['dob_year'],"Please Select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['dob_year']."</option>";
			  } 
    		  ?>
          	<option>---Please Select---</option>
          	<option>1980</option>
          	<option>1981</option>
          	<option>1982</option>
          	<option>1983</option>
          	<option>1984</option>
          	<option>1985</option>
          	<option>1986</option>
          	<option>1987</option>
          	<option>1988</option>
          	<option>1989</option>
          	<option>1990</option>
          	<option>1991</option>
          	<option>1992</option>
          	<option>1993</option>
          	<option>1994</option>
          	<option>1995</option>
          	<option>1996</option>
          	<option>1997</option>
          	<option>1998</option>
          	<option>1999</option>
          	<option>2000</option>
          </select><span class="required">*</span>
        </div>
        <div style="clear:both">
          <label for="high_school">High School
          <?php 
			if(isset($high_school_msg) && $high_school_msg == true){
				echo '<span class="small">High school is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="high_school" id="high_school" class="<?php echo($required); ?>" value="<?php echo($high_school);?>" /><span class="required">*</span>
		</div>        
        <div style="clear:both">
          <label for="high_school_city">High School City/Town</label>
          <input type="text" name="high_school_city" id="high_school_city" />
		</div>        
        <div style="clear:both">
          <label for="high_school_state">High School State/Province
          <?php 
			if(isset($high_school_state_msg) && $high_school_state_msg == true){
				echo '<span class="small">High school state is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <select name="high_school_state" id="high_school_state" class="<?php echo($required); ?>" onchange="checkState(this.value)" />
			  <?php
			  if (isset($_POST['high_school_state']) && !(stristr($_POST['high_school_state'],"Please Select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['high_school_state']."</option>";
			  } 
    		  ?>
              <option>---Please Select---</option>
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
          </select><span class="required">*</span>
		</div>

        <div id="nycountyDiv" style="clear:both; display:none;">
          <label for="nycounty">New York County
          <?php 
			if(isset($nycounty_msg) && $nycounty_msg == true){
				echo '<span class="small">New York area is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <select name="nycounty" id="nycounty" class="<?php echo($required); ?>" />
			  <?php
			  if (isset($_POST['nycounty']) && !(stristr($_POST['nycounty'],"Please Select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['nycounty']."</option>";
			  } 
    		  ?>
              <option>---Please Select---</option>
              <option value="NS">Nassau/Suffolk</option>
              <option value="NYC">New York City/Five Boroughs</option>
              <option value="OTH">Other</option>
          </select><span class="required">*</span>
		</div>

        <div id="paAreaDiv" style="clear:both; display:none;">
          <label for="paArea">Area of PA
          <?php 
			if(isset($paArea_msg) && $paArea_msg == true){
				echo '<span class="small">Area of PA is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <select name="paArea" id="paArea" class="<?php echo($required); ?>" />
			  <?php
			  if (isset($_POST['paArea']) && !(stristr($_POST['paArea'],"Please Select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['paArea']."</option>";
			  } 
    		  ?>
              <option>---Please Select---</option>
              <option value="PAE">Zip code starting with 164-194</option>
              <option value="PAW">Zip code starting with 150-168</option>
          </select><span class="required">*</span>
		</div>

        <div style="clear:both">
          <label for="high_school_country">High School Country</label>
          <input type="text" name="high_school_country" id="high_school_country" value="<?php echo($high_school_country);?>" />
		</div>        
        <div style="clear:both">
          <label for="anticipated_grad_year">Anticipated Year of Graduation
          <?php 
			if(isset($anticipated_grad_year_msg) && $anticipated_grad_year_msg == true){
				echo '<span class="small">Anticipated graduation year is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="anticipated_grad_year" id="anticipated_grad_year" class="<?php echo($required); ?>" value="<?php echo($anticipated_grad_year);?>" /><span class="required">*</span>
		</div>        
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="academic_interests">Academic Interests</label>
          <textarea style="width: 350px; height: 80px; margin: 0 0 0 10px;" name="academic_interests" id="academic_interests" /><?php echo($academic_interests);?></textarea>
		</div>
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="extra_interests">Extra Curricular Interests</label>
          <textarea style="width: 350px; height: 80px; margin: 0 0 0 10px;" name="extra_interests" id="extra_interests" /><?php echo($extra_interests);?></textarea>
		</div>
		

<?php
if($parent_url == "inquire"){
?>
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="three_words">What three words capture your essence?</label>
          <textarea style="width: 350px; height: 80px; margin: 0 0 0 10px;" name="three_words" id="three_words" /><?php echo($three_words);?></textarea>
		</div>

<?php
}
?>		
		
        <div style="clear:both; width:500px; text-align:center; padding: 10px 0 10px 40px; font-weight:bold">
		        	Ethnic Background (Optional) <em>Please check all that apply</em>
		</div>
        <div style="clear:both; margin-left: 150px ">
			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_af" id="ethnicity_af" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_af']) && $_POST['ethnicity_af'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div class="radiolabels" >
            	<label for="ethnicity_af" class="labelwide">African American, Black</label>            	
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:left;" >
                	<input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_ai" id="ethnicity_ai" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_ai']) && $_POST['ethnicity_ai'] == "Yes"){
					 echo " checked ";
					}
					?>
					 />
				</div>
                <div class="radiolabels">
	                <label for="ethnicity_ai" class="labelwide">American Indian, Alaska Native</label>
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label for="ethnicity_ai_tribe" style="margin:0"><em>tribal affiliation:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="ethnicity_ai_tribe" id="ethnicity_ai_tribe" value="<?php echo($ethnicity_ai_tribe);?>" /></div>
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label for="ethnicity_ai_enrolled" style="margin:0"><em>enrolled:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="ethnicity_ai_enrolled" id="ethnicity_ai_enrolled" value="<?php echo($ethnicity_ai_enrolled);?>" /></div>
                </div>
            </div>
            
			<div class="radiorow1">
            	<div style="clear:none; float:left;" >
                	<input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_as" id="ethnicity_as" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_as']) && $_POST['ethnicity_as'] == "Yes"){
					 echo " checked ";
					}
					?>					
					 />
				</div>
                <div class="radiolabels">
	                <label for="ethnicity_as" class="labelwide">Asian American</label>
                </div>
            </div>
			<div class="radiorow1">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label class="labelmed" for="as_origin_country" style="margin:0"><em>country/ies of family's origin:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="as_origin_country" id="as_origin_country" value="<?php echo($as_origin_country);?>" /></div>
                </div>
            </div>            
            
			<div class="radiorow2">
            	<div style="clear:none; float:left;" >
                	<input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_is" id="ethnicity_is" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_is']) && $_POST['ethnicity_is'] == "Yes"){
					 echo " checked ";
					}
					?>							
					 />
				</div>
                <div class="radiolabels">
	                <label for="ethnicity_is" class="labelwide">Asian, including the Indian Subcontinent</label>
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label class="labelmed" for="is_origin_country" style="margin:0"><em>country/ies:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="is_origin_country" id="is_origin_country" value="<?php echo($is_origin_country);?>" /></div>
                </div>
            </div>

			<div class="radiorow1">
            	<div style="clear:none; float:left;" >
                	<input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_hs" id="ethnicity_hs" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_hs']) && $_POST['ethnicity_hs'] == "Yes"){
					 echo " checked ";
					}
					?>								
					 />
				</div>
                <div class="radiolabels">
	                <label for="ethnicity_hs" class="labelwide">Hispanic, Latino/Latina</label>
                </div>
            </div>
			<div class="radiorow1">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label class="labelmed" for="hs_origin_country" style="margin:0"><em>country/ies:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="hs_origin_country" id="hs_origin_country" value="<?php echo($hs_origin_country);?>" /></div>
                </div>
            </div>

			<div class="radiorow2">
            	<div style="clear:none; float:left;" >
                <input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_ma" id="ethnicity_ma" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_ma']) && $_POST['ethnicity_ma'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div class="radiolabels">
            	<label for="ethnicity_ma" class="labelwide">Mexican American, Chicano/Chicana</label>            	
                </div>
            </div>

			<div class="radiorow1">
            	<div style="clear:none; float:left;" >
                <input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_nh" id="ethnicity_nh" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_nh']) && $_POST['ethnicity_nh'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div class="radiolabels">
            	<label for="ethnicity_nh" class="labelwide">Native Hawaiian, Pacific Islander</label>            	
                </div>
            </div>

			<div class="radiorow2">
            	<div style="clear:none; float:left;" >
                <input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_pr" id="ethnicity_pr" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_pr']) && $_POST['ethnicity_pr'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div class="radiolabels">
            	<label for="ethnicity_pr" class="labelwide">Puerto Rican</label>
                </div>
            </div>
			<div class="radiorow1">
            	<div style="clear:none; float:left;" >
                <input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_un" id="ethnicity_un" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_un']) && $_POST['ethnicity_un'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div class="radiolabels">
            	<label for="ethnicity_un" class="labelwide">Unknown</label>
                </div>
            </div>

			<div class="radiorow2">
            	<div style="clear:none; float:left;" >
                <input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_wh" id="ethnicity_wh" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_wh']) && $_POST['ethnicity_wh'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div class="radiolabels">
            	<label for="ethnicity_wh" class="labelwide">White, Caucasian</label>
                </div>
            </div>


			<div class="radiorow1">
            	<div style="clear:none; float:left;" >
                	<input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_ot" id="ethnicity_ot" value="Yes"
					<?php 
					if (isset($_POST['ethnicity_ot']) && $_POST['ethnicity_ot'] == "Yes"){
					 echo " checked ";
					}
					?>
					 />
				</div>
                <div class="radiolabels">
	                <label for="ethnicity_ot" class="labelwide">Other</label>
                </div>
            </div>
			<div class="radiorow1">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label class="labelmed" for="ot_specify" style="margin:0"><em>specify:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="ot_specify" id="ot_specify" value="<?php echo($ot_specify);?>" /></div>
                </div>
            </div>
		</div>




		<div class="spacer" style="clear:both; height:15px;"></div>
        
        <p><strong>Parent Information</strong></p>
		<div style="padding: 0 15px 15px 15px">We find that the decision to apply to Simon's Rock is best made after a conversation between the student and their family.  We are interested in providing as much information as we can to facilitate this effort.  If you would like us to contact your parent(s) directly, please provide their contact information below.</div>

		<div style="clear:both">
          <label for="parent1_fname">Parent 1 First Name
          </label>
          <input type="text" name="parent1_fname" id="parent1_fname" value="<?php echo($parent1_fname);?>" />
        </div>
		<div style="clear:both">
          <label for="parent1_lname">Parent 1 Last Name
          </label>
          <input type="text" name="parent1_lname" id="parent1_lname" value="<?php echo($parent1_lname);?>" />
		</div>

        <div style="clear: both">
          <label for="parent1_type">Relationship to Student</label>
	      <div style="margin: 0 0 0 150px;">
              <div style="float:left">
	              <input class="radio" type="radio" name="parent1_type" id="parent1_typeM" value="mother" 
					<?php 
					if (isset($_POST['parent1_type']) && $_POST['parent1_type'] == "mother")
					 echo " checked ";
					?>
				  />
                  	<label for="parent1_typeM" class="labelsmall">Mother</label></div>
              <div style="padding: 0 0 0 20px; float:left">
    	          <input class="radio" type="radio" name="parent1_type" id="parent1_typeF" value="father" 
					<?php 
					if (isset($_POST['parent1_type']) && $_POST['parent1_type'] == "father")
					 echo " checked ";
					?>
				  />
                  	<label for="parent1_typeF" class="labelsmall">Father</label></div>
              <div style="padding: 0 0 0 20px; float:left">
    	          <input class="radio" type="radio" name="parent1_type" id="parent1_typeG" value="guardian" 
					<?php 
					if (isset($_POST['parent1_type']) && $_POST['parent1_type'] == "guardian")
					 echo " checked ";
					?>
				  />
                  	<label for="parent1_typeG" class="labelsmall">Guardian</label></div>
          </div>
        </div>



		<div style="clear:both">
          <label for="parent1_email">Parent 1 E-mail
          </label>
          <input type="text" name="parent1_email" id="parent1_email" value="<?php echo($parent1_email);?>" />
		</div>
		<div style="clear:both">
          <label for="parent1_phone">Parent 1 Phone
          </label>
          <input type="text" name="parent1_phone" id="parent1_phone" value="<?php echo($parent1_phone);?>" />
		</div>
        <div style="clear: both">
          <label>Phone Type</label>
	      <div style="margin: 0 0 0 150px;">
              <div style="float:left">
	              <input class="radio" type="radio" name="parent1_phonetype" id="parent1_phonetype_cell" value="c"
					<?php 
					if (isset($_POST['parent1_phonetype']) && $_POST['parent1_phonetype'] == "c"){
					 echo " checked ";
					}
					?>				  
				   />
                  	<label for="parent1_phonetype_cell" class="labelsmall">Cell</label></div>
              <div style="padding: 0 0 0 10px; float:left">
    	          <input class="radio" type="radio" name="parent1_phonetype" id="parent1_phonetype_home" value="h"
					<?php 
					if (isset($_POST['parent1_phonetype']) && $_POST['parent1_phonetype'] == "h"){
					 echo " checked ";
					}
					?>
				   />
                  	<label for="parent1_phonetype_home" class="labelsmall">Home</label></div>
              <div style="padding: 0 0 0 10px; float:left">
    	          <input class="radio" type="radio" name="parent1_phonetype" id="parent1_phonetype_biz" value="b" 
					<?php 
					if (isset($_POST['parent1_phonetype']) && $_POST['parent1_phonetype'] == "b"){
					 echo " checked ";
					}
					?>
				  />
                  	<label for="parent1_phonetype_biz" class="labelsmall">Business</label></div>
          </div>
        </div>

		<div style="clear:both">
          <label for="parent2_fname">Parent 2 First Name</label>
          <input type="text" name="parent2_fname" id="parent2_fname" value="<?php echo($parent2_fname);?>" />
        </div>
		<div style="clear:both">
          <label for="parent2_lname">Parent 2 Last Name
          </label>
          <input type="text" name="parent2_lname" id="parent2_lname" value="<?php echo($parent2_lname);?>" />
		</div>
        <div style="clear: both">
          <label for="parent2_type">Relationship to Student</label>
	      <div style="margin: 0 0 0 150px;">
              <div style="float:left">
	              <input class="radio" type="radio" name="parent2_type" id="parent2_typeM" value="mother" 
					<?php 
					if (isset($_POST['parent2_type']) && $_POST['parent2_type'] == "mother")
					 echo " checked ";
					?>
				  />
                  	<label for="parent2_typeM" class="labelsmall">Mother</label></div>
              <div style="padding: 0 0 0 20px; float:left">
    	          <input class="radio" type="radio" name="parent2_type" id="parent2_typeF" value="father" 
					<?php 
					if (isset($_POST['parent2_type']) && $_POST['parent2_type'] == "father")
					 echo " checked ";
					?>
				  />
                  	<label for="parent2_typeF" class="labelsmall">Father</label></div>
              <div style="padding: 0 0 0 20px; float:left">
    	          <input class="radio" type="radio" name="parent2_type" id="parent2_typeG" value="guardian" 
					<?php 
					if (isset($_POST['parent2_type']) && $_POST['parent2_type'] == "guardian")
					 echo " checked ";
					?>
				  />
                  	<label for="parent2_typeG" class="labelsmall">Guardian</label></div>
          </div>
        </div>
		<div style="clear:both">
          <label for="parent2_email">Parent 2 E-mail
          </label>
          <input type="text" name="parent2_email" id="parent2_email" value="<?php echo($parent2_email);?>" />
		</div>
		<div style="clear:both">
          <label for="parent2_phone">Parent 2 Phone
          </label>
          <input type="text" name="parent2_phone" id="parent2_phone" value="<?php echo($parent2_phone);?>" />
		</div>
        <div style="clear: both">
          <label>Phone Type</label>
	      <div style="margin: 0 0 0 150px;">
              <div style="float:left">
	              <input class="radio" type="radio" name="parent2_phonetype" id="parent2_phonetype_cell" value="c"
					<?php 
					if (isset($_POST['parent2_phonetype']) && $_POST['parent2_phonetype'] == "c"){
					 echo " checked ";
					}
					?>
				   />
                  	<label for="parent2_phonetype_cell" class="labelsmall">Cell</label></div>
              <div style="padding: 0 0 0 10px; float:left">
    	          <input class="radio" type="radio" name="parent2_phonetype" id="parent2_phonetype_home" value="h"
					<?php 
					if (isset($_POST['parent2_phonetype']) && $_POST['parent2_phonetype'] == "h"){
					 echo " checked ";
					}
					?>
					/>
                  	<label for="parent2_phonetype_home" class="labelsmall">Home</label></div>
              <div style="padding: 0 0 0 10px; float:left">
    	          <input class="radio" type="radio" name="parent2_phonetype" id="parent2_phonetype_biz" value="b"
					<?php 
					if (isset($_POST['parent2_phonetype']) && $_POST['parent2_phonetype'] == "b"){
					 echo " checked ";
					}
					?>
				  />
                  	<label for="parent2_phonetype_biz" class="labelsmall">Business</label></div>
          </div>
        </div>

		<p style="clear:both"></p>

<?php
if($parent_url != "inquire"){
?>
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="how_did_you_hear">How did you hear about Simon's Rock?</label>
          <textarea style="width: 350px; height: 80px; margin: 0 0 0 10px;" name="how_did_you_hear" id="how_did_you_hear" /><?php echo($how_did_you_hear);?></textarea>
		</div>
		<div class="spacer" style="clear:both"></div>
<?php
}
else{
?>
        <div style="clear:both; padding: 0 0 10px 0; ">
		<label for="how_did_you_hear">How did you hear about Simon's Rock?
          <?php 
			if(isset($dob_year_msg) && $dob_year_msg == true){
				echo '<span class="small">How you heard is a required field.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <select name="how_did_you_hear" id="how_did_you_hear" class="<?php echo($required); ?>"  onchange="showDiv(this.value,'how_hear_other_div')" />
			  <?php
			  if (isset($_POST['dob_year']) && !(stristr($_POST['how_did_you_hear'],"Please Select")) ) { 
			  	echo "<option selected=\"selected\" value=\"".$_POST['how_did_you_hear']."\">".$_POST['how_did_you_hear']."</option>";
			  } 
    		  ?>
          	<option>---Please Select---</option>
          	<option value="Pamphlet in the mail">Pamphlet in the mail</option>
          	<option value="">College fair/High school visit</option>
          	<option value="Email">Email</option>
          	<option value="Other">Other</option>
          </select><span class="required">*</span>
		</div>
		<div class="spacer" style="clear:both"></div>
		<div  style="display:none" id="how_hear_other_div">
			<div style="clear:none; float:right; margin-right: 150px" >
				<div style="clear:none; float:left" >
					<label class="labelmed" for="how_hear_other" style="margin:0"><em>please specify:</em></label></div>
				<div style="clear:none; float:left" >
					<input style="width: 90px; margin: 2px" type="text" name="how_hear_other" id="how_hear_other" value="<?php echo($ot_specify);?>" /><span class="required">*</span></div>
			</div>
		</div>
		<div class="spacer" style="clear:both"></div>
<?php
}
?>


        <div style="clear:both; margin-left: 150px ">

<?php
if($parent_url != "inquire"){
?>
			<div style="clear:both;">
            	<div style="clear:none; float:left;" >
                <input class="radio" style="margin-bottom: 0;" type="checkbox" name="mailinglist" id="mailinglist" value="Yes"
					<?php 
					if (isset($_POST['mailinglist']) && $_POST['mailinglist'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div class="radiolabels">
            	<label for="mailinglist" class="labelwide">YES, put me on your mailing list.</label>
                </div>
            </div>

<?php
}
?>

			<div style="clear:both;">
            	<div style="clear:none; float:left;" >
                <input class="radio" style="margin-bottom: 0;" type="checkbox" name="additional_questions" id="additional_questions" value="Yes"
					<?php 
					if (isset($_POST['additional_questions']) && $_POST['additional_questions'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div class="radiolabels">
            	<label for="additional_questions" class="labelwide">I have additional questions. Please have my admission counselor contact me</label>
                </div>
            </div>
        </div>
		<div class="spacer" style="clear:both"></div>
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="questions_and_comments">Please note questions and comments here:</label>
          <textarea style="width: 350px; height: 80px; margin: 0 0 0 10px;" name="questions_and_comments" id="questions_and_comments" /><?php echo($questions_and_comments);?></textarea>
		</div>
			<input type="hidden" name="parent_url" value="<?php echo($parent_url); ?>" />
          <button type="submit" name="submit" id="submit">Request Info</button>
          <div class="spacer"></div>
          </form>
      </div>
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

		if (document.request.street_address.value.length == 0) {
            document.request.street_address.style.backgroundColor = highlight
			if(fieldFocus == ""){
				fieldFocus = "street_address";
			}
			rval = false
        } 
		else {
            document.request.street_address.style.backgroundColor = normal
		}

		if (document.request.city.value.length == 0) {
            document.request.city.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "city";
			}
        } 
		else {
            document.request.city.style.backgroundColor = normal
		}

		if (document.getElementById('state').options[document.getElementById('state').selectedIndex].value == '---Please Select---')  {
            document.request.state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "state";
			}
        } 
		else {
            document.request.state.style.backgroundColor = normal
		}

        if (document.request.zip.value.length == 0) {
            document.request.zip.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "zip";
			}
        } 
		else {
            document.request.zip.style.backgroundColor = normal
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

		if (document.getElementById('dob_month').options[document.getElementById('dob_month').selectedIndex].value == '---Please Select---')  {
            document.request.dob_month.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "dob_month";
			}
        } 
		else {
            document.request.dob_month.style.backgroundColor = normal
		}
			
		if (document.getElementById('dob_day').options[document.getElementById('dob_day').selectedIndex].value == '---Please Select---') {
            document.request.dob_day.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "dob_day";
			}
        } 
		else {
            document.request.dob_day.style.backgroundColor = normal
		}


		if (document.getElementById('dob_year').options[document.getElementById('dob_year').selectedIndex].value == '---Please Select---') {
            document.request.dob_year.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "dob_year";
			}
        } 
		else {
            document.request.dob_year.style.backgroundColor = normal
		}

        if (document.request.high_school.value.length == 0) {
            document.request.high_school.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "high_school";
			}
        } 
		else {
            document.request.high_school.style.backgroundColor = normal
		}

		if (document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == '---Please Select---') {
            document.request.high_school_state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "high_school_state";
			}
        } 
		else {
            document.request.high_school_state.style.backgroundColor = normal
		}
		if (document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == 'NY') {
		if (document.getElementById('nycounty').options[document.getElementById('nycounty').selectedIndex].value == '---Please Select---') {
				document.request.nycounty.style.backgroundColor = highlight
	            rval = false
				if(fieldFocus == ""){
					fieldFocus = "nycounty";
				}
			}
			else {
				document.request.nycounty.style.backgroundColor = normal
			}
        } 
		if (document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == 'PA') {
			if (document.getElementById('paArea').options[document.getElementById('paArea').selectedIndex].value == '---Please Select---')  {
				document.request.paArea.style.backgroundColor = highlight
	            rval = false
				if(fieldFocus == ""){
					fieldFocus = "paArea";
				}
			}
			else {
				document.request.paArea.style.backgroundColor = normal
			}
        } 




        if (document.request.anticipated_grad_year.value.length == 0) {
            document.request.anticipated_grad_year.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "anticipated_grad_year";
			}
        } 
		else {
            document.request.anticipated_grad_year.style.backgroundColor = normal
		}

<?php
if($parent_url == "inquire"){
?>
		if (document.getElementById('how_did_you_hear').options[document.getElementById('how_did_you_hear').selectedIndex].value == '---Please Select---') {
            document.request.how_did_you_hear.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "how_did_you_hear";
			}
		} 
		else {
            document.request.how_did_you_hear.style.backgroundColor = normal
			if (
			  (document.getElementById('how_did_you_hear').options[document.getElementById('how_did_you_hear').selectedIndex].value == 'Other') 
			  && document.getElementById('how_hear_other').value.length == 0) {
				document.request.how_hear_other.style.backgroundColor = highlight
				rval = false
				if(fieldFocus == ""){
					fieldFocus = "how_hear_other";
				}
			} 
			else{
	            document.request.how_hear_other.style.backgroundColor = normal
			}
		}
<?php
}
?>			
			
/*		if (!checkemail(document.request.email.value )) {
            document.request.email.style.backgroundColor = highlight                    
            rval = false
        } else 
            document.request.email.style.backgroundColor = normal
*/

        if (!rval) {
			alert ("Please complete all required (highlighted) fields prior to submitting your form.");
			document.getElementById(fieldFocus).focus();
			document.getElementById(fieldFocus).style.display='';
		}
		if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "NY"){
			document.getElementById('nycountyDiv').style.display = '';
			document.getElementById('paAreaDiv').style.display = 'none';
		}
		if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "PA"){
			document.getElementById('paAreaDiv').style.display = '';
			document.getElementById('nycountyDiv').style.display = 'none';
		}		
        return rval
    } else
        return true
}
if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "NY"){
	document.getElementById('nycountyDiv').style.display = '';
	document.getElementById('paAreaDiv').style.display = 'none';
}
if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "PA"){
	document.getElementById('paAreaDiv').style.display = '';
	document.getElementById('nycountyDiv').style.display = 'none';
}		
// -->
</script>
<script>
scrollup = '<?php echo($scrollup); ?>';
if(scrollup == '1'){
	document.getElementById('<?php echo($firstToFix); ?>').focus();
}
</script>
</body>
</html>