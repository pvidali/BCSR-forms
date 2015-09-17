<?php
ini_set("display_errors","On");
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$statesArray = array('alaska' => 'AK', 'alabama' => 'AL', 'arkansas' => 'AR', 'american samoa' => 'AS', 'arizona' => 'AZ','california' => 'CA','colorado' => 'CO','connecticut' => 'CT','d.c.' => 'DC','washington dc' => 'DC','washington d.c.' => 'DC','florida' => 'FL','micronesia' => 'FM','georgia' => 'GA','guam' => 'GU','hawaii' => 'HI','iowa' => 'IA','idaho' => 'ID','illinois' => 'IL','indiana' => 'IN','kansas' => 'KS','kentucky' => 'KY','louisiana' => 'LA','massachusetts' => 'MA','maryland' => 'MD','maine' => 'ME','marshall islands' => 'MH','michigan' => 'MI','minnesota' => 'MN','missouri' => 'MO','marianas' => 'MP','mississippi' => 'MS','montana' => 'MT','north carolina' => 'NC','north dakota' => 'ND','nebraska' => 'NE','new hampshire' => 'NH','new jersey' => 'NJ','new mexico' => 'NM','nevada' => 'NV','new york' => 'NY','ohio' => 'OH','oklahoma' => 'OK','oregon' => 'OR','pennsylvania' => 'PA','puerto rico' => 'PR','palau' => 'PW','rhode island' => 'RI','south carolina' => 'SC','south dakota' => 'SD',
'tennessee' => 'TN','texas' => 'TX','utah' => 'UT','virginia' => 'VA','virgin islands' => 'VI','vermont' => 'VT','washington' => 'WA','wisconsin' => 'WI','west virginia' => 'WV','wyoming' => 'WY','military americas' => 'AA','military pacific' => 'AP');


/********************************************************
  #20120521 - @dscheff - populateZipsFromDB()
  grab values from received db table and populates a 
  php array

*********************************************************/
function populateZipsFromDB($dbase,$table){
	$zips	= array();
	$sql  = "";
	$sql .= "SELECT * FROM $table";
	$dbase->do_query($sql);
	while($row = $dbase->fetchObject()){
		//foreach($array as $key => $val){
		$state		= $row->GTVZIPC_STAT_CODE;
		$zip		= $row->GTVZIPC_CODE;
		$city		= $row->GTVZIPC_CITY;
		$zips[$zip] = array($state,$city);
	}
	return $zips;
}

// get all zips for each state
$zips = populateZipsFromDB($db,'populator_zipcodes_gtvzipc');

foreach($zips as $zip => $vals){
//	echo $states[$state],  $vals<br />";
	echo("ZIP: $zip, STATE: " . $vals[0] .", CITY " . $vals[1] ."<br />");
}





foreach($statesArray as $stateCode){
	$$stateCode = array();
	$sql .= "SELECT * FROM populator_zipcodes_gtvzipc WHERE GTVZIPC_STAT_CODE = $stateCode";
	$dbase->do_query($sql);
	while($row = $dbase->fetchObject()){
		$state		= $row->GTVZIPC_STAT_CODE;
		$zip		= $row->GTVZIPC_CODE;
		$city		= $row->GTVZIPC_CITY;
		$$stateCode[$zip] = $city;
	}	
}



foreach($statesArray as $stateCode){
	foreach($$stateCode as $k => $v){
		echo "STATE: " . $$stateCode . ", ZIP: " . $k . " is for the city " .$v ."<br />";
	}
}






?>