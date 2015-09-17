// JavaScript Document
function checkState(state){
	if(state == "NY"){
		document.getElementById('nycountyDiv').style.display = '';
		document.getElementById('paAreaDiv').style.display = 'none';
	}
	else if(state == "PA"){
		document.getElementById('paAreaDiv').style.display = '';
		document.getElementById('nycountyDiv').style.display = 'none';
	}
	else {
		document.getElementById('nycountyDiv').style.display = 'none';
		document.getElementById('paAreaDiv').style.display = 'none';
		if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "NY"){
			document.getElementById('nycountyDiv').style.display = '';
		}
		if(document.getElementById('high_school_state').options[document.getElementById('high_school_state').selectedIndex].value == "PA"){
			document.getElementById('paAreaDiv').style.display = '';
		}
	}
}

function showDiv(val,div){
	if(val == 'Other'){
		document.getElementById(div).style.display = '';
	}
	else {
		document.getElementById(div).style.display = 'none';
	}
}

function trackOutboundLink(link, category, action, label) { 
	try { 
		ga('send', 'event', category, action, label);
//		_gaq.push(['_trackEvent', category , action, label]); 
	} 
	catch(err){}
	setTimeout(
		function() {
			document.location.href = link.href;
		}, 100
	);
}