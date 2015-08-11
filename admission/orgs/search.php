<?php
//ini_set("display_errors","On");
//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
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

define( "HOST", "localhost");
define( "USER", "webuser");
define( "PASSWORD", "bab020211f");
define( "DATABASE","forms");

include "DB.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();
	
// if the 'term' variable is not sent with the request, exit
//if ( !isset($_REQUEST['term']) )
//	exit;
 
// connect to the database server and select the appropriate database for use
//$dblink = mysql_connect('localhost', 'webuser', 'bab020211f') or die( mysql_error() );
//mysql_select_db('orgs');
 
// query the database table for zip codes that match 'term'
//$rs = mysql_query('select name, city, state from orgs where name like "'. mysql_real_escape_string($_REQUEST['term']) .'%" order by name asc limit 0,10', $dblink);

// $sql = 'select name, city, state from orgs where name like "'. mysql_real_escape_string($_REQUEST['term']) .'%" order by name asc limit 0,10';
$sql = 'select name, city, state, country from orgs WHERE name like "%'.mysql_real_escape_string($_REQUEST['term']).'%" order by name asc limit 0,10';
//exit();
$db->do_query($sql);

// loop through each zipcode returned and format the response for jQuery
$data = array();
if ( $db->numRows() )
{
	while( $row = $db->fetchArray() )
	{
		$data[] = array(
			'label' => $row['name'] .', '. $row['city'] .' '. $row['state'].' '. $row['country'] ,
			'value' => $row['name']
		);
	}
}


// jQuery wants JSON data
echo json_encode($data);
flush();

?>