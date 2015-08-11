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
<script type="text/javascript">
function requestCall(day){ 
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
	document.getElementById(day).style.color = '#000';
	document.getElementById(day).style.textDecoration = 'none';
	document.getElementById(day).style.cursor = 'default';
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

</script>
</head>

<body>
<div id="container">
	<div id="content">
		<div id="header"><a href="http://www.simons-rock.edu/"><img src="l/a/header.png" width="1024" height="77" border="0" alt="Bard College at Simon's Rock"></a></div>
		<div id="main">
			<div>
				<p>Yes, it's true - you <em>can</em> start college next year, without completing your high school requirements or getting a diploma. And not just any college, but a small private college, highly selective, designed specifically for smart, interesting, creative 16 - 17 year olds, like you. So next fall, instead of taking the same old courses in your high school, you can select from hundreds - Psychology, Philosophy, Arabic or Chinese, Theater, Photography, Creative Writing, Pre-Med or Pre-Engineering - and so many more. And instead of living at home, you'd be living on a campus 24/7 with your kind of people from around the country and abroad. Here's what we mean:</p>
			</div>
			<div id="video_box">
				<object width="400" height="224" ><param name="allowfullscreen" value="true" />
					<param name="movie" value="http://www.facebook.com/v/3084822432326" />
					<embed src="http://www.facebook.com/v/3084822432326" type="application/x-shockwave-flash" allowfullscreen="true" width="400" height="224"></embed>
				</object>
				<div style="clear:both"></div>
				<p>
					<a href="http://simons-rock.edu/admission/faqs/academics-faqs/#diploma" target="_new">What about my high school diploma?</a><br />
					<a href="http://simons-rock.edu/admission/faqs/financial-aid-faqs/" target="_new">What about scholarships and other financial aid?</a><br />
					<a href="http://simons-rock.edu/newsroom/headlines/the-world-is-waiting/" target="_new">What kind of students attend Simon’s Rock?</a><br />
					<a href="http://simons-rock.edu/admission/faqs/transfer-faqs/" target="_new">What about transferring to other colleges after the A.A.?</a><br />
					<a href="http://simons-rock.edu/academics/concentrations" target="_new">What types of courses do you offer?</a><br />
					<a href="http://simons-rock.edu/academics/special-study/study-abroad-opportunities/" target="_new">Can I study abroad?</a>&nbsp;&nbsp;How about <a href="http://simons-rock.edu/academics/concentrations/pre-engineering" target="_new">3/2 engineering</a> and other <a href="http://simons-rock.edu/academics/signature-programs" target="_new">Signature Programs</a>?
				</p>
			</div>
			<div style="float:right; width:580px;">
				<p>Want to talk to one of our students who left high school after 10th or 11th grade? Visit our <a href="http://www.facebook.com/simonsrock">facebook page</a> or <a href="mailto:askastudent@simons-rock.edu">send a message</a>. Our current students also call prospective students many Wednesday and Thursday evenings. If you'd like to receive a call then, click <span id="Wednesday" class="action" onClick="requestCall('Wednesday')">Wednesday</span> or <span id="Thursday" class="action" onClick="requestCall('Thursday')">Thursday</span> to let us know which is better for you (you don't need to fill out another form).</p>
				<div style="height: auto">
					<div id="questionDiv">
						<p><strong>Your counselor is <?php echo($couns_name);?>. Ask <?php echo($couns_fname);?> a question!</strong></p>
						<img src="images/<?php echo($pic);?>" style="float:left; margin: 0 5px">
						<textarea id="question" name="question" style="width: 400px; height:150px"></textarea>
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