<?php

/*** begin our session ***/
session_start();

/*** check if the users is already logged in ***/
if(!isset( $_SESSION['user_id'] ))
{
	
?>	
<html>
<head>
<title>Summer Program 2012 Reports</title>
<style>
.rowOther {
	background-color: #CCC;
}
</style>
</head>
<body>	
<p>You must be logged in to view the reports.</p>	
<p><a href="login.php">Login Here</a></p>
<?php } 
else {
?>
<html>
<head>
<title>Summer Program 2012 Reports</title>
<style>
.rowOther {
	background-color: #CCC;
}
</style>
</head>
<body>
<p>

<p>You are now logged in.</p>
<p>View by Week:</a></p>
<ul>
	<li><a href="detailed/week.php?week=1">Week 1</a></li>
	<li><a href="detailed/week.php?week=2">Week 2</a></li>
	<li><a href="detailed/week.php?week=3">Week 3</a></li>
	<li><a href="detailed/week.php?week=4">Week 4</a></li>
	<li><a href="detailed/week.php?week=all">ALL</a></li>
</ul>
<p>View by Class:</a></p>
<ul>
	<li><a href="detailed/class.php?class=1">Flamenco and Spanish Culture</a></li>
	<li><a href="detailed/class.php?class=2">Pop Culture Meets Social Psychology</a></li>
	<li><a href="detailed/class.php?class=3">Native Americans in the Berkshires</a></li>
	<li><a href="detailed/class.php?class=4">Eco-Blitz: Field Ecology at Simon’s Rock</a></li>
	<li><a href="detailed/class.php?class=5">Creating Digital Animation</a></li>
	<li><a href="detailed/class.php?class=6">Painting Like Van Gogh</a></li>
	<li><a href="detailed/class.php?class=7">Bio-technology Boot Camp</a></li>
	<li><a href="detailed/class.php?class=8">Citizen Journalism and Digital Media</a></li>
	<li><a href="detailed/class.php?class=9">Improvisational Theater Workshop</a></li>
	<li><a href="detailed/class.php?class=10">Life in Extreme Environments</a></li>
	<li><a href="detailed/class.php?class=11">Creating Digital Music</a></li>
	<li><a href="detailed/class.php?class=12">Exploring Graphic Novels</a></li>
	<li><a href="detailed/class.php?class=all">ALL</a></li>
</ul>
<? } ?>
</body>
</html>
