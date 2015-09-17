<?php 
//ini_set("display_errors","On");
//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

if(isset($_POST['submit'])) {
	$post_msg = "";
	if($_POST['student1Fname'] == ""){
		$post_msg .= "First name";
	}
	else{
		foreach($_POST as $textKey => $textValue){
			$$textKey = addslashes($textValue);
			if(stristr($$textKey, "please select")){
				$$textKey = "N/A";
			}
			if(stristr($textKey, "Adult") && $textValue==""){
				$$textKey = "0";
			}
			if(stristr($textKey, "Child") && $textValue==""){
				$$textKey = "0";
			}
		}
		$sql = "INSERT INTO forms.family_weekend (student1Fname, student1Lname, student1Class, student1Meeting, student2Fname, student2Lname, student2Class, student2Meeting, accessibilityNeeds, relative1Fname, relative1Lname, relative1Hometown, relative1Homestate, relative1Country, relative1Class, relative2Fname, relative2Lname, relative2Hometown, relative2Homestate, relative2Country, relative2Class, relative3Fname, relative3Lname, relative3Hometown, relative3Homestate, relative3Country, relative3Class, relative4Fname, relative4Lname, relative4Hometown, relative4Homestate, relative4Country, relative4Class, relative5Fname, relative5Lname, relative5Hometown, relative5Homestate, relative5Country, relative5Class, honorsConvocationAdults, honorsConvocationChild, FYAdjustmentAdults, FYAdjustmentChild, alumniPanelAdults, alumniPanelChild, studyAbroadPanelAdults, studyAbroadPanelChild, internationalFairAdults, internationalFairChild, provostsReceptionAdults, hikeUpMountainAdults, hikeUpMountainChild, fridayLunchAdults, fridayLunchChild, fridayDinnerAdults, fridayDinnerChild, saturdayBrunchAdults, saturdayBrunchChild, saturdayDinnerAdults, saturdayDinnerChild, sundayBrunchAdults, sundayBrunchChild, totalFamilyMembersAttending, date_submitted, student1MeetingSpecifyWhich, student2MeetingSpecifyWhich, relative1Email,academicAdvisorMeeting1,academicAdvisorMeeting2,sophomoreFacultyMeeting1,sophomoreFacultyMeeting2,SMLateArrival1, arrivaldetails1,SMLateArrival2, arrivaldetails2)  
 		VALUES ('$student1Fname', '$student1Lname', '$student1Class', '$student1Meeting', '$student2Fname', '$student2Lname', '$student2Class', 
'$student2Meeting', '$accessibilityNeeds', '$relative1Fname', '$relative1Lname', '$relative1Hometown', '$relative1Homestate', '$relative1Country', '$relative1Class', '$relative2Fname', '$relative2Lname', '$relative2Hometown', '$relative2Homestate', '$relative2Country', '$relative2Class', '$relative3Fname', '$relative3Lname', '$relative3Hometown', '$relative3Homestate', '$relative3Country','$relative3Class', '$relative4Fname', '$relative4Lname', '$relative4Hometown', '$relative4Homestate', '$relative4Country', '$relative4Class', '$relative5Fname', '$relative5Lname', '$relative5Hometown', '$relative5Homestate', '$relative5Country', '$relative5Class', $honorsConvocationAdults, $honorsConvocationChild, $FYAdjustmentAdults, $FYAdjustmentChild, $alumniPanelAdults, $alumniPanelChild, $studyAbroadPanelAdults, $studyAbroadPanelChild, $internationalFairAdults, $internationalFairChild, $provostsReceptionAdults, $hikeUpMountainAdults, $hikeUpMountainChild, $fridayLunchAdults, $fridayLunchChild, $fridayDinnerAdults, $fridayDinnerChild, $saturdayBrunchAdults, $saturdayBrunchChild, $saturdayDinnerAdults, $saturdayDinnerChild, $sundayBrunchAdults, $sundayBrunchChild, $totalFamilyMembersAttending, NOW(), '$student1MeetingSpecifyWhich', '$student2MeetingSpecifyWhich', '$relative1Email', '$academicAdvisorMeeting1', '$academicAdvisorMeeting2', '$sophomoreFacultyMeeting1', '$sophomoreFacultyMeeting2','$SMLateArrival1','$arrivaldetails1','$SMLateArrival2','$arrivaldetails2')";

		$db->do_query($sql);
		$post_success = true;
	}
}
$relativesTotal = 5;
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Family Weekend Registration</title>
<?php 
if(isset($post_success) && $post_success == true){
	echo "<script>
			window.top.location.href = \"http://www.simons-rock.edu/parents-families/family-weekend/family-weekend-2011-registration-confirmation\";
		</script>
		<noscript>
			Registration successful.  <a href=\"/parents-families/family-weekend/family-weekend-2011-registration-confirmation\">Click here to continue</a>.
		</noscript>";
}
?>
<script type="text/javascript">
<!--
function setMeetingTimeMsg(level,student) {
	stud = 'meetingTimeMsg';
	stud += student;
	FM = 'nonSophomoreFM';
	FM += student;
	FMS = 'sophomoreFM';
	FMS += student;
	if(level == "---Please Select---"){
		document.getElementById(FM).style.display = 'none';
		document.getElementById(FMS).style.display = 'none';
		if(document.getElementById('accessibilityNeeds').value.length==0){
			if(student==1){
				document.getElementById('accessibilityDiv').style.display = 'none';
			}
		}
	}
	else if(level != "Sophomore"){
		msg = 'PLEASE NOTE: All Faculty Meetings for ';
		msg += level;
		msg += ' Students take place Saturday, between 10 a.m. and 1 p.m.<br /><br /><p>Please let us know if you will be arriving late Saturday. We will schedule accordingly.</p>';

		msg = '<p style="font-weight: normal"><strong>Faculty and advisor meetings take place only on Saturday, October 27, from 10:00 am to 1:00 pm</strong>. We recommend that family members of first-semester students meet with as many of their student\'s faculty as possible&mdash;it is a nice opportunity to put faces and names together. In addition, midterm grades and comments will be out shortly before Family Weekend and these meetings are a good opportunity to follow up on your student\’s progress in his/her classes.<br /><br /><strong>NOTE: </strong>Many faculty schedules are full or almost full for Saturday morning meetings. Please indicate with whom you would like to meet and we will let you know which faculty members still have available meeting times. We will continue scheduling meetings for families through Thursday morning. Thank you.</p><p style="font-weight: normal; display: none">We do not schedule meetings for any of the ensemble classes (Chorus, Jazz, Madrigal Group, Chamber Orchestra, and Collegium). Generally, faculty members with "adjunct" status are not available for meetings on Family Weekend, nor are private music instructors.</p>';


		document.getElementById(stud).innerHTML = msg;
		document.getElementById(FM).style.display = '';
		document.getElementById(FMS).style.display = 'none';
		document.getElementById('accessibilityDiv').style.display = '';
	}
	else{
		document.getElementById(FMS).style.display = '';
//		document.getElementById(FM).style.display = 'none';
		if(document.getElementById('accessibilityNeeds').value.length==0){
			if(student==1){
	//			document.getElementById('accessibilityDiv').style.display = 'none';
			}
		}
	}
}
function specifyWhich(val,studNum){
	stud = 'student';
	stud += studNum;
	stud += 'MeetingSpecifyWhichDiv';
	if(val == "some"){
		document.getElementById(stud).style.display = '';
	}
	else {
		document.getElementById(stud).style.display = 'none';
	}
}
function toggleDiv(id,div){
	if(document.getElementById(id).checked){
		document.getElementById(div).style.display='';
	}
	else{
		document.getElementById(div).style.display='none';
	}
}
function showAnother(id,type){
	if(document.getElementById(id).style.display == ''){
		document.getElementById(id).style.display = 'none';
		moreOrLess = 'less';
	}
	else{
		document.getElementById(id).style.display = '';
		moreOrLess = 'more';
	}
	if(type == 'family'){
		if(moreOrLess == 'more'){
			document.getElementById('totalFamilyMembersAttending').value++;
		}
		else{
			document.getElementById('totalFamilyMembersAttending').value--;
		}
		document.getElementById('totalFamilyMembersAttendingShow').innerHTML = document.getElementById('totalFamilyMembersAttending').value;
	}
}
var tooltip=function(){
 var id = 'tt';
 var top = 3;
 var left = 3;
 var maxw = 300;
 var speed = 10;
 var timer = 20;
 var endalpha = 95;
 var alpha = 0;
 var tt,t,c,b,h;
 var ie = document.all ? true : false;
 return{
  show:function(v,w){
   if(tt == null){
    tt = document.createElement('div');
    tt.setAttribute('id',id);
    t = document.createElement('div');
    t.setAttribute('id',id + 'top');
    c = document.createElement('div');
    c.setAttribute('id',id + 'cont');
    b = document.createElement('div');
    b.setAttribute('id',id + 'bot');
    tt.appendChild(t);
    tt.appendChild(c);
    tt.appendChild(b);
    document.body.appendChild(tt);
    tt.style.opacity = 0;
    tt.style.filter = 'alpha(opacity=0)';
    document.onmousemove = this.pos;
   }
   tt.style.display = 'block';
   c.innerHTML = v;
   tt.style.width = w ? w + 'px' : 'auto';
   if(!w && ie){
    t.style.display = 'none';
    b.style.display = 'none';
    tt.style.width = tt.offsetWidth;
    t.style.display = 'block';
    b.style.display = 'block';
   }
  if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
  h = parseInt(tt.offsetHeight) + top;
  clearInterval(tt.timer);
  tt.timer = setInterval(function(){tooltip.fade(1)},timer);
  },
  pos:function(e){
   var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
   var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
   tt.style.top = (u - h) + 'px';
   tt.style.left = (l + left) + 'px';
  },
  fade:function(d){
   var a = alpha;
   if((a != endalpha && d == 1) || (a != 0 && d == -1)){
    var i = speed;
   if(endalpha - a < speed && d == 1){
    i = endalpha - a;
   }else if(alpha < speed && d == -1){
     i = a;
   }
   alpha = a + (i * d);
   tt.style.opacity = alpha * .01;
   tt.style.filter = 'alpha(opacity=' + alpha + ')';
  }else{
    clearInterval(tt.timer);
     if(d == -1){tt.style.display = 'none'}
  }
 },
 hide:function(){
  clearInterval(tt.timer);
   tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
  }
 };
}();
 
//-->
</script>
<style>
body{
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	background:#fff;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}
/* ----------- My Form ----------- */
.myform{
	margin:0 auto;
	width:530px;
	padding:6px;
}
/* ----------- stylized ----------- */
#stylized{
	border:solid 1px #b7ddf2;
	/*          background:#ebf4fb; */
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
	padding-bottom:10px;
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
	text-align:left; 
	width: 20px;
	padding: 0 15px 0 0;
	margin: 0;
	float: right;
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
margin:2px 0 10px 10px;
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
  padding:0;
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
.msg {
	padding: 15px;
	font-size: 12px;
	font-weight: bold;
}

 #tt {
 position:absolute;
 display:block;
 background:url(images/tt_left.gif) top left no-repeat;
 }
 #tttop {
 display:block;
 height:5px;
 margin-left:5px;
 background:url(images/tt_top.gif) top right no-repeat;
 overflow:hidden;
 }
 #ttcont {
 display:block;
 padding:2px 12px 3px 7px;
 margin-left:5px;
 background:#666;
 color:#fff;
 }
#ttbot {
display:block;
height:5px;
margin-left:5px;
background:url(images/tt_bottom.gif) top right no-repeat;
overflow:hidden;
}



</style>
</head>
<body>
  <div id="stylized" class="myform">
  
<?php
if(isset($post_success) & $post_success == true)  {
	echo "<p>Thank you! We look forward to seeing you at Family Weekend.</p>";
	echo "</div></body></html>";
}
else {
?>
  
  
	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()">

    <div class="spacer" style="clear:both"></div>
	<div style="margin: 15px; font-size:16px"><strong>About Your Student(s)</strong></div>
	<div style="clear:both; border: 1px solid #000; background:#F8F8F8; " id="student1Div">
		<div style="float:right; font-size: 14px">Student #1</div>
    	<div style="clear:both" id="student1FnameDiv">
          <label for="student1Fname">Student First Name
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="student1Fname" id="student1Fname" /><span class="required">*</span>
        </div>
        <div style="clear:both" id="student1LnameDiv">
          <label for="student1Lname">Student Last Name
          </label>
          <input type="text" name="student1Lname" id="student1Lname" /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both">
          <label for="student1Class">Currently a:</label>
          <select name="student1Class" id="student1Class" onChange="setMeetingTimeMsg(this.value,'1')" />
          	<option>---Please Select---</option>
          	<option value="First-year">First-year</option>
          	<option value="Sophomore">Sophomore</option>
          	<option value="Junior">Junior</option>
          	<option value="Senior">Senior</option>
          </select>
        </div>

        <div style="clear: both; display: ''" id="nonSophomoreFM1">
        	<div style="padding: 0 0 0 20px; font-weight: bold">
            	Faculty Meetings 
                	<div class="msg" id="meetingTimeMsg1">
						<p style="font-weight: normal"><strong>Faculty and advisor meetings take place only on Saturday, October 27, from 10:00 am to 1:00 pm</strong>. We recommend that family members of first-semester students meet with as many of their student's faculty as possible&mdash;it is a nice opportunity to put faces and names together. In addition, midterm grades and comments will be out shortly before Family Weekend and these meetings are a good opportunity to follow up on your student's progress in his/her classes.<br>
							<!--
								<br>
								<strong>NOTE: </strong>Many faculty schedules are full or almost full for Saturday morning meetings. Please indicate with whom you would like to meet and we will let you know which faculty members still have available meeting times. We will continue scheduling meetings for families through Thursday morning. Thank you. 
							-->
						</p>
						<p style="font-weight: normal; display: none">We do not schedule meetings for any of the ensemble classes (Chorus, Jazz, Madrigal Group, Chamber Orchestra, and Collegium). Generally, faculty members with "adjunct" status are not available for meetings on Family Weekend, nor are private music instructors.</p></div>
            </div>
        	<div style="padding: 0 0 0 70px; "><strong>Meetings Requests</strong></div>
			<div style="padding: 0 0 0 70px; ">1. I would like to meet with My Student's Academic Advisor:</div>
			<div style="width:150px; padding-left:125px; display:inline-block;">
				<div style="float:left" ><input type="radio" class="radio" name="academicAdvisorMeeting1" id="academicAdvisorMeeting1Yes" value="1">
					<label for="academicAdvisorMeeting1Yes" class="labelsmall">Yes</label></div>
				<div style="float:left" ><input type="radio" class="radio" name="academicAdvisorMeeting1" id="academicAdvisorMeeting1No" value="0">
					<label for="academicAdvisorMeeting1No" class="labelsmall">No</label></div>
			</div>
        	<div style="padding: 0 0 0 70px; ">2. I would like to meet with:</div>
            <div style="margin: 0 0 0 150px; display: inline-block;">
            	<div style="float:left;">
              	<input class="radio" type="radio" name="student1Meeting" id="student1MeetingAll" value="all"  onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display='none'"  /><label class="labelwide" for="student1MeetingAll">All of the Student's Available Faculty</label></div>
            	<div style="float:left; ">
              	<input class="radio" type="radio" name="student1Meeting" id="student1MeetingNone" value="none"   onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display='none'" /><label class="labelwide" for="student1MeetingNone" >No Meetings with Faculty</label></div>
                <div style="float:left; ">
              	<input class="radio" type="radio" name="student1Meeting" id="student1MeetingSpecify" value="some"   onClick="document.getElementById('student1MeetingSpecifyWhichDiv').style.display=''" /><label class="labelwide" for="student1MeetingSpecify">Specify Certain Faculty</label>
                
                	<div id="student1MeetingSpecifyWhichDiv" style="display:none" >Please specify the Faculty (or the course subject matter) with which you wish to meet:<br />
<input type="text" name="student1MeetingSpecifyWhich" style="width:300px; padding: 4px" id="student1MeetingSpecifyWhich">
                    </div>
                </div>
            </div>
	    </div>

        <div style="clear: both; display: none" id="sophomoreFM1">
        	<div style="padding: 0 0 0 20px; font-weight: bold">
            	Sophomore Planning Meetings 
                	<div class="msg">
					<p style="font-weight: normal">Elizabeth Lierman will be available, by appointment, to meet with sophomores and their parents to discuss post-graduation plans. Please note that <strong>all Sophomore Planning Meetings will be scheduled on Friday between 10:00 am and 1:00 pm</strong> <span style="font-weight: normal">Please let us know if you will be arriving late Friday. We will schedule accordingly.</span></p>
					</div>
            </div>
        	<div style="padding: 0 0 0 70px; ">I would like to request a Sophomore Planning Meeting:</div>
			<div style="width:150px; padding-left:125px">
				<div style="float:left" ><input type="radio" class="radio" name="sophomoreFacultyMeeting1" id="sophomoreFacultyMeeting1Yes" value="1" onClick="document.getElementById('lateArrive1_div').style.display=''">
					<label for="sophomoreFacultyMeeting1Yes" class="labelsmall" >Yes</label></div>
				<div style="float:left" ><input type="radio" class="radio" name="sophomoreFacultyMeeting1" id="sophomoreFacultyMeeting1No" value="0" onClick="document.getElementById('lateArrive1_div').style.display='none'">
					<label for="sophomoreFacultyMeeting1No" class="labelsmall">No</label></div>
			</div>
			<div id="lateArrive1_div" style="clear:both; padding: 0 0 0 70px; display: inline-block; display: none ">
				<div>
					<input type="checkbox" name="SMLateArrival1" id="SMLateArrival1" class="radio" onClick="toggleDiv('SMLateArrival1','arrivaldetails_div')">
						<label for="SMLateArrival1" class="labelwide">Yes, I will be arriving late, and am unable to meet between 10 am  and 1pm on Friday and wish to meet later on Friday (if possible).</label></div>
				<div style="display:none; clear:both" id="arrivaldetails_div">Please provide specifics about your estimated arrival time so that we may schedule on that basis.<br>
					<textarea name="arrivaldetails1" id="arrivaldetails1" style="width:300px; height: 80px; margin: 8px" ></textarea>
				</div>
			</div>
		</div>

		<div style="clear:both;">
			<div><a href="javascript: showAnother('student2Div','student')" style="text-decoration: none; font-size:14px;"><img src="userblue_add.png" style="padding: 0 10px; border: 0" />I have more than one student at Simon's Rock</a></div>		
			<div class="spacer"></div>	
		</div>
	</div>
	<div class="spacer"></div>
	<div style="clear:both; border: 1px solid #000; background:#F8F8F8; display: none" id="student2Div">
		<div style="float:right; font-size: 14px">Student #2</div>
    	<div style="clear:both" id="student2FnameDiv">
          <label for="student2Fname">Student First Name
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="student2Fname" id="student2Fname" /><span class="required">*</span>
        </div>
        <div style="clear:both" id="student2LnameDiv">
          <label for="student2Lname">Student Last Name
          </label>
          <input type="text" name="student2Lname" id="student2Lname" /><span class="required">*</span>
        </div>
        <div class="spacer"></div>
        <div style="clear:both; display:inline-block">
          <label for="student2Class">Currently a:</label>
          <select name="student2Class" id="student2Class" onChange="setMeetingTimeMsg(this.value,'2')" />
          	<option>---Please Select---</option>
          	<option value="First-year">First-year</option>
          	<option value="Sophomore">Sophomore</option>
          	<option value="Junior">Junior</option>
          	<option value="Senior">Senior</option>
          </select>
        </div>        
        <div style="clear: both; display:''" id="nonSophomoreFM2">
        	<div style="padding: 0 0 0 20px; font-weight: bold">
            	<div class="msg" id="meetingTimeMsg2"><p style="font-weight: normal"><strong>Faculty and advisor meetings take place only on Saturday, October 27, from 10:00 am to 1:00 pm</strong>. We recommend that family members of first-semester students meet with as many of their student's faculty as possible&mdash;it is a nice opportunity to put faces and names together. In addition, midterm grades and comments will be out shortly before Family Weekend and these meetings are a good opportunity to follow up on your student's progress in his/her classes.<br /><br /><strong>NOTE:</strong> Many faculty schedules are full or almost full for Saturday morning meetings. Please indicate with whom you would like to meet and we will let you know which faculty members still have available meeting times. We will continue scheduling meetings for families through Thursday morning. Thank you.
</p>
					<p style="font-weight: normal; display: none">We do not schedule meetings for any of the ensemble classes (Chorus, Jazz, Madrigal Group, Chamber Orchestra, and Collegium). Generally, faculty members with "adjunct" status are not available for meetings on Family Weekend, nor are private music instructors.</p>
				</div> 
            </div>
        	<div style="padding: 0 0 0 70px; "><strong>Meetings Requests</strong></div>
			<div style="padding: 0 0 0 70px; ">1. I would like to meet with My Student's Academic Advisor:</div>
			<div style="width:150px; padding-left:125px; display:inline-block;">
				<div style="float:left" ><input type="radio" class="radio" name="academicAdvisorMeeting2" id="academicAdvisorMeeting2Yes" value="1">
					<label for="academicAdvisorMeeting2Yes" class="labelsmall">Yes</label></div>
				<div style="float:left" ><input type="radio" class="radio" name="academicAdvisorMeeting2" id="academicAdvisorMeeting2No" value="0">
					<label for="academicAdvisorMeeting2No" class="labelsmall">No</label></div>
			</div>
        	<div style="padding: 0 0 0 70px; ">2. I would like to meet with:</div>
            <div style="margin: 0 0 0 150px; display: inline-block;">
            	<div style="float:left;">
              	<input class="radio" type="radio" name="student2Meeting" id="student2MeetingAll" value="all" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display='none'" /><label class="labelwide" for="student2MeetingAll">All of the Student's Available Faculty</label></div>
            	<div style="float:left; ">
              	<input class="radio" type="radio" name="student2Meeting" id="student2MeetingNone" value="none" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display='none'" /><label class="labelwide" for="student2MeetingNone" >No Meetings with Faculty</label></div>
                <div style="float:left; ">
              	<input class="radio" type="radio" name="student2Meeting" id="student2MeetingSpecify" value="some" onClick="document.getElementById('student2MeetingSpecifyWhichDiv').style.display=''"  /><label class="labelwide" for="student2MeetingSpecify">Specify Certain Faculty</label>
                
                	<div id="student2MeetingSpecifyWhichDiv" style="display:none" >Please specify the Faculty (or the course subject matter) with which you wish to meet:<br />
<input type="text" name="student2MeetingSpecifyWhich" style="width:300px; padding: 4px" id="student2MeetingSpecifyWhich">
                    </div>
                </div>
            </div>
        </div>
		
        <div style="clear: both; display: none" id="sophomoreFM2">
        	<div style="padding: 0 0 0 20px; font-weight: bold">
            	Sophomore Planning Meetings 
                	<div class="msg"><p style="font-weight: normal">Elizabeth Lierman will be available, by appointment, to meet with sophomores and their parents to discuss post-graduation plans. Please note that <strong>all Sophomore Planning Meetings will be scheduled on Friday between 10:00 am and 1:00 pm</strong> <span style="font-weight: normal">Please let us know if you will be arriving late Friday. We will schedule accordingly.</span></p></div>
            </div>
        	<div style="padding: 0 0 0 70px; ">I would like to request a Sophomore Planning Meeting:</div>
			<div style="width:150px; padding-left:125px; display:inline-block;">
				<div style="float:left" ><input type="radio" class="radio" name="sophomoreFacultyMeeting2" id="sophomoreFacultyMeeting2Yes" value="1" onClick="document.getElementById('lateArrive2_div').style.display='inline-block'">
					<label for="sophomoreFacultyMeeting2Yes" class="labelsmall">Yes</label></div>
				<div style="float:left" ><input type="radio" class="radio" name="sophomoreFacultyMeeting2" id="sophomoreFacultyMeeting2No" value="0" onClick="document.getElementById('lateArrive2_div').style.display='none'">
					<label for="sophomoreFacultyMeeting2No" class="labelsmall">No</label></div>
			</div>
			<div id="lateArrive2_div" style="clear:both; padding: 0 0 0 70px;display: inline-block; display: none">
				<div>
					<input type="checkbox" name="SMLateArrival2" id="SMLateArrival2" class="radio" onClick="toggleDiv('SMLateArrival2','arrivaldetails2_div')">
						<label for="SMLateArrival2" class="labelwide">Yes, I will be arriving late, and am unable to meet between 10 am  and 1pm on Friday and wish to meet later on Friday (if possible).</label></div>
				<div style="display:none; clear:both " id="arrivaldetails2_div">Please provide specifics about your estimated arrival time so that we can schedule on that basis.<br>
					<textarea name="arrivaldetails2" id="arrivaldetails2" style="width:300px; height: 80px; margin: 8px" ></textarea>
				</div>
			</div>					
		</div>
		
	</div>
	
	<div class="spacer"></div>
    <div style="clear:both; padding:5px; margin:5px; " id="accessibilityDiv">
		<div style="margin: 15px; font-size:16px"><strong>Accessibility</strong></div>
		<div style="margin: 15px; font-size:13px">Meetings take place in faculty offices located around campus in 4 different academic buildings. Some buildings have elevators and some have only stairs, so <strong>please let us know if you would like to meet in an accessible meeting location</strong> by providing a brief description of your accessibility needs.</div>
		<textarea name="accessibilityNeeds" id="accessibilityNeeds" style="width:500px; height: 80px; margin: 8px" ></textarea>	
	</div>
    <div class="spacer" style="clear:both"></div>
	<div style="margin: 15px; font-size:16px"><strong>Family Members Attending</strong></div>
	
<?php 
for($relativeCount=1; $relativeCount <= $relativesTotal; $relativeCount++){
	if($relativeCount==1){
		$display = '';
	}
	else{
		$display = 'none';
	}

	echo '<div style="clear:both; border: 1px solid #000; background:#F8F8F8; display:'.$display.'" id="relative'.$relativeCount.'Div">';
	if($relativeCount==1){
		echo '<div style="font-size:14px; font-weight: bold; text-indent: 20px;">Your Information</div>';
	}
	else{
		echo '<div style="font-size:14px; font-weight: bold; text-indent: 15px;">Family Member '.($relativeCount).'</div>';
	}
	echo '
		<div style="clear:both" id="student'.$relativeCount.'FnameDiv">
          <label for="relative'.$relativeCount.'Fname">First Name
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="relative'.$relativeCount.'Fname" id="relative'.$relativeCount.'Fname" /><span class="required">*</span>
        </div>
        <div style="clear:both" id="relative'.$relativeCount.'LnameDiv">
          <label for="relative'.$relativeCount.'Lname">Last Name
          </label>
          <input type="text" name="relative'.$relativeCount.'Lname" id="relative'.$relativeCount.'Lname" /><span class="required">*</span>
        </div>';
		if($relativeCount==1){
			echo '
        <div style="clear:both" id="relative'.$relativeCount.'EmailDiv">
          <label for="relative'.$relativeCount.'Email">Email
          </label>
          <input type="text" name="relative'.$relativeCount.'Email" id="relative'.$relativeCount.'Email" /><span class="required">*</span>
        </div>			
			';
		}
		echo '
        <div style="clear:both" id="relative'.$relativeCount.'HometownDiv">
          <label for="relative'.$relativeCount.'Hometown">City
          </label>
          <input type="text" name="relative'.$relativeCount.'Hometown" id="relative'.$relativeCount.'Hometown" />
        </div>
        <div style="clear:both" id="relative'.$relativeCount.'HomestateDiv">
          <label for="relative'.$relativeCount.'Homestate">State/Province
          </label>
          <input type="text" name="relative'.$relativeCount.'Homestate" id="relative'.$relativeCount.'Homestate" />
        </div>
        <div style="clear:both" id="relative'.$relativeCount.'CountryDiv">
          <label for="relative'.$relativeCount.'Country">Country
          </label>
          <input type="text" name="relative'.$relativeCount.'Country" id="relative'.$relativeCount.'Country" />
        </div>
        <div style="clear:both">
          <label for="relative'.$relativeCount.'Class">Relationship:</label>
          <select name="relative'.$relativeCount.'Class" id="relative'.$relativeCount.'Class" style="float:none" />
          	<option>---Please Select---</option>
          	<option>Parent/Guardian</option>
          	<option>Other Adult Family Member</option>
          	<option>Child under 12</option>
          </select>
        </div>        

';
		if($relativeCount<$relativesTotal){
			echo '
	<div style="clear:both; ">
				  <div><a href="javascript: showAnother(\'relative'.($relativeCount+1).'Div\',\'family\')" style="text-decoration: none; font-size:14px;"><img src="userblue_add.png" style="padding: 0 10px; border: 0" /> Add additional Family Members Attending</a></div>
				<div class="spacer"></div>	
			</div>
			';
		}
	echo '
	</div>	
	<div class="spacer"></div>';
}
?>
    <div class="spacer" style="clear:both"></div>
	<div style="margin: 15px; font-size:14px; text-align:right">
		<div style="float: right; "><input type="hidden" name="totalFamilyMembersAttending" id="totalFamilyMembersAttending" value="1" /></div>
		<div style="float: right; margin-bottom: 0"><strong>Total Family Members Attending: <span id="totalFamilyMembersAttendingShow">1</span></strong></div>
	</div>
	
	
	<div style="clear:both; padding:5px; margin:5px; ">
		<p style="margin: 15px; font-size:16px"><strong>Events</strong></p>
		<div>
			<div style="margin: 15px; font-size:13px">Please indicate which of the events listed below you plan to attend, and the number of attendees.</div>
		</div>
		<div style="margin: 15px; font-size:15px"><strong>Friday, October 27th</strong></div>
		<div>
			<div style="float:left; text-indent: 10px; text-align: center; width:180px;"><strong>Event</strong></div>
			<div style="width:160px; float: left"><strong>Number Attending:</strong></div>
		</div>
		<div>
			<div style="padding-left: 190px; width:53px; margin-right: 12px; float: left">Adults</div>
			<div style="width:50px; float: left">Children</div>
		</div>
    	<div style="clear:both; display:none;" id="attendClassesDiv">
          <label for="attendClasses" class="labelmed">Attend Classes
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" style="width: 50px" name="attendClassesAdults" id="attendClassesAdults" />
		  <input type="text" style="width: 50px" name="attendClassesChild" id="attendClassesChild" />
        </div>
		<div style="clear:both; display:none;" id="labOpenHouseDiv">
          <label for="labOpenHouse" class="labelmed">Lab Open House
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" style="width: 50px" name="labOpenHouseAdults" id="labOpenHouseAdults" />
		  <input type="text" style="width: 50px" name="labOpenHouseChild" id="labOpenHouseChild" />
        </div>
		<div style="clear:both; display:none; " id="familyRecreationTimeDiv">
          <label for="familyRecreationTime" class="labelmed">Family Recreation Time
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" style="width: 50px" name="familyRecreationTimeAdults" id="familyRecreationTimeAdults" />
		  <input type="text" style="width: 50px" name="familyRecreationTimeChild" id="familyRecreationTimeChild" />
        </div>
		<div style="clear:both; display:none;" id="winStudentResourceCommonsDiv">
          <label for="winStudentResourceCommons" class="labelmed">Win Student Resource Commons: Support Services for Students</label>
          <input type="text" style="width: 50px" name="winStudentResourceCommonsAdults" id="winStudentResourceCommonsAdults" />
		  <input type="text" style="width: 50px" name="winStudentResourceCommonsChild" id="winStudentResourceCommonsChild" />
        </div>
		<div style="clear:both; " id="honorsConvocationDiv">
          <label for="honorsConvocationCommons" class="labelmed">Honors Convocation and Reception</label>
          <input type="text" style="width: 50px" name="honorsConvocationAdults" id="honorsConvocationAdults" />
		  <input type="text" style="width: 50px" name="honorsConvocationChild" id="honorsConvocationChild" />
		  <img src="info.png" onMouseOver="tooltip.show('Join Provost Peter Laipson and the faculty and student speakers on this special evening when the College celebrates this year\'s recipients of named scholarships', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" />
        </div>
		<div style="clear:both; display:none; " id="welcomeReceptionDiv">
          <label for="welcomeReception" class="labelmed">Welcome Reception</label>
          <input type="text" style="width: 50px" name="welcomeReceptionAdults" id="welcomeReceptionAdults" />
		  <input type="text" style="width: 50px" name="welcomeReceptionChild" id="welcomeReceptionChild" />
        </div>
		<div class="spacer"></div>
		
		<div style="margin: 15px; font-size:15px; clear:both"><strong>Saturday, October 28th</strong></div>
		
    	<div style="clear:both; display:none;" id="studAffairsOHDiv">
          <label for="studAffairsOH" class="labelmed">Student Affairs Open House</label>
          <input type="text" style="width: 50px" name="studAffairsOHAdults" id="studAffairsOHAdults" />
		  <input type="text" style="width: 50px" name="studAffairsOHChild" id="studAffairsOHChild" />
        </div>
    	<div style="clear:both" id="FYAdjustmentDiv">
          <label for="FYAdjustment" class="labelmed">First-Year Adjustment</label>
          <input type="text" style="width: 50px" name="FYAdjustmentAdults" id="FYAdjustmentAdults" />
		  <input type="text" style="width: 50px" name="FYAdjustmentChild" id="FYAdjustmentChild" />
		  <img src="info.png" onMouseOver="tooltip.show('How does a student settle into the Simon\'s Rock routine? Attend this panel presentation to find out!', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" />
        </div>
    	<div style="clear:both" id="alumniPanelDiv">
          <label for="alumniPanel" class="labelmed">Alumni Panel</label>
          <input type="text" style="width: 50px" name="alumniPanelAdults" id="alumniPanelAdults" />
		  <input type="text" style="width: 50px" name="alumniPanelChild" id="alumniPanelChild" />
		  <img src="info.png" onMouseOver="tooltip.show('Alumni share their academic/career paths since leaving Simon\'s Rock.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" />
        </div>
    	<div style="clear:both; display:none;" id="jazzPerformanceDiv">
          <label for="jazzPerformance" class="labelmed">Jazz Ensemble Performance</label>
          <input type="text" style="width: 50px" name="jazzPerformanceAdults" id="jazzPerformanceAdults" />
		  <input type="text" style="width: 50px" name="jazzPerformanceChild" id="jazzPerformanceChild" />
        </div>
    	<div style="clear:both" id="studyAbroadPanelDiv">
          <label for="studyAbroadPanel" class="labelmed">Study Abroad Panel</label>
          <input type="text" style="width: 50px" name="studyAbroadPanelAdults" id="studyAbroadPanelAdults" />
		  <input type="text" style="width: 50px" name="studyAbroadPanelChild" id="studyAbroadPanelChild" />
		  <img src="info.png" onMouseOver="tooltip.show('Five seniors will share their experiences during their study away program.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" />
        </div>
    	<div style="clear:both" id="internationalFairDiv">
          <label for="internationalFair" class="labelmed">International Fair</label>
          <input type="text" style="width: 50px" name="internationalFairAdults" id="internationalFairAdults" />
		  <input type="text" style="width: 50px" name="internationalFairChild" id="internationalFairChild" />
		  <img src="info.png" onMouseOver="tooltip.show('Students invite you to learn about their area of the world in a variety of ways:  through photographs, videos, dress, cuisine, and language, among others.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" />
        </div>
    	<div style="clear:both" id="provostsReceptionDiv">
          <label for="provostsReception" class="labelmed">Provost's Reception</label>
          <input type="text" style="width: 50px" name="provostsReceptionAdults" id="provostsReceptionAdults" />
		  <input type="text" style="width: 50px; display: none" value="0" name="provostsReceptionChild" id="provostsReceptionChild" />
		  <img src="info.png" onMouseOver="tooltip.show('Provost Peter Laipson invites parents (only, please) to join him and members of the faculty and staff for a reception.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" />
        </div>
		<div class="spacer"></div>
		
		
		<div style="margin: 15px; font-size:15px; clear:both; display: none"><strong>Sunday, October 30th</strong></div>
		
    	<div style="clear:both; display: none" id="hikeUpMountainDiv">
          <label for="hikeUpMountain" class="labelmed">Hike Up Mountain</label>
          <input type="text" style="width: 50px" name="hikeUpMountainAdults" id="hikeUpMountainAdults" />
		  <input type="text" style="width: 50px" name="hikeUpMountainChild" id="hikeUpMountainChild" />
		  <img src="info.png" onMouseOver="tooltip.show('Join us for a hike in one of our local parks.', 210);" onMouseOut="tooltip.hide();" style="float:left; padding: 2px 0 0 5px" />
        </div>
	</div>
	<div class="spacer"></div>

	<div style="clear:both; padding:5px; margin:5px; ">
		<p style="margin: 15px; font-size:16px"><strong>Meals</strong></p>
		<div>
			<div style="margin: 15px; font-size:13px">The dining hall is not able to accept credit cards. Please come prepared to pay cash at the door. Thank you! </div>
		</div>
		<div>
			<div style="float:left; text-indent: 10px; text-align: center; width:180px;"><strong>Meal</strong></div>
			<div style="width:160px; float: left"><strong>Number Attending:</strong></div>
		</div>
		<div>
			<div style="padding-left: 190px; width:53px; margin-right: 12px; float: left">Adults</div>
			<div style="width:50px; float: left">Children</div>
		</div>
    	<div style="clear:both; " id="fridayLunchDiv">
          <label for="fridayLunch" class="labelmed">Friday Lunch</label>
          <input type="text" style="width: 50px" name="fridayLunchAdults" id="fridayLunchAdults" />
		  <input type="text" style="width: 50px" name="fridayLunchChild" id="fridayLunchChild" />
        </div>
    	<div style="clear:both" id="fridayDinnerDiv">
          <label for="fridayDinner" class="labelmed">Friday Dinner</label>
          <input type="text" style="width: 50px" name="fridayDinnerAdults" id="fridayDinnerAdults" />
		  <input type="text" style="width: 50px" name="fridayDinnerChild" id="fridayDinnerChild" />
        </div>
    	<div style="clear:both" id="saturdayBrunchDiv">
          <label for="saturdayBrunch" class="labelmed">Saturday Brunch</label>
          <input type="text" style="width: 50px" name="saturdayBrunchAdults" id="saturdayBrunchAdults" />
		  <input type="text" style="width: 50px" name="saturdayBrunchChild" id="saturdayBrunchChild" />
        </div>
    	<div style="clear:both" id="saturdayDinnerDiv">
          <label for="saturdayDinner" class="labelmed">Saturday Dinner</label>
          <input type="text" style="width: 50px" name="saturdayDinnerAdults" id="saturdayDinnerAdults" />
		  <input type="text" style="width: 50px" name="saturdayDinnerChild" id="saturdayDinnerChild" />
        </div>
    	<div style="clear:both" id="sundayBrunchDiv">
          <label for="sundayBrunch" class="labelmed">Sunday Brunch</label>
          <input type="text" style="width: 50px" name="sundayBrunchAdults" id="sundayBrunchAdults" />
		  <input type="text" style="width: 50px" name="sundayBrunchChild" id="sundayBrunchChild" />
        </div>
	</div>
	<div class="spacer" style="height: 20px;"></div>
	<button type="submit" name="submit" id="submit">Register Now</button>
	<div class="spacer"></div>
	</form>
  </div>
<script>
<!--
function checkForm(){
    var bgcolor
    var normal
    var rval
    highlight = "#ffcccc"
    normal = "#ffffff"
    rval = true
	fieldFocus = "";
	if (document.layers||document.getElementById||document.all) {
        if (document.request.student1Fname.value.length == 0) {
            document.request.student1Fname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "student1Fname";
			}
		} 
		else {
            document.request.student1Fname.style.backgroundColor = normal
		}
        if (document.request.student1Lname.value.length == 0) {
            document.request.student1Lname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "student1Lname";
			}
		} 
		else {
            document.request.student1Lname.style.backgroundColor = normal
		}
	
		if (document.getElementById('student1Class').options[document.getElementById('student1Class').selectedIndex].value == '---Please Select---') {
            document.request.student1Class.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "student1Class";
			}
		} 
		else {
            document.request.student1Class.style.backgroundColor = normal
			//if(document.getElementById('student1Class').options[document.getElementById('student1Class').selectedIndex].value != "Sophomore"){
			if(1){
				if (getCheckedValue(document.request.elements['student1Meeting']) == undefined || getCheckedValue(document.request.elements['student1Meeting']) == "") {
					document.getElementById('nonSophomoreFM1').style.display = '';
					document.getElementById('nonSophomoreFM1').style.backgroundColor = highlight
					rval = false
				} 
				else {
					document.getElementById('nonSophomoreFM1').style.backgroundColor = normal
				} 
			}
			if(document.getElementById('student1Class').options[document.getElementById('student1Class').selectedIndex].value == "Sophomore"){
//			else {
				if (getCheckedValue(document.request.elements['sophomoreFacultyMeeting1']) == undefined || getCheckedValue(document.request.elements['sophomoreFacultyMeeting1']) == "") {
					document.getElementById('sophomoreFM1').style.display = '';
					document.getElementById('sophomoreFM1').style.backgroundColor = highlight
					rval = false
				} 
				else {
					document.getElementById('sophomoreFM1').style.backgroundColor = normal
				} 				
			}
		}
        if (document.request.relative1Fname.value.length == 0) {
            document.request.relative1Fname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "relative1Fname";
			}
		} 
		else {
            document.request.relative1Lname.style.backgroundColor = normal
		}		
        if (document.request.relative1Lname.value.length == 0) {
            document.request.relative1Lname.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "relative1Lname";
			}
		} 
		else {
            document.request.relative1Lname.style.backgroundColor = normal
		}
        if (document.request.relative1Email.value.length == 0) {
            document.request.relative1Email.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "relative1Email";
			}
		} 
		else {
            document.request.relative1Email.style.backgroundColor = normal
		}


        if (!rval) {
			alert ("Please complete all required (highlighted) fields prior to submitting your form.");
			if(fieldFocus != "") {
				document.getElementById(fieldFocus).style.display='';
				document.getElementById(fieldFocus).focus();
			}
		}
        return rval
    } 
	else {
        return true
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

// alert(document.request.elements['student1Meeting']);
// -->
</script>
</body>
</html>
<?php 
}
?>
