<?php 
ini_set("display_errors","On");
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
// require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// $db = new DB(HOST,USER,PASSWORD,DATABASE);
// $db->connect();

if(isset($_POST['submit'])) {

	// build an error message if one needed
	$post_msg = "";
	
	foreach($_POST as $k => $v){
		//echo "KEY: $k, VAL: $v<br />";
		$$k = $v;
	}
	
	$requiredFields = array("first_name","last_name","alumni_class_year","alumni_email","degree_earned");

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

		$redirStr  = "http://simons-rock.edu/alumni/forms/thank-you-update-info";
		$doRedir = true;

		$subj = "Alumni Contact Information Update";
		
		// now build and send the email
		$body = "";
		$body .= "This request was submitted online at ". date('M j, Y ')."\n\n\n";
		$body .= "ALUM\n";
		$body .= "----\n";
		$body .= "             First Name: " . $_POST['first_name']."\n";
		$body .= "            Maiden Name: " . $_POST['maiden_name']."\n";
		$body .= "              Last Name: " . $_POST['last_name']."\n";
		$body .= "             Entry Year: " . $_POST['alumni_class_year']."\n";
		$body .= "          Degree Earned: " . $_POST['degree_earned']."\n\n";
		$body .= "NEW CONTACT INFORMATION\n";
		$body .= "-----------------------\n";
		$body .= "       Street Address 1: " . $_POST['street']."\n";
		$body .= "       Street Address 2: " . $_POST['street2']."\n";
		$body .= "                   City: " . $_POST['alumni_city']."\n";
		$body .= "         State/Province: " . $_POST['alumni_state']."\n";
		$body .= "               Zip code: " . $_POST['zip']."\n";
		$body .= "                Country: " . $_POST['country']."\n";
		$body .= "          Email address: " . $_POST['alumni_email']."\n";
		$body .= "           Phone (home): " . $_POST['home_phone']."\n";
		$body .= "           Phone (cell): " . $_POST['cell_phone']."\n";
		$body .= "       Phone (business): " . $_POST['business_phone']."\n\n";
		$body .= "ADVANCED DEGREE INFORMATION\n";
		$body .= "---------------------------\n";
		$body .= "     Advanced Degree(s): " . $_POST['advanced_degrees']."\n";
		$body .= "         Institution(s): " . $_POST['institutions']."\n";
		$body .= "        Year(s) Awarded: " . $_POST['years_awarded']."\n\n";
		$body .= "NEW JOB INFORMATION\n";
		$body .= "-------------------\n";
		$body .= "                  Title: " . $_POST['job_title']."\n";
		$body .= "                Company: " . $_POST['company']."\n";
		$body .= "       Street Address 1: " . $_POST['company_street']."\n";
		$body .= "       Street Address 2: " . $_POST['company_street2']."\n";
		$body .= "                   City: " . $_POST['company_city']."\n";
		$body .= "         State/Province: " . $_POST['company_state']."\n";
		$body .= "               Zip code: " . $_POST['company_zip']."\n";
		$body .= "                Country: " . $_POST['company_country']."\n";
		$body .= "                  Email: " . $_POST['company_email']."\n\n";
		$body .= "NEW ROCKER FAMILY INFORMATION\n";
		$body .= "-----------------------------\n";
		$body .= "     Child's First Name: " . $_POST['child_first_name']."\n";
		$body .= "      Child's Last Name: " . $_POST['child_last_name']."\n";
		$body .= "                 Gender: " . $_POST['child_gender']."\n";
		$body .= "          Date of Birth: " . $_POST['child_dob']."\n\n";
		$body .= "OTHER NEWS\n";
		$body .= "----------\n";
		$body .= $_POST['other_news'];


		$from = $_POST['alumni_email'];
		$headers = "From: $from";

 		mail("alumni@simons-rock.edu",$subj,$body,$headers);

		mail("dscheff@simons-rock.edu",$subj,$body,$headers);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update your information</title>
<?php 
if($doRedir){
//	echo $body;
//	exit();
	echo "<script>
			window.top.location.href = \"$redirStr\";
		</script>";
}
?>
<script language="JavaScript">


function CountWords (this_field, show_word_count, show_char_count, doAlert) {
	if (show_word_count == null) {
		show_word_count = true;
	}
	if (show_char_count == null) {
		show_char_count = false;
	}
	var char_count = this_field.value.length;
	var fullStr = this_field.value + " ";
	var initial_whitespace_rExp = /^[^A-Za-z0-9]+/gi;
	var left_trimmedStr = fullStr.replace(initial_whitespace_rExp, "");
	var non_alphanumerics_rExp = rExp = /[^A-Za-z0-9]+/gi;
	var cleanedStr = left_trimmedStr.replace(non_alphanumerics_rExp, " ");
	var splitString = cleanedStr.split(" ");
	var word_count = splitString.length -1;

	if (fullStr.length <2) {
		word_count = 0;
	}
	if (word_count > 250) {
		if(doAlert == true){
			alert ("Please limit the number of words to 250 or fewer. \mYour current word count is " + word_count);
		}
		else{
			return true;
		}
	}
	return word_count;
}
</script>
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
	width:auto;
	padding:6px;
}
/* ----------- stylized ----------- */
#stylized{
	border:0;
}
#stylized h1 {
	font-size:14px;
	font-weight:bold;
	margin-bottom:8px;
}
#stylized p{
	color:#666666;
	margin-bottom:20px;
	border-bottom:solid 1px #b7ddf2;
	padding:10px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
#stylized label{
	display:block;
	text-align:right;
	width:250px;
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
	margin-left:218px;
	width:125px;
	height:31px;
	background:#666666 url(img/button.png) no-repeat;
	text-align:center;
	line-height:31px;
	color:#FFFFFF;
	font-size:11px;
	font-weight:bold;
	cursor:pointer;
}
.required {
	color:#FF0000;
	font-size:14px;
	padding: 0 5px;
}
.errors{
	background-color:#ffcccc;
}
fieldset{
	background: #f4f4f4;
	border-radius: 10px !important;
	margin-bottom: 10px;
	width: 550px;
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
        <p>
        	Tell us about your new job, advanced degree, honors and awards. Are you newly married? Do you have a new baby or a grandchild? Have you moved?<br /><br />
			Please share your latest contact info so we can invite you to upcoming events and send you the latest news from the Rock!<br /><br />
        ( * = required field)
        	<?php 
            if($do_post_msg){
            //	echo $post_msg;
                echo "Please complete all highlighted fields.";
            }
            ?>
        </p>
		
        <fieldset>
        <legend>Your Information</legend>
		<div style="clear:both">
          <label for="first_name">First name
          <?php 
			if(isset($first_name_msg) && $first_name_msg == true){
				echo '<span class="small">First name is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="first_name" id="first_name" class="<?php echo($required); ?>" value="<?php echo($first_name);?>" />
          <span class="required">*</span>
        </div>
		<div style="clear:both">
          <label for="maiden_name">Maiden name
          </label>
          <input type="text" name="maiden_name" id="maiden_name" class="<?php echo($required); ?>" value="<?php echo($maiden_name);?>" />
        </div>
		<div style="clear:both">
          <label for="last_name">Last name:
          <?php 
			if(isset($last_name_msg) && $last_name_msg == true){
				echo '<span class="small">Last name is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="last_name" id="last_name" class="<?php echo($required); ?>" value="<?php echo($last_name);?>" />
          <span class="required">*</span>
        </div>

		<div style="clear:both">
			<label for="alumni_class_year">Entry year
			  <?php 
				if(isset($alumni_class_year_msg) && $alumni_class_year_msg == true){
					echo '<span class="small">Entry year is required.</span>';
					$required = "errors";
				}
				else{
					$required = "";
				}
			  ?>
			</label>
			<input type="text" name="alumni_class_year" id="alumni_class_year" class="<?php echo($required); ?>" value="<?php echo($alumni_class_year);?>" />
			<span class="required">*</span>
		</div>

        <div style="clear:both">
          <label id="degree_earned_div" for="degree_earned">Degree earned</label>
          <select name="degree_earned" id="degree_earned" class="" />
			  <?php
			  if (isset($_POST['degree_earned']) && !(stristr($_POST['degree_earned'],"please select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['degree_earned']."</option>";
			  } 
    		  ?>
 			  <option>---Please Select---</option>
              <option>AA</option>
              <option>BA</option>
              <option>RockNot</option>
          </select>
          <span class="required">*</span>
		</div>
	
	
		<div style="clear:both">
          <label for="alumni_email">Email address
          <?php 
			if(isset($alumni_email_msg) && $alumni_email_msg == true){
				echo '<span class="small">Your email address is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="email" name="alumni_email" id="alumni_email" class="<?php echo($required); ?>" value="<?php echo($alumni_email);?>"  /><span class="required">*</span>
		</div>
		</fieldset>

		<fieldset>
		<legend>New Contact Information</legend>
		
		<div style="clear:both">
          <label for="street">Street address</label>
          <input type="text" name="street" id="street" value="<?php echo($street);?>"  />
		</div>
		<div style="clear:both">
          <label for="street2">Street address 2</label>
          <input type="text" name="street2" id="street2" value="<?php echo($street2);?>"  />
		</div>
		
		<div style="clear:both">
          <label for="alumni_city">City</label>
          <input type="text" name="alumni_city" id="alumni_city" value="<?php echo($alumni_city);?>"  />
		</div>

        <div style="clear:both">
          <label id="alumni_state_div" for="alumni_state">State/Province</label>
          <select name="alumni_state" id="alumni_state" class="" />
			  <?php
			  if (isset($_POST['alumni_state']) && !(stristr($_POST['alumni_state'],"please select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['alumni_state']."</option>";
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
		</div>

		<div style="clear:both">
          <label for="zip">Zip/Postal Code</label>
          <input type="text" name="zip" id="zip" value="<?php echo($zip);?>"  />
		</div>

		<div style="clear:both">
          <label for="country">Country</label>
          <input type="text" name="country" id="country" value="<?php echo($country);?>"  />
		</div>
        
		<div style="clear:both">
          <label for="home_phone">Home phone</label>
          <input type="text" name="home_phone" id="home_phone" value="<?php echo($home_phone);?>" />
		</div>

		<div style="clear:both">
          <label for="cell_phone">Cell phone</label>
          <input type="text" name="cell_phone" id="cell_phone" value="<?php echo($cell_phone);?>" />
		</div>

		<div style="clear:both">
          <label for="business_phone">Business phone</label>
          <input type="text" name="business_phone" id="business_phone" value="<?php echo($business_phone);?>" />
		</div>
		</fieldset>

		<fieldset>
		<legend>Advanced Degree Information</legend>

		<div style="clear:both">
          <label for="advanced_degrees">Advanced degree(s)</label>
          <input type="text" name="advanced_degrees" id="advanced_degrees" value="<?php echo($advanced_degrees);?>" />
        </div>
		
		<div style="clear:both">
          <label for="institutions">Institution(s)</label>
          <input type="text" name="institutions" id="institutions" value="<?php echo($institutions);?>" />
        </div>
		
		<div style="clear:both">
          <label for="years_awarded">Year(s) awarded</label>
          <input type="text" name="years_awarded" id="years_awarded" value="<?php echo($years_awarded);?>" />
        </div>
		</fieldset>

		<fieldset>
		<legend>New Job Information</legend>

		<div style="clear:both">
          <label for="job_title">Title</label>
          <input type="text" name="job_title" id="job_title" value="<?php echo($job_title);?>" />
        </div>
		
		<div style="clear:both">
          <label for="company">Company</label>
          <input type="text" name="company" id="company" value="<?php echo($company);?>" />
        </div>
		
		<div style="clear:both">
          <label for="company_street">Street address</label>
          <input type="text" name="company_street" id="company_street" value="<?php echo($company_street);?>" />
        </div>
		
		<div style="clear:both">
          <label for="company_street2">Street address 2</label>
          <input type="text" name="company_street2" id="company_street2" value="<?php echo($company_street2);?>" />
        </div>
		
		<div style="clear:both">
          <label for="company_city">Company city</label>
          <input type="text" name="company_city" id="company_city" value="<?php echo($company_city);?>" />
        </div>

        <div style="clear:both">
          <label id="company_state_div" for="company_state">State/Province</label>
          <select name="company_state" id="company_state" class="" />
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
		</div>
		
		<div style="clear:both">
          <label for="company_zip">Zip/Postal code</label>
          <input type="text" name="company_zip" id="company_zip" value="<?php echo($company_zip);?>" />
        </div>
		
		<div style="clear:both">
          <label for="company_country">Country</label>
          <input type="text" name="company_country" id="company_country" value="<?php echo($company_country);?>" />
        </div>
		
		<div style="clear:both">
          <label for="company_email">Email address</label>
          <input type="email" name="company_email" id="company_email" value="<?php echo($company_email);?>" />
        </div>
		</fieldset>

		<fieldset>
		<legend>New Rocker Family Information</legend>

		<div style="clear:both">
          <label for="child_first_name">Child's first name</label>
          <input type="text" name="child_first_name" id="child_first_name" value="<?php echo($child_first_name);?>" />
        </div>
		<div style="clear:both">
          <label for="child_last_name">Child's last name</label>
          <input type="text" name="child_last_name" id="child_last_name" value="<?php echo($child_last_name);?>" />
        </div>
		<div style="clear:both">
          <label for="child_gender">Gender</label>
          <input type="text" name="child_gender" id="child_gender" value="<?php echo($child_gender);?>" />
        </div>
		<div style="clear:both">
          <label for="child_dob">Date of birth</label>
          <input type="text" name="child_dob" id="child_dob" value="<?php echo($child_dob);?>" />
        </div>
		
        <div style="clear:both; padding: 0 0 10px 20px; ">
          <label class="labelwide" style="width:450px" for="other_news">Other news:</label>
          <br />
          <textarea style="width: 400px; height: 90px; margin: 0;" name="other_news" id="other_news" /><?php echo($other_news);?></textarea>
		</div>
       </fieldset>
		<div class="spacer" style="clear:both"></div>
          <button type="submit" name="submit" id="submit">Submit</button>
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
        if (document.request.first_name.value.length == 0) {
            document.request.first_name.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "first_name";
			}
		} 
		else {
            document.request.first_name.style.backgroundColor = normal
		}
        if (document.request.last_name.value.length == 0) {
            document.request.last_name.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "last_name";
			}
		} 
		else {
            document.request.last_name.style.backgroundColor = normal
		}
        if (document.request.alumni_class_year.value.length == 0) {
            document.request.alumni_class_year.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "alumni_class_year";
			}
		} 
		else {
            document.request.alumni_class_year.style.backgroundColor = normal
		}
        if (document.request.alumni_email.value.length == 0) {
            document.request.alumni_email.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "alumni_email";
			}
		} 
		else {
            document.request.alumni_email.style.backgroundColor = normal
		}
        if (document.request.degree_earned.value == "---Please Select---") {
            document.request.degree_earned.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "degree_earned";
			}
		} 
		else {
            document.request.degree_earned.style.backgroundColor = normal
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
<script>
scrollup = '<?php echo($scrollup); ?>';
if(scrollup == '1'){
	document.getElementById('<?php echo($firstToFix); ?>').focus();
}
</script>
</body>
</html>