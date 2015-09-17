<?php
// Include the database connection and class extraction layer
// Create an instance and connect
require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
$db = new DB(HOST,USER,PASSWORD,DATABASE);
$db->connect();

$sortValue = "id";
if(isset($_REQUEST['sort']))
{
	$sortValue = $_REQUEST['sort'];
}
if (isset($_REQUEST['csort']))
{
	if($_REQUEST['csort'] != "DESC")
	{
		$csortValue = "DESC";
	}
	else
	{
		$csortValue = "ASC";
	}
}
else
{
	$csortValue = "ASC";
}

$header_fname = "header";
$header_lname = "header";
$header_email = "header";
$header_phone = "header";
$header_gender = "header";


switch($_REQUEST['sort'])
{
	case 'fname':
		$header_fname = "headersort_".$csortValue;
		break;
	case 'lname':
		$header_lname = "headersort_".$csortValue;
		break;
	case 'email':
		$header_email = "headersort_".$csortValue;
		break;
	case 'phone':
		$header_phone = "headersort_".$csortValue;
		break;
	case 'gender':
		$header_gender = "headersort_".$csortValue;
		break;
}

$sql = "SELECT * FROM admission_recruiter ORDER BY $sortValue $csortValue";
$db->do_query($sql);

$body = "";

$recrRows = array();
while($row = $db->fetchObject())
{
	$id = $row->id;
	$recrRows[$id]['fname']		= $row->fname;
	$recrRows[$id]['lname']		= $row->lname;
	$recrRows[$id]['email']		= $row->email . "@simons-rock.edu";
	$recrRows[$id]['phone']		= $row->phone;
	$recrRows[$id]['cell']		= $row->cell;
	$recrRows[$id]['gender']	= $row->gender;
}

function makeRecrRow($rowId,$recruiterRowsArray)
{
	$row = "";
	$row .= "\t\t<tr>\n";
	$row .= "\t\t\t<td class='fname' id=\"".$rowId."_fname\">";
	$row .= $recruiterRowsArray[$rowId]['fname'];
	$row .= "</td>\n";
	$row .= "\t\t\t<td class='lname' id=\"".$rowId."_lname\">";
	$row .= $recruiterRowsArray[$rowId]['lname'];
	$row .= "</td>\n";
	$row .= "\t\t\t<td class='email' id=\"".$rowId."_email\">";
	$row .= $recruiterRowsArray[$rowId]['email'];
	$row .= "</td>\n";
	$row .= "\t\t\t<td class='phone' id=\"".$rowId."_phone\">";
	$row .= $recruiterRowsArray[$rowId]['phone'];
	$row .= "</td>\n";
//	$row .= "\t\t<td class='cell'>";
//	$row .= $recruiterRowsArray[$rowId]['cell'];
//	$row .= "</td>\n";
	$row .= "\t\t\t<td class=\"gender\" id=\"".$rowId."_gender\">";
	$row .= "<span style='cursor: pointer' ";
	$row .= "onclick=\"inlineEditable('".$rowId."','gender','".$recruiterRowsArray[$rowId]['gender']."')\" ";
	$row .= ">";
	$row .= $recruiterRowsArray[$rowId]['gender'];
	$row .= "</span></td>\n";
	$row .= "\t\t</tr>\n";
	return $row;
}

function makeRecrRows($recruiterRows)
{
	global $csortValue;
	global $header_fname;
	global $header_lname;
	global $header_email;
	global $header_phone;
	global $header_gender;

	$table = "\t<table id='mainTable'>\n";
	$table .= "\t\t<tr>\n";
	$table .= "\t\t\t<td class=\"$header_fname\" title=\"Click to sort\" onclick=\"window.location='?sort=fname&csort=$csortValue'\">First</td>\n";
	$table .= "\t\t\t<td class=\"$header_lname\" title=\"Click to sort\" onclick=\"window.location='?sort=lname&csort=$csortValue'\">Last</td>\n";
	$table .= "\t\t\t<td class=\"$header_email\" title=\"Click to sort\" onclick=\"window.location='?sort=email&csort=$csortValue'\">email</td>\n";
	$table .= "\t\t\t<td class=\"$header_phone\" title=\"Click to sort\" onclick=\"window.location='?sort=phone&csort=$csortValue'\">Phone</td>\n";
//	$table .= "<td class='header'>cell</td>";
	$table .= "\t\t\t<td class=\"$header_gender\" title=\"Click to sort\" onclick=\"window.location='?sort=gender&csort=$csortValue'\">gender</td>\n";
	$table .= "\t\t</tr>\n";
	foreach($recruiterRows as $recruiterRowId => $recruiterRow)
	{
		$table .= makeRecrRow($recruiterRowId,$recruiterRows);
	}
/*	$table .= "\t\t<tr>\n";
	$table .= "\t\t\t<td class=\"$header_fname\" onclick=\"window.location='?sort=fname&csort=$csortValue'\">First</td>\n";
	$table .= "\t\t\t<td class=\"$header_lname\" onclick=\"window.location='?sort=lname&csort=$csortValue'\">Last</td>\n";
	$table .= "\t\t\t<td class=\"$header_email\" onclick=\"window.location='?sort=email&csort=$csortValue'\">email</td>\n";
	$table .= "\t\t\t<td class=\"$header_phone\" onclick=\"window.location='?sort=phone&csort=$csortValue'\">Phone</td>\n";
//	$table .= "<td class='header'>cell</td>";
	$table .= "\t\t\t<td class=\"$header_gender\" onclick=\"window.location='?sort=gender&csort=$csortValue'\">gender</td>\n";
	$table .= "\t\t</tr>\n";
*/
	$table .= "\t</table>\n";
	return $table;
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admission Counselor Administration Panel</title>
<script>
function inlineEditable(passed_id,field,current_value){
	var idToEdit = passed_id+"_"+field;
	
	var str = "";
	str += "<input type=\"text\" value=\""+current_value+"\" ";
	str += "onblur=\"resetCell('"+passed_id+"','gender','"+current_value+"')\">";
	document.getElementById(idToEdit).innerHTML = str;
	document.getElementById(idToEdit).childNodes.item(0).focus();
}
function resetCell(passed_id,field,current_value)
{
	var idToEdit = passed_id+"_"+field;
	var str = "";
	str += "<span style='cursor: pointer'";
	str += "onclick=\"inlineEditable('"+passed_id+"','"+field+"','"+current_value+"')\" ";
	str += ">";
	str += current_value;
	str += "</span>";
/*
	$row .= "<span ";
	$row .= "onclick=\"inlineEditable('".$rowId."','gender','".$recruiterRowsArray[$rowId]['gender']."')\" ";
	$row .= ">";
*/


	document.getElementById(idToEdit).innerHTML = str;
}
</script>
<style>
p,table,tr,td,body{
	font-size: 12px;
	font-family:Arial, Helvetica, sans-serif;
}
input{
	font-size:10px;
}
td{
	border: 1px solid #000;
	padding:4px;
}

.gender{
	text-align:center;
}
.header{
	font-weight:bold;
	text-transform:uppercase;
	cursor: pointer;

}
.headersort_ASC{
	font-weight:bold;
	text-transform:uppercase;
	background: url(assets/sort-asc.png) right no-repeat;
	cursor: pointer;
}
.headersort_DESC{
	font-weight:bold;
	text-transform:uppercase;
	background: url(assets/sort-desc.png) right no-repeat;
	cursor: pointer;
}
#mainTable{
	width: 650px;
}
</style>
</head>

<body>
<?php
echo makeRecrRows($recrRows);

?>
</body>
</html>