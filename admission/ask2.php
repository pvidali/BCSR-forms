<?php

?>


<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script src="http://malsup.github.com/jquery.form.js"></script>

<script>
// prepare the form when the DOM is ready 
$(document).ready(function() { 
    var options = { 
        target:        '#responseDiv',   // target element(s) to be updated with server response 
        beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
 
    // bind to the form's submit event 
    $('#question').submit(function() { 
        // inside event callbacks 'this' is the DOM element so we first 
        // wrap it in a jQuery object and then invoke ajaxSubmit 
        $(this).ajaxSubmit(options); 
 
        // !!! Important !!! 
        // always return false to prevent standard browser submit and page navigation 
        return false; 
    }); 
}); 
 
// pre-submit callback 
function showRequest(formData, jqForm, options) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
	//   var queryString = $.param(formData); 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 

	var form = jqForm[0]; 
    if (!form.three_words.value) { 
        $('#responseDiv').empty();
		$('#responseDiv').append('Please enter a question'); 
        return false; 
    } 
 
    //alert('About to submit: \n\n' + queryString); 
 
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
} 
 
// post-submit callback 
function showResponse(responseText, statusText, xhr, $form)  { 
//alert(statusText + responseText);
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 
 
    // if the ajaxSubmit method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 
 
    // if the ajaxSubmit method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 
 	if(statusText == "success"){
		$('#question').fadeOut(300);
        $('#responseDiv').empty();
		$('#responseDiv').append("Thank you for you question!");
	}
	else{
		alert(statusText); 
	}
} 
</script>
</head>
<body>

<div id="responseDiv"></div>
<form id="question" name="question" action="askquestion.php" method="post">
<input type="hidden" name="lname" id="lname" value="<?php echo($_REQUEST["lname"]);?>">
<input type="hidden" name="email" id="email" value="<?php echo($_REQUEST["email"]);?>">
<textarea name="three_words" id="three_words"></textarea>
<input type="hidden" name="formid" id="formid" value="685000007028041">
<input type="hidden" name="seed" id="seed" value="13">
<input type="submit" name="submit" value="submit">



</form>
</body>
</html>