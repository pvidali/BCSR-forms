<?php 
// ini_set("display_errors","On");
// error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
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
	
	$requiredFields = array("alumni_name","alumni_class_year","alumni_email");

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

		$redirStr  = "http://www.simons-rock.edu/alumni/jstor/thank-you";
		$doRedir = true;

		$purpose = $_REQUEST['purpose'];
		
		$subj = "JSTOR Access Request";
		
		// now build and send the email
		$body = "";
		$body .= "This request was submitted online at ". date('M j, Y ')."\n\n\n";
		$body .= "$subj\n\n";
		$body .= "ALUM INFO\n";
		$body .= "----\n";
		$body .= "                   Name: " . $_POST['alumni_name']."\n";
		$body .= "      Alumni Class Year: " . $_POST['alumni_class_year']."\n";
		$body .= "          Alumni E-mail: " . $_POST['alumni_email']."\n";
		$body .= "\n\n";

		$from = $_POST['alumni_email'];
		$headers = "From: $from";

 		mail("jstor@simons-rock.edu",$subj,$body,$headers);
		mail("dscheff@simons-rock.edu",$subj,$body,$headers);


		// now build and send the email with access creds
		$body = "";
		$body .= "Thank you for your request for Simon's Rock alumni access to JSTOR, sponsored by the Simon's Rock Alumni Leadership Council.\n\n";
		$body .= "Please use the following to login:\n\n";
		$body .= "ALUM INFO\n";
		$body .= "URL: https://alumniproxy.simons-rock.edu/login?url=http://www.jstor.org/search \n";
		$body .= "Username: alumni \n";
		$body .= "Password: llamasR#1! \n\n";
		$body .= "These credentials will be changed annually, in January. Please expect an e-mail to the address you have provided with new credentials at that time.\n\n";
		$body .= "This is an automatic response to your inquiry. Please e-mail individual questions to Cathy Ingram and Rich Montone at alumni@simons-rock.edu.\n\n";
		$body .= "Thanks so much. Enjoy JSTOR!\n\n";
		$body .= "=====\n\n";
		$body .= "Bard College at Simon's Rock alumni JSTOR use guidelines:\n\n";
		$body .= "This electronic resource is governed by a license agreement that limits use to Bard College at Simon's Rock alumni. Each user is responsible for ensuring that he or she uses these products only for non-commercial, educational, scholarly or research use without systematically downloading, distributing, or retaining indefinitely substantial portions of information. The use of software such as scripts, agents, or robots, is prohibited and may result in loss of access to these resources for the individual or the entire Simon's Rock community.\n\n";
		$body .= "Copyright Law (including the protections of \"fair use\") and contractual license agreements govern the access, use, and reproduction of these resources. Permitted actions include: downloading, temporarily storing, or printing discrete reasonable portions of the materials. Prohibited actions include: sharing of passwords or authorized access codes, systematic downloading of significant portions of the materials, posting copyrighted materials on a publicly accessible website, or commercial exploitation of the licensed information.\n\n";
		$body .= "Please Be Aware:\n\n";
		$body .= "Sharing an access password with unauthorized users - including family, friends, co-workers, or any other unauthorized user - is prohibited. Do not post username/password information on any publicly accessible website.\n\n";
		$body .= "Downloading entire issues of electronic journals or attempting to create large databases from bibliographic files, is prohibited by license agreements. Systematic downloading of content - manually or with specialized software - is detectable by information providers and may result in loss of that information service to the individual, the relevant computer addresses, or the entire Simon's Rock community.\n\n";
		$body .= "Engaging in actions intended to circumvent or defeat access control mechanisms of the Library or information provider is prohibited.\n\n";
		$body .= "Sharing proprietary or client software connected to information resources, such as that used to analyze spatial data or search and retrieve texts, is also prohibited under the terms of academic licenses.\n\n";
		$body .= "\n\n";

		$subj = "Simon's Rock alumni access to JSTOR";

		$from = "jstor@simons-rock.edu";
		$to = $_POST['alumni_email'];
		$headers = "From: $from";

 		mail($to,$subj,$body,$headers);

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
          <label for="alumni_name">Your full name:
          <?php 
			if(isset($alumni_name_msg) && $alumni_name_msg == true){
				echo '<span class="small">Your name is required.</span>';
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