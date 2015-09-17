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
	
	$requiredFields = array("alumni_name","alumni_class_year","alumni_email","alumni_phone","fname","lname","street_address","city","state","zip","email","why_refer");

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

		$redirStr  = "http://www.simons-rock.edu/alumni/";
		$doRedir = true;
		
		// now build and send the email
		$body = "";
		$body .= "This request was submitted online at ". date('M j, Y ')."\n\n\n";
		$body .= "ALUM\n";
		$body .= "----\n";
		$body .= "                   Name: ". $_POST['alumni_name']."\n";
		$body .= "      Alumni Class Year: ". $_POST['alumni_class_year']."\n";
		$body .= "          Alumni E-mail: ". $_POST['alumni_email']."\n";
		$body .= "           Alumni Phone: ". $_POST['alumni_phone']."\n\n";
		$body .= "STUDENT REFERRAL INFORMATION\n";
		$body .= "----------------------------\n";
		$body .= "     Student First Name: ". $_POST['fname']."\n";
		$body .= "      Student Last Name: ". $_POST['lname']."\n";
		$body .= "         Street Address: " . $_POST['street_address']."\n";
		$body .= "                   City: " . $_POST['city']."\n";
		$body .= "         State/Province: " . $_POST['state']."\n";
		$body .= "               Zip code: " . $_POST['zip']."\n";
		$body .= "          Email address: " . $_POST['email']."\n";
		$body .= "                  Phone: " . $_POST['phone']."\n";
		$body .= "            High School: " . $_POST['high_school']."\n";
		$body .= "  Anticipated grad year: " . $_POST['anticipated_grad_year']."\n\n";
		$body .= "          Why referring? " . $_POST['why_refer'];
		$body .= "\n\n";


		$subj = "SR Alumni Referral Form";

		$from = $_POST['alumni_email'];
		$headers = "From: $from";
			// 
		mail("admit@simons-rock.edu",$subj,$body,$headers);

		$body .= "\n\nPATH: $redirStr\n\n";
		mail("dscheff@simons-rock.edu",$subj,$body,$headers);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Alumni Referral Form</title>
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
	width:450px;
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
        <p><strong>Your Information</strong> <br />( * = required field)
        	<?php 
            if($do_post_msg){
            //	echo $post_msg;
                echo "Please complete all highlighted fields.";
            }
            ?>
        </p>

		<div style="clear:both">
          <label for="alumni_name">Alumni Name
          <?php 
			if(isset($alumni_name_msg) && $alumni_name_msg == true){
				echo '<span class="small">Alumni name is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="alumni_name" id="alumni_name" class="<?php echo($required); ?>" value="<?php echo($alumni_name);?>" />
          <span class="required">*</span>
        </div>

		<div style="clear:both">
			<label for="alumni_class_year">Alumni Class Year</label>
			<input type="text" name="alumni_class_year" id="alumni_class_year" class="<?php echo($required); ?>" value="<?php echo($alumni_class_year);?>" />
			<span class="required">*</span>
		</div>

		
		
		<div style="clear:both">
          <label for="alumni_email">Alumni E-mail
          <?php 
			if(isset($alumni_email_msg) && $alumni_email_msg == true){
				echo '<span class="small">Alumni E-mail is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="email" name="alumni_email" id="alumni_email" class="<?php echo($required); ?>" value="<?php echo($alumni_email);?>"  /><span class="required">*</span>
		</div>

		<div style="clear:both">
          <label for="alumni_phone">Alumni Phone
		  		</label>
          <input type="text" name="alumni_phone" id="alumni_phone" class="<?php echo($required); ?>" value="<?php echo($alumni_phone);?>" />
			<span class="required">*</span>
		</div>


		<div style="clear:both"></div>
		<div style="clear:both">
          <label for="fname">Student first name
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
          <label for="lname">Student last name
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
       
        <div class="spacer"></div>
        <div style="clear:both">
          <label for="street_address"> Address
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
          </label>
          <input type="email" name="email" id="email" class="<?php echo($required); ?>" value="<?php echo($email);?>"  /><span class="required">*</span>
		</div>
        <div style="clear:both">
          <label for="phone">Student Phone
          </label>
          <input type="text" name="phone" id="phone" value="<?php echo($phone); ?>" />
		</div>
		
        <div style="clear:both">
          <label for="high_school">High School
          </label>
          <input type="text" name="high_school" id="high_school" class="<?php echo($required); ?>" value="<?php echo($high_school);?>" />
		</div>
		
		

      <div style="clear:both">
          <label for="anticipated_grad_year">Anticipated Year of Graduation</label>
          <input type="text" name="anticipated_grad_year" id="anticipated_grad_year" value="<?php echo($anticipated_grad_year);?>" />
		</div>   
		
         
             
        <div style="clear:both; padding: 0 0 10px 20px; ">
          <label class="labelwide" style="width:450px" for="why_refer">Please share with us why you are referring this student to Simon’s Rock:</label><br />
          <textarea style="width: 350px; height: 80px; margin: 0;" name="why_refer" id="why_refer" /><?php echo($why_refer);?></textarea>
		</div>
		
		<div style="clear:both; padding: 0 0 10px 20px; ">Thanks!  If you have any questions about the Admission process, please contact Alexandra Billick, Assistant Director of Admission at 
			<a href="mailto:abillick@simons-rock.edu">abillick@simons-rock.edu</a> or by phone at 413-528-7395.</div>




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
        if (document.request.alumni_name.value.length == 0) {
            document.request.alumni_name.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "alumni_name";
			}
		} 
		else {
            document.request.alumni_name.style.backgroundColor = normal
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
        if (document.request.alumni_phone.value.length == 0) {
            document.request.alumni_phone.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "alumni_phone";
			}
		} 
		else {
            document.request.alumni_phone.style.backgroundColor = normal
		}

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
        if (document.request.why_refer.value.length == 0) {
            document.request.why_refer.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "why_refer";
			}
        } 
		else {
            document.request.why_refer.style.backgroundColor = normal
		}



			
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