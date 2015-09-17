<?php
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
?>