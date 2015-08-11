<script type="text/javascript">
<!--

function checkForm() {
    var bgcolor
    var normal
    var rval
    highlight = "#ffcccc"
    normal = "#ffffff"
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

		if (document.request.street_address.value.length == 0) {
            document.request.street_address.style.backgroundColor = highlight
			if(fieldFocus == ""){
				fieldFocus = "street_address";
			}
			rval = false
        } 
		else {
            document.request.street_address.style.backgroundColor = normal
		}

		if (document.request.city.value.length == 0) {
            document.request.city.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "city";
			}
        } 
		else {
            document.request.city.style.backgroundColor = normal
		}

		if (document.getElementById('state').options[document.getElementById('state').selectedIndex].value == '---Please Select---')  {
            document.request.state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "state";
			}
        } 
		else {
            document.request.state.style.backgroundColor = normal
		}

        if (document.request.zip.value.length == 0) {
            document.request.zip.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "zip";
			}
        } 
		else {
            document.request.zip.style.backgroundColor = normal
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

/*		if (document.getElementById('dob_month').options[document.getElementById('dob_month').selectedIndex].value == '---Please Select---')  {
            document.request.dob_month.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "dob_month";
			}
        } 
		else {
            document.request.dob_month.style.backgroundColor = normal
		}
			
		if (document.getElementById('dob_day').options[document.getElementById('dob_day').selectedIndex].value == '---Please Select---') {
            document.request.dob_day.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "dob_day";
			}
        } 
		else {
            document.request.dob_day.style.backgroundColor = normal
		}


		if (document.getElementById('dob_year').options[document.getElementById('dob_year').selectedIndex].value == '---Please Select---') {
            document.request.dob_year.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "dob_year";
			}
        } 
		else {
            document.request.dob_year.style.backgroundColor = normal
		}
*/
//		alert(document.request.orderdate.value);
		if (document.request.orderdate.value == '01-JAN-2011') {
            document.getElementById('orderdateDiv').style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "orderdateDiv";
			}
		}
		else {
            document.getElementById('orderdateDiv').style.backgroundColor = normal
		}

        if (document.request.high_school.value.length == 0) {
            document.request.high_school.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "high_school";
			}
        } 
		else {
            document.request.high_school.style.backgroundColor = normal
		}

		if (document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == '---Please Select---') {
            document.request.high_school_state.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "high_school_state";
			}
        } 
		else {
            document.request.high_school_state.style.backgroundColor = normal
		}
		if (document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == 'NY') {
		if (document.getElementById('nycounty').options[document.getElementById('nycounty').selectedIndex].value == '---Please Select---') {
				document.request.nycounty.style.backgroundColor = highlight
	            rval = false
				if(fieldFocus == ""){
					fieldFocus = "nycounty";
				}
			}
			else {
				document.request.nycounty.style.backgroundColor = normal
			}
        } 
		if (document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == 'PA') {
			if (document.getElementById('paArea').options[document.getElementById('paArea').selectedIndex].value == '---Please Select---')  {
				document.request.paArea.style.backgroundColor = highlight
	            rval = false
				if(fieldFocus == ""){
					fieldFocus = "paArea";
				}
			}
			else {
				document.request.paArea.style.backgroundColor = normal
			}
        } 




        if (document.request.anticipated_grad_year.value.length == 0) {
            document.request.anticipated_grad_year.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "anticipated_grad_year";
			}
        } 
		else {
            document.request.anticipated_grad_year.style.backgroundColor = normal
		}

<?php
if(isset($_POST) && ($do_post_msg == true) ){
?>
		if (document.getElementById('how_did_you_hear').options[document.getElementById('how_did_you_hear').selectedIndex].value == '---Please Select---') {
            document.request.how_did_you_hear.style.backgroundColor = highlight
            rval = false
			if(fieldFocus == ""){
				fieldFocus = "how_did_you_hear";
			}
		} 
		else {
            document.request.how_did_you_hear.style.backgroundColor = normal
			if (
			  (document.getElementById('how_did_you_hear').options[document.getElementById('how_did_you_hear').selectedIndex].value == 'Other') 
			  && document.getElementById('how_hear_other').value.length == 0) {
				document.request.how_hear_other.style.backgroundColor = highlight
				rval = false
				if(fieldFocus == ""){
					fieldFocus = "how_hear_other";
				}
			} 
			else{
	            document.request.how_hear_other.style.backgroundColor = normal
			}
		}
<?php
}
?>			
			
        if (!rval) {
			alert ("Please complete all required (highlighted) fields prior to submitting your form.");
			document.getElementById(fieldFocus).focus();
			document.getElementById(fieldFocus).style.display='';
		}
		if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "NY"){
			document.getElementById('nycountyDiv').style.display = '';
			document.getElementById('paAreaDiv').style.display = 'none';
		}
		if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "PA"){
			document.getElementById('paAreaDiv').style.display = '';
			document.getElementById('nycountyDiv').style.display = 'none';
		}		
        return rval
    } 
	else {
		_gaq.push(['_trackEvent', 'Form', 'Submit', 'Slideshow LP Form 2']);
		return true
	}
}
if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "NY"){
	document.getElementById('nycountyDiv').style.display = '';
	document.getElementById('paAreaDiv').style.display = 'none';
}
if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "PA"){
	document.getElementById('paAreaDiv').style.display = '';
	document.getElementById('nycountyDiv').style.display = 'none';
}		
// -->
</script>