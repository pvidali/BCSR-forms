<?php
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

if(isset($_POST['submit'])) {

	if ($_FILES["file"]["error"] > 0) {
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
	}
	else {
		// clear the table, reset auto_increment
		$sql = "TRUNCATE TABLE forms.admission_banner_upload_cpy";
		$db->do_query($sql);
		$sql = "INSERT INTO forms.admission_banner_upload_cpy SELECT * FROM forms.admission_banner_upload";
		$db->do_query($sql);
		$sql = "TRUNCATE TABLE forms.admission_banner_upload";
		$db->do_query($sql);
		$thefile = $_FILES["file"]["tmp_name"];
		$records = array();
		$lines = file($thefile);
		$loop = 0;
		foreach($lines as $line){
			$thisline = explode("\t",$line);
			$records[$loop]['SPRIDEN_ID']				= $thisline[0];
			$records[$loop]['PERS_LAST_NAME']			= $thisline[1];
			$records[$loop]['PERS_FIRST_NAME'] 			= $thisline[2];
			$records[$loop]['GOREMAL_EMAIL_ADDRESS']	= $thisline[3];
			$records[$loop]['SPRADDR_ZIP'] 				= $thisline[4];
			$loop++;
		}
		foreach($records as $record){
			$SPRIDEN_ID 			= $record['SPRIDEN_ID'];
			$PERS_LAST_NAME 		= addslashes($record['PERS_LAST_NAME']);
			$PERS_FIRST_NAME 		= addslashes($record['PERS_FIRST_NAME']);
			$GOREMAL_EMAIL_ADDRESS	= $record['GOREMAL_EMAIL_ADDRESS'];
			$SPRADDR_ZIP 			= $record['SPRADDR_ZIP'];
			$sql = "INSERT INTO forms.admission_banner_upload 
						(SPRIDEN_ID, PERS_LAST_NAME, PERS_FIRST_NAME, GOREMAL_EMAIL_ADDRESS, SPRADDR_ZIP) 
				VALUES  ($SPRIDEN_ID, '$PERS_LAST_NAME', '$PERS_FIRST_NAME', '$GOREMAL_EMAIL_ADDRESS', '$SPRADDR_ZIP')";
			$db->do_query($sql);
		}
	}
}

?>

<html>
<body>
<?php
if(!isset($_POST['submit'])) {
?>
<form action="<?php echo($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
<label for="file">File to upload:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="submit" value="Submit" />
</form>

<?php
}
else{
?>

<p>Mission Accomplished!</p>

<?php
}
?>
</body>
</html>
