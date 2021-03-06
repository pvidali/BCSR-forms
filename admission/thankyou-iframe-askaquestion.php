<?php
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php";
$email = $_REQUEST['email'];
$couns = $_REQUEST['couns'];

// parse their interests (&acint=$acint&exinst=$exint)
$academicInterests = unserialize($_REQUEST['acint']);
$extracurricularInterests = unserialize($_REQUEST['exint']);

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
//	document.getElementById(day).disabled = true;
	document.getElementById(day).style.display = "none";
	document.getElementById(buttonCell).style.innerHTML = "Thanks!";
//	document.getElementById(day).style.background = "#595959";
//	document.getElementById(day).style.cursor = "text";

//	document.getElementById(day).style.color = '#000';
//	document.getElementById(day).style.textDecoration = 'none';
//	document.getElementById(day).style.cursor = 'default';
}

function askQuestion(){ 
//	var alerts = new Array();
//	alerts[alerts.length] = "Is it a trick question? Please type your question in the box.";
//	alerts[alerts.length] = "It will help me if you actually tell us your question using the little box next to the 'Ask' button.";
//	alerts[alerts.length] = "Just type your question in the box, and I will be happy to help you!";
//	alerts[alerts.length] = "Your question is, well, sort of vague...\n\nPlease type your question in the box to the left.";
//	var randomnumber = Math.floor(Math.random()*alerts.length);
	var question = document.getElementById('question').value;
	chunk = question.substring(0,16);
	if(chunk == "Your counselor is"){
		return false;
	}
	else if(question == ""){
		// alert(alerts[randomnumber]);
		var str = "Your question is, well, sort of vague...\n\nPlease type your question in the box to the left.";
		alert(str);
		document.getElementById('question').focus();
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
}

qStr = "Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!";
document.getElementById('question').value = qStr;
function clear_qStr(){
	if(document.getElementById('question').value == qStr){
		document.getElementById('question').value = "";
	}
	document.getElementById('askCounselor').disabled = false;
	document.getElementById('askCounselor').style.cursor = "pointer";
}
</script>
</head>

<body style="margin:0">
<div style="width:229px;">
	<div style="width: 229px; height: auto">
		<div style="width:231px; border: 1px solid #a82f3e">
			<div style="height: 41px; background: #a82f3e; padding: 3px 5px; width: 221px; color: #fff; text-decoration: none; font-weight: bold; font-family:Arial, Helvetica, sans-serif">
				Contact Your<br>Admission Counselor
				<?php //echo("Academic: ".$academicInterests);?>
				<?php //echo("Extra: ".$extracurricularInterests);?>
			</div>
			<div id="questionDiv" style="width:230px">
		
				<p style="padding: 0 5px;">
				<img src="/admission/images/<?php echo($pic);?>" style="float:left; margin: 5px">
				<strong><label for="question">Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!</label></strong></p>
				<div style="clear:both; height:2px"></div>
				<textarea id="question" name="question" style="margin-left: 10px; margin-bottom:6px; width: 200px; float: left; height: 54px;" onFocus="clear_qStr()">Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!</textarea>
				<button id="askCounselor" onClick="_gaq.push(['_trackEvent', 'Form', 'Click', 'Ask a Counselor']); askQuestion()" value="Ask!" disabled="disabled" style="border:1px solid #999; padding:6px 10px; font-size: 15px; cursor:default; ">Ask!</button>
			</div>
			<div id="answer" style="display:none">
				<p>Thanks for your question! I'll be in touch as soon as possible.</p>
			</div>
		</div>
	</div>
</div>
<!-- Google Code for Form Submit Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */

// NOT SURE WE WILL WANT THIS HERE ALSO, OR IF IT NEEDS TO BE MODIFIED
/*
var google_conversion_id = 996668063;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "CraOCJmXggUQn-Wf2wM";
var google_conversion_value = 0;
*/
/* ]]> */
</script>
<!-- 
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/996668063/?value=0&amp;label=CraOCJmXggUQn-Wf2wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
-->
</body>
</html>