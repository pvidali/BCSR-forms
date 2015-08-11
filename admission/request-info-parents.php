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

	$requiredFields = array("fname","lname","parent1_fname","parent1_lname");
	
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
	}
    else{
		$doRedir = true;
		// now build and send the email
		$body = "";
		$body .= "This request was submitted online at ". date('M j, Y ')."\n\n\n";
		$body .= "            Student First Name: ". $_POST['fname']."\n";
		$body .= "             Student Last Name: ". $_POST['lname']."\n";
		$body .= "                 Date of Birth: ". $_POST['orderdate']."\n";
		$body .= "           Parent 1 first name: ".$_POST['parent1_fname']."\n";
		$body .= "            Parent 1 last name: ".$_POST['parent1_lname']."\n";
		$body .= "                 Parent 1 type: ".$_POST['parent1_type']."\n";
		$body .= "                Parent 1 email: ".$_POST['parent1_email']."\n";
		$body .= "                Parent 1 phone: ".$_POST['parent1_phone']."\n";
		$body .= "           Parent 1 phone type: ".$_POST['parent1_phonetype']."\n";
		$body .= "       Parent 1 Street Address: ".$_POST['street_address']."\n";
		$body .= "                 Parent 1 City: ".$_POST['city']."\n";
		$body .= "                Parent 1 State: ".$_POST['state']."\n";
		$body .= "                  Parent 1 Zip: ".$_POST['zip']."\n";
		$body .= "              Parent 1 Country: ".$_POST['country']."\n";
		$body .= "           Parent 2 first name: ".$_POST['parent2_fname']."\n";
		$body .= "            Parent 2 last name: ".$_POST['parent2_lname']."\n";
		$body .= "                 Parent 2 type: ".$_POST['parent2_type']."\n";
		$body .= "                Parent 2 email: ".$_POST['parent2_email']."\n";
		$body .= "                Parent 2 phone: ".$_POST['parent2_phone']."\n";
		$body .= "           Parent 2 phone type: ".$_POST['parent2_phonetype']."\n";
		$body .= "       Parent 2 Street Address: ".$_POST['p2_street_address']."\n";
		$body .= "                 Parent 2 City: ".$_POST['p2_city']."\n";
		$body .= "                Parent 2 State: ".$_POST['p2_state']."\n";
		$body .= "                  Parent 2 Zip: ".$_POST['p2_zip']."\n";
		$body .= "              Parent 2 Country: ".$_POST['p2_country']."\n";
		$body .= "\n\n";

		$subj = "Information Request - Parent ";

		$from = $_POST['parent1_email'];
		$headers = "From: $from";

		mail("recruit@simons-rock.edu",$subj,$body,$headers);

		mail("dscheff@simons-rock.edu",$subj,$body,$headers);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Request Information</title>
<script src="date.js" type="text/javascript"></script>
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

function toggleDiv(element,div){
	if(element.checked){
		document.getElementById(div).style.display = '';
	}
	else{
		document.getElementById(div).style.display = 'none';
	}
}

function showDiv(val,div){
	if(val != ''){
		document.getElementById(div).style.display = '';
	}
	else {
		document.getElementById(div).style.display = 'none';
	}
}
function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
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
			window.top.location.href = \"http://www.simons-rock.edu/admission/thank-you-parents/\";
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
#stylized .calendarDateInput{
	width:58px;
	margin-left: 8px;
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
</head>
<body>
	<div id="stylized" class="myform">
	<p>( * = required field)</p>
    	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onsubmit="return checkForm()" >
        	<?php 
            if($do_post_msg){
                echo "<div><strong>Please complete all highlighted fields.</strong></div>";
            }
            ?>
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
          <input type="text" name="fname" id="fname" value="<?php echo($fname);?>" />
        </div><span class="required">*</span>


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
          <input type="text" name="lname" id="lname" value="<?php echo($lname);?>" />
        </div><span class="required">*</span>
        
        <div style="clear:both;" id="orderdateDiv">
 			<label for="dob">Student Date of Birth</label><script>DateInput('orderdate', true, 'DD-MON-YYYY','01-JAN-2011')</script> 
        </div>
		<div class="spacer"></div>


		<div style="clear:both">
          <label for="parent1_fname">Parent First Name
          </label>
          <input type="text" name="parent1_fname" id="parent1_fname" value="<?php echo($parent1_fname);?>" />
        </div><span class="required">*</span>
		<div style="clear:both">
          <label for="parent1_lname">Parent Last Name
          </label>
          <input type="text" name="parent1_lname" id="parent1_lname" value="<?php echo($parent1_lname);?>" />
		</div><span class="required">*</span>

        <div style="clear: both; height:45px" id="parent1_typeDiv">
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
                  	<label for="parent1_typeG" class="labelsmall">Guardian</label><span class="required" style="margin-left:30px">*</span></div>
          </div>
        </div>

		<div style="clear:both">
          <label for="parent1_email">Parent E-mail
          </label>
          <input type="text" name="parent1_email" id="parent1_email" value="<?php echo($parent1_email);?>" />
		</div>
		<div style="clear:both">
          <label for="parent1_phone">Parent Phone
          </label>
          <input type="text" name="parent1_phone" id="parent1_phone" value="<?php echo($parent1_phone);?>" onchange="showDiv(this.value,'phonetypeDiv')" />
		</div>
        <div style="clear: both; display: none" id="phonetypeDiv">
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



        <div class="spacer"></div>
		
		
			<div style="width: 250px; margin: 0  110px 10px 110px; border: 1px solid #000; background-color:#CCC; padding: 5px"><strong>NOTE: </strong>If your mailing address is different than the one your student provided us, please complete the following address fields.</div>
        <div style="clear:both">
          <label for="street_address">Street Address</label>
          <input type="text" name="street_address" id="street_address" value="<?php echo($street_address);?>" />
        </div>
		<div style="clear:both">
		  <label for="city">City</label>
          <input type="text" name="city" id="city" value="<?php echo($city);?>" />
        </div>
        <div style="clear:both">
          <label id="state_div" for="state">State/Province</label>
          <select name="state" id="state"  />
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
		</div>
        <div style="clear:both">
          <label for="zip">Zip/Postal Code</label>
          <input type="text" name="zip" id="zip" class="<?php echo($required); ?>" value="<?php echo($zip);?>" />
		</div>
        <div style="clear:both">
          <label for="country">Country
          </label>
          <input type="text" name="country" id="country" value="<?php echo($country); ?>" />
		</div>
		
		
		
		<div style="clear: both">
			<div style="float:left; padding-left: 50px;">
	        	<input class="radio" type="checkbox" name="list_another_parent" id="list_another_parent" value="Yes" onchange="toggleDiv(this.form.list_another_parent,'parent2')" 
					<?php 
					if (isset($_POST['list_another_parent']) && $_POST['list_another_parent'] == "Yes")
					 echo " checked ";
					?>
				  />
				<label for="list_another_parent" class="labelwide">List another parent?</label></div>
		</div>


		<div id="parent2" style="display:none">
			<div style="clear:both">
			  <label for="parent2_fname">Parent 2 First Name</label>
			  <input type="text" name="parent2_fname" id="parent2_fname" value="<?php echo($parent2_fname);?>" />
			</div><span class="required">*</span>
			<div style="clear:both">
			  <label for="parent2_lname">Parent 2 Last Name
			  </label>
			  <input type="text" name="parent2_lname" id="parent2_lname" value="<?php echo($parent2_lname);?>" />
			</div><span class="required">*</span>
			<div style="clear: both; height:45px" id="parent2_typeDiv">
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
						<label for="parent2_typeG" class="labelsmall">Guardian</label><span class="required" style="margin-left:30px">*</span></div>
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
			  <input type="text" name="parent2_phone" id="parent2_phone" value="<?php echo($parent2_phone);?>" onchange="showDiv(this.value,'phonetype2Div')" />
			</div>
			<div style="clear: both; display: none" id="phonetype2Div">
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
			<div class="spacer"></div>
			
			
				<div style="width: 250px; margin: 0  110px 10px 110px; border: 1px solid #000; background-color:#CCC; padding: 5px"><strong>NOTE: </strong>If this mailing address is different than the one your student provided us, please complete the following address fields.</div>
			<div style="clear:both">
			  <label for="p2_street_address">Street Address</label>
			  <input type="text" name="p2_street_address" id="p2_street_address" value="<?php echo($p2_street_address);?>" />
			</div>
			<div style="clear:both">
			  <label for="p2_city">City</label>
			  <input type="text" name="p2_city" id="p2_city" value="<?php echo($p2_city);?>" />
			</div>
			<div style="clear:both">
			  <label id="p2_state_div" for="p2_state">State/Province</label>
			  <select name="p2_state" id="p2_state"  />
				  <?php
				  if (isset($_POST['p2_state']) && !(stristr($_POST['p2_state'],"please select")) ) { 
					echo "<option selected=\"selected\">".$_POST['p2_state']."</option>";
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
			  <label for="p2_zip">Zip/Postal Code</label>
			  <input type="text" name="p2_zip" id="p2_zip" class="<?php echo($p2_required); ?>" value="<?php echo($p2_zip);?>" />
			</div>
			<div style="clear:both">
			  <label for="p2_country">Country
			  </label>
			  <input type="text" name="p2_country" id="p2_country" value="<?php echo($p2_country); ?>" />
			</div>

		</div>
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
    var rmsg
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

        if (document.request.parent1_fname.value.length == 0) {
            document.request.parent1_fname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "parent1_fname";
			}
		} 
		else {
            document.request.parent1_fname.style.backgroundColor = normal
		}
        if (document.request.parent1_lname.value.length == 0) {
            document.request.parent1_lname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "parent1_lname";
			}
		} 
		else {
            document.request.parent1_lname.style.backgroundColor = normal
		}


		if (getCheckedValue(document.request.elements['parent1_type']) == undefined || getCheckedValue(document.request.elements['parent1_type']) == "") {
			document.getElementById('parent1_typeDiv').style.backgroundColor = highlight
			rval = false
		} 
		else {
			document.getElementById('parent1_typeDiv').style.backgroundColor = normal
		} 

        if (document.request.parent1_email.value.length == 0 && document.request.parent1_phone.value.length == 0) {
            document.request.parent1_email.style.backgroundColor = highlight
            document.request.parent1_phone.style.backgroundColor = highlight
            rval = false
			rmsg = "Please provide either your email or phone.";
			if(fieldFocus == ""){
				fieldFocus = "parent1_email";
			}
        } 
		else {
            document.request.parent1_email.style.backgroundColor = normal
            document.request.parent1_phone.style.backgroundColor = normal
		}

		if(document.request.list_another_parent.checked){
			if (document.request.parent2_fname.value.length == 0) {
				document.request.parent2_fname.style.backgroundColor = highlight
				rval = false
				if(fieldFocus == ""){
					fieldFocus = "parent2_fname";
				}
			} 
			else {
				document.request.parent2_fname.style.backgroundColor = normal
			}
			if (document.request.parent2_lname.value.length == 0) {
				document.request.parent2_lname.style.backgroundColor = highlight
				rval = false
				if(fieldFocus == ""){
					fieldFocus = "parent2_lname";
				}
			} 
			else {
				document.request.parent2_lname.style.backgroundColor = normal
			}
			if (getCheckedValue(document.request.elements['parent2_type']) == undefined || getCheckedValue(document.request.elements['parent2_type']) == "") {
				document.getElementById('parent2').style.display = '';
				document.getElementById('parent2_typeDiv').style.display = '';
				document.getElementById('parent2_typeDiv').style.backgroundColor = highlight
				rval = false
			} 
			else {
				document.getElementById('parent2_typeDiv').style.backgroundColor = normal
			} 
			if (document.request.parent2_email.value.length == 0 && document.request.parent2_phone.value.length == 0) {
				document.request.parent2_email.style.backgroundColor = highlight
				document.request.parent2_phone.style.backgroundColor = highlight
				rval = false
				rmsg = "Please provide either your email or phone.";
				if(fieldFocus == ""){
					fieldFocus = "parent2_email";
				}
			} 
			else {
				document.request.parent2_email.style.backgroundColor = normal
				document.request.parent2_phone.style.backgroundColor = normal
			}

		}


		if (document.request.orderdate.value == '01-JAN-2011') {
            document.getElementById('orderdateDiv').style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "orderdateDiv";
			}
		}
		else {
            document.getElementById('orderdateDiv').style.backgroundColor = normal
		}



       if (!rval) {
		   if(rmsg == ""){
			   msg = "Please complete all required (highlighted) fields prior to submitting your form.";
			}
			else {
				msg = "Please complete all required (highlighted) fields prior to submitting your form.\n\n Also, " + rmsg;
			}
		   alert (msg);
			document.getElementById(fieldFocus).focus();
			document.getElementById(fieldFocus).style.display='';
		}
        return rval
    } else
        return true
}
// -->
</script>
</body>
</html>