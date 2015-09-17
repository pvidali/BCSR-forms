// JavaScript Document

function echeck(str,field) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		var alertMsg = "Email format is not valid, please make sure you have entered your email address correctly.";
		if (str.indexOf(at)==-1){
		   alert(alertMsg)
		   document.getElementById(field).focus();
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert(alertMsg)
		   document.getElementById(field).focus();
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert(alertMsg)
		    document.getElementById(field).focus();
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert(alertMsg)
		   document.getElementById(field).focus();
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert(alertMsg)
		   document.getElementById(field).focus();
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert(alertMsg)
		   document.getElementById(field).focus();
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert(alertMsg)
		   document.getElementById(field).focus();
		    return false
		 }

 		 return true					
	}