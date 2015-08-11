<?php
// update counselors to proper state

require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$ids = array('1' => 'MA','28' => 'CO','32' => 'AA','36' => 'AR','39' => 'TX','48' => 'not applicable','78' => 'IL','84' => 'MA','85' => 'MA','128' => 'GA','130' => 'MO','131' => 'IN','132' => 'VA','133' => 'NH','138' => 'not applicable','139' => 'not applicable','140' => 'VA','145' => 'CA','146' => 'NY','147' => 'OH','149' => 'PA','150' => 'NY','152' => 'CA','159' => 'NY','160' => 'NY','161' => 'NY','162' => 'TN','163' => 'NY','166' => 'IL','168' => 'GA','177' => 'VA','178' => 'ME','184' => 'ME','185' => 'CA','187' => 'ID','190' => 'NJ','191' => 'MA','194' => 'IL','197' => 'VA','199' => 'CA','200' => 'NY','201' => 'OH','203' => 'PA','208' => 'IL','211' => 'FL','212' => 'KS','216' => 'MD','218' => 'AL','222' => 'NY','226' => 'GA','228' => 'NY','229' => 'NC','230' => 'NJ','231' => 'PA','234' => 'CA','235' => 'OH','241' => 'OH','242' => 'CA','245' => 'VA','250' => 'NY','254' => 'VA','256' => 'AZ','257' => 'TN','259' => 'IL','262' => 'CT','263' => 'VA','265' => 'MI','267' => 'IN','271' => 'NY','274' => 'CA','281' => 'WA','282' => 'PA','283' => 'PA','285' => 'OH','294' => 'FL','295' => 'GA','297' => 'LA','298' => 'NJ','301' => 'CA','302' => 'NJ','308' => 'IL','312' => 'MA','323' => 'NJ','325' => 'FL','327' => 'IL','332' => 'TX','333' => 'NH','334' => 'TN','335' => 'not applicable','338' => 'GA','345' => 'CA','346' => 'not applicable','347' => 'NY','348' => 'CA','351' => 'MA','353' => 'FL','356' => 'VA','359' => 'CT','360' => 'NH','361' => 'GA','362' => 'GA','363' => 'PA','369' => 'IN','370' => 'NJ','372' => 'MA','376' => 'VA','377' => 'CT','395' => 'not applicable','396' => 'not applicable','405' => 'CA','413' => 'CA','415' => 'WA','419' => 'NY','420' => 'NY','434' => 'TX','445' => 'NY','446' => 'CT','451' => 'CA','453' => 'NY','467' => 'NY','468' => 'VA','469' => 'NJ','471' => 'NJ','473' => 'CA','474' => 'not applicable','479' => 'TX');

// $ids = array('1','28','32','36','39','48','78','84','85','128','130','131','132','133','138','139','140','145','146','147','149','150','152','159','160','161','162','163','166','168','177','178','184','185','187','190','191','194','197','199','200','201','203','208','211','212','216','218','222','226','228','229','230','231','234','235','241','242','245','250','254','256','257','259','262','263','265','267','271','274','281','282','283','285','294','295','297','298','301','302','308','312','323','325','327','332','333','334','335','338','345','346','347','348','351','353','356','359','360','361','362','363','369','370','372','376','377','395','396','405','413','415','419','420','434','445','446','451','453','467','468','469','471','473','474','479');

// test with this
// $ids = array('78' => 'MA');
//echo ($ids['78']);

foreach($ids as $k => $v){
	$territoryInfo = getTerritoryInfo($v,$territories);
	$counselor = $territoryInfo['fields_recruiter'];

	$sql = "UPDATE forms.admission_form_submission SET counselor = '$counselor' WHERE id = $k";
	$db->do_query($sql);
//	echo $sql; 
//	echo "FOR ID $k, the state is $v, which means the counselor is $fields_recruiter<br />";
}



?>