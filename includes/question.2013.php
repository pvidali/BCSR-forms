<?php
$contact = $_REQUEST['email'];
$couns = $_REQUEST['couns'];
$question = $_REQUEST['question'];

if($couns == "davidson"){
	$couns_email = "leslied@simons-rock.edu";
}
elseif($couns == "pitt"){
	$couns_email = "jpitt@simons-rock.edu";
}
elseif($couns == "dubrowski"){
	$couns_email = "adubrowski@simons-rock.edu";
}
elseif($couns == "corso"){
	$couns_email = "jcorso@simons-rock.edu";
}
elseif($couns == "taylor"){
	$couns_email = "ataylor@simons-rock.edu";
}
elseif($couns == "coleman"){
	$couns_email = "scoleman@simons-rock.edu";
}


$msg  = "";
$msg .= "QUESTION SUBMISSION FROM THANK YOU PAGE\n\n";
$msg .= "email: ". $contact;
$msg .= "\nquestion: ". $question;
$msg .= "\n";

$headers = '';
$headers .= "From: $contact" . "\r\n" . "Cc: recruit@simons-rock.edu" . "\r\n";
// $headers .= 'From: daniel.a.scheff@gmail.com' . "\r\n" . 'Cc: dscheff@simons-rock.edu' . "\r\n";

mail($couns_email,"TY PAGE QUESTION SUBMISSION",$msg, $headers);
//mail("dscheff@simons-rock.edu","TY PAGE QUESTION SUBMISSION",$msg, $headers);
$headers = '';
$headers .= "From: $contact" . "\r\n";
mail("dscheff@simons-rock.edu","TY PAGE QUESTION SUBMISSION",$msg);

?>