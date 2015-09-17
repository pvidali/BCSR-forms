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
	$sql = "SELECT * FROM vote_alc_2012  WHERE remote_addr = '$remote_addr' OR email = '$email'";
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
	
	
		$sql = "INSERT INTO vote_alc_2012  
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
		mail("rmontone@simons-rock.edu","ALC VOTE",$msg);
		mail("dscheff@simons-rock.edu","ALC VOTE",$msg);
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
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
    	<p><strong><span style="font-size:15px">Elections are open until 11:59pm on Sunday, September 16</span><br>
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
			ERA: The &lsquo;60s<br />
				<br />
				<span style="font-size:12px">There are no nominees from the &lsquo;60s.</span> <a href="http://simons-rock.edu/alumni/alc/alc-representative-candidate-nomination-form" target="_blank" style="font-size: 12px">Nominate a potential candidate for future elections</a>. 
			</div>

			<div style="clear: both; width: 650px; text-align: left; padding: 10px 0 10px 0px; font-weight: bold; font-size: 15px; background: antiqueWhite; border-bottom: 1px solid black; border-right: 1px solid black; margin-top: 10px; padding=left: 3px">				
			ERA: The &lsquo;70s<br />
				<br />
				<a href="http://simons-rock.edu/alumni/alc/alc-representative-candidate-nomination-form" target="_blank" style="font-size: 12px">Nominate a potential candidate for future elections</a>. 
			</div>
			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_akalman" value="Audrey Kalman"
					<?php 
					if (isset($_POST['radio_akalman']) && $_POST['radio_akalman'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
					<label for="radio_akalman" class="labelwide"><strong>Audrey (Handelman) Kalman</strong><strong> &lsquo;77</strong>
					</label>
					<br />
					<img src="Kalman.jpg" style=" float: right" />
					Simon's Rock was a part of my life long before I became a student. Almost as soon as my mother (Eileen Handelman) began teaching there in the late 1960s I began frequenting the campus, and by the time 9th grade rolled around I was itching to escape my high school and move on to Simon's Rock. I truly feel as if I would not have survived those years if I had not had access to Simon's Rock. <span onClick="showHide('akalman','akalmanmore')" style="color: blue; cursor:pointer" id="akalmanmore">more...</span>
					<br /><br />
					<div id="akalman" style="display: none">
						During the years that my mother continued to remain involved, I stayed connected to the Rock through her. Since her retirement in the early 1990s, I had to begin to maintain those ties on my own, which has not always been easy from 3,000 miles away on the opposite coast. I would welcome the opportunity to give something back to the institution that meant so much to my family and had such a profound impact on me. I can certainly lend my time and perspective across the continent to help Simon's Rock flourish for new generations of students. 
						<br /><br />
						Biography: Audrey Kalman has been writing since long before she enrolled at Simon’s Rock and emerged with a bachelor’s degree in creative writing (with a minor in environmental science). She went on to pursue a master’s degree in magazine journalism from Syracuse University and has written professionally for more than 30 years. 
						<br /><br />
						She published newspaper and magazine articles in the days when such things still involved ink on paper, wrote a database how-to book when such things were popular, and now offers writing and editing services as a consultant. She also has a completely separate career as a birth doula, supporting women and families during labor and birth. After joining the California Writers Club (CWC) in 2011, Audrey was inspired to pursue a non-traditional publishing path for her novel <em>Dance of Souls</em>, which is available for Amazon’s Kindle and in paperback. Her short story “The Boy in the Window” won the CWC’s “Most Promising Writer of the Year” Award in May, 2012.
					</div>
                </div>
            </div>
			<div class="radiorow2" style="display:none">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_rbrown" value="Ric Brown"
					<?php 
					if (isset($_POST['radio_rbrown']) && $_POST['radio_rbrown'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_rbrown" class="labelwide"><strong>Ric Brown &lsquo;78</strong>
            	</label>
            	<br />
				Currently residing in New York City, Ric focused on environmental studies and social sciences while at Simon’s Rock. He has since earned a PhD in sociology at the CUNY Graduate Center in New York.
                </div>
            </div>
			<div class="spacer" style="clear:both; height:15px;"></div>

			<div style="clear: both; width: 650px; text-align: left; padding: 10px 0 10px 0px; font-weight: bold; font-size: 15px; background: antiqueWhite; border-bottom: 1px solid black; border-right: 1px solid black; margin-top: 10px; padding=left: 3px;">
				ERA: The &lsquo;80s<br />
			</div>

			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_jherda" value="Joel Herda"
					<?php 
					if (isset($_POST['radio_jherda']) && $_POST['radio_jherda'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_jherda" class="labelwide"><strong>Joel Herda ‘84</strong>
            	</label><br />
				Based in the Boston area, Joel is affiliated with Arisia Incorporated, New England’s largest and most diverse science fiction and fantasy convention.
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_cbelfer" value="Cate Belfer"
					<?php 
					if (isset($_POST['radio_cbelfer']) && $_POST['radio_cbelfer'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_cbelfer" class="labelwide"><strong>Cat Belfer</strong><strong> &lsquo;88</strong></label>
            	<br />
				<img src="Belfer.jpg" style=" float: right" />
I'm Cat Belfer '88.  I'm one of that small percentage of students who were basket cases in High School with potential, and Simon's Rock perhaps literally saved my life.  I served on the Alumni Council for a couple years before taking a longer-than-expected break to build my cohousing community, and am now ready to return to actively participating. I'm particularly interested in helping to increase the percentage of alumni giving and involvement with the school, and in helping to build out the alumni career network.                </div>
            </div>
			<div class="spacer" style="clear:both; height:15px;"></div>

			<div style="clear: both; width: 650px; text-align: left; padding: 10px 0 10px 0px; font-weight: bold; font-size: 15px; background: antiqueWhite; border-bottom: 1px solid black; border-right: 1px solid black; margin-top: 10px; padding=left: 3px;">
				ERA: The &lsquo;90s<br />
				<br />
				<a href="http://simons-rock.edu/alumni/alc/alc-representative-candidate-nomination-form" target="_blank" style="font-size: 12px">Nominate a potential candidate for future elections</a>. 
			</div>

			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_bconley" value="Brian Conley"
					<?php 
					if (isset($_POST['radio_bconley']) && $_POST['radio_bconley'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_bconley" class="labelwide"><strong>Brian Conley ‘96</strong>
            	</label><br />
				<img src="bconley.jpg" style=" float: right" />
				Brian lives in Oregon. He is the director of Small World News, which focuses on developing the capacity of citizens to engage with the international community in crisis areas and conflict zones.
                </div>
            </div>

			<div class="spacer" style="clear:both; height:15px;"></div>
        
			<div style="clear: both; width: 650px; text-align: left; padding: 10px 0 10px 0px; font-weight: bold; font-size: 15px; background: antiqueWhite; border-bottom: 1px solid black; border-right: 1px solid black; margin-top: 10px; padding=left: 3px;">
				ERA: The 2000s<br />
			</div>

			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_hgardner" value="Hillary Gardner"
					<?php 
					if (isset($_POST['radio_hgardner']) && $_POST['radio_hgardner'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_hgardner" class="labelwide"><strong>Hillary Gardner ‘02</strong>
            	</label><br />
				<img src="hgardner.jpg" style=" float: right" />
					The network of Rockers I have been so lucky to connect with at and after Simon's Rock have given so much to me, and I am eager to give back.  I can't help you earn your fourth RAP credit, but I am always happy to talk about your ideas for improving Simon's Rock for our alumni and to implement those ideas.<span onClick="showHide('hgardner','hgardnermore')" style="color: blue; cursor:pointer" id="hgardnermore">more...</span>
					<br /><br />
					<div style="display:none" id="hgardner">
						To tell you about myself, after Simon's Rock I attended Cornell University and Emory Law School, and I've worked for the past three years as an attorney in New York and DC, litigating against insurance companies.  On September 18th, I'll be leaving for a year to work in Palau, a small country in the South Pacific, where I will bring legal resources to an underserved population.  
						<br /><br />
						As a member of the ALC, I hope to use my time in the Eastern Hemisphere facilitating mentoring among alumni and bringing together our Simon's Rock alumni living (or hoping to live) abroad, with the help of the widespread internet available even on a remote tropical island.
						<br /><br />
						I am very grateful to have been nominated for a position on the Alumni Leadership Counsel and I look forward to connecting with many of you in the future.
					</div>
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_cpalermo" value="Claire Palermo"
					<?php 
					if (isset($_POST['radio_cpalermo']) && $_POST['radio_cpalermo'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_cpalermo" class="labelwide"><strong>Claire Palermo ‘06</strong>
            	</label><br />
				<img src="Palermo.jpg" style=" float: right" />
				Hi, I'm Claire Palermo '06, a freelance writer, aspiring social worker and zinester who hails from Los Angeles, California. To me, Simon's Rock is more than just a college; it's a learning community that challenges everyone who comes in contact with it to think bigger, include as many voices as possible, and treat no topic as too controversial. I want be part of the Alumni Leadership Council because I'd like to work with current students, faculty and alumni to keep that atmosphere of intellectual curiosity, rigor and boldness alive at every level. I'd especially like to be a liaison for recent alumni who have graduated within the past ten years; many of us are dealing with a tough job market and could benefit from mentoring each other, being mentors to students, and/or local alumni gatherings. 
                </div>
            </div>
			<div class="radiorow1">
				<div style="clear:none; float:left; " >
				<input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_jbenavie" value="Jochai Ben-Avie"
					<?php 
					if (isset($_POST['radio_jbenavie']) && $_POST['radio_jbenavie'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
				<div>
					<label for="radio_jbenavie" class="labelwide"><strong>Jochai Ben-Avie ‘06</strong>
					</label><br />
					<img src="Ben-Avie.jpg" style=" float: right" />
					Jochai Ben-Avie, a second person narrative: You graduated from Simon’s Rock with a BA in Social Psychology and Political Science (of the Law, Policy, and Society variety).  The biggest regret of your Simon’s Rock experience was not doing a dance concert dance to the Lonely Island song “I’m on a Boat.”
					<br /><br />
					Seriously though, Simon’s Rock was an incredibly influential experience that was instrumental into making you who you are today. You’ve spent the last few years giving back to the College trying to make that experience available to others. <span onClick="showHide('jbenavie','jbenaviemore')" style="color: blue; cursor:pointer" id="jbenaviemore">more...</span>  
					<br /><br />
					<div style="display:none" id="jbenavie">
						While a student, you sought to raise the level of representation on campus, serving as the Senior Representative to the Board of Overseers, a member of the Anti-Harassment and Anti-Defamation Committee, and twice on the Standards & Procedures Committee, in addition to facilitating regular meetings of the student body’s representatives on other committees. Having worked in half of the offices of the College, you have good relations with a number of College staff, which will enable you to more effectively represent the alumni community. 
						<br /><br />
						By day, you are the Policy Director at Access (<a href="http://AccessNow.org" target="_blank">AccessNow.org</a>), an international organization that extends and defends the digital rights of users at risk around the world.
					</div>
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_rli" value="Rose Yun Li"
					<?php 
					if (isset($_POST['radio_rli']) && $_POST['radio_rli'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_rli" class="labelwide"><strong>"Rose" Yun Li</strong><strong> ‘06</strong>
            	</label>
            	<br />
				<img src="Li.jpg" style=" float: right" />
				I look back at my two years at SRC as a time that was sacred to my intellectual development and a sanctuary where I found room to grow as not only a scientist, a musician, and a student, but also as an individual. Serving on the Alumni Leadership Council would be an opportunity to give back to the very community that had played a critical role in my development, an institution I will always be grateful towards. I am particularly interested in recruitment and alumni relations efforts, because I think connecting graduates and attracting young minds to SRC are two critical goals to the continued success of SRC. <span onClick="showHide('rli','rlimore')" style="color: blue; cursor:pointer" id="rlimore">more...</span>
				<br /><br />
					<div style="display:none" id="rli">
						Biography: Rose was born in Beijing, China, and immigrated to the US in 1998. At the age 16, she won a full-tuition scholarship to study at Bard College at Simon’s Rock, where she pursued biochemistry, Chinese and Spanish Literature. She interned at the American Cancer Society, volunteered at medical walk-in clinics weekly, and served as an English-as-a-Second Language instructor. As a junior, Rose transferred to Duke University, to study the molecular mechanisms regulating smell and taste in mammals. She is the first author of a cover article in <em>Science Signaling</em> and a related patent, and has continued this work at the University of Pennsylvania by studying the role of odor receptors in animal models and at the level of single olfactory neurons through electrophysiology. After entering the MD/PhD Program at the University of Pennsylvania, she has worked on identifying genetic risk factors for amyotrophic lateral sclerosis (ALS) and published manuscripts in <em>Neurology</em> and <em>Human Molecular Genetics</em>. 
						Her thesis will focus on the identification of genomic markers for solid organ and hematopoietic stem cell transplantation rejection. 
						<br /><br />
						Rose also remained a web editor for <em>Orion Magazine</em>, an environmental/nature magazine based in Great Barrington since freshman year at Simon’s Rock, and interns at the African Family Health Organization in Philadelphia.
					</div>
                </div>
            </div>
			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_abarrica" value="Andrea Barrica"
					<?php 
					if (isset($_POST['radio_abarrica']) && $_POST['radio_abarrica'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_abarrica" class="labelwide"><strong>Andrea Barrica ‘06</strong>
            	</label><br />
				<img src="abarrica.jpg" style=" float: right" />
				Based in the San Francisco Bay Area, Andrea is Vice President of Operations at inDinero – a firm that helps small businesses manage their money well.
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_jbarden" value="James Barden"
					<?php 
					if (isset($_POST['radio_jbarden']) && $_POST['radio_jbarden'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_jbarden" class="labelwide"><strong>James Barden ‘07</strong>
            	</label>
				<img src="Barden.jpg" style=" float: right" />
            	<br />
				After graduating from Simon’s Rock with my AA in 2009, I transferred to the University of Massachusetts in Amherst, where I completed my BA in Political Science with a minor in Art History. <span onClick="showHide('barden','bardenmore')" style="color: blue; cursor:pointer" id="bardenmore">more...</span> 
				<br /><br />
					<div style="display:none" id="barden">
						The first time I took courses in Economics was in the fall of 2008, when the near-collapse of the global economy came into fruition. Looking back, I appreciate the level of analysis and discussion we engaged in, as these events occurred. But in addition to being encouraged to think critically – and to engage in analysis – Simon's Rock also helped instill a sense of appreciation and desire to help those in need.
						<br /><br />
						At Simon's Rock, I was given the opportunity to volunteer at a Bronx soup kitchen for a week in February, where I witnessed the impact of direct service to those living in poverty. That led me to pursue an internship (facilitated through Simon's Rock) with Common Ground – an organization in New York City that strives to end homelessness through affordable housing. 
						<br /><br />
						And today, I'm serving as an AmeriCorps VISTA at The Food Bank of Western Massachusetts, a position facilitated through the New York City Coalition Against Hunger's Anti-Hunger and Opportunity Corps. Every day, I have the opportunity to make a difference in a family's life; and that's a gift that Simon's Rock has given, and still gives, to me.
						<br /><br />
						I want to give back. Simon's Rock has an important – and effective – message to share; I would be grateful for the opportunity to serve on the Alumni Leadership Council to do what I can to support the institution that has given so much to me.
					</div>
				</div>
            </div>
			<div class="radiorow1">
            	<div style="clear:none; float:left; " >
                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_hrivera" value="Hector Rivera"
					<?php 
					if (isset($_POST['radio_hrivera']) && $_POST['radio_hrivera'] == "Yes"){
					 echo " checked ";
					}
					?>
				 /></div>
                <div>
            	<label for="radio_hrivera" class="labelwide"><strong>Hector Rivera ‘08</strong>
            	</label><br />
				<img src="hrivera.jpg" style=" float: right" />
				Hector is from the Bronx, New York. He earned a BA (cum laude) at Simon’s Rock in 2012. His thesis explored theatre as a means for social change.
                </div>
            </div>
			<div class="radiorow2">
            	<div style="clear:none; float:left; " >
	                <input class="radio" style="margin-bottom: 0;" type="radio" name="vote" id="radio_mehrmanshapiro" value="Max Ehrman-Shapiro" />
				</div>
                <div>
            	<label for="radio_mehrmanshapiro" class="labelwide"><strong>Max Ehrman-Shapiro ‘08</strong>
            	</label><br />
				<img src="mehrmanshapiro.jpg" style=" float: right" />
				From Connecticut and son of Simon’s Rock alumna Judy ’80, Max earned a BA at Simon’s Rock in 2012. For his thesis, Max studied how challenge is used to facilitate personal growth in adventure education. Max currently works in Massachusetts as a raft guide and as a sound, electrics, carpentry and general stagehand.
                </div>
            </div>
			<div class="spacer" style="clear:both; height: 20px;"></div>
			<button type="submit" name="submit" id="submit" value="submit">Cast My Vote!</button>
		<div class="spacer"></div>
	</form>
</div>

<script>
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

//window.parent.scroll(0,0);
//window.parent.scrollTo(0,0);
//window.parent.window.scrollBy(0,50); // horizontal and vertical scroll increments
</script>

</body>
</html>