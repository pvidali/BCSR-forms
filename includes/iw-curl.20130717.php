<?php
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
/*EXAMPLE FORM*/

/*
if (!isset($_POST['submit']))
{
	header('Location: INSERT HOSTING PAGE URL HERE');
	exit();
}
*/

/*
Examples for JSON Parameters :
the numbers are field IDs in Intelliworks
{"formValues":{"Contacts":{"603000000003015":"John","603000000003017":"Smith","603000000003021":"john.smith@school.com","603000000003027":"88837495","603000000128047":"Costa Rican","603000000101077":"Costa Rica","603000000169043":"2011","603000000169029":["MBA Spanish 15 meses"],"603000000003013":"Landing Page GMAT","603000000101561":"English"},"Cases":{"603000000111021":"INCAE.edu"}},"filesUploaded":[],"deleteAttachments":[],"inquiryFormId":603000000371574,"messageType":"submit","seed":33,"formId":603000000371574}
*/

$this_source = setSource('ADG');
$lead_source = "Online...";
$specify_source = "Google Adwords";


/* Fields THIS IS DIFFERENT FOR EACH IW FORM YOU BASE THIS OFF*/

define('FIRSTNAME',		'685000000003015');
define('LASTNAME',		'685000000003017');
define('EMAIL',			'685000000003021');
define('HS_GRADYEAR',	'685000000110551');
define('STREET',		'685000000003063');
define('STREET2',		'685000000121961');
define('CITY',			'685000000003065');
define('STATE',			'685000000123120');
define('ZIP',			'685000000155005');
define('COUNTRY',		'685000000131001');

if(isset($postArray['phonetype']) && $postArray['phonetype'] == 'Cell'){
	define('PHONE',		'685000000003031');
}
else {
	define('PHONE',		'685000000003027');
}

define('DATESOURCE',	'685000006711125'); // THIS IS A MODIFIED SBGI WITH DATE as Ymd plus a space prepended to the 3-letter banner code

define('LEADSOURCE',	'685000000003013'); // 
define('SPECIFYSOURCE',	'685000000155215'); // 

define('THREE_WORDS',	'685000000003279'); // this is a case comment

/* variables GET THE FORM ID AND SEED FROM THE IW FORM SOURCE CODE*/

$formid = '685000002104499';
$seed = 62; // get from z value in IW form code

/* validations */

// $programas	= array();
// foreach ($_POST['PROGRAM'] as $p) { $programas[] = utf8_encode($p); }
$FIRSTNAME			= $postArray['fname'];
$LASTNAME			= $postArray['lname'];
$HS_GRADYEAR		= $postArray['hs_gradyear'];
$EMAIL				= $postArray['email'];
$PHONE				= $postArray['phone'];
$STREET				= $postArray['street'];
$STREET2			= $postArray['street2'];
$CITY				= $postArray['city'];
$STATE		 		= $postArray['state'];
$ZIP		 		= $postArray['zip'];
$COUNTRY			= $postArray['country'];
$THREE_WORDS		= $postArray['three_words'];
$DATESOURCE			= $this_source;
$LEADSOURCE			= $lead_source;
$SPECIFYSOURCE		= $specify_source;
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
		'Contacts' => array(
							FIRSTNAME		=> $FIRSTNAME,
							LASTNAME		=> $LASTNAME,
							EMAIL			=> $EMAIL,
							PHONE			=> $PHONE,
							STREET			=> $STREET,
							STREET2			=> $STREET2,
							CITY			=> $CITY,
							STATE			=> $STATE,
							ZIP				=> $ZIP,
							COUNTRY			=> $COUNTRY,
							HS_GRADYEAR		=> $HS_GRADYEAR,
							DATESOURCE		=> $DATESOURCE,
							LEADSOURCE		=> $LEADSOURCE,
							SPECIFYSOURCE	=> $SPECIFYSOURCE
						),
		'Cases' => array(
							THREE_WORDS		=> $THREE_WORDS
						)
	),
	'filesUploaded' => (array()),
	'deleteAttachments' => (array()),
	'inquiryFormId' => $formid,
	'messageType' => 'submit',
	'seed' => $seed,
	'formId' => $formid
);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

/*
DONE '<pre>';
print_r(json_encode($data));
DONE '</pre>';
exit();
*/

//make the request
$result = curl_exec($ch);

curl_close($ch);  

/* ANSWER */

$result = json_decode(utf8_encode($result));

//print_r($data);
//exit();

/* Log */

/*
$filename = 'log/inquiries-' . date('y-W') . '.csv';
if ($handle = fopen($filename, 'a'))
{
	$content = $email;
	$content .= ',' . $nombre;
	$content .= ',' . $apellidos;
	$content .= ',' . $pais;
	$content .= ',' . $nacionalidad;
	$content .= ',' . $phone;
	$content .= ',';
	$content .= ',';
	$content .= ',';
	$content .= ',' . implode('-',$programas);
	$content .= ',' . $ano;
	$content .= ',' . date('Y-n-j');
	$content .= "\n";
	
	fwrite($handle, $content);
}
*/
/* Redirect */

if (strcmp($result->status,'ok') == 0)
{
	//header('Location: ' . $result->redirect);
	
	if (isset($_POST['redirect']))
	{
		header('Location: REDIRECTURL' . $_POST['redirect']);
	}
	else
	{
		header('Location: ' . $result->redirect);
	}
	
}
else
{
print_r(json_encode($data));

print_r($result);
/*
	session_start();
	$_SESSION['error'] = $result->msg;
	if (isset($_SERVER['lang']))
		header('Location: URL' . $_SERVER['lang'] . '/URL');
	else
		header('Location: URL');
*/
}
/**/
?>