<?php

require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-defines.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/form-functions.php");
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
// require_once $_SERVER['DOCUMENT_ROOT']."/classes/test.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$postArray = $_POST;

fixFormatting($postArray);

foreach($postArray as $k => $v){
	$$k = $v;
}

$lname = $_POST["lname"];
$email = $_POST["email"];
$three_words = $_POST["three_words"];

// require_once $_SERVER['DOCUMENT_ROOT']."/includes/errors.php";
if (!function_exists('json_encode')) {
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}

if(!function_exists('json_decode'))
{
    function json_decode($json)
    {
        $comment = false;
        $out = '$x=';
        for ($i=0; $i<strlen($json); $i++)
        {
            if (!$comment)
            {
                if (($json[$i] == '{') || ($json[$i] == '['))
                    $out .= ' array(';
                else if (($json[$i] == '}') || ($json[$i] == ']'))
                    $out .= ')';
                else if ($json[$i] == ':')
                    $out .= '=>';
                else
                    $out .= $json[$i];
            }
            else
                $out .= $json[$i];
            if ($json[$i] == '"' && $json[($i-1)]!="\\")
                $comment = !$comment;
        }
        eval($out . ';');
        return $x;
    }
}

/* CURL process */
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects 
curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, 'http://crm.orionondemand.com/crm/InquiryFormRuntime.sas');//THIS STAYS THE SAME
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));

//prepare the field values being posted to the service

$data = array(
	'formValues' => array(
		'Contacts' => array(),
		'Cases' => array()
	),
	'filesUploaded' => (array()),
	'deleteAttachments' => (array()),
	'inquiryFormId' => $formid,
	'messageType' => 'submit',
	'seed' => $seed,
	'formId' => $formid
);

foreach($postArray as $key => $val){
	$iw_formfield_name = iw_fieldmap_name($db,$key);
	
	if(!$iw_formfield_name){
		$iw_formfield_name = $key;
	}

	// if the field was found in the DB, grab the value and plunk it into the translated var name
	if(stristr($iw_formfield_name,"Contacts")){
		$iw_formfield_name = str_replace("Contacts.","",$iw_formfield_name);
		$thisfieldvalue = $postArray[$key];
		$data['formValues']['Contacts'][$iw_formfield_name] = $thisfieldvalue;
	}
	else if(stristr($iw_formfield_name,"Cases")){
		$iw_formfield_name = str_replace("Cases.","",$iw_formfield_name);
		$thisfieldvalue = $postArray[$key];
		$data['formValues']['Cases'][$iw_formfield_name] = $thisfieldvalue;
	}
}

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

//make the request
// $result = curl_exec($ch);
curl_close($ch); 
 // include $_SERVER['DOCUMENT_ROOT']. "/includes/iw-curl.php";


?>