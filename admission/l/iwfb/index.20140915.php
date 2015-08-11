<?php

if( isset($_POST['submit']) ) {
    // get the input
    // create/send the email
    // show the thank you message
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $url = $_POST['URL'];

    $msg = "";
    $msg .= "First name: $fname\n";
    $msg .= "Last name: $lname\n";
    $msg .= "Email: $email\n";
    $msg .= "Comment: $comment\n";
    $msg .= "URL: $url\n";
    
    mail('admit@simons-rock.edu',"Sept 12/13 2014 Admission Form",$msg);
    mail('dscheff@simons-rock.edu',"Sept 12/13 2014 Admission Form",$msg);
    
}



?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>The Early College Checklist: 5 Signs You're Ready for College Now</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="//forms.simons-rock.edu/admission/l/5-signs-ready-for-college/stylesheets/base.css">
	<link rel="stylesheet" href="//forms.simons-rock.edu/admission/l/5-signs-ready-for-college/stylesheets/skeleton.css">
	<link rel="stylesheet" href="//forms.simons-rock.edu/admission/l/5-signs-ready-for-college/stylesheets/layout.css">

	<style>
		ul.bullets{
			list-style: outside !important;
		}
		.bullets li{
			margin: 15px;
			font-size: 1.3em;
		}
		.bullets li a{
			color: #990020;
		}

    </style>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="icon" type="image/png" href="//forms.simons-rock.edu/admission/l/5-signs-ready-for-college/images/favicon.png">
	<script type="text/javascript" src="//forms.simons-rock.edu/js/form-funcs.js"></script>
</head>
<body>
<?php
if(! isset($_POST['submit']) ) {
    
?>
    <p><strong>Request Information</strong></p>
    <form id="request" name="request" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return checkForm()">
        <fieldset>
            <!-- <legend>Request Info</legend> -->
            <label for="fname">* First name:</label><input type="text" name="fname" id="fname" onblur="fieldStyleReset(this)" value="">
            <label for="lname">* Last name:</label><input type="text" name="lname" id="lname" onblur="fieldStyleReset(this)" value="">
            <label for="email">* Email:</label><input type="text" name="email" id="email" onblur="fieldStyleReset(this)" value="">
            <label for="comment">Questions/comments:</label><br>
            <textarea name="comment" id="comment"></textarea>
            <input name="URL" value="FACEBOOK" type="hidden">
            <button type="submit" name="submit" id="submit">Submit</button>
        </fieldset>
</form>
    
<?php  
} else {
?>
    
    <p><strong>Thank you for your request!</strong></p>
    
<?php 
}
?>
 <script type="text/javascript">
<!--

function fieldStyleReset(field){
	var val = field.value;
	if(val !== ""){
	   field.style.background = "#fff";
	}
}


function checkForm() {

    var bgcolor
    var normal
    var rval
    highlight = "#990020"
    normal = "#fff"
    rval = true
    fieldFocus = "";
    if (document.layers||document.getElementById||document.all) {
    if (document.request.fname.value.length == 0) {
        document.request.fname.style.backgroundColor = highlight
        rval = false
                    if(fieldFocus == ""){
                            fieldFocus = "fname";
                    }
            } 
            else {
        document.request.fname.style.backgroundColor = normal
            }

            if (document.request.lname.value.length == 0) {
        document.request.lname.style.backgroundColor = highlight
        rval = false
                    if(fieldFocus == ""){
                            fieldFocus = "lname";
                    }
            } 
            else {
        document.request.lname.style.backgroundColor = normal
            }

            if (document.request.email.value.length == 0) {
        document.request.email.style.backgroundColor = highlight
        rval = false
                    if(fieldFocus == ""){
                            fieldFocus = "email";
                    }
        } 
        else {
            document.request.email.style.backgroundColor = normal
        }		



        if (!rval) {
                    alert ("Please complete all required (highlighted) fields prior to submitting your form.");
                    document.getElementById(fieldFocus).focus();
                    document.getElementById(fieldFocus).style.display='';
            }
            return rval
    } 
    else {
            return true
    }
}
// -->
			
</script>   
</body>    
</html>