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
	
	$requiredFields = array("alumni_name","alumni_class_year","alumni_city","alumni_state","alumni_email","alumni_phone","nominee_name","nominee_class_year","why_refer");

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

		$redirStr  = "http://www.simons-rock.edu/alumni/alc/thank-you";
		$doRedir = true;

		$purpose = $_REQUEST['purpose'];
		
		if($purpose == "rep"){
			$subj = "SR ALC Representative Nomination Form";
		}
		else {
			$subj = "SR Outstanding Alum Nomination Form";
		}
		
		// now build and send the email
		$body = "";
		$body .= "This request was submitted online at ". date('M j, Y ')."\n\n\n";
		$body .= "$subj\n\n";
		$body .= "ALUM\n";
		$body .= "----\n";
		$body .= "                   Name: " . $_POST['alumni_name']."\n";
		$body .= "      Alumni Class Year: " . $_POST['alumni_class_year']."\n";
		$body .= "          Alumni E-mail: " . $_POST['alumni_email']."\n";
		$body .= "           Alumni Phone: " . $_POST['alumni_phone']."\n\n";
		$body .= "NOMINEE INFORMATION\n";
		$body .= "----------------------------\n";
		$body .= "           Nominee Name: " . $_POST['nominee_name']."\n";
		$body .= "     Nominee Entry Year: " . $_POST['nominee_class_year']."\n\n";
		$body .= "           Nominee City: " . $_POST['nominee_city']."\n";
		$body .= " Nominee State/Province: " . $_POST['nominee_state']."\n";
		$body .= "  Nominee Email address: " . $_POST['nominee_email']."\n";
		$body .= "          Nominee Phone: " . $_POST['nominee_phone']."\n";
		$body .= "         Why nominating? " . $_POST['why_refer'];
		$body .= "\n\n";

		$from = $_POST['alumni_email'];
		$headers = "From: $from";

 		mail("alumni@simons-rock.edu",$subj,$body,$headers);

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
	width:690px;
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
          <label for="alumni_name">Your Name:
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
			<label for="alumni_class_year">Your Simon&rsquo;s Rock year of entry:
			  <?php 
				if(isset($alumni_class_year_msg) && $alumni_class_year_msg == true){
					echo '<span class="small">Alumni name is required.</span>';
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
          <label for="alumni_city">Your city
          <?php 
			if(isset($alumni_city_msg) && $alumni_city_msg == true){
				echo '<span class="small">Your City is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="alumni_city" id="alumni_city" class="<?php echo($required); ?>" value="<?php echo($alumni_city);?>"  /><span class="required">*</span>
		</div>

        <div style="clear:both">
          <label id="alumni_state_div" for="alumni_state">Your State/Province</label>
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
          <span class="required">*</span>
		</div>
	
		<div style="clear:both">
          <label for="alumni_email">Your E-mail
          <?php 
			if(isset($alumni_email_msg) && $alumni_email_msg == true){
				echo '<span class="small">Your e-mail address is required.</span>';
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
          <label for="alumni_phone">Your Phone
 			<?php 
			if(isset($alumni_phone_msg) && $alumni_phone_msg == true){
				echo '<span class="small">Your telephone is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		 	 ?>
	  		</label>
          <input type="text" name="alumni_phone" id="alumni_phone" class="<?php echo($required); ?>" value="<?php echo($alumni_phone);?>" />
			<span class="required">*</span>
		</div>


		<div style="clear:both"></div>
		<div style="clear:both">
          <label for="nominee_name">Name of nominee
          <?php 
			if(isset($nominee_name_msg) && $nominee_name_msg == true){
				echo '<span class="small">Nominee\'s name is required.</span>';
				$required = "errors";
            }
			else{
				$required = "";
			}
		  ?>
          </label>
          <input type="text" name="nominee_name" id="nominee_name" class="<?php echo($required); ?>" value="<?php echo($nominee_name);?>" /><span class="required">*</span>
        </div>
		
		<div style="clear:both">
			<label for="nominee_class_year">Nominee's year of entry to Simon's Rock:
			  <?php 
				if(isset($nominee_class_year_msg) && $nominee_class_year_msg == true){
					echo '<span class="small">Nominee\'s year of entry is required.</span>';
					$required = "errors";
				}
				else{
					$required = "";
				}
			  ?>
			</label>
			<input type="text" name="nominee_class_year" id="nominee_class_year" class="<?php echo($required); ?>" value="<?php echo($nominee_class_year);?>" />
			<span class="required">*</span>
		</div>

        <div style="clear:both; padding: 0 0 10px 20px; ">
<!--          <label class="labelwide" style="width:450px" for="why_refer">Your reasons for nominating this candidate: (no more than 250 words)</label> -->
          <label class="labelwide" style="width:450px" for="why_refer">Your reasons for nominating this candidate:</label>
          <br />
<!--          <textarea style="width: 550px; height: 90px; margin: 0;" name="why_refer" id="why_refer" onblur="CountWords(this.form.why_refer, true, true);" /><?php echo($why_refer);?></textarea> -->
          <textarea style="width: 550px; height: 90px; margin: 0;" name="why_refer" id="why_refer" /><?php echo($why_refer);?></textarea>
		</div>
       
        <div class="spacer"></div>
        <div style="clear:both">
          <label for="nominee_city"> Nominee City</label>
          <input type="text" name="nominee_city" id="nominee_city" class="" value="<?php echo($nominee_city);?>" />
        </div>
        <div style="clear:both">
          <label id="nominee_state_div" for="nominee_state">Nominee State/Province</label>
          <select name="nominee_state" id="nominee_state" class="" />
			  <?php
			  if (isset($_POST['nominee_state']) && !(stristr($_POST['nominee_state'],"please select")) ) { 
			  	echo "<option selected=\"selected\">".$_POST['nominee_state']."</option>";
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
          <label for="nominee_email">Nominee E-mail</label>
          <input type="email" name="nominee_email" id="nominee_email" class="" value="<?php echo($nominee_email);?>"  />
		</div>
        <div style="clear:both">
          <label for="nominee_phone">Nominee Phone</label>
          <input type="text" name="nominee_phone" id="nominee_phone" value="<?php echo($nominee_phone); ?>" />
		</div>
		
		<div style="clear:both; padding: 0 0 10px 20px; ">If you have questions about your nomination, you can e-mail the ALC at <a href="mailto:sralc@simons-rock.edu">sralc@simons-rock.edu</a>.</div>


		<div class="spacer" style="clear:both"></div>
		  <input type="hidden" name="purpose" value="<?php echo($_REQUEST['purpose'])?>" />
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
        if (document.request.alumni_city.value.length == 0) {
            document.request.alumni_city.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "alumni_city";
			}
		} 
		else {
            document.request.alumni_city.style.backgroundColor = normal
		}
		if (document.getElementById('alumni_state').options[document.getElementById('alumni_state').selectedIndex].value == '---Please Select---')  {
            document.request.alumni_state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "alumni_state";
			}
        } 
		else {
            document.request.alumni_state.style.backgroundColor = normal
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

		if (document.request.nominee_name.value.length == 0) {
            document.request.nominee_name.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "nominee_name";
			}
		} 
		else {
            document.request.nominee_name.style.backgroundColor = normal
		}
		if (document.request.nominee_class_year.value.length == 0) {
            document.request.nominee_class_year.style.backgroundColor = highlight
			if(fieldFocus == ""){
				fieldFocus = "nominee_class_year";
			}
			rval = false
        } 
		else {
            document.request.nominee_class_year.style.backgroundColor = normal
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