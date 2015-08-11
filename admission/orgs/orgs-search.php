<html>
<head>
<link href="css/ui-lightness/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.1.custom.min.js"></script>


	
<script>
jQuery(document).ready(function($){
	$('#zipsearch').autocomplete({
		source:'search.php', minLength:2});
});

</script>

</head>
<body>
<form action="search.php" method="post">
	Enter your school:
	<input type="text" id="zipsearch" name="term" />
 
	<br />
	<input type="submit" value="Search" />
</form>
</body>
</html>