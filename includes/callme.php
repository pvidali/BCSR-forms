<?php
$contact = $_REQUEST['email'];
$day = $_REQUEST['d'];

$msg  = "";
$msg .= "CALL REQUEST FROM THANK YOU PAGE\n\n";
$msg .= "email: ". $contact;
$msg .= "\nday: ". $day;
$msg .= "\n";

mail("recruit@simons-rock.edu","MAIL",$msg);
mail("dscheff@simons-rock.edu","TY PAGE CALL REQUEST",$msg);

?>