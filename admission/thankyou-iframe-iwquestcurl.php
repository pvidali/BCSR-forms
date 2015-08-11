<?php
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php";

if(isset($_REQUEST['email']) && $_REQUEST['email'] != ""){
	$email = $_REQUEST['email'];
}
else{
	$email = "";
}
if(isset($_REQUEST['couns']) && $_REQUEST['couns'] != ""){
	$couns = $_REQUEST['couns'];
}
else{
	$couns = "";
}

if(isset($email) && $email != ""){
	$counsDivDisplay = "";
	$noCounsDivDisplay = "none";
}
else{
	$counsDivDisplay = "none";
	$noCounsDivDisplay = "";
}

$isFB = $_REQUEST['isFB'];

//***** THIS NEEDS TO BE CONVERTED TO DB QUERY ******//
//$tinfo = getTerritoryInfo($_REQUEST['state'],$territories);
//$couns = $tinfo['fields_recruiter'];
if($couns == "davidson"){
	$pic = "leslie-globe.gif";
	$couns_name = "Leslie Davidson";
	$couns_fname = "Leslie";
	$couns_pron = "her";
}
elseif($couns == "pitt"){
	$pic = "joel-sml.jpg";
	$couns_name = "Joel Pitt";
	$couns_fname = "Joel";
	$couns_pron = "him";
}
elseif($couns == "dubrowski"){
	$pic = "amanda-thumb.jpg";
	$couns_name = "Amanda Dubrowski";
	$couns_fname = "Amanda";
	$couns_pron = "her";
}
elseif($couns == "verrelli"){
	$pic = "verrelli-sml.jpg";
	$couns_name = "Meg Verrelli";
	$couns_fname = "Meg";
	$couns_pron = "her";
}
elseif($couns == "taylor"){
	$pic = "aft-headshot.jpg";
	$couns_name = "Alexandra Taylor";
	$couns_fname = "Alexandra";
	$couns_pron = "her";
}
elseif($couns == "coleman"){
	$pic = "steve-sml.jpg";
	$couns_name = "Steve Coleman";
	$couns_fname = "Steve";
	$couns_pron = "him";
}


?>

<!DOCTYPE HTML>
<html><head>
<meta charset="utf-8">
<title>Start College Now</title>
<style>
body {
	text-align: center;
	background:#FFF;
}
p{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#000;	
	padding: 10px 2px;
	font-weight:normal;
}
div#container {
	margin-left: auto;
	margin-right: auto;
	width: 700px;
	height:auto;
	text-align: left;
	display: inline-block;
}
#content{
	display:inline-block;
	height: auto;
}
#header {
	clear:both
}
#main {
	width: 700px;
	display:inline-block;
}
#main div#leadtext p{
	color: #323232;
	font-size:16px;
	font-weight:bold;
}
#slidenav {
	background-color: #949494;
	height: 37px;
	width:565px;
	margin-left:5px;
}
#video_box{
	width:425px;
	border: none;
	display:inline-block;
	height:auto;
	float:left;
	margin: 5px;
}
#left {
	width: 567px;
	float:left;
}
#left2 {
	width: 567px;
	float:left;
}
#right {
	width:457px;
	float: right;
}
#righttop {
	background:#FFF;
	width:455px;
	height: 53px; 
	text-align: center; 
	color:  #ee4236; 
	font-size: 19px; 
	font-weight: bold; 
	font-family: arial; 
	padding: 2px 0 2px 0; 
	line-height: 51px;
	text-transform: uppercase;
	border-top: 1px solid #000;
	border-left: 1px solid #000;
	border-right: 1px solid #000;
} 
.action{
	color: blue;
	text-decoration:underline;
	cursor: pointer;
}
#footer{
	font-size:10px;
	color:#999999;
	font-family: Arial, Helvetica, sans-serif;
	text-align:center;
	margin-top: 50px;
}

.curved{
	height: 65px;
	width:160px;
	-moz-border-radius: 15px;
	border-radius: 15px;
	border: 2px solid #00BCDD;
	padding:0 10px 10px 10px;
}
select{
	width: 100px !important;
	min-width: 1em !important;
}
label, label.left{
	font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #AB033A;
	width: 18em;
}
#simplemodal-overlay {background-color:#000;}
#simplemodal-container {background-color:#333; border:8px solid #444; padding:12px;}
</style>
<link href="/includes/SyntaxHighlighter.css" rel="stylesheet" type="text/css" />
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/google-analytics.php";
?>
<script>
	_gaq.push(['_trackEvent', 'Form', 'Submit', 'Main Request Form']);
</script>

<?php 
if($isFB == "1"){
?>

<script type="text/javascript">
var fb_param = {};
fb_param.pixel_id = '6008129027317';
fb_param.value = '0.00';
(function(){
 var fpw = document.createElement('script');
 fpw.async = true;
 fpw.src = '//connect.facebook.net/en_US/fp.js';
 var ref = document.getElementsByTagName('script')[0];
 ref.parentNode.insertBefore(fpw, ref);
})();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6008129027317&amp;value=0" /></noscript>

<?php 
}
?>

<script type="text/javascript" src="/includes/shCore.js" language="javascript"></script>
<script type="text/javascript" src="/includes/shBrushJScript.js" language="javascript"></script>
<script type="text/javascript" src="/includes/ModalPopups.js" language="javascript"></script>
<script>
function toggleCountryDiv(){
	if(document.getElementById('state').value == "not applicable"){
		document.getElementById('countryDiv').style.display = '';
	}
	else{
		document.getElementById('countryDiv').style.display = 'none';
		document.getElementById('country').value = '';
		getCounselorInfo();
	}
}
function ModalPopupsAlert1(whichDiv) {  
	if(whichDiv == "diploma"){
		ModalPopups.Alert("jsAlert1",  
			"What about my high school diploma",  
			"<div style='padding:25px; width: 450px; height: auto'>Students here start college courses right away, and do not receive a high school diploma from Simon’s Rock. Some students work with their high schools to transfer credits back toward a diploma. Those who plan on transferring after earning their A.A. can take the GED in their first or second year at Simon’s Rock. For 45 years our alumni have found a comprehensive array of employment and graduate study opportunities despite not getting their high school diplomas. Last year we were ranked #13 among all colleges and universities in the country for the percent of our graduates who go on to earn PhD degrees.<br /><br /><a href=\"http://simons-rock.edu/admission/faqs/academics-faqs/#diploma\" target=\"_new\">Learn more…</div>",   
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "aid"){
		ModalPopups.Alert("jsAlert1",  
			"What about scholarships and other financial aid?",  
			"<div style='padding:25px; width: 450px; height: auto'>As is the case at most other private liberal arts colleges, the tuition at Bard College at Simon’s Rock is expensive; however, the College is committed to making a Simon’s Rock education available to a diverse group of highly motivated, academically qualified students. In a typical year, more than 80% of our students receive financial assistance. We offer both need- and merit-based financial aid through institutional and federal awards. Even though the majority of our students have not completed high school, as college students at Simon’s Rock they are able to apply for federal funding through federal student aid programs. <br /><br /><a href=\"http://simons-rock.edu/admission/faqs/financial-aid-faqs/\" target=\"_new\">Learn more…</div>",
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "students"){
		ModalPopups.Alert("jsAlert1",  
			"What kind of students attend Simon’s Rock?",  
			"<div style='padding:25px; width: 450px; height: auto'>They are most frequently described as bright, mature, intellectual and creative. The average incoming student is about sixteen and a half years old and has not graduated from high school. About two-thirds of students come from public high schools, a quarter from private, and the rest home school. Our students represent 40 states and 13 countries, and the population is about 30% students of color. They have all chosen to come to Simon’s Rock to be engaged in small classes, to delve deeply into topics they love, and to be surrounded by peers who love learning as much as they do. <br /><br /><a href=\"http://simons-rock.edu/newsroom/headlines/the-world-is-waiting/\" target=\"_new\">Learn more…</div>",
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "transfer"){
		ModalPopups.Alert("jsAlert1",  
			"What about transferring to other colleges after the A.A.?",  
			"<div style='padding:25px; width: 450px; height: auto'>During the sophomore year, advisors help students articulate how they want to use the second two years of college, and the best place to do that. For about half of our students, that plan includes transfer to another institution as juniors. Students who are successful at Simon’s Rock have been admitted and done extremely well at many of the most selective institutions. The top 5 recent transfer schools have been Bard, Brown, Stanford, University of Chicago, and NYU. The full list includes everything from similarly small liberal arts institutions like Hampshire and Oberlin to large research institutions like University of Michigan and University of Southern California, and everything in between. <br /><br /><a href=\"http://simons-rock.edu/admission/faqs/transfer-faqs/\" target=\"_new\">Learn more…</div>",
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "courses"){
		ModalPopups.Alert("jsAlert1",  
			"What types of courses do you offer?",  
			"<div style='padding:25px; width: 450px; height: auto'>Bard College at Simon’s Rock offers a full range of courses through its program in the liberal arts and sciences.  In their first two years, Simon’s Rock students take courses in the arts, cultural perspectives, foreign language, math, science and a three-semester seminar course which focuses on important works across many disciplines.  Students who moderate into the B.A. program can choose from 40 concentrations in four divisions, ranging from hard sciences to humanities to visual and performing arts. Most importantly, classes are small with many topping out at 15 students, and taught in a discussion-based seminar style.  <br /><br /><a href=\"http://simons-rock.edu/academics/concentrations\" target=\"_new\">Learn more…</div>",   			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "studyAbroad"){
		ModalPopups.Alert("jsAlert1",  
			"Can I study abroad?",  
			"<div style='padding:25px; width: 450px; height: auto'>Yes! We urge all our students to take some or all of their junior year abroad. Where do they go? They follow their interests and passions. Our students have recently taken intensive math instruction at Central European University in Budapest, Hungary; helped build a school in a remote village in northern Thailand; and served as apprentices to dancers, drummers, mask carvers, and batik artists in Bali. Students can also take advantage of Bard’s study abroad and international programs, including special arrangements with universities in Germany, Russia, and South Africa; and intensive and immersive language programs in China, Japan, Morocco, Mexico, Italy, France, Russia, and Germany. <br /><br /><a href=\"http://simons-rock.edu/academics/special-study/study-abroad-opportunities/\" target=\"_new\">Learn more…</div>",   
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "32engineer"){
		ModalPopups.Alert("jsAlert1",  
			"How about 3/2 engineering?",  
			"<div style='padding:25px; width: 450px; height: auto'>Pre-engineering is a popular concentration and an amazing opportunity. Along with the opportunity to explore the liberal arts, students take a series of nine math and science courses on our campus and then continue their studies at the School of Engineering at Columbia University in New York City. Engineering and applied science fields include applied math, applied physics, computer science, materials science, and biomedical, chemical, civil, computer, electrical, environmental, industrial, and mechanical engineering. Students earn a B.A. from Simon’s Rock and a B.S. in Engineering from Columbia <br /><br /><a href=\"http://simons-rock.edu/academics/concentrations/pre-engineering\" target=\"_new\">Learn more…</div>",   
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "signature"){
		ModalPopups.Alert("jsAlert1",  
			"How about other Signature Programs?",  
			"<div style='padding:25px; width: 450px; height: auto'>We offer advanced students (during their junior year, mostly) an extraordinary amount of freedom to challenge themselves, to go beyond our standard offerings, to design an education (an experience—a life) that matches their highest ambitions. The opportunities are varied and Simon’s Rock students work closely with faculty to find the program that provides the best fit with their interests as well as educational and career goals. Listed below are our current Signature Programs, which are agreements we have with institutions and programs—inside the US, abroad, as well as in-house—to provide exceptional educational opportunities for qualified Simon’s Rock students. <br /><br /><a href=\"http://www.simons-rock.edu/academics/signature-programs\" target=\"_new\">Learn more…</div>",   
			{  
				okButtonText: "Close"  
			}  
		);  
	}
} 
</script>
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
<script type="text/javascript">
function requestCall(day){ 
	var buttonCell = day;
	buttonCell += "TD";
	var xmlhttp;
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("POST","/includes/callme.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	if(day=="Thursday"){
		xmlhttp.send("email=<?php echo($_REQUEST['email']) ?>&d=Thursday");
	}
	else{
		xmlhttp.send("email=<?php echo($_REQUEST['email']) ?>&d=Wednesday");
	}
	alert('Done! Thanks, someone will be in touch very soon');
	document.getElementById(day).style.display = "none";
	document.getElementById(buttonCell).style.innerHTML = "Thanks!";
}

function askQuestion(){ 
	var question = document.getElementById('question').value;
	var email = document.getElementById('email').value;
	chunk = question.substring(0,16);
	if(chunk == "Your counselor is"){
		return false;
	}
	else if(question == ""){
		// alert(alerts[randomnumber]);
		var str = "Your question is, well, sort of vague...\n\nPlease type your question in the box to the left.";
		alert(str);
		return false;
	}
	else if(email == ""){
		// alert(alerts[randomnumber]);
		var str = "Your email address is needed for us to respond to you.";
		alert(str);
		return false;
	}
	else {
		var xmlhttp;
		var str = "";
		if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("POST","/includes/question-iw.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		str += "email=";
		str += email;
		str += "&";
		str += "couns=<?php echo($couns)?>";
		str += "&";
		str += "question=";
		str += question;
		xmlhttp.send(str);
		document.getElementById('questionDiv').style.display = 'none';
		document.getElementById('answer').style.display = '';
	}
}
function getCounselorInfo(){ 
	var theirState = document.getElementById('state').value;
	if(theirState == "not applicable"){
		theirState = "";
		var theirCountry = document.getElementById('country').value;
	}
	else {
		theirCountry = "";
	}

	var xmlhttp;
	var str = "";
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("POST","/includes/getCounselorInfo.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	str += "state=";
	str += theirState;
	str += "&";
	str += "country=";
	str += theirCountry;
	xmlhttp.send(str);

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			counsInfo = new Array();
			counsInfo = xmlhttp.responseText.split("&");
			document.getElementById('counsImage').innerHTML = "<img src=\"/admission/images/" + counsInfo[2] + "\" style=\"float:left; margin: 5px\">"; 
//			document.getElementById('counsFname').innerHTML = counsInfo[0];
//			document.getElementById('counsLname').innerHTML = counsInfo[1];
			document.getElementById('counsIntro').innerHTML = "<strong>Your counselor is " + counsInfo[0] + " " + counsInfo[1] + ". Ask " + counsInfo[0] + " a question!</strong>";
			// document.getElementById('preQuestion').innerHTML = "<textarea id=\"question\" name=\"question\" style=\"margin-left: 10px;width: 210px; float: left; height: 54px;\" onFocus=\"clear_qStr()\">Your counselor is " + counsInfo[0] + " " + counsInfo[1] + ". Ask " + counsInfo[0] + " a question!</textarea>";
			document.getElementById('emailDiv').innerHTML = "<label for=email>Your email</label>:<br /><input id='email' type='text' name='email' value=''>";
			document.getElementById('counsDiv').style.display = "";
			document.getElementById('emailDiv').style.display = "";
			document.getElementById('emailDiv').style.margin = "0 0 0 10px";
			
			document.getElementById('noCounsDiv').style.display = "none";
		}
	}
}



//qStr = "Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!";
// document.getElementById('question').value = qStr;
function clear_qStr(){
	if(document.getElementById('question').value == qStr){
		document.getElementById('question').value = "";
	}
	document.getElementById('askCounselor').disabled = false;
	document.getElementById('askCounselor').style.cursor = "pointer";
}
</script>
</head>

<body style="margin: 0 !important; background: #fff;text-align: left;">
<div id="container">
	<div id="content">
		<?php
		if(isset($_REQUEST['showBanner']) && $_REQUEST['showBanner'] == 1){
			echo '<div id="header"><img src="http://www.simons-rock.edu/admission/thankyou/banners/thanks.jpg" /></div>';	
		}

		?>
		<div id="main">
			<div style="padding: 0px;" id="leadtext">
			<?php
				if(isset($_REQUEST['showBanner']) && $_REQUEST['showBanner'] == 2){
					echo '<p style="font-size: 24px; color: #990020; font-weight: bold">Thank you for your interest!</p>';	
				}
			
			?>
				<p style="font-weight:normal; font-size:14px; padding: 10px 0 0 0">
					<strong>You don’t need a high school diploma to attend Bard College at Simon’s Rock,</strong> the country’s only four-year residential college specifically for younger students. You do need the desire to learn from engaged professors, to choose from hundreds of courses, and to live on a beautiful campus with other smart, interesting, creative 16-17 year olds&mdash;like you.</p>
				<p style="font-weight:normal; font-size:14px;">Want to talk to one of our students who left high school after 10th or 11th grade? Current students call prospective students many Wednesday and Thursday evenings. They also email and maintain a Facebook page.</p>
			</div>
			<div id="video_box" style="margin-left: 20px; display:none">
				<div style="clear:both"></div>
			</div>
			<div style="float:right; width:700px;">
				<p style="display:none">Want to talk to one of our students who left high school after 10th or 11th grade? Current students call prospective students many Wednesday and Thursday evenings. They also email and maintain a Facebook page.</p>
				<div style="clear:both; height: 5px;"></div>
				<table width="700" align="center" cellpadding="0" cellspacing="3" >
					<tr>
						<td id="WednesdayTD">
							<button onClick="_gaq.push(['_trackEvent', 'Call', 'Click', 'Wednesday']); requestCall('Wednesday')" type="submit" name="Wednesday" id="Wednesday" value="clicked" style="width:165px; height: 65px; background: url(/admission/images/button-call-w.png); cursor:pointer; border: none">
								
							</button></td>
						<td>
							<button onClick="_gaq.push(['_trackEvent', 'Call', 'Click', 'Thursday']); requestCall('Thursday')" type="submit" name="Thursday" id="Thursday" value="clicked" style="width:165px; height: 65px; background: url(/admission/images/button-call-t.png); cursor:pointer; border: none">
							
							</button></td>
						<td><a href="mailto:askastudent@simons-rock.edu" onClick="_gaq.push(['_trackEvent', 'Email', 'Click', 'Ask a Student']);" style="text-decoration: none">
							<button type="submit" name="button3" value="clicked" style="text-decoration: none; width:165px; height: 65px; background: url(/admission/images/button-email.png); cursor:pointer; border: none">
							
							</button></a></td>
						<td><a href="http://www.facebook.com/simonsrock" style="text-decoration: none" target="_top">
							<button type="submit" name="button4" value="clicked" style="text-decoration: none; width:165px; height: 65px; background: url(/admission/images/facebook-button.png); cursor:pointer; border: none">
							
							</button></a></td>
					</tr>
				</table>
				<div style="clear:both; height: 25px;"></div>
				<div style="width: 700px; height: 200px">
                    <div style="min-height: 226px; width:310px; float: left; border: 1px solid #a82f3e">
						<div style="height: 23px; background: #a82f3e; padding: 3px 5px;width: 300px; color: #fff; text-decoration: none; font-weight: bold; font-family:Arial, Helvetica, sans-serif">
							Contact your Admission Counselor 
						</div>
                        <div id="questionDiv" style="width:300px; padding-bottom: 35px;">

                           <div id="counsDiv" style="display: <?php echo($counsDivDisplay) ?>">
                            <p style="padding: 0 5px;">
                              <span id="counsImage"><img src="/admission/images/<?php echo($pic);?>" style="float:left; margin: 5px"></span>
                              <span id="counsIntro"><strong>Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!</strong></span>
                            </p>
							<div style="clear:both"></div>
                          	<div id="emailDiv" style="display: none"><label for=email>Your email</label>:<br /><input id='email' type='text' name='email' value='<?php echo($email)?>'></div>
                            <div style="clear:both; height:2px"></div>
                            <textarea id="question" name="question" style="margin-left: 10px;width: 210px; float: left; height: 54px;"></textarea>
                            <button id="askCounselor" onClick="_gaq.push(['_trackEvent', 'Form', 'Click', 'Ask a Counselor']); askQuestion()" value="Ask!" style="border:1px solid #999; padding:6px 10px; font-size: 15px; cursor:pointer; ">Ask!</button>
                           </div>

						   <div id="noCounsDiv" style="display: <?php echo ($noCounsDivDisplay)?>">
                            <p style="padding: 0 5px;">
                            <strong>Your counselor is based on where you attend high school.</strong></p>
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
								<div id="countryDiv" class="form-control field-control" style="padding: 0 !important; display:none">
									<label for="country" style="width:17em;" class="left">* Country</label>
									<select id="country" name="country" onChange="getCounselorInfo()">
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
                        </div>
                        <div id="answer" style="display:none">
                            <p>Thanks for your question! I'll be in touch as soon as possible.</p>
                        </div>
                    </div>
                    <div style="width: 350px; float: right">
                        <div style="padding: 5px; background: #a82f3e">
	                        <span style="color: #fff; text-decoration: none; font-weight: bold; font-family:Arial, Helvetica, sans-serif">Student Interviews</span>
                        </div>
                        <div>
							<iframe width="350" height="197" src="http://www.youtube.com/embed/CRQLXMxHE8I" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Google Code for Form Submit Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 996668063;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "CraOCJmXggUQn-Wf2wM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/996668063/?value=0&amp;label=CraOCJmXggUQn-Wf2wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>