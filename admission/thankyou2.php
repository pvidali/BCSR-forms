<?php
$email = $_REQUEST['email'];
$couns = $_REQUEST['couns'];
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
elseif($couns == "corso"){
	$pic = "joe-sml.jpg";
	$couns_name = "Joe Corso";
	$couns_fname = "Joe";
	$couns_pron = "him";
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
	font-size:15px;
	color:#000;	
	padding: 10px;
}
div#container {
	margin-left: auto;
	margin-right: auto;
	width: 1024px;
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
	width: 1024px;
	display:inline-block;
}
#main div#leadtext p{
	background-color: #74A8FC;
	color: #fff;
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
#simplemodal-overlay {background-color:#000;}
#simplemodal-container {background-color:#333; border:8px solid #444; padding:12px;}
</style>
<link href="/includes/SyntaxHighlighter.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/includes/shCore.js" language="javascript"></script>
<script type="text/javascript" src="/includes/shBrushJScript.js" language="javascript"></script>
<script type="text/javascript" src="/includes/ModalPopups.js" language="javascript"></script>
<script>
function ModalPopupsAlert1(whichDiv) {  
	if(whichDiv == "diploma"){
		ModalPopups.Alert("jsAlert1",  
			"What about my high school diploma",  
			"<div style='padding:25px; width: 450px; height: auto'>Students here are engaged in a college learning environment right away, and do not receive a high school diploma from Simon’s Rock. Some students work with their home high schools to transfer credits back toward a high school diploma. Some students take the GED in their first or second year at Simon’s Rock. A high school diploma or its equivalent can be helpful to those students who choose to transfer and plan to apply for financial aid at another institution. Many of our students opt not to pursue a high school diploma or GED and find that with the completion of their A.A. and B.A. degrees, the same broad range of employment and graduate study opportunities remain open to them. <br /><br /><a href=\"http://simons-rock.edu/admission/faqs/academics-faqs/#diploma\" target=\"_new\">Learn more…</div>",   
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "aid"){
		ModalPopups.Alert("jsAlert1",  
			"What about scholarships and other financial aid?",  
			"<div style='padding:25px; width: 450px; height: auto'>As is the case at most other private liberal arts colleges, the tuition at Bard College at Simon’s Rock is expensive; however, the College is committed to making a Simon’s Rock education available to a diverse group of highly motivated, academically qualified students. In a typical year, more than 80% of our students receive financial assistance. We offer both need- and merit-based financial aid through institutional and federal awards. Even though the majority of our students have not completed high school, as college students at Simon’s Rock they are able to apply for federal funding through federal student aid programs.  <br /><br /><a href=\"http://simons-rock.edu/admission/faqs/financial-aid-faqs/\" target=\"_new\">Learn more…</div>",   			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "students"){
		ModalPopups.Alert("jsAlert1",  
			"What kind of students attend Simon’s Rock?",  
			"<div style='padding:25px; width: 450px; height: auto'>They are most frequently described as bright, mature, intellectual and creative.  The average incoming student is about sixteen and a half years old and has not graduated from high school. About two-thirds of students come from public high schools, a quarter from private, and the rest from home school.  Our students represent 40 states and 13 countries, and the population is about 30% students of color. They have all chosen to come to Simon’s Rock to be engaged in small classes, to delve deeply into topics they love, and to be surrounded by peers who love learning as much as they do.  <br /><br /><a href=\"http://simons-rock.edu/newsroom/headlines/the-world-is-waiting/\" target=\"_new\">Learn more…</div>",   			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "transfer"){
		ModalPopups.Alert("jsAlert1",  
			"What about transferring to other colleges after the A.A.?",  
			"<div style='padding:25px; width: 450px; height: auto'>During the sophomore year, students working toward completion of their A.A. degree in the liberal arts work with their advisors and members of the Win Resource Commons staff to develop a plan for their B.A. program. For about half of our students, that plan includes transfer to another institution as juniors. Students who maintain their academic focus at Simon’s Rock and take the transfer application process seriously do quite well gaining admission at their top choices of transfer schools. Once there, they typically transfer enough credits (most or all) from Simon’s Rock to graduate with a B.A. in two additional years.  <br /><br /><a href=\"http://simons-rock.edu/admission/faqs/transfer-faqs/\" target=\"_new\">Learn more…</div>",   			{  
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
			"<div style='padding:25px; width: 450px; height: auto'>Many students take some or all of their junior year abroad.  Where do they go?  Our students have recently taken intensive math instruction at Central European University in Budapest, Hungary; helped build a school in a remote village in northern Thailand; and served as apprentices to dancers, drummers, mask carvers, and batik artists in Bali. Students can also take advantage of Bard’s study abroad and international programs, including special arrangements with universities in Germany, Russia, and South Africa; and intensive and immersive language programs in China, Japan, Morocco, Mexico, Italy, France, Russia, and Germany. <br /><br /><a href=\"http://simons-rock.edu/academics/special-study/study-abroad-opportunities/\" target=\"_new\">Learn more…</div>",   
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "32engineer"){
		ModalPopups.Alert("jsAlert1",  
			"How about 3/2 engineering?",  
			"<div style='padding:25px; width: 450px; height: auto'>The pre-engineering concentration prepares students for the Simon’s Rock/Columbia University Engineering Program. Engineering and applied science fields include applied math, applied physics, biomedical engineering, chemical engineering, civil engineering, computer engineering, computer science, electrical engineering, environmental engineering, industrial engineering, materials science, and mechanical engineering. The goal of the pre-engineering concentration is to allow students the opportunity to explore their interests in the liberal arts while gaining the necessary background in mathematics and science. <br /><br /><a href=\"http://simons-rock.edu/academics/concentrations/pre-engineering\" target=\"_new\">Learn more…</div>",   
			{  
				okButtonText: "Close"  
			}  
		);  
	}
	if(whichDiv == "signature"){
		ModalPopups.Alert("jsAlert1",  
			"How about other Signature Programs?",  
			"<div style='padding:25px; width: 450px; height: auto'>We offer advanced students (during their junior year, mostly) an extraordinary amount of freedom to challenge themselves, to go beyond our standard offerings, to design an education (an experience—a life) that matches their highest ambitions. The opportunities are varied and Simon’s Rock students work closely with faculty to find the program that provide the best fit with their interests as well as educational and career goals. Listed below are our current Signature Programs, which are agreements we have with institutions and programs—inside the US, abroad, as well as in-house—to provide exceptional educational opportunities for qualified Simon’s Rock students. <br /><br /><a href=\"http://www.simons-rock.edu/academics/signature-programs\" target=\"_new\">Learn more…</div>",   
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

	alert('Done! Thanks, someone will be in touch very soon');
	document.getElementById(day).disabled = true;
	document.getElementById(day).style.color = "gray";
	document.getElementById(day).style.background = "#595959";
	document.getElementById(day).style.cursor = "text";
//	document.getElementById(day).style.color = '#000';
//	document.getElementById(day).style.textDecoration = 'none';
//	document.getElementById(day).style.cursor = 'default';
}

function askQuestion(){ 
	var question = document.getElementById('question').value;
	var xmlhttp;
	var str = "";
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("POST","/includes/question.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	str += "email=<?php echo($email)?>";
	str += "&";
	str += "couns=<?php echo($couns)?>";
	str += "&";
	str += "question=";
	str += question;
	xmlhttp.send(str);
//	alert('Thanks for your question, your admission counselor will be in touch very soon');
	document.getElementById('questionDiv').style.display = 'none';
	document.getElementById('answer').style.display = '';
}

qStr = "Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!";
document.getElementById('question').value = qStr;
function clear_qStr(){
	if(document.getElementById('question').value == qStr){
		document.getElementById('question').value = "";
	}
}
</script>
</head>

<body>
<div id="container">
	<div id="content">
		<div id="header"><a href="http://www.simons-rock.edu/"><img src="l/a/header.png" width="1024" height="77" border="0" alt="Bard College at Simon's Rock"></a></div>
		<div id="main">
			<div style="padding: 0 20px" id="leadtext">
				<p>It's true - you <em>can</em> start college next year, without a high school diploma. Not just any college—only at one small selective college designed for smart, interesting, creative 16 - 17 year olds like you. So, instead of taking the same old courses in high school next fall, you could select from hundreds - Psychology, Philosophy, Arabic or Chinese, Theater, Photography, Creative Writing, Pre-Med or Pre-Engineering - and so many more. And instead of living at home, you could live on campus 24/7 with your kind of people from around the country and abroad. Here's what we mean:</p>
			</div>
			<div id="video_box" style="margin-left: 20px;">
				<object width="400" height="224" ><param name="allowfullscreen" value="true" />
				<param name="wmode" value="transparent">
					<param name="movie" value="http://www.facebook.com/v/3084822432326" />
					<embed src="http://www.facebook.com/v/3084822432326" type="application/x-shockwave-flash" allowfullscreen="true" width="400" height="224" wmode="transparent"></embed>
				</object>
				<div style="clear:both"></div>
				<p>
					<a href="javascript:ModalPopupsAlert1('diploma')" >What about my high school diploma?</a><br />
					<a href="javascript:ModalPopupsAlert1('aid')" >What about scholarships and other financial aid?</a><br />
					<a href="javascript:ModalPopupsAlert1('students')">What kind of students attend Simon’s Rock?</a><br />
					<a href="javascript:ModalPopupsAlert1('transfer')" >What about transferring to other colleges after the A.A.?</a><br />
					<a href="javascript:ModalPopupsAlert1('courses')" >What types of courses do you offer?</a><br />
					<a href="javascript:ModalPopupsAlert1('studyAbroad')" >Can I study abroad?</a>&nbsp;&nbsp;How about <a href="javascript:ModalPopupsAlert1('32engineer')">3/2 engineering</a> and other <a href="javascript:ModalPopupsAlert1('signature')">Signature Programs</a>?
				</p>

			</div>
			<div style="float:right; width:560px;">
				<p>Want to talk to one of our students who left high school after 10th or 11th grade? Current students call prospective students many Wednesday and Thursday evenings. They also email and maintain a Facebook page.</p>
				<div style="clear:both; height: 5px;"></div>
				<table width="450" align="center" cellpadding="0" cellspacing="3" >
					<tr>
						<td>
							<button onClick="requestCall('Wednesday')" type="submit" name="Wednesday" id="Wednesday" value="clicked" style="width:162px; height: 57px; background: url(images/buttons.png); color: navy; font-family: Tahoma, Arial, Verdana, Geneva, sans-serif; font-size:13px; line-height: 19px; font-weight:bold; cursor:pointer; border: 1px outset buttonface">
							Sign me up for a<br>Wednesday call
							</button></td>
						<td>
							<button onClick="requestCall('Thursday')" type="submit" name="Thursday" value="clicked" style="width:162px; height: 57px; background: url(images/buttons.png); color: navy; font-family: Tahoma, Arial, Verdana, Geneva, sans-serif; font-size:13px; line-height: 19px; font-weight:bold; cursor:pointer; border: 1px outset buttonface">
							Sign me up for a<br>Thursday call
							</button></td>
					</tr>
					<tr>
						<td><a href="mailto:askastudent@simons-rock.edu" style="text-decoration: none">
							<button type="submit" name="button3" value="clicked" style="text-decoration: none; width:162px; height: 57px; background: url(images/buttons.png); color: navy; font-family: Tahoma, Arial, Verdana, Geneva, sans-serif; font-size:13px; line-height: 19px; font-weight:bold; cursor:pointer; border: 1px outset buttonface">
							Email a student
							</button></a></td>
						<td><a href="http://www.facebook.com/simonsrock" style="text-decoration: none">
							<button type="submit" name="button4" value="clicked" style="text-decoration: none; width:162px; height: 57px; background: url(images/buttons.png); color: navy; font-family: Tahoma, Arial, Verdana, Geneva, sans-serif; font-size:13px; line-height: 19px; font-weight:bold; cursor:pointer;; border: 1px outset buttonface">
							<div style="width:auto; height: auto; background: url(images/facebook.png) top right no-repeat;">
								Visit us<br>
on facebook
							</div>
							</button></a></td>
					</tr>
				</table>
<!--				<p>Want to talk to one of our students who left high school after 10th or 11th grade? Visit our <a href="http://www.facebook.com/simonsrock">facebook page</a> or <a href="mailto:askastudent@simons-rock.edu">send a message</a>. Our current students also call prospective students many Wednesday and Thursday evenings. If you'd like to receive a call then, click <span id="Wednesday" class="action" onClick="requestCall('Wednesday')">Wednesday</span> or <span id="Thursday" class="action" onClick="requestCall('Thursday')">Thursday</span> to let us know which is better for you (you don't need to fill out another form).</p> -->
				<div style="clear:both; height: 25px;"></div>
				<div style="height: auto">
					<div id="questionDiv">
						<!-- <p><strong>Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!</strong></p> -->
						<img src="images/<?php echo($pic);?>" style="float:left; margin: 0 5px">
						<textarea id="question" name="question" style="width: 400px; height:93px" onFocus="clear_qStr()">Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!</textarea>
						<button onClick="askQuestion()" value="Ask!" style="border:1px solid #999; padding:6px 10px; font-size: 15px; float:right; cursor: pointer">Ask!</button>
					</div>
					<div id="answer" style="display:none">
						<p>Thanks for your question! I'll be in touch as soon as possible.</p>
					</div>
						
				</div>
			</div>
		</div>
		<div id="footer">
			Bard College at Simon's Rock  //  84 Alford Rd.  //  Simon's Rock  //  Great Barrington, MA 01230  //  413 644 4400  //  fax 413 528 7365  //  © Bard College at Simon's Rock / All Rights Reserved
		</div>
	</div>
</div>

</body>
</html>