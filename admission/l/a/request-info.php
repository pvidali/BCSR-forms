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

$test_env = false;


require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

// THE FOLLOWING CODE GRABS VALUES FROM VERTICAL RESPONSE EMAIL CLICKTHROUGHS
if(isset($_REQUEST['utm_content']) && $_REQUEST['utm_content'] != ""){
	$vr_email = str_replace("%40","@",$_REQUEST['utm_content']);
}
if(isset($_REQUEST['utm_campaign']) && $_REQUEST['utm_campaign'] != ""){
	$vr_campaign =  str_replace("%3Fcontent","?",str_replace("%20"," ",$_REQUEST['utm_campaign']));
}
if(isset($_REQUEST['utm_term']) && $_REQUEST['utm_term'] != ""){
	$vr_term = str_replace("%20"," ",$_REQUEST['utm_term']);
}


if(isset($_POST['submit'])) {
	$postArray = $_POST;
	$postArray['ethnicities'] = $ethnicities;
	$post_msg = "";
	
	fixFormatting($postArray);

	foreach($postArray as $k => $v){
		$$k = $v;
	}
	if($formNum == '1'){
		$requiredFields = array("fname","lname","street_address","city","state","zip","email","phone","high_school","high_school_state","anticipated_grad_year");

		if($high_school_state == "NY"){
			 $requiredFields[] = "nycounty";
		}
		if($high_school_state=="PA"){
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
	}
	if($post_msg != ""){
		$do_post_msg = true;
		$scrollup = true;
	}
	else{
		// get their state
		// exceptions: PA (West), PA (East),  NY (except NYC, Nassau & Suffok), NY (Nassau & Suffolk), 
		if($formNum == '1'){
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
			$emailArray = makeEmail($postArray,$formNum,$dup_flag);
			
			// add auto-submit icontact submission form in hidden iframe
			if(!$test_env){
				$icontactFrame = makeIcontactFrame($email,$fname,$lname,$street_address,$city,$state,$zip,getDOB($dob_y,$dob_m,$dob_d),$anticipated_grad_year,$fields_recruiter);
			}
			
			// add to mysql db
			// get it all ready for safe insertion
			$db->do_query(makeSQL($postArray,$formNum));
			$db_id = mysql_insert_id();
		}
		else {
			// build the form 2 email
			$emailArray = makeEmail($postArray,$formNum,"");
			$db->do_query(makeSQL($postArray,$formNum));
			$doRedir = true;
		}


		$bad = array("emeraldninjadragon@gmail.com","rooneyl14@nycxavierhs.org");

		$from = $email;
		if( ! in_array($bad,$from) ){
			$headers = "From: $from\r\n";
			$headers .= 'Cc: recruit@simons-rock.edu' . "\r\n";
			$headers .= 'Bcc: dscheff@simons-rock.edu' . "\r\n";			
			if(!$test_env){
				if(!isset($recruiter_email_handle)){
					$recruiter_email_handle = getCounselorEmailHandle($_POST['counselor']);
				}
				mail($recruiter_email_handle,$emailArray['subj'],$emailArray['body'],$headers);
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
			$redirStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$fields_recruiter&tid=$db_id";
			header("Location: $redirStr");
		}	
	}
}

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
?>
<div style="display: <?php echo($form1Display); ?>">
	<div id="righttop">Request More Information Below
		<hr style="width:325px;" align="center" />
	</div>

	<div id="stylized" class="myform" >
    	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
        <p style="padding:18px">Fill in this form and we’ll mail you brochures about Simon’s Rock.<br>( * = required field)
        	<?php 
            if($do_post_msg){
            //	echo $post_msg;
                echo "Please complete all highlighted fields.";
            }
            ?>
        </p>
		<div>
			<div style="clear:both; float: left">
			  <label for="fname">Student First Name<br />
	
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
		<div style="clear:both; display: none;">
          <label for="mname">Student Middle Name</label>
          <input type="text" name="mname" id="mname" value="<?php echo($mname);?>" />
		</div>
        <div class="simpleclear">
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
		</div>        
        <div class="simpleclear">
          <label for="nickname">Usually Called
          </label>
          <input type="text" name="nickname" id="nickname" value="<?php echo($nickname);?>" />
		</div>
        <div class="simpleclear">
          <label for="gender">Gender</label>
	      <div style="margin: 0 0 0 150px;">
          		<div style="float:left">
	              <input class="radio" type="radio" name="gender" id="genderM" value="male" 
					<?php 
					if (isset($_POST['gender']) && $_POST['gender'] == "male")
					 echo " checked ";
					?>
				  />
                  	<label for="genderM" class="labelsmall">Male</label>
				</div>
          		<div style="padding: 0 0 0 10px; float:left">
    	          <input class="radio" type="radio" name="gender" id="genderF" value="female" 
					<?php 
					if (isset($_POST['gender']) && $_POST['gender'] == "female")
					 echo " checked ";
					?>
				  />
                  	<label for="genderF" class="labelsmall">Female</label>
				</div>
        	</div>
        </div>
        <div class="spacer"></div>
        <div class="simpleclear">
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
		<div class="simpleclear">
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
        <div class="simpleclear">
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
        <div class="simpleclear">
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
        <div class="simpleclear">
          <label for="country">Country
          </label>
          <input type="text" name="country" id="country" value="<?php echo($country); ?>" />
		</div>
        <div class="simpleclear">
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
          <div style="clear:both; padding: 0 40px 2px 10px; font-size:10px; text-align:right">
		  
		  <!-- We won't ask you to type it twice (we know you hate that), but we do ask that you --> Please enter your email address carefully <!-- , as it is our primary mode of contact.--></div>
		</div>
        <div class="simpleclear">
          <label for="phone">Phone
          <?php 
			if(isset($phone_msg) && $phone_msg == true){
				echo '<span class="small">Phone is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label><span class="required">*</span>
          <input type="text" name="phone" id="phone" value="<?php echo($phone); ?>" />
		</div>
        <div style="clear:both;" id="orderdateDiv">
 			<label for="dob">Date of Birth</label>
				<select name="dob_m" class="dob" id="dob_m">
					<option value=""></option>
					<option value="Jan">Jan</option>
					<option value="Feb">Feb</option>
					<option value="Mar">Mar</option>
					<option value="Apr">Apr</option>
					<option value="May">May</option>
					<option value="Jun">Jun</option>
					<option value="Jul">Jul</option>
					<option value="Aug">Aug</option>
					<option value="Sep">Sep</option>
					<option value="Oct">Oct</option>
					<option value="Nov">Nov</option>
					<option value="Dec">Dec</option>
				</select>
				<select name="dob_d" class="dob" id="dob_d">
					<option value=""></option>
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
				</select>
				<select name="dob_y" class="doby" id="dob_y">
					<option value=""></option>
					<option value="1985">1985</option>
					<option value="1986">1986</option>
					<option value="1987">1987</option>
					<option value="1988">1988</option>
					<option value="1989">1989</option>
					<option value="1990">1990</option>
					<option value="1991">1991</option>
					<option value="1992">1992</option>
					<option value="1993">1993</option>
					<option value="1994">1994</option>
					<option value="1995">1995</option>
					<option value="1996">1996</option>
					<option value="1997">1997</option>
					<option value="1998">1998</option>
					<option value="1999">1999</option>
					<option value="2000">2000</option>
					<option value="2001">2001</option>
					<option value="2002">2002</option>
					<option value="2003">2003</option>
				</select>
				<!--
				 <script>DateInput('orderdate')</script> 
				--><span class="required">*</span>
        </div>
        <div class="simpleclear">
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
        <div class="simpleclear">
          <label for="high_school_city">High School City/Town</label>
          <input type="text" name="high_school_city" id="high_school_city" />
		</div>        
        <div class="simpleclear">
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
          <select name="high_school_state" id="high_school_state" class="<?php echo($required); ?>" onChange="checkState(this.value)" />
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

        <div class="simpleclear">
          <label for="high_school_country">High School Country</label>
          <input type="text" name="high_school_country" id="high_school_country" value="<?php echo($high_school_country);?>" />
		</div>        
        <div class="simpleclear">
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

			<input type="hidden" name="vr_email" value="<?php echo($vr_email); ?>" />
			<input type="hidden" name="vr_campaign" value="<?php echo($vr_campaign); ?>" />
			<input type="hidden" name="vr_term" value="<?php echo($vr_term); ?>" />
			<input type="hidden" name="formNum" value="1" />

		  <button onClick="_gaq.push(['_trackEvent', 'Form', 'Submit', 'Slideshow LP Form 1'])" type="submit" name="submit" id="submit" style="clear: both; margin-left: 150px; width: 188px; height: 35px; background: url(/admission/images/submit.png); cursor:pointer" onMouseOver="this.style.background='url(/admission/images/submit-hover.png)'" onMouseOut="this.style.background='url(/admission/images/submit.png)'"></button>

          <div class="spacer"></div>
          </form>
      </div>
</div>
<div style="display: <?php echo($form2Display); ?>">
	<div id="righttop" style="width: 662px; margin-left:162px ">Thank You!</div>
	<div id="stylized" class="myform" style="width:650px; margin-left:162px ">
    	<form id="request2" name="request2" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" >
		<p>We’d love to know more about you. More information helps us tailor the information we send you and better answer your questions. Please take another minute to fill out our survey. </p>
	    <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="academic_interests" style="text-align: left; padding-left:15px; width:260px;">Academic Interests</label>
			<div class="simpleclear"></div>
          <textarea class="textareas" name="academic_interests" id="academic_interests" /><?php echo($academic_interests);?></textarea>
		</div>
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="extra_interests" class="textarealabels">Extra Curricular Interests</label>
			<div class="simpleclear"></div>
          <textarea class="textareas" name="extra_interests" id="extra_interests" /><?php echo($extra_interests);?></textarea>
		</div>
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="three_words" class="textarealabels">What three words capture your essence?</label>
			<div class="simpleclear"></div>
          <textarea class="textareas" name="three_words" id="three_words" /><?php echo($three_words);?></textarea>
		</div>

		<div class="spacer" class="simpleclear"></div>
		    <div style="clear:both;">
            	<div style="clear:none; float:left; padding-left:10px" >
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

        <div style="clear:both; padding: 0 0 10px 0; ">
          <label class="labelwide" style="padding-left:40px; padding-top:5px" for="questions_and_comments">Please note questions and comments here:</label>
			<div class="simpleclear"></div>
          <textarea class="textareas" name="questions_and_comments" id="questions_and_comments" /><?php echo($questions_and_comments);?></textarea>
		</div>

        <div style="clear:both; width:500px; padding: 10px 0 10px 15px;">
	   		Ethnic Background (Optional) <em>Please check all that apply</em>
		</div>
        <div style="clear:both; margin-left: 20px ">
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
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
			<div class="radiorow2">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label for="ethnicity_ai_tribe" style="margin:0"><em>tribal affiliation:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="ethnicity_ai_tribe" id="ethnicity_ai_tribe" value="<?php echo($ethnicity_ai_tribe);?>" /></div>
                </div>
            </div>
			<div class="simpleclear"></div>
			<div class="radiorow2">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label for="ethnicity_ai_enrolled" style="margin:0"><em>enrolled:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="ethnicity_ai_enrolled" id="ethnicity_ai_enrolled" value="<?php echo($ethnicity_ai_enrolled);?>" /></div>
                </div>
            </div>
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
			<div class="radiorow1">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label class="labelmed" for="as_origin_country" style="margin:0"><em>country/ies of family's origin:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="as_origin_country" id="as_origin_country" value="<?php echo($as_origin_country);?>" /></div>
                </div>
            </div>            
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
			<div class="radiorow2">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label class="labelmed" for="is_origin_country" style="margin:0"><em>country/ies:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="is_origin_country" id="is_origin_country" value="<?php echo($is_origin_country);?>" /></div>
                </div>
            </div>
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
			<div class="radiorow1">
            	<div style="clear:none; float:right; margin-right: 20px" >
					<div style="clear:none; float:left" >
    	                <label class="labelmed" for="hs_origin_country" style="margin:0"><em>country/ies:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="hs_origin_country" id="hs_origin_country" value="<?php echo($hs_origin_country);?>" /></div>
                </div>
            </div>
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
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
			<div class="simpleclear"></div>
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

		<div class="simpleclear">
          <label for="parent1_fname">Parent 1 First Name
          </label>
          <input type="text" name="parent1_fname" id="parent1_fname" value="<?php echo($parent1_fname);?>" />
        </div>
		<div class="simpleclear">
          <label for="parent1_lname">Parent 1 Last Name
          </label>
          <input type="text" name="parent1_lname" id="parent1_lname" value="<?php echo($parent1_lname);?>" />
		</div>

        <div class="simpleclear">
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
              <div class="inputdiv">
    	          <input class="radio" type="radio" name="parent1_type" id="parent1_typeF" value="father" 
					<?php 
					if (isset($_POST['parent1_type']) && $_POST['parent1_type'] == "father")
					 echo " checked ";
					?>
				  />
                  	<label for="parent1_typeF" class="labelsmall">Father</label></div>
              <div class="inputdiv">
    	          <input class="radio" type="radio" name="parent1_type" id="parent1_typeG" value="guardian" 
					<?php 
					if (isset($_POST['parent1_type']) && $_POST['parent1_type'] == "guardian")
					 echo " checked ";
					?>
				  />
                  	<label for="parent1_typeG" class="labelsmall">Guardian</label></div>
          </div>
        </div>
		<div class="simpleclear">
          <label for="parent1_email">Parent 1 E-mail
          </label>
          <input type="text" name="parent1_email" id="parent1_email" value="<?php echo($parent1_email);?>" />
		</div>
		<div class="simpleclear">
          <label for="parent1_phone">Parent 1 Phone
          </label>
          <input type="text" name="parent1_phone" id="parent1_phone" value="<?php echo($parent1_phone);?>" />
		</div>
        <div class="simpleclear">
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

		<div class="simpleclear">
          <label for="parent2_fname">Parent 2 First Name</label>
          <input type="text" name="parent2_fname" id="parent2_fname" value="<?php echo($parent2_fname);?>" />
        </div>
		<div class="simpleclear">
          <label for="parent2_lname">Parent 2 Last Name
          </label>
          <input type="text" name="parent2_lname" id="parent2_lname" value="<?php echo($parent2_lname);?>" />
		</div>
        <div class="simpleclear">
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
              <div class="inputdiv">
    	          <input class="radio" type="radio" name="parent2_type" id="parent2_typeF" value="father" 
					<?php 
					if (isset($_POST['parent2_type']) && $_POST['parent2_type'] == "father")
					 echo " checked ";
					?>
				  />
                  	<label for="parent2_typeF" class="labelsmall">Father</label></div>
              <div class="inputdiv">
    	          <input class="radio" type="radio" name="parent2_type" id="parent2_typeG" value="guardian" 
					<?php 
					if (isset($_POST['parent2_type']) && $_POST['parent2_type'] == "guardian")
					 echo " checked ";
					?>
				  />
                  	<label for="parent2_typeG" class="labelsmall">Guardian</label></div>
          </div>
        </div>
		<div class="simpleclear">
          <label for="parent2_email">Parent 2 E-mail
          </label>
          <input type="text" name="parent2_email" id="parent2_email" value="<?php echo($parent2_email);?>" />
		</div>
		<div class="simpleclear">
          <label for="parent2_phone">Parent 2 Phone
          </label>
          <input type="text" name="parent2_phone" id="parent2_phone" value="<?php echo($parent2_phone);?>" />
		</div>
        <div class="simpleclear">
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
        <div style="clear:both; margin-left: 150px;  "></div>
<!-- --------------------- -->
<?
			//$redirStr = $_POST['redirString'];
			if(stristr($redirStr,"amanda-dubrowski")){
				$redir = "dubrowski";
			}
			elseif(stristr($redirStr,"verrelli")){
				$redir = "verrelli";
			}
			elseif(stristr($redirStr,"joel-pitt")){
				$redir = "pitt";
			}
			elseif(stristr($redirStr,"taylor")){
				$redir = "taylor";
			}
			elseif(stristr($redirStr,"coleman")){
				$redir = "coleman";
			}
			else{
				$redir = "davidson";
			}

			$email = $_POST['email'];
			$redirectStr = "http://www.simons-rock.edu/admission/thankyou/?email=$email&couns=$redir";
?>
			<input type="hidden" name="db_id" value="<?php echo($db_id); ?>" />
			<input type="hidden" name="counselor" value="<?php echo($redir); ?>" />
			<input type="hidden" name="email" value="<?php echo($_POST['email']); ?>" />
			<input type="hidden" name="redirString" value="<?php echo($redirStr); ?>" />
			<input type="hidden" name="formNum" value="2" />
          <button type="submit" name="submit" id="submit" style="margin-top:30px; margin-left:220px; ">Submit Survey</button>&nbsp; 
		  <a href="<?php echo($redirectStr); ?>">No thanks, maybe later.</a>
          <div class="spacer"></div>
<!-- Learn some neat facts about your <a href="<?php // echo($redirStr);?>" target="_blank">admission counselor here</a>. -->
		</form>
      </div>		
</div>
<div class="spacer" style="height:50px"></div>
<div style="display: <?php echo($page3Display); ?>; width: 1020px; text-align:center;" >
	<div id="righttop" style="width: 1020px; text-align:center; border: 0; font-size:27px">Thank You!</div>
	<p style="font-size:16px">We appreciate your particitapation in our brief survey.</p>
	<p style="font-size:16px">Learn some neat facts about your <a href="<?php echo($redirStr);?>">admission counselor here</a>.</p>
</div>
<?php 
if($form1Display != 'none') {
	include "form1Check.php";
}
else if($form2Display != 'none'){
	echo ($icontactFrame);
	include "form2Check.php";
}
?>