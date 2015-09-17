<?php

/*** begin our session ***/
session_start();

/*** check if the users is already logged in ***/
if(!isset( $_SESSION['user_id'] ))
{
	
?>	
<html>
<head>
<title>Family Weekend Reports</title>
<style>
.rowOther {
	background-color: #CCC;
}
</style>
</head>
<body>	
<p>You must be logged in to view the reports.</p>	
<p><a href="/family-weekend/reports/login.php">Login Here</a></p>
</body>
</html>

<?php 
}
else {
	$message .= "<p>You are now logged in.</p>";
//	if($_SESSION['user_id']->phpro_username == 'fwstats'){
//		$message .= '<p><a href="overall/index.php">View the Event/Meal stats</a><br />';
//		$message .= '<a href="detailed/index.php">View the Registered Attendees</a><br />';
//		$message .= '<a href="detailed/provost.php">View the Provost Reception Attendees</a></p>';
//	}
//	else{
		$message .= '<p><a href="overall/index.php">View the Event/Overall Meal stats</a><br />';
		$message .= '<a href="detailed/index.php">View the Registered Attendees</a><br />';
		$message .= '<a href="detailed/meals.php">View the detailed Meals Purchased reports</a><br />';
		$message .= '<a href="detailed/details.php">View the meeting info</a><br /></p>';
//	}
}
?>
<html>
<head>
<title>Login</title>
</head>
<body>
<?php echo $message; ?>
</body>
</html>
