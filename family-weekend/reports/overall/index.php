<?php
if(isset($_REQUEST['test']) && $_REQUEST['test'] == "1"){
	ini_set("display_errors","On");
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
}
/*** begin our session ***/
session_start();

/*** check if the users is already logged in ***/
if(!isset( $_SESSION['user_id'] ))
{
	
?>	
<html>
<head>
<title>Family Weekend Reports</title>
<style>
.rowOther {
	background-color: #CCC;
}
</style>
</head>
<body>	
<p>You must be logged in to view the reports.</p>	
<p><a href="/family-weekend/reports/login.php">Login Here</a></p>
</body>
</html>

<?php 
}
else {
	$pend = "-09-01 00:00:00";
	$startyear = date('Y');
	if(
		 (isset($_REQUEST['year']) && $_REQUEST['year'] != "all")  
		 	||
		 (!isset($_REQUEST['year']))
	   ){
		if(isset($_REQUEST['year'])){
			$startyear = $_REQUEST['year'];
		}
		$endyear = $startyear+1;
		$rangestart =  $startyear.$pend;
		$rangeend = $endyear.$pend;
	}
	else if(isset($_REQUEST['year']) && $_REQUEST['year'] == "all"){
		$rangestart =  "2000".$pend;
		$rangeend = "2500".$pend;
	}

	
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
	$db = new DB(HOST,USER,PASSWORD,DATABASE);
	$db->connect();
	
	$sql = "SELECT SUM(trickOrTreatingAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$trickOrTreatingAdults = $res['SUM(trickOrTreatingAdults)'];
	$sql = "SELECT SUM(trickOrTreatingChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$trickOrTreatingChild = $res['SUM(trickOrTreatingChild)'];
	
	$sql = "SELECT SUM(alumniPanelAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$AlumniPanelAdults = $res['SUM(alumniPanelAdults)'];
	$sql = "SELECT SUM(alumniPanelChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$AlumniPanelChild = $res['SUM(alumniPanelChild)'];
	
	$sql = "SELECT SUM(FYAdjustmentAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$FYAdjustmentAdults = $res['SUM(FYAdjustmentAdults)'];
	$sql = "SELECT SUM(FYAdjustmentChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$FYAdjustmentChild = $res['SUM(FYAdjustmentChild)'];
	
	$sql = "SELECT SUM(welcomeReceptionAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$welcomeReceptionAdults = $res['SUM(welcomeReceptionAdults)'];
	$sql = "SELECT SUM(welcomeReceptionChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$welcomeReceptionChild = $res['SUM(welcomeReceptionChild)'];
	
	$sql = "SELECT SUM(murderMysteryChallengeAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$murderMysteryChallengeAdults = $res['SUM(murderMysteryChallengeAdults)'];
	$sql = "SELECT SUM(murderMysteryChallengeChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$murderMysteryChallengeChild = $res['SUM(murderMysteryChallengeChild)'];
	
	$sql = "SELECT SUM(halloweenDanceAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$halloweenDanceAdults = $res['SUM(halloweenDanceAdults)'];
	$sql = "SELECT SUM(halloweenDanceChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$halloweenDanceChild = $res['SUM(halloweenDanceChild)'];
	
	$sql = "SELECT SUM(hikeUpMountainAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$hikeUpMountainAdults = $res['SUM(hikeUpMountainAdults)'];
	$sql = "SELECT SUM(hikeUpMountainChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$hikeUpMountainChild = $res['SUM(hikeUpMountainChild)'];
	
	$sql = "SELECT SUM(frightFilmFestAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$frightFilmFestAdults = $res['SUM(frightFilmFestAdults)'];
	$sql = "SELECT SUM(frightFilmFestChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$frightFilmFestChild = $res['SUM(frightFilmFestChild)'];
	
	$sql = "SELECT SUM(honorsConvocationAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$honorsConvocationAdults = $res['SUM(honorsConvocationAdults)'];
	$sql = "SELECT SUM(honorsConvocationChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$honorsConvocationChild = $res['SUM(honorsConvocationChild)'];
	
//	$sql = "SELECT SUM(provostsReceptionAdults) FROM family_weekend_2015 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
//	$db->do_query($sql);
//	$res = $db->fetchArray();
//	$provostsReceptionAdults = $res['SUM(provostsReceptionAdults)'];
	
	
	$sql = "SELECT SUM(studyAbroadPanelAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$studyAbroadPanelAdults = $res['SUM(studyAbroadPanelAdults)'];
	$sql = "SELECT SUM(studyAbroadPanelChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$studyAbroadPanelChild = $res['SUM(studyAbroadPanelChild)'];
	
	$sql = "SELECT SUM(jazzEnsembleConcertAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$jazzEnsembleConcertAdults = $res['SUM(jazzEnsembleConcertAdults)'];
	$sql = "SELECT SUM(jazzEnsembleConcertChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$jazzEnsembleConcertChild = $res['SUM(jazzEnsembleConcertChild)'];
	
	$sql = "SELECT SUM(hikeUpMountainAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$hikeUpMountainAdults = $res['SUM(hikeUpMountainAdults)'];
	$sql = "SELECT SUM(hikeUpMountainChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$hikeUpMountainChild = $res['SUM(hikeUpMountainChild)'];
	
	$sql = "SELECT SUM(pianoRecitalAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$pianoRecitalAdults = $res['SUM(pianoRecitalAdults)'];
	$sql = "SELECT SUM(pianoRecitalChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$pianoRecitalChild = $res['SUM(pianoRecitalChild)'];
	
	$sql = "SELECT SUM(normanRockwellMuseumAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$normanRockwellMuseumAdults = $res['SUM(normanRockwellMuseumAdults)'];
	$sql = "SELECT SUM(normanRockwellMuseumChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$normanRockwellMuseumChild = $res['SUM(normanRockwellMuseumChild)'];
	$sql = "SELECT SUM(normanRockwellMuseumTransportationAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$normanRockwellMuseumTransportationAdults = $res['SUM(normanRockwellMuseumTransportationAdults)'];
	
	$sql = "SELECT SUM(walkingTourAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$walkingTourAdults = $res['SUM(walkingTourAdults)'];
	$sql = "SELECT SUM(walkingTourChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$walkingTourChild = $res['SUM(walkingTourChild)'];
	$sql = "SELECT SUM(walkingTourTransportationAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$walkingTourTransportationAdults = $res['SUM(walkingTourTransportationAdults)'];



/*
	$sql = "SELECT SUM(internationalFairAdults) FROM family_weekend_2015 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$internationalFairAdults = $res['SUM(internationalFairAdults)'];
	$sql = "SELECT SUM(internationalFairChild) FROM family_weekend_2015 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$internationalFairChild = $res['SUM(internationalFairChild)'];
*/	
	// meals
	$sql = "SELECT SUM(fridayLunchAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$fridayLunchAdults = $res['SUM(fridayLunchAdults)'];
	$sql = "SELECT SUM(fridayLunchChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$fridayLunchChild = $res['SUM(fridayLunchChild)'];
	
	$sql = "SELECT SUM(fridayDinnerAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$fridayDinnerAdults = $res['SUM(fridayDinnerAdults)'];
	$sql = "SELECT SUM(fridayDinnerChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$fridayDinnerChild = $res['SUM(fridayDinnerChild)'];
	
	$sql = "SELECT SUM(saturdayBrunchAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$saturdayBrunchAdults = $res['SUM(saturdayBrunchAdults)'];
	$sql = "SELECT SUM(saturdayBrunchChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$saturdayBrunchChild = $res['SUM(saturdayBrunchChild)'];

	$sql = "SELECT SUM(saturdayLunch) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$saturdayLunch = $res['SUM(saturdayLunch)'];
	
	$sql = "SELECT SUM(saturdayDinnerAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$saturdayDinnerAdults = $res['SUM(saturdayDinnerAdults)'];
	$sql = "SELECT SUM(saturdayDinnerChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$saturdayDinnerChild = $res['SUM(saturdayDinnerChild)'];
	
	$sql = "SELECT SUM(sundayBrunchAdults) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$sundayBrunchAdults = $res['SUM(sundayBrunchAdults)'];
	$sql = "SELECT SUM(sundayBrunchChild) FROM family_weekend_2016 WHERE date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$res = $db->fetchArray();
	$sundayBrunchChild = $res['SUM(sundayBrunchChild)'];
	
	// Totals
	$totalAdults = 0;
//	$sql = "SELECT * FROM family_weekend_2015 WHERE relative1Class NOT LIKE '%Other%';";
	$sql = "SELECT * FROM family_weekend_2016 WHERE (relative1Class LIKE '%Parent%' OR relative1Class LIKE '%Other%') AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$totalAdults += $db->numRows();

	$sql = "SELECT * FROM family_weekend_2016 WHERE (relative2Class LIKE '%Parent%' OR relative2Class LIKE '%Other%') AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$totalAdults += $db->numRows();

	$sql = "SELECT * FROM family_weekend_2016 WHERE (relative3Class LIKE '%Parent%' OR relative3Class LIKE '%Other%') AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$totalAdults += $db->numRows();

	$sql = "SELECT * FROM family_weekend_2016 WHERE (relative4Class LIKE '%Parent%' OR relative4Class LIKE '%Other%) AND date_submitted > '$rangestart' AND date_submitted < '$rangeend''";
	$db->do_query($sql);
	$totalAdults += $db->numRows();

	$sql = "SELECT * FROM family_weekend_2016 WHERE (relative5Class LIKE '%Parent%' OR relative5Class LIKE '%Other%) AND date_submitted > '$rangestart' AND date_submitted < '$rangeend''";
	$db->do_query($sql);
	$totalAdults += $db->numRows();
	
	$totalChildren = 0;
//	$sql = "SELECT * FROM family_weekend_2015 WHERE relative1Class NOT LIKE '%Other%';";
	$sql = "SELECT * FROM family_weekend_2016 WHERE relative1Class LIKE '%Child%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$totalChildren += $db->numRows();

	$sql = "SELECT * FROM family_weekend_2016 WHERE relative2Class LIKE '%Child%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$totalChildren += $db->numRows();

	$sql = "SELECT * FROM family_weekend_2016 WHERE relative3Class LIKE '%Child%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$totalChildren += $db->numRows();

	$sql = "SELECT * FROM family_weekend_2016 WHERE relative4Class LIKE '%Child%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$totalChildren += $db->numRows();

	$sql = "SELECT * FROM family_weekend_2016 WHERE relative5Class LIKE '%Child%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$totalChildren += $db->numRows();

	$freshmenVisited = 0;
	$sql = "SELECT * FROM family_weekend_2016 WHERE student1Class LIKE '%First%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$freshmenVisited += $db->numRows();
	$sql = "SELECT * FROM family_weekend_2016 WHERE student2Class LIKE '%First%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$freshmenVisited += $db->numRows();

	$sophomoresVisited = 0;
	$sql = "SELECT * FROM family_weekend_2016 WHERE student1Class LIKE '%Soph%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$sophomoresVisited += $db->numRows();
	$sql = "SELECT * FROM family_weekend_2016 WHERE student2Class LIKE '%Soph%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$sophomoresVisited += $db->numRows();

	$juniorsVisited = 0;
	$sql = "SELECT * FROM family_weekend_2016 WHERE student1Class LIKE '%Jun%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$juniorsVisited += $db->numRows();
	$sql = "SELECT * FROM family_weekend_2016 WHERE student2Class LIKE '%Jun%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$juniorsVisited += $db->numRows();

	$seniorsVisited = 0;
	$sql = "SELECT * FROM family_weekend_2016 WHERE student1Class LIKE '%Sen%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$seniorsVisited += $db->numRows();
	$sql = "SELECT * FROM family_weekend_2016 WHERE student2Class LIKE '%Sen%' AND date_submitted > '$rangestart' AND date_submitted < '$rangeend'";
	$db->do_query($sql);
	$seniorsVisited += $db->numRows();


?>

<html>
<head>
<title>Family Weekend Reports</title>
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
.rowOther {
	background-color: #CCC;
}
TD{
	font-size: 11px;
}


</style>
</head>
<body>
<div style="float:right"><a href="/family-weekend/reports/login.php?logout=true">Log Out</a> </div>

<h1>Family Weekend Reports for <?php echo ($startyear)?></h1>

<h2>Number Attending Event</h2>

<?php
include_once "../date.php";
?>

<table cellpadding="2" cellspacing="0">
	<tr>
		<td width="125"><strong>Adults</strong></td>
		<td width="125"><strong>Kids</strong></td>
		<td width="275"><strong>Event</strong></td>
	</tr>
	<!--<tr class="rowOther">
		<td><?php echo($trickOrTreatingAdults); ?></td>
		<td><?php echo($trickOrTreatingChild); ?></td>
		<td>Trick or Treating</td>
	</tr>
	-->
	<tr>
		<td><?php echo($FYAdjustmentAdults); ?></td>
		<td><?php echo($FYAdjustmentChild); ?></td>
		<td>First-Year Adjustment</td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($welcomeReceptionAdults); ?></td>
		<td><?php echo($welcomeReceptionChild); ?></td>
		<td>Welcome Reception/Senior Thesis Posters</td>
	</tr>
	<tr>
		<td><?php echo($murderMysteryChallengeAdults); ?></td>
		<td><?php echo($murderMysteryChallengeChild); ?></td>
		<td>Murder Mystery Challenge</td>
	</tr>
	
	<tr>
		<td><?php echo($frightFilmFestAdults); ?></td>
		<td><?php echo($frightFilmFestChild); ?></td>
		<td>Scary Movie</td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($honorsConvocationAdults); ?></td>
		<td><?php echo($honorsConvocationChild); ?></td>
		<td>Honors Convocation</td>
	</tr>
	<tr>
		<td><?php echo($AlumniPanelAdults); ?></td>
		<td><?php echo($AlumniPanelChild); ?></td>
		<td>Alumni Career Panel</td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($studyAbroadPanelAdults); ?></td>
		<td><?php echo($studyAbroadPanelChild); ?></td>
		<td>Study Abroad Panel</td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($halloweenDanceAdults); ?></td>
		<td><?php echo($halloweenDanceChild); ?></td>
		<td>Halloween Dance</td>
	</tr>
	<!--<tr>
		<td><?php echo($jazzEnsembleConcertAdults); ?></td>
		<td><?php echo($jazzEnsembleConcertChild); ?></td>
		<td>Jazz Ensemble Concert</td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($hikeUpMountainAdults); ?></td>
		<td><?php echo($hikeUpMountainChild); ?></td>
		<td>Interpretative Trail Walk</td>
	</tr>
	-->
	<tr>
		<td><?php echo($pianoRecitalAdults); ?></td>
		<td><?php echo($pianoRecitalChild); ?></td>
		<td>Faculty Concert</td>
	</tr>
	<!--
	<tr class="rowOther">
		<td><?php echo($normanRockwellMuseumAdults); ?></td>
		<td><?php echo($normanRockwellMuseumChild); ?></td>
		<td>Norman Rockwell Museum/Stockbridge</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo($normanRockwellMuseumTransportationAdults); ?></td>
		<td>Norman Rockwell Museum/Stockbridge Transportation</td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($walkingTourAdults); ?></td>
		<td><?php echo($walkingTourChild); ?></td>
		<td>GB Historical Walking Tour</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo($walkingTourTransportationAdults); ?></td>
		<td>GB Historical Walking Tour Transportation</td>
	</tr>
	-->
</table>

<h2>Number Attending Meal</h2>
<table cellpadding="2" cellspacing="0">
	<tr>
		<td width="155"><strong>Quantity</strong></td>
		<td width="275"><strong>Meal</strong></td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($fridayLunchAdults); ?></td>
		<td>Friday Lunch</td>
	</tr>
	<tr>
		<td><?php echo($fridayDinnerAdults); ?></td>
		<td>Friday Dinner</td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($saturdayBrunchAdults); ?></td>
		<td>Saturday Breakfast</td>
	</tr>
	<tr>
		<td><?php echo($saturdayLunch); ?></td>
		<td>Saturday Lunch</td>
	</tr>
	<tr class="rowOther">
		<td><?php echo($saturdayDinnerAdults); ?></td>
		<td>Saturday Dinner</td>
	</tr>
	<tr>
		<td><?php echo($sundayBrunchAdults); ?></td>
		<td>Sunday Brunch</td>
	</tr>
</table>
<h2>Totals</h2>
<table cellpadding="4" cellspacing="0">
	<tr>
		<td align="right"><strong>Number of children under 12 attending: </strong></td>
		<td width="125"><strong><?php echo($totalChildren); ?></strong></td>
	</tr>
	<tr>
		<td align="right"><strong>Number of Adults attending: </strong></td>
		<td width="125"><strong><?php echo($totalAdults); ?></strong></td>
	</tr>
	<tr>
		<td align="right"><strong>Number of freshmen visited: </strong></td>
		<td width="125"><strong><?php echo($freshmenVisited); ?></strong></td>
	</tr>
	<tr>
		<td align="right"><strong>Number of sophomores visited: </strong></td>
		<td width="125"><strong><?php echo($sophomoresVisited); ?></strong></td>
	</tr>
	<tr>
		<td align="right"><strong>Number of juniors visited: </strong></td>
		<td width="125"><strong><?php echo($juniorsVisited); ?></strong></td>
	</tr>
	<tr>
		<td align="right"><strong>Number of seniors visited: </strong></td>
		<td width="125"><strong><?php echo($seniorsVisited); ?></strong></td>
	</tr>
</table>
</body>
</html>
<?php
}
?>