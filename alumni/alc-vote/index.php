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


require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();
// table: vote (id,name,email,phone,zip,vote)

$alert = "";
if(isset($_POST['submit'])) {


	// prevent mutiple submissions
	$remote_addr = ($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	$email = $_POST['email'];
//	$remote_addr = $_SERVER['REMOTE_ADDR'];
	$sql = "SELECT * FROM vote_alc_2014  WHERE remote_addr = '$remote_addr' OR email = '$email'";
	$db->do_query($sql);
	if($db->numRows() >	 0){
		$res = $db->fetchObject();
		$rem_add = $res->remote_addr;
		$eml = $res->email;
		$alert = "Only one vote per person, thank you.";
		$msg  = "DUP ENTRY ATTEMPT\n\n";
		$msg .= "REMOTE_ADDR = $remote_addr, ($rem_add in DB)\n";
		$msg .= "EMAIL SUBMITTED = $email, ($eml in DB)\n";
		mail("dscheff@simons-rock.edu","ALC VOTE",$msg);
	}
	else {
		$post_msg = "";
		$fname	= safe($_POST['fname']);
		$email	= safe($_POST['email']);
		$phone	= safe($_POST['phone']);
		$zip	= safe($_POST['zip']);
		$vote	= safe($_POST['vote']);
		
		$vote	= safe($_POST['vote']);
		
		// if the voted name was not on the ballot, append the class range
		if(strstr($vote,"writein")){
			// we've detected that the radiobutton sp[ecified it was going to be a write-in
			// so now we can do 2 things:
			// 1. 	Since we named the write-in fields based according to which date range they were in
			// 		we know the POST array key will hold the written value

			$key = $vote ."_value"; 
			$voted_name = $_POST[$key];

			// 2.	We can also extract the date range based on the way we named the fields
			// 		SO, this is basically what we're working from: writein_9099_value
			$key_parts = explode("_",$key);
			$start_date_range = substr($key_parts[1],0,4);
			$end_date_range = substr($key_parts[1],4,4);
			$vote = "$voted_name ($start_date_range - $end_date_range)";
		}

		$sql = "INSERT INTO vote_alc_2014  
				(id, name, email, phone, zip, vote, remote_addr, date) 
					VALUES  
				(NULL, '$fname', '$email', '$phone', '$zip', '$vote', '$remote_addr', now())";

		$db->do_query($sql);
		
		$msg = "";
		$msg .= "ALC VOTE\n\n";
		$msg .= "Voter Name: $fname\n";
		$msg .= "Email: $email\n";
		$msg .= "Phone: $phone\n";
		$msg .= "Zip: $zip\n\n";
		$msg .= "Vote Cast: $vote\n\n";
//		$msg .= "SQL: $sql\n\n";
		
	//	echo ($msg);
		mail("rmontone@simons-rock.edu","ALC VOTE 2014",$msg);
		mail("dscheff@simons-rock.edu","ALC VOTE 2014",$msg);
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>ALC VOTE 2014</title>
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
	width:686px;
	padding:6px;
	display: inline-block;
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
	width:235px;
	padding-top: 5px;
	float:left;
}
#stylized label.labelwide{
	width: auto;
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
	width:631px; 
	float:left;
	padding:10px;
}
#stylized .radiorow2{
	background-color: #D9D9D9; 
	width:631px; 
	float:left;
	padding:10px;
}
.radiolabels {
	clear:right; 
	float:left; 
	width: 150px; 
	padding-top: 3px;
}
#stylized button{
	clear: both;
	margin-left: 267px;
	min-width: 161px;
	height: 31px;
	background: #666 url(img/button.png) no-repeat;
	text-align: center;
	line-height: 31px;
	color: white;
	font-size: 21px;
	font-weight: bold;
	cursor:pointer;
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

<body onLoad="window.scroll(0,0); window.parent.scroll(0,0);">
<div id="innertop"></div>

<?php
if(!isset($_POST['submit'])) 
{
?>
<div id="stylized" class="myform">
	<form id="request" name="request" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" onSubmit="return checkForm()" >
    	<p><strong><span style="font-size:15px">Elections are open until 11:59pm on Sunday, July 6</span><br>
    					<br>
    					Your Information</strong> ( * = required field)<br /><br />
        	<?php 
            if($do_post_msg){
            //	echo $post_msg;
                echo "Please complete all highlighted fields.";
            }
            ?>
        </p>
			
		<div style="clear:both">
          <label for="fname">Full Name
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
          <label for="email">E-mail
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
          <input type="email" name="email" id="email" class="<?php echo($required); ?>" value="<?php echo($email);?>" /><span class="required">*</span>

		</div>
        <div style="clear:both">
          <label for="phone">Phone
          </label>
          <input type="text" name="phone" id="phone" value="<?php echo($phone); ?>" /><span class="required"> </span>
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

		<div style="clear:both; width:650px; text-align:left; padding: 10px 0 10px 10px; font-weight:bold; font-size: 15px">
			The Candidates<br />
			<span style="font-size: 13px; padding-left:10px;">(NOTE: You must choose a candidate from YOUR OWN era)</span>
		</div>
        <div style="clear:both; margin-left: 10px ">
			<div style="clear: both; width: 650px; text-align: left; padding: 10px 0 10px 0px; font-weight: bold; font-size: 15px; background: antiqueWhite; border-bottom: 1px solid black; border-right: 1px solid black; margin-top: 10px; padding=left: 3px">				
			Candidates for 2000-2009 Representative<br />
				<br /><a href="http://simons-rock.edu/alumni/alc/alc-representative-candidate-nomination-form" target="_top" style="font-size: 12px">Nominate a potential candidate for future elections</a>. 
			</div>

			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" onChange="toggleWritein(this)" style="margin-bottom: 0;" type="radio" name="vote" id="radio_amadiwale" value="Ajay Madiwale"
					<?php 
					if (isset($_POST['radio_amadiwale']) && $_POST['radio_amadiwale'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
					<label for="radio_amadiwale" class="labelwide"><strong>Ajay Madiwale</strong><strong> &lsquo;01 &ndash; Brooklyn, NY</strong>
					</label>
					<br />
					<img src="ajay-madiwale-sml.jpg" style=" float: right; margin: 0 0 5px 5px" />
					Attending Simon’s Rock changed the course of my life and has defined my world-view. Since graduating, I’ve embarked on a wide-ranging career in international development and human rights that has taken me to India, Afghanistan, London and now New York. Currently, I work at the United Nations representing the Red Cross in intergovernmental negotiation ensuring that the interests of the most vulnerable are reflected in UN resolutions and policy. Upon my return to New York, I immediately reengaged with the college, attending numerous alumni events and mentoring outgoing seniors interested in a career in international development. When I learned of the alumni leadership council, I thought the various drafting, negotiation and consensus building skills that I had developed professionally might also be useful in support of its activities. It would be an honor to give back to a community that has shaped my values, sharpened my intellect, provided me with life-long friends, and given me such a breadth of perspective. Thank you for your consideration of my candidacy to the Alumni Leadership Council. <!-- <br /><br /><span onClick="showHide('akalman','akalmanmore')" style="color: blue; cursor:pointer" id="akalmanmore">more...</span> -->
                </div>
            </div>

			<div class="radiorow2">
            	<div style="clear:none; float:left; " >
                <input class="radio" onChange="toggleWritein(this)" style="margin-bottom: 0;" type="radio" name="vote" id="radio_bsmith" value="Brian Smith"
					<?php 
					if (isset($_POST['radio_bsmith']) && $_POST['radio_bsmith'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
                    <label for="radio_bsmith" class="labelwide"><strong>Brian Smith &lsquo;04 &ndash; San Francisco, CA</strong>
                    </label>
                    <br />
					<img src="brian-smith-sml.jpg" style=" float: right; margin: 0 0 5px 5px" />
                    What does Simon's Rock mean to me? Two things: word-class academics, and a tribe that stays with you for life. The academics portion barely needs elaboration. SRC took me from being a middling high school student to getting into NYU for law school. It did that through its small class sizes; demanding professors; and the crucible that we call the senior thesis. At the risk of sounding cliche, if Simon's Rock did not exist, we would need to invent it.
                    <br /><br />
                    The tribe though, the tribe is what matters. I have lived in DC, Seattle, NYC, and the Bay Area since graduating from college, and Rockers have been my primary social circle in each. The shared experience of attending the early college brings us together. They also happen to be the most worthwhile people I know. Almost all of my close friends are Rockers (Jake Rudulph '04; Kori Higgins '04; Lauren DesRosiers '04). The attached photo was taken by a Rocker (Skyler Baulbus '04). The love of my life is a Rocker (Yesenia Gorbea '04). And I was not even particularly close with many of these people while I was at the school. I think that speaks to the fact that the Rock attracts interesting people, and should continue to do so.
                    <br /><br />
                    Why would I be a good candidate to serve on the ALC? Because I believe in the experience of attending Simon's Rock. Because, as an attorney for Davis, Polk & Wardwell, I possess the sort of bona fides that show choosing an alternative education today does not mean foregoing traditional success tomorrow. And because I live on the West Coast (and SRC needs to interact with people outside of the NY/New England bubble).
                    <br /><br />
                    It would be an honor to serve on the Alumni Leadership Council, and I hope that you elect me.
                </div>
            </div>
			<div style="clear:both;"></div>
<!-- @dscheff 20140616 - add a write in possibility -->
			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" onChange="toggleWritein(this)" style="margin-bottom: 0;" type="radio" name="vote" id="writein_20002009" value="writein_20002009"
					<?php 
					if (isset($_POST['writein_20002009']) && $_POST['writein_20002009'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
                    <label for="writein_20002009" class="labelwide"><strong>(Write-in candidate for 2000-2009, subject to candidate’s acceptance)</strong>
                    </label>
                    <br />
                    <input type="text" name="writein_20002009_value" id="writein_20002009_value" disabled >
                </div>
            </div>
			<div class="spacer" style="clear:both; height:15px;"></div>








			<div style="clear: both; width: 650px; text-align: left; padding: 10px 0 10px 0px; font-weight: bold; font-size: 15px; background: antiqueWhite; border-bottom: 1px solid black; border-right: 1px solid black; margin-top: 10px; padding=left: 3px">				
			Candidates for 1990-1999 Representative<br />
				<br />
				<a href="http://simons-rock.edu/alumni/alc/alc-representative-candidate-nomination-form" target="_top" style="font-size: 12px">Nominate a potential candidate for future elections</a>. 
			</div>
			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" onChange="toggleWritein(this)" style="margin-bottom: 0;" type="radio" name="vote" id="radio_kkapinos" value="Kristopher Kapinos"
					<?php 
					if (isset($_POST['radio_kkapinos']) && $_POST['radio_kkapinos'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div> 
                <div>
					<label for="radio_kkapinos" class="labelwide"><strong>Kristopher Kapinos</strong><strong> &lsquo;92 &ndash; London, UK</strong>
					</label>
					<br />
					<img src="kristopher-kapinos-sml.jpg" style=" float: right; margin: 0 0 5px 5px" />
					I am eager to join the Alumni Leadership Council (ALC) with a view to begin paying-forward that which I gained from my experience at Bard College at Simon's Rock. Like many former Simon's Rockers, I firmly believe the school has a unique place and special mission in American education. It is still a relatively young institution and, as such, is still developing its brand recognition. I know this from my own struggle to explain to others, especially in interviews as I was starting my career, the story of this fantastic education I had received from a small school in western Massachusetts. I would like to join the ALC to offer my assistance to continue to develop the brand and to assist the school's efforts to better enable the transition of its graduating students to professional life after Simon's Rock.<!-- <br /><br /><span onClick="showHide('akalman','akalmanmore')" style="color: blue; cursor:pointer" id="akalmanmore">more...</span> -->
                </div>
	        </div>

			<div class="radiorow2">
				<div style="clear:none; float:left; " >
                <input class="radio" onChange="toggleWritein(this)" style="margin-bottom: 0;" type="radio" name="vote" id="radio_mlawrence" value="Michael Lawrence"
					<?php 
					if (isset($_POST['radio_mlawrence']) && $_POST['radio_mlawrence'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
					<label for="radio_mlawrence" class="labelwide"><strong>Michael Lawrence</strong><strong> &lsquo;98 &ndash; Chicago, IL</strong>
					</label>
					<br />
					<img src="michael-lawrence-sml.jpg" style=" float: right; margin: 0 0 5px 5px" />
					More than a decade since graduating with my BA from Simon's Rock, my experience there (1998-2002) remains central to my sense of identity, both professionally and personally. It is because of my passion for the rich liberal arts education Simon's Rock offers that I went to work at Bard High School Early College in Manhattan after finishing my own degree. Inspired by the Simon's Rock faculty I studied so closely with, I went on to complete my PhD (Communication/Rhetorical Studies, University of Iowa) and now teach in the interdisciplinary First-Year Seminar program at Columbia College Chicago. I've maintained close ties with Simon's Rock: I've been back to visit a number of times, I stay in touch with Rocker friends and faculty, I attend alumni events in Chicago, and I cannot keep myself from extolling the virtues of the school's vision to anyone who will let me. Additionally, I co-authored a book chapter for the volume Simon's Rock published in 2011 about its unique pedagogy. I remember gathering in the dining hall on the eve of commencement, listening to representatives of the ALC making the case that we must plan to donate to the College every year, even if the donation was small; I'm proud to say I've done that. I cherish my memories of the Rock and believe that the education I received there is second to none. It continues to inform my own teaching, my writing, and my thinking. The Simon's Rock spirit&mdash;a belief that deep curiosity need not defer to social convention, a commitment to bold risk taking, thoughtful community, open dialogue, gritty erudition&mdash;serves me still as a polestar guiding my life path. I consider myself an engaged member of the alumni community and am excited by the possibility of serving that community more actively. I believe as alumni it is our responsibility to help the institution move always in the direction of the lofty ideals and high standards instilled in us as students.<!-- <br /><br /><span onClick="showHide('akalman','akalmanmore')" style="color: blue; cursor:pointer" id="akalmanmore">more...</span> -->
                </div>
            </div>

			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" onChange="toggleWritein(this)" style="margin-bottom: 0;" type="radio" name="vote" id="writein_19901999" value="writein_19901999"
					<?php 
					if (isset($_POST['writein_19901999']) && $_POST['writein_19901999'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
                    <label for="writein_19901999" class="labelwide"><strong>(Write-in candidate for 1990-1999, subject to candidate’s acceptance)</strong>
                    </label>
                    <br />
                    <input type="text" name="writein_19901999_value" id="writein_19901999_value" disabled >
                </div>
			</div>

			<div class="spacer" style="clear:both; height:15px;"></div>

			<div style="clear: both; width: 650px; text-align: left; padding: 10px 0 10px 0px; font-weight: bold; font-size: 15px; background: antiqueWhite; border-bottom: 1px solid black; border-right: 1px solid black; margin-top: 10px; padding=left: 3px">				
			Candidates for 1980-1989 Representative<br />
				<br />
				<a href="http://simons-rock.edu/alumni/alc/alc-representative-candidate-nomination-form" target="_top" style="font-size: 12px">Nominate a potential candidate for future elections</a>. 
			</div>
			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" onChange="toggleWritein(this)" style="margin-bottom: 0;" type="radio" name="vote" id="radio_jemmer" value="Jody Emmer"
					<?php 
					if (isset($_POST['radio_jemmer']) && $_POST['radio_jemmer'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
					<label for="radio_jemmer" class="labelwide"><strong>Jody Emmer</strong><strong> &lsquo;87 &ndash; Washington, DC</strong>
					</label>
					<br />
					<img src="jody-emmer-sml.jpg" style=" float: right; margin: 0 0 5px 5px" />
					Simon's Rock has always represented a place of artistic freedom to me. Lately, I have found the rest of the world to be rather restrictive and conforming and one that I have never fit into. I have no idea if I would be the ideal candidate for any kind of organization leadership position. I was trained in the image of The Milwaukee Junior League and that had been the foundation for my organizational structure and community leadership roles that led me to believe that I could possibly be of service to any organization that could possibly use me. I attempt to answer to the community and that is all I can do in the name of service. I write for a community newsletter and I attempt to uphold some sort of honor in what I do. I do not gossip or write inflammatory articles, I focus on the charitable and the truly visionary leaders of the community and their contributions to promoting change and behaving in a kind and decent manner. I haven't always lived up to the ideals that I promote and unfortunately I had to experience some public humiliation in order to evolve into the person I am today. I served on a variety of different leadership committees, I have demonstrated responsibility in the positions I have served. In 2012, I was sent to Milwaukee County Jail for some stupid reason and I probably learned more from that experience than I could ever have learned anywhere else. I left The Junior League shortly after my incarceration because I simply didn’t feel I could truly explain myself to that organization and perhaps it isn’t necessary. Since that incidence I have written over two hundred articles for four different news outlets and I have been involved in many charitable causes and public PR marketing campaigns. Again, I have no idea if I am the ideal candidate for any of this I only know that I serve the community and I take direction and feedback from my peers who guide me when it is needed.<!-- <br /><br /><span onClick="showHide('akalman','akalmanmore')" style="color: blue; cursor:pointer" id="akalmanmore">more...</span> -->
                </div>
	        </div>
			<div style="clear:both;"></div>
			<div class="radiorow2">
            	<div style="clear:none; float:left; " >
                <input class="radio" onChange="toggleWritein(this)" style="margin-bottom: 0;" type="radio" name="vote" id="writein_19801989" value="writein_19801989"
					<?php 
					if (isset($_POST['writein_19801989']) && $_POST['writein_19801989'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
                    <label for="writein_19801989" class="labelwide"><strong>(Write-in candidate for 1980-1989, subject to candidate’s acceptance)</strong>
                    </label>
                    <br />
                    <input type="text" name="writein_19801989_value" id="writein_19801989_value" disabled >
                </div>
            </div>


			<div class="spacer" style="clear:both; height: 20px;"></div>
			<button type="submit" name="submit" id="submit" value="submit">Cast My Vote!</button>
		<div class="spacer"></div>
        <p style="font-weight:bold; font-size:13px; color:#000; margin: 10px">ALC representative seats for 1966-1969, 1970-1979, and 2010-present are not up for election at this time. You can always nominate someone for a future election cycle using <a href="http://simons-rock.edu/alumni/alc/alc-representative-candidate-nomination-form/" target="_top">this form</a>.</p>
	</form>
</div>

<script>
function toggleWritein(radioObj){
	arr = document.getElementsByName('vote');
	for(x=0;x<arr.length;x++) {
		var thisId = arr.item(x).id;
		if (thisId.indexOf("writein") > -1) {
			var showfld = thisId + "_value";
			if(document.getElementById(thisId).checked) {
				document.getElementById(showfld).disabled = false;
				document.getElementById(showfld).focus();
			}
			else {
				document.getElementById(showfld).disabled = true;
				document.getElementById(showfld).value = "";
			}
		}
	}
}
function writeInEmpty() {
	arr = document.getElementsByName('vote');
	for(x=0;x<arr.length;x++) {
		var thisId = arr.item(x).id;
		if (thisId.indexOf("writein") > -1) {
			var showfld = thisId + "_value";
			if(document.getElementById(thisId).checked) {
				if(document.getElementById(showfld).value == "") {
					return false;
				}
				else {
					return true;
				}
			}
		}
	}
	return true;
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

function checkForm() {
    var bgcolor
    var normal
    var rval
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
		if (getCheckedValue(document.request.vote) == ""){
			alert ("You forgot to vote! Please choose a candidate from your era.");
			return false;
		}
		else{
		}
		if(!writeInEmpty()){
			alert ("To do a write-in vote, make sure to put the person's name in the corresponding text field.");
			return false;
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
        return  true; 
	}
}

function showHide(theDiv,moreLink){
	if(document.getElementById(theDiv).style.display == "none"){
		document.getElementById(theDiv).style.display = '';
		document.getElementById(moreLink).innerHTML = 'less...';
	}
	else {
		document.getElementById(theDiv).style.display = 'none';
		document.getElementById(moreLink).innerHTML = 'more...';
	}
}
//window.scroll(0,0);
</script>

<?php
}
else if($alert != "") {
	
?>
<div id="top" ></div>
<a name="top"></a>
<p>
<?php
echo($alert);
?>
</p>

<?php
}
else{
?>

<p>Thank you for your vote.</p>


<?php
}
?>

<script>
	document.getElementById('innertop').scrollIntoView();
</script>

</body>
</html>